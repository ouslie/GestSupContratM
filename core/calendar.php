<?php
################################################################################
# @Name : event_update.php
# @Description : update event in db
# @Call : /calendar.php
# @Parameters : 
# @Author : Flox
# @Create : 19/02/2018
# @Update : 18/12/2018
# @Version : 3.1.37
################################################################################

//init var

//db connection
require "./../connect.php";
$db->exec('SET sql_mode = ""');

if($_POST['action']=='update_title')
{
	//data
	$id=$_POST['id'];
	$title=$_POST['title'];
	//db update
	$query = "UPDATE tevents SET title=? WHERE id=?";
	$query = $db->prepare($query);
	$query->execute(array($title,$id));
} elseif($_POST['action']=='move_event' || $_POST['action']=='resize_event') {
	//data
	$id=$_POST['id'];
	$title=$_POST['title'];
	$start=$_POST['start'];
	$end=$_POST['end'];
	//db update
	$query = "UPDATE tevents SET title=?, date_start=?, date_end=? WHERE id=?";
	$query = $db->prepare($query);
	$query->execute(array($title,$start,$end,$id));
} elseif($_POST['action']=='delete_event')
{
	//db delete
	{
		$query = $db->prepare("DELETE FROM tevents WHERE id=:id");
		$query->execute(array(':id'=>$_POST['id']));
	}
	
} elseif($_POST['action']=='add_event')
{
	//data
	$title=$_POST['title'];
	$start=$_POST['start'];
	$end=$_POST['end'];
	$allday=$_POST['allday'];
	$technician=$_POST['technician'];
	//db insert
	$query = "INSERT INTO tevents (technician,title, date_start, date_end,allday) VALUES (:technician, :title, :start, :end, :allday)";
	$query = $db->prepare($query);
	$query->execute(array(':technician'=>$technician,':title'=>$title, ':start'=>$start, ':end'=>$end, ':allday'=>$allday));
}
?>