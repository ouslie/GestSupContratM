<?php 
################################################################################
# @Name : ticket_userinfos.php
# @Description : get user information to display on ticket
# @call : ticket.php over ajax
# @parameters : 
# @Author : Flox
# @Create : 25/01/2019
# @Update : 26/01/2019
# @Version : 3.1.40 p2
################################################################################

//initialize variables 
if(!isset($_GET['token'])) $_GET['token']=''; 
if(!isset($_COOKIE['token'])) $_COOKIE['token']=''; 

//security check
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	//check post value and token
	if($_POST['user'] && $_GET['token']==$_COOKIE["token"])
	{
		//init var
		$service='';
		$agency='';
		$other_ticket='';
		
		//db connect
		require('../connect.php');
		
		//get user data
		$qry=$db->prepare("SELECT `phone`,`mobile`,`mail`,`function`,`company` FROM `tusers` WHERE id=:id");
		$qry->execute(array('id' => $_POST['user']));
		$user=$qry->fetch();
		$qry->closeCursor();
		
		$qry=$db->prepare("SELECT `name` FROM `tcompany` WHERE id=:id");
		$qry->execute(array('id' => $user['company']));
		$company=$qry->fetch();
		$qry->closeCursor();
		
		$qry=$db->prepare("SELECT `name` FROM `tcompany` WHERE id=:id AND id!=0");
		$qry->execute(array('id' => $user['company']));
		$company=$qry->fetch();
		$qry->closeCursor();
		
		$qry=$db->prepare("SELECT `name` FROM `tservices`,`tusers_services` WHERE `tservices`.`id`=`tusers_services`.`service_id` AND `tusers_services`.`user_id`=:user_id AND `tservices`.`disable`=0");
		$qry->execute(array('user_id' => $_POST['user']));
		while($row=$qry->fetch()) {$service.=' '.$row['name'];}
		$qry->closeCursor();
		
		$qry=$db->prepare("SELECT `name` FROM `tagencies` WHERE `id` IN (SELECT `agency_id` FROM `tusers_agencies` WHERE `user_id`=:user_id) AND `disable`=0");
		$qry->execute(array('user_id' => $_POST['user']));
		while($row=$qry->fetch()) {$agency.=' '.$row['name'];}
		$qry->closeCursor();
		
		$qry=$db->prepare("SELECT `id`,`title` FROM `tincidents` WHERE user=:user_id AND (`state`='1' OR `state`='2' OR `state`='6' OR `state`='5') AND `id`!=:ticket AND `disable`=0 ORDER BY id DESC LIMIT 0,3");
		$qry->execute(array('user_id' => $_POST['user'],'ticket' => $_GET['ticket']));
		while($row=$qry->fetch()) {$other_ticket.='&nbsp;<a title="'.$row['title'].'" href="./index.php?page=ticket&amp;id='.$row['id'].'">#'.$row['id'].'</a>';}
		$qry->closeCursor();
		
		$qry = $db->prepare("SELECT `id`,`netbios` FROM `tassets` WHERE `user`=:user_id AND `state`='2' AND `user`!='0' ORDER BY id DESC");
		$qry->execute(array('user_id' => $_POST['user']));
		$asset=$qry->fetch();
		$qry->closeCursor(); 
		
		//encode result ajax call
		if($user) {
			echo json_encode(
				array(
					"status" => "success",
					"phone" => $user["phone"],
					"mobile" => $user["mobile"],
					"mail" => $user["mail"],
					"function" => $user["function"],
					"company" => $company["name"],
					"service" => $service,
					"agency" => $agency,
					"asset_id" => $asset['id'],
					"asset_netbios" => $asset['netbios'],
					"other_ticket" => $other_ticket
				)
			);
		} else {
			echo json_encode(array("status" => "failed"));
		}
	} else {
		echo json_encode(array("status" => "failed"));
	} 
} else {
	echo json_encode(array("status" => "failed"));
}
?>