<?php
################################################################################
# @Name : /core/mail.php
# @Description : page to send mail
# @Call : /preview_mail.php, /core_automail.php
# @Parameters : ticket id destinataires
# @Author : Flox
# @Create : 15/07/2014
# @Update : 23/10/2018
# @Version : 3.1.36
################################################################################

//initialize variables 
if(!isset($_POST['usercopy'])) $_POST['usercopy'] = '';
if(!isset($_POST['usercopy2'])) $_POST['usercopy2'] = '';
if(!isset($_POST['usercopy3'])) $_POST['usercopy3'] = '';
if(!isset($_POST['usercopy4'])) $_POST['usercopy4'] = '';
if(!isset($_POST['usercopy5'])) $_POST['usercopy5'] = '';
if(!isset($_POST['usercopy6'])) $_POST['usercopy6'] = '';
if(!isset($_POST['manual_address'])) $_POST['manual_address'] = '';
if(!isset($_POST['receiver'])) $_POST['receiver'] = ''; 
if(!isset($_POST['withattachment'])) $_POST['withattachment'] = ''; 
if(!isset($fname11)) $fname11 = '';
if(!isset($fname21)) $fname21 = '';
if(!isset($fname31)) $fname31 = '';
if(!isset($fname41)) $fname41 = '';
if(!isset($fname51)) $fname51 = '';
if(!isset($resolution)) $resolution = '';
if(!isset($mail_text_end)) $mail_text_end = '';
if(!isset($rtech4['firstname'])) $rtech4['firstname'] = '';
if(!isset($rtech4['lastname'])) $rtech4['lastname'] = '';
if(!isset($rtech5['firstname'])) $rtech5['firstname'] = '';
if(!isset($rtech5['lastname'])) $rtech5['lastname'] = '';
if(!isset($rtechgroup4['name'])) $rtechgroup4['name'] = '';
if(!isset($rtechgroup5['name'])) $rtechgroup5['name'] = '';
if(!isset($from_mail2ticket)) $from_mail2ticket=0;

//call crypt function if not call from mail2ticket
if(!$from_mail2ticket){require_once('./core/crypt.php');}

$db_id=strip_tags($_GET['id']);

$dest_mail=0;

//database queries to find values for create mail	
$qry=$db->prepare("SELECT * FROM `tincidents` WHERE id=:id");
$qry->execute(array('id' => $db_id));
$globalrow=$qry->fetch();
$qry->closeCursor();

$qry=$db->prepare("SELECT * FROM `tusers` WHERE id=:id");
$qry->execute(array('id' => $globalrow['user']));
$userrow=$qry->fetch();
$qry->closeCursor();

$qry=$db->prepare("SELECT * FROM `tusers` WHERE id=:id");
$qry->execute(array('id' => $globalrow['technician']));
$techrow=$qry->fetch();
$qry->closeCursor();

//group case
if ($globalrow['t_group']!=0)
{
	$qry=$db->prepare("SELECT `name` FROM `tgroups` WHERE id=:id");
	$qry->execute(array('id' => $globalrow['t_group']));
	$grouptech=$qry->fetch();
	$qry->closeCursor();
}
if ($globalrow['u_group']!=0)
{
	$qry=$db->prepare("SELECT `name` FROM `tgroups` WHERE id=:id");
	$qry->execute(array('id' => $globalrow['u_group']));
	$groupuser=$qry->fetch();
	$qry->closeCursor();
}

//case no send mail from mail2ticket
if(isset($_SESSION['user_id']))
{
	$qry=$db->prepare("SELECT * FROM `tusers` WHERE id=:id");
	$qry->execute(array('id' => $_SESSION['user_id']));
	$creatorrow=$qry->fetch();
	$qry->closeCursor();
}	

$qry=$db->prepare("SELECT `name` FROM `tstates` WHERE id=:id");
$qry->execute(array('id' => $globalrow['state']));
$staterow=$qry->fetch();
$qry->closeCursor();
	
$qry=$db->prepare("SELECT * FROM `tcategory` WHERE id=:id");
$qry->execute(array('id' => $globalrow['category']));
$catrow=$qry->fetch();
$qry->closeCursor();
	
$qry=$db->prepare("SELECT * FROM `tsubcat` WHERE id=:id");
$qry->execute(array('id' => $globalrow['subcat']));
$subcatrow=$qry->fetch();
$qry->closeCursor();

//case place parameter
if ($rparameters['ticket_places']==1)
{
	$qry=$db->prepare("SELECT `id`,`name` FROM `tplaces` WHERE id=:id");
	$qry->execute(array('id' => $globalrow['place']));
	$placerow=$qry->fetch();
	$qry->closeCursor();
	if($placerow['id']!=0)
	{
		$place='
		<tr>
			<td colspan="2"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Lieu').' :</b> '.$placerow['name'].'</font></td>
		</tr>
		';
	} else {$place='';}
} else {$place='';}

//generate resolution
if($rparameters['mail_order']==1) {
	$qry=$db->prepare("SELECT * FROM `tthreads` WHERE ticket=:ticket AND private=:private ORDER BY date DESC");
} else {
	$qry=$db->prepare("SELECT * FROM `tthreads` WHERE ticket=:ticket AND private=:private ORDER BY date ASC");
}
$qry->execute(array(
	'ticket' => $db_id,
	'private' => 0
));
while($row=$qry->fetch()) 
{
	//remove display date from old post 
	$find_old=explode(" ", $row['date']);
	$find_old=$find_old[1];
	if ($find_old!='12:00:00') $date_thread=date_convert($row['date']); else $date_thread='';
		
	if($row['type']==0)
	{
		//text back-line format
		$text=nl2br($row['text']);
		
		//test if author is not the technician
		if ($row['author']!=$globalrow['technician'])
		{
			//find author name
			$qry2=$db->prepare("SELECT `firstname`,`lastname` FROM `tusers` WHERE id=:id");
			$qry2->execute(array('id' => $row['author']));
			$rauthor=$qry2->fetch();
			$qry2->closeCursor();
			
			$resolution="$resolution <b> $date_thread $rauthor[firstname] $rauthor[lastname]: </b><br /> $text  <hr />";
		} else {
			if ($date_thread!='')
			{
				$resolution="$resolution <b>$date_thread:</b><br />$text<hr />";
			} else {
				$resolution="$resolution  $text <hr />";
			}
		}
	} elseif ($row['type']==1) {
		//generate attribution thread
		if ($row['group1']!=0)
		{
			$qry2=$db->prepare("SELECT `name` FROM `tgroups` WHERE id=:id");
			$qry2->execute(array('id' => $row['group1']));
			$rtechgroup=$qry2->fetch();
			$qry2->closeCursor();

			$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Attribution du ticket au groupe').' '.$rtechgroup['name'].'.<br /><br />';
		} else {
			$qry2=$db->prepare("SELECT `firstname`,`lastname` FROM `tusers` WHERE id=:id");
			$qry2->execute(array('id' => $row['tech1']));
			$rtech3=$qry2->fetch();
			$qry2->closeCursor();
			
			$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Attribution du ticket à').' '.$rtech3['firstname'].' '.$rtech3['lastname'].'.<br /><br />';
		}
	} elseif($row['type']==2) {
		//generate transfert thread
		if ($row['group1']!=0 && $row['group2']!=0) //case group to group 
		{
			$qry2=$db->prepare("SELECT `name` FROM `tgroups` WHERE id=:id");
			$qry2->execute(array('id' => $row['group1']));
			$rtechgroup1=$qry2->fetch();
			$qry2->closeCursor();
			
			$qry2=$db->prepare("SELECT `name` FROM `tgroups` WHERE id=:id");
			$qry2->execute(array('id' => $row['group2']));
			$rtechgroup2=$qry2->fetch();
			$qry2->closeCursor();
			
			$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Transfert du ticket du groupe').' '.$rtechgroup1['name'].' '.T_('au groupe ').' '.$rtechgroup2['name'].'. <br /><br />';
		} elseif(($row['tech1']==0 || $row['tech2']==0) && ($row['group1']==0 || $row['group2']==0)) { //case group to tech
			if ($row['tech1']!=0) {
				$qry2=$db->prepare("SELECT `firstname`,`lastname` FROM `tusers` WHERE id=:id");
				$qry2->execute(array('id' => $row['tech1']));
				$rtech4=$qry2->fetch();
				$qry2->closeCursor();
			}
			if ($row['tech2']!=0) {
				$qry2=$db->prepare("SELECT `firstname`,`lastname` FROM `tusers` WHERE id=:id");
				$qry2->execute(array('id' => $row['tech2']));
				$rtech5=$qry2->fetch();
				$qry2->closeCursor();
			}
			if ($row['group1']!=0) {
				$qry2=$db->prepare("SELECT `name` FROM `tgroups` WHERE id=:id");
				$qry2->execute(array('id' => $row['group1']));
				$rtechgroup4=$qry2->fetch();
				$qry2->closeCursor();
			}
			if ($row['group2']!=0) {
				$qry2=$db->prepare("SELECT `name` FROM `tgroups` WHERE id=:id");
				$qry2->execute(array('id' => $row['group2']));
				$rtechgroup5=$qry2->fetch();
				$qry2->closeCursor();
			}
			$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Transfert du ticket de').' '.$rtechgroup4['name'].$rtech4['firstname'].' '.$rtech4['lastname'].' '.T_('à ').' '.$rtechgroup5['name'].$rtech5['firstname'].' '.$rtech5['lastname'].'. <br /><br />';
	} elseif($row['tech1']!=0 && $row['tech2']!=0) { //case tech to tech
			$qry2=$db->prepare("SELECT `firstname`,`lastname` FROM `tusers` WHERE id=:id");
			$qry2->execute(array('id' => $row['tech1']));
			$rtech1=$qry2->fetch();
			$qry2->closeCursor();
						
			$qry2=$db->prepare("SELECT `firstname`,`lastname` FROM `tusers` WHERE id=:id");
			$qry2->execute(array('id' => $row['tech2']));
			$rtech2=$qry2->fetch();
			$qry2->closeCursor();
			
			$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Transfert du ticket de').' '.$rtech1['firstname'].' '.$rtech1['lastname'].' à '.$rtech2['firstname'].' '.$rtech2['lastname'].'. <br /><br />';
		}
	}
}
$qry->closeCursor();
	
$description = $globalrow['description'];

//date conversion
$date_create = date_cnv("$globalrow[date_create]");
$date_hope = date_cnv("$globalrow[date_hope]");
$date_res = date_cnv("$globalrow[date_res]");
	
//generate mail object via db state name
$qry=$db->prepare("SELECT `mail_object` FROM `tstates` WHERE id=:id");
$qry->execute(array('id' => $globalrow['state']));
$robject=$qry->fetch();
$qry->closeCursor();
$objet=T_($robject['mail_object']).' '.T_('pour le ticket').' n°'.$db_id.': '.$globalrow['title'];

//recipient user mail
$destinataire="$userrow[mail]";

//check if unique sender mail address exist else get creator mail address
if($rparameters['mail_from_adr']==''){$emetteur=$creatorrow['mail'];} else {$emetteur=$rparameters['mail_from_adr'];}

//display custom end text mail, else auto generate
if ($rparameters['mail_txt_end'])
{
	//generate mail end text
	$mail_text_end=str_replace("[tech_name]", "$techrow[firstname] $techrow[lastname]", $rparameters['mail_txt_end']);
	$mail_text_end=str_replace("[tech_phone]", "$techrow[phone]", $mail_text_end);
	if ($rparameters['mail_link']==1) {
		$link='<a href="'.$rparameters['server_url'].'/index.php?page=ticket&id='.$_GET['id'].'">'.$rparameters['server_url'].'/index.php?page=ticket&id='.$_GET['id'].'</a>';
		$mail_text_end=str_replace("[link]", "$link", $mail_text_end);
	}
} else { //auto end mail
	if ($rparameters['mail_link']==1) //integer link parameter
	{
		$link=', '.T_('ou consultez votre ticket sur ce lien').': <a href="'.$rparameters['server_url'].'/index.php?page=ticket&id='.$_GET['id'].'">'.$rparameters['server_url'].'/index.php?page=ticket&id='.$_GET['id'].'</a>';	
	} else $link=".";
	if (($techrow['lastname']!='Aucun') && ($techrow['phone']!='')) //case technician phone
	{$mail_text_end=T_('Pour toutes informations complémentaires sur votre ticket, vous pouvez joindre').' '.$techrow['firstname'].' '.$techrow['lastname'].' '.T_('au').' '.$techrow['phone'].' '.$link;}
	elseif ($rparameters['mail_link']==1) //case technician no phone
	{$mail_text_end=T_("Vous pouvez suivre l'état d'avancement de votre ticket sur ce lien:").'<a href="'.$rparameters['server_url'].'/index.php?page=ticket&id='.$_GET['id'].'">'.$rparameters['server_url'].'/index.php?page=ticket&id='.$_GET['id'].'</a>';}
}
//add tag in mail to split fonction of imap connector
if ($rparameters['imap']==1 && $rparameters['imap_reply']==1) {$msg='---- '.T_('Repondre au dessus de cette ligne').' ----';} else {$msg='';}
$msg.='
	<html>
		<head>
			<meta charset="UTF-8" />
		</head>
		<body>
			<font face="Arial">
				<table width="700" cellspacing="0" cellpadding="10">
					<tr bgcolor="'.$rparameters['mail_color_title'].'" >
					  <th><span style="font-size: large; color: #FFFFFF;"> &nbsp; '.$objet.' &nbsp;</span></th>
					</tr>
					<tr bgcolor="'.$rparameters['mail_color_bg'].'" >
					  <td>
						<font color="'.$rparameters['mail_color_text'].'">
							';
							if($rparameters['mail_txt']) {$msg.=T_($rparameters['mail_txt']);}
							$msg.='
						</font>
						<br />
						<br />
						<table  border="1" bordercolor="'.$rparameters['mail_color_title'].'" cellspacing="0"  cellpadding="5">
							<tr>
								<td><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Titre').' :</b> '.$globalrow['title'].'</font></td>
								<td><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Catégorie').' :</b> '.$catrow['name'].' - '.$subcatrow['name'].'</font></td>
							</tr>
							<tr>
								';
								//detect user group  
								if ($globalrow['u_group']!=0)
								{$msg.='<td width="400"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Demandeur').' :</b> '.$groupuser['name'].'</font></td>';}
								else
								{$msg.='<td width="400"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Demandeur').' :</b> '.$userrow['lastname'].' '.$userrow['firstname'].'</font></td>';}
								//detect technician group  
								if ($globalrow['t_group']!=0)
								{$msg.='<td width="400"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Groupe de technicien en charge').' :</b> '.$grouptech['name'].'</font></td>';}
								else
								{$msg.='<td width="400"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Technicien en charge').' :</b> '.$techrow['lastname'].' '.$techrow['firstname'].'</font></td>';}
								$msg.='
							</tr>
							<tr>
								<td><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('État').' :</b> '.T_($staterow[0]).'</font></td>
								<td><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Date de la demande').' :</b> '.$date_create.'</font></td>	
							</tr>
							'.$place;
							//invert resolution and description part for antechrono case
							if($rparameters['mail_order']==1)
							{
								$msg.='
									<tr>
										<td colspan="2"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Résolution').' :</b><br />'.$resolution.'</font></td>
									</tr>
									<tr>
										<td colspan="2"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Description').' :</b><br />'.$description.'</font></td>
									</tr>
								';
							} else {
								$msg.='
									<tr>
										<td colspan="2"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Description').' :</b><br />'.$description.'</font></td>
									</tr>
									<tr>
										<td colspan="2"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Résolution').' :</b><br /> '.$resolution.'</font></td>
									</tr>
								';
							}
							$msg.='
							<tr>
								<td width="400"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Date de résolution estimé').' :</b> '.$date_hope.'</font></td>
								<td width="400"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Date de résolution').' :</b> '.$date_res.'</font></td>
							</tr>
						</table>
						<br />
						<hr />
						<font color="'.$rparameters['mail_color_text'].'">
						';
						$msg.=$mail_text_end;
						$msg.='
						</font>
					  </td>
					</tr>
				</table>
			</font>
		</body>
	</html>
';
//add tag in mail to split fonction of imap connector
if ($rparameters['imap']==1 && $rparameters['imap_reply']==1) {$msg.='---- '.T_('Repondre au dessus du ticket').' ----';} else {$msg.='';}

if ($send==1)
{
	if ($rparameters['debug']==1) {echo '<b>SMTP SERVER:</b><br />';}
	require_once(__DIR__.'/../components/PHPMailer/src/PHPMailer.php');
	require_once(__DIR__.'/../components/PHPMailer/src/SMTP.php');
	require_once(__DIR__.'/../components/PHPMailer/src/Exception.php');
	$mail = new PHPMailer\PHPMailer\PHPMailer(true);
	
	//detect and convert image in mail
	if(preg_match_all('/<img.*?>/', $msg, $matches))
	{
		//for each images detected
		$i = 1;
		foreach ($matches[0] as $img)
		{
			if (strpos($img, 'base64') !== false)
			{
				if ($rparameters['debug']) {echo 'DEBUG: Images base64 detected conversion ('.$img.')<br />';}
				//generate cid
				$id = 'img'.($i++);
				//keep data of current image
				preg_match('/src="(.*?)"/', $img, $m);
				//extract image parameters
				$image_data=explode(',',$m[1]);
				$image_encoding=explode(';',$image_data[0]);
				$image_type=explode(':',$image_encoding[0]);
				$msg = str_replace($img, '<img alt="" src="cid:'.$id.'" style="border: none;" />', $msg); 
				//add to mail
				$mail->AddStringEmbeddedImage(base64_decode($image_data[1]), $id, $id, $image_encoding[1], $image_type[1]);
			} else {if ($rparameters['debug']) {echo 'DEBUG: Images no base64 detected ('.$img.')<br />';}}
		}
	} 
	
	//add agency mail if user have no mail and agency parameter is enable
	if($rparameters['user_agency']) {
		//get agency mail
		$qry=$db->prepare("SELECT `mail` FROM `tagencies` WHERE id IN (SELECT agency_id FROM tusers_agencies WHERE user_id=:user_id)");
		$qry->execute(array('user_id' => $userrow['id']));
		$row=$qry->fetch();
		$qry->closeCursor();
		
		if($row['mail']) 
		{
			if($userrow['mail']){$mail->AddCC("$row[mail]"); $dest_mail=1;} else {$mail->AddAddress("$row[mail]"); $dest_mail=1;}
		}
	}
	
	$mail->CharSet = 'UTF-8'; //ISO-8859-1 possible if string problems
	if ($rparameters['mail_smtp_class']=='IsSendMail()') {$mail->IsSendMail();} else {$mail->IsSMTP();} 
	if($rparameters['mail_secure']=='SSL') 
	{$mail->Host = "ssl://$rparameters[mail_smtp]";} 
	elseif($rparameters['mail_secure']=='TLS') 
	{$mail->Host = "tls://$rparameters[mail_smtp]";} 
	else 
	{$mail->Host = "$rparameters[mail_smtp]";}
	$mail->SMTPAuth = $rparameters['mail_auth'];
	if ($rparameters['debug']==1) $mail->SMTPDebug = 4;
	if ($rparameters['mail_secure']!=0) $mail->SMTPSecure = $rparameters['mail_secure'];
	if ($rparameters['mail_port']!=25) $mail->Port = $rparameters['mail_port'];
	$mail->Username = "$rparameters[mail_username]";
	if(preg_match('/gs_en/',$rparameters['mail_password'])) {$rparameters['mail_password']=gs_crypt($rparameters['mail_password'], 'd' , $rparameters['server_private_key']);}
	$mail->Password = "$rparameters[mail_password]";
	$mail->IsHTML(true); 
	$mail->From = "$emetteur";
	$mail->FromName = "$rparameters[mail_from_name]";

	//generate adresse list
	if ($_POST['receiver']!='none') {
		if ($globalrow['u_group']!=0)
		{
			$qry2=$db->prepare("SELECT `mail` FROM `tusers`, `tgroups_assoc` WHERE tgroups_assoc.user=tusers.id AND tgroups_assoc.group=:group AND tusers.disable=:disable");
			$qry2->execute(array(
				'group' => $globalrow['u_group'],
				'disable' => 0
				));
			while($row=$qry2->fetch())
			{
				$mail->AddAddress("$row[0]");
				$dest_mail=1;
			}
			$qry2->closeCursor();
		} elseif ($userrow['mail']) {$mail->AddAddress("$userrow[mail]"); $dest_mail=1;}
	}
	if ($rparameters['mail_from_adr']!='') {$mail->AddReplyTo($rparameters['mail_from_adr']);} elseif ($techrow['mail']!='') {$mail->AddReplyTo($techrow['mail']);}
	if ($rparameters['mail_cc']!='') {
		$addresses = explode(";",$rparameters['mail_cc']);
		foreach($addresses as $mailCC){
			$mail->AddCC("$mailCC");
			$dest_mail=1;
		}
	}
	if ($_POST['usercopy']!='')
	{ 
		if(substr($_POST['usercopy'], 0, 1) =='G') 
		{
			$groupid= explode("_", $_POST['usercopy']);
			$qry2=$db->prepare("SELECT `mail` FROM `tusers`, `tgroups_assoc` WHERE tgroups_assoc.user=tusers.id AND tgroups_assoc.group=:group AND tusers.disable=:disable");
			$qry2->execute(array('group' => $groupid[1],'disable' => 0));
			while($row=$qry2->fetch()){$mail->AddCC("$row[0]"); $dest_mail=1;}
			$qry2->closeCursor();
		} else {$mail->AddCC("$_POST[usercopy]"); $dest_mail=1;}
	}
	if ($_POST['usercopy2']!='')
	{ 
		if(substr($_POST['usercopy2'], 0, 1) =='G') 
		{
			$groupid= explode("_", $_POST['usercopy2']);
			$qry2=$db->prepare("SELECT `mail` FROM `tusers`, `tgroups_assoc` WHERE tgroups_assoc.user=tusers.id AND tgroups_assoc.group=:group AND tusers.disable=:disable");
			$qry2->execute(array('group' => $groupid[1],'disable' => 0));
			while($row=$qry2->fetch()){$mail->AddCC("$row[0]"); $dest_mail=1;}
			$qry2->closeCursor();
		} else {$mail->AddCC("$_POST[usercopy2]");$dest_mail=1;}
	} 
	if ($_POST['usercopy3']!='')
	{ 
		if(substr($_POST['usercopy3'], 0, 1) =='G') 
		{
			$groupid= explode("_", $_POST['usercopy3']);
			$qry2=$db->prepare("SELECT `mail` FROM `tusers`, `tgroups_assoc` WHERE tgroups_assoc.user=tusers.id AND tgroups_assoc.group=:group AND tusers.disable=:disable");
			$qry2->execute(array('group' => $groupid[1],'disable' => 0));
			while($row=$qry2->fetch()){$mail->AddCC("$row[0]"); $dest_mail=1;}
			$qry2->closeCursor();
		} else {$mail->AddCC("$_POST[usercopy3]"); $dest_mail=1;}
	}
	if ($_POST['usercopy4']!='')
	{ 
		if(substr($_POST['usercopy4'], 0, 1) =='G') 
		{
			$groupid= explode("_", $_POST['usercopy4']);
			$qry2=$db->prepare("SELECT `mail` FROM `tusers`, `tgroups_assoc` WHERE tgroups_assoc.user=tusers.id AND tgroups_assoc.group=:group AND tusers.disable=:disable");
			$qry2->execute(array('group' => $groupid[1],'disable' => 0));
			while($row=$qry2->fetch()){$mail->AddCC("$row[0]"); $dest_mail=1;}
			$qry2->closeCursor();
		} else {$mail->AddCC("$_POST[usercopy4]"); $dest_mail=1;}
	}
	if ($_POST['usercopy5']!='')
	{ 
		if(substr($_POST['usercopy5'], 0, 1) =='G') 
		{
			$groupid= explode("_", $_POST['usercopy5']);
			$qry2=$db->prepare("SELECT `mail` FROM `tusers`, `tgroups_assoc` WHERE tgroups_assoc.user=tusers.id AND tgroups_assoc.group=:group AND tusers.disable=:disable");
			$qry2->execute(array('group' => $groupid[1],'disable' => 0));
			while($row=$qry2->fetch()){$mail->AddCC("$row[0]"); $dest_mail=1;}
			$qry2->closeCursor();
		} else {$mail->AddCC("$_POST[usercopy5]"); $dest_mail=1;}
	}
	if ($_POST['usercopy6']!='')
	{ 
		if(substr($_POST['usercopy6'], 0, 1) =='G') 
		{
			$groupid= explode("_", $_POST['usercopy6']);
			$qry2=$db->prepare("SELECT `mail` FROM `tusers`, `tgroups_assoc` WHERE tgroups_assoc.user=tusers.id AND tgroups_assoc.group=:group AND tusers.disable=:disable");
			$qry2->execute(array('group' => $groupid[1],'disable' => 0));
			while($row=$qry2->fetch()){$mail->AddCC("$row[0]"); $dest_mail=1;}
			$qry2->closeCursor();
		} else {$mail->AddCC("$_POST[usercopy6]"); $dest_mail=1;}
	}
	if ($_POST['manual_address']!=''){$mail->AddCC("$_POST[manual_address]"); $dest_mail=1;}
    if ($_POST['withattachment']==1)
    {
    	if ($globalrow['img1']!='')$mail->AddAttachment("./upload/$_GET[id]/$globalrow[img1]");
    	if ($globalrow['img2']!='')$mail->AddAttachment("./upload/$_GET[id]/$globalrow[img2]");
    	if ($globalrow['img3']!='')$mail->AddAttachment("./upload/$_GET[id]/$globalrow[img3]");
    	if ($globalrow['img4']!='')$mail->AddAttachment("./upload/$_GET[id]/$globalrow[img4]");
    	if ($globalrow['img5']!='')$mail->AddAttachment("./upload/$_GET[id]/$globalrow[img5]");
    }
	$mail->Subject = "$objet";
	
	if ($rparameters['mail_ssl_check']==0)
	{
		//bug fix 3292 & 3427
		$mail->smtpConnect([
		'ssl' => [
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			]
		]);
	}
	$mail->Body = "$msg";
	
	//check mail is not empty before send
	if($dest_mail)
	{
		if (!$mail->Send()){
    	echo '<div class="alert alert-block alert-danger"><center><i class="icon-remove red"></i> <b>'.T_('Message non envoyé, vérifier la configuration de votre serveur de messagerie').'.</b> (';
        	echo $mail->ErrorInfo;
    	echo ')</center></div>';
		} elseif(isset($_SESSION['user_id'])) {
			echo '<div class="alert alert-block alert-success"><center><i class="icon-envelope green"></i> '.T_('Message envoyé').'.</center></div>';
			//redirect
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			<!--
			function redirect()
			{
			window.location='./index.php?page=dashboard&&state=$_GET[state]&userid=$_GET[userid]&view=$_GET[view]&date_start=$_GET[date_start]&date_end=$_GET[date_end]'
			}
			setTimeout('redirect()',$rparameters[time_display_msg]);
			-->
			</SCRIPT>
			";
		}
		$mail->SmtpClose();
	} else {
		echo '<div class="alert alert-block alert-danger"><center><i class="icon-remove red"></i> <b>'.T_('Erreur').'.</b> '.T_('Aucune adresse mail renseignée.').' </center></div>';
	}
}

// Date conversion
function date_cnv ($date) 
{return substr($date,8,2) . "/" . substr($date,5,2) . "/" . substr($date,0,4);}
?>