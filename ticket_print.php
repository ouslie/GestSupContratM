﻿<?php
################################################################################
# @Name : ticket.php 
# @Description : page to edit ticket
# @Call : /ticket.php
# @Author : Flox
# @Version : 3.1.33
# @Create : 09/02/2014
# @Update : 08/06/2018
################################################################################

//initialize variables 
if(!isset($_GET['token'])) $_GET['token'] = ''; 
if(!isset($resolution)) $resolution = '';
//connexion script with database parameters
require "connect.php";

//switch SQL MODE to allow empty values with lastest version of MySQL
$db->exec('SET sql_mode = ""');

//get userid to find language
$_SESSION['user_id']=$_GET['user_id'];

$db_id=strip_tags($db->quote($_GET['id']));
$db_session_user_id=strip_tags($db->quote($_GET['user_id']));

//load user table
$quser=$db->query("SELECT * FROM tusers WHERE id=$db_session_user_id");
$ruser=$quser->fetch();
$quser->closeCursor(); 

//load parameter table
$query=$db->query("SELECT * FROM tparameters");
$rparameters=$query->fetch();
$query->closeCursor(); 

//define current language
require "localization.php";

//initialize variables 
if(!isset($userreg)) $userreg = ''; 
if(!isset($u_group)) $u_group = ''; 
if(!isset($globalrow['u_group'])) $globalrow['u_group'] = ''; 
if(!isset($_POST['user'])) $_POST['user'] = ''; 
if(!isset($_POST['technician'])) $_POST['technician'] = ''; 

//master query
$globalquery = $db->query("SELECT * FROM tincidents WHERE id LIKE $db_id");
$globalrow=$globalquery->fetch(); 
$globalquery->closeCursor();

//get last token
$query = $db->query("SELECT token FROM `ttoken` WHERE action='ticket_print' ORDER BY id DESC LIMIT 1");
$token=$query->fetch(); 
$query->closeCursor();

//delete token
$query = $db->query("DELETE FROM `ttoken` WHERE action='ticket_print'");

//secure connect
if ($_GET['token'] && $token['token']==$_GET['token'])
{
	
	//database queries to find values for create print
	$query = $db->query("SELECT * FROM tusers WHERE id LIKE '$globalrow[user]'");
	$userrow=$query->fetch();
	$query->closeCursor();	
		
	$query = $db->query("SELECT * FROM tusers WHERE id LIKE '$globalrow[technician]'");
	$techrow=$query->fetch();
	$query->closeCursor();

	if ($globalrow['t_group']!=0)
	{
		$query = $db->query("SELECT name FROM tgroups WHERE id LIKE '$globalrow[t_group]'");
		$grouptech=$query->fetch();
		$query->closeCursor();
	}

	if ($globalrow['u_group']!=0)
	{
		$query = $db->query("SELECT name FROM tgroups WHERE id LIKE '$globalrow[u_group]'");
		$groupuser=$query->fetch();
		$query->closeCursor();
	}
		
	$query = $db->query("SELECT * FROM tusers WHERE id LIKE '$_SESSION[user_id]'");
	$creatorrow=$query->fetch();
	$query->closeCursor();
		
	$query = $db->query("SELECT name FROM tstates WHERE id LIKE '$globalrow[state]'");
	$staterow=$query->fetch();
	$query->closeCursor();
		
	$query = $db->query("SELECT * FROM tcategory WHERE id LIKE '$globalrow[category]'");
	$catrow=$query->fetch();
	$query->closeCursor();
		
	$query = $db->query("SELECT * FROM tsubcat WHERE id LIKE '$globalrow[subcat]'");
	$subcatrow=$query->fetch();
	$query->closeCursor();

	
	if ($rparameters['ticket_places']==1)
	{
		$query=$db->query("SELECT * FROM tplaces WHERE id LIKE '$globalrow[place]'");
		$placerow=$query->fetch();	
		$query->closeCursor();
		if($placerow['id']!=0)
		{
			$place='
			<tr>
				<td colspan="2"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Lieu').':</b> '.$placerow['name'].'</font></td>
			</tr>
			';
		} else {$place='';}
	} else {$place='';}

	//generate resolution
	if($rparameters['mail_order']==1) {$mail_order='DESC';} else {$mail_order='ASC';}
	$query = $db->query("SELECT * FROM tthreads WHERE ticket=$db_id AND private='0' ORDER BY date $mail_order");
	while ($row = $query->fetch())
	{
		//remove display date from old post 
		$find_old=explode(" ", $row['date']);
		$find_old=$find_old[1];
		if ($find_old!='12:00:00') $date_thread=date_convert($row['date']); else  $date_thread='';
			
		if($row['type']==0)
		{
			//text back-line format
			$text=nl2br($row['text']);
			
			//test if author is not the technician
			if ($row['author']!=$globalrow['technician'])
			{
				//find author name
				$query2 = $db->query("SELECT * FROM tusers WHERE id='$row[author]'");
				$rauthor=$query2->fetch();
				$query2->closeCursor();
				$resolution="$resolution <b> $date_thread $rauthor[firstname] $rauthor[lastname]: </b><br /> $text  <hr />";
			} else {
				if ($date_thread!='')
				{
					$resolution="$resolution <b>$date_thread:</b><br />$text<hr />";
				} else {
					$resolution="$resolution  $text <hr />";
				}
			}
		} 
		if ($row['type']==1)
		{
			//generate attribution thread
			if ($row['group1']!=0)
			{
				$query2=$db->query("SELECT name FROM tgroups WHERE id='$row[group1]'");
				$rtechgroup=$query2->fetch();
				$query2->closeCursor();
				$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Attribution du ticket au groupe').' '.$rtechgroup['name'].'.<br /><br />';
			} else {
				$query2=$db->query("SELECT * FROM tusers WHERE id='$row[tech1]'");
				$rtech3=$query2->fetch();
				$query2->closeCursor();
				$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Attribution du ticket à').' '.$rtech3['firstname'].' '.$rtech3['lastname'].'.<br /><br />';
			}
		}
		if ($row['type']==4)
		{
			//find author name
			$query2 = $db->query("SELECT * FROM tusers WHERE id='$row[author]'");
			$rauthor=$query2->fetch();
			$query2->closeCursor();
			$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Clôture du ticket').' par '.$rauthor['firstname'].' '.$rauthor['lastname'].'.<br /><br />';
		}
		if ($row['type']==5 && $row['state']==2)
		{
			//find author name
			$query2 = $db->query("SELECT * FROM tusers WHERE id='$row[author]'");
			$rauthor=$query2->fetch();
			$query2->closeCursor();
			$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_("Changement d'état en cours").' par '.$rauthor['firstname'].' '.$rauthor['lastname'].'.<br /><br />';
		}
		if ($row['type']==6)
		{
			//find author name
			$query2 = $db->query("SELECT * FROM tusers WHERE id='$row[author]'");
			$rauthor=$query2->fetch();
			$query2->closeCursor();
			$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Ticket facturable').' par '.$rauthor['firstname'].' '.$rauthor['lastname'].'.<br /><br />';
		}
		if ($row['type']==7)
		{
			//find author name
			$query2 = $db->query("SELECT * FROM tusers WHERE id='$row[author]'");
			$rauthor=$query2->fetch();
			$query2->closeCursor();
			$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Ticket non facturable').' par '.$rauthor['firstname'].' '.$rauthor['lastname'].'.<br /><br />';
		}
		if($row['type']==2)
		{
			//generate transfert thread
			if ($row['group1']!=0 && $row['group2']!=0) //case group to group 
			{
				$query2=$db->query("SELECT name FROM tgroups WHERE id='$row[group1]'");
				$rtechgroup1=$query2->fetch();
				$query2->closeCursor();
				$query2=$db->query("SELECT name FROM tgroups WHERE id='$row[group2]'");
				$rtechgroup2=$query2->fetch();
				$query2->closeCursor();
				$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Transfert du ticket du groupe').' '.$rtechgroup1['name'].' '.T_('au groupe ').' '.$rtechgroup2['name'].'. <br /><br />';
			} elseif(($row['tech1']==0 || $row['tech2']==0) && ($row['group1']==0 || $row['group2']==0)) { //case group to tech
				if ($row['tech1']!=0) {
					$query2=$db->query("SELECT * FROM tusers WHERE id='$row[tech1]'");
					$rtech4=$query2->fetch();
					$query2->closeCursor();
				}
				if ($row['tech2']!=0) {
					$query2=$db->query("SELECT * FROM tusers WHERE id='$row[tech2]'");
					$rtech5=$query2->fetch();
					$query2->closeCursor();
				}
				if ($row['group1']!=0) {
					$query2=$db->query("SELECT name FROM tgroups WHERE id='$row[group1]'");
					$rtechgroup4=$query2->fetch();
					$query2->closeCursor();
				}
				if ($row['group2']!=0) {
					$query2=$db->query("SELECT name FROM tgroups WHERE id='$row[group2]'");
					$rtechgroup5=$query2->fetch();
					$query2->closeCursor();
				}
				$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Transfert du ticket de').' '.$rtechgroup4['name'].$rtech4['firstname'].' '.$rtech4['lastname'].' '.T_('à ').' '.$rtechgroup5['name'].$rtech5['firstname'].' '.$rtech5['lastname'].'. <br /><br />';
		}elseif($row['tech1']!=0 && $row['tech2']!=0) { //case tech to tech
				$query2 = $db->query("SELECT * FROM tusers WHERE id='$row[tech1]'");
				$rtech1=$query2->fetch();
				$query2->closeCursor();
				$query2=$db->query("SELECT * FROM tusers WHERE id='$row[tech2]'");
				$rtech2=$query2->fetch();
				$query2->closeCursor();
				$resolution=$resolution.' <b>'.$date_thread.':</b> '.T_('Transfert du ticket de').' '.$rtech1['firstname'].' '.$rtech1['lastname'].' à '.$rtech2['firstname'].' '.$rtech2['lastname'].'. <br /><br />';
			}
		}
	}	
		
	$description = $globalrow['description'];

	//dates conversions
	$date_create = date_convert("$globalrow[date_create]");
	$date_hope = date_convert("$globalrow[date_hope]");
	$date_res = date_convert("$globalrow[date_res]");
	
	
	echo '
	<html>
		<head>
			<title>Impression du ticket n°'.sprintf("%'.08d\n", $globalrow['id']).'</title>
			<meta charset="UTF-8" />
		</head>
		<body onload="window.print()">
			<font face="Arial">
				<table width="800" cellspacing="0" cellpadding="10">
					<tr bgcolor="'.$rparameters['mail_color_title'].'" >
						<th>
							<span style="font-size: large; color: #FFFFFF;"> &nbsp; Ticket n°'.sprintf("%'.08d\n", $globalrow['id']).' &nbsp;</span>
						</th>
					</tr>
					<tr bgcolor="'.$rparameters['mail_color_bg'].'" >
					  <td>
						<font color="'.$rparameters['mail_color_text'].'"></font>
						<table  border="1" bordercolor="'.$rparameters['mail_color_title'].'" cellspacing="0"  cellpadding="5">
							<tr>
								<td><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Titre').':</b></b> '.$globalrow['title'].'</font></td>
								<td><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Catégorie').':</b></b> '.$catrow['name'].' - '.$subcatrow['name'].'</td>
							</tr>
							<tr>
								';
								//detect user group  
								if ($globalrow['u_group']!=0)
								{echo '<td width="400"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Demandeur').':</b></b> '.$groupuser['name'].'</font></td>';}
								else
								{echo '<td width="400"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Demandeur').':</b></b> '.$userrow['firstname'].' '.$userrow['lastname'].'</font></td>';}
								//detect technician group  
								if ($globalrow['t_group']!=0)
								{echo '<td width="400"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Groupe de technicien en charge').':</b> '.$grouptech['name'].'</font></td>';}
								else
								{echo '<td width="400"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Technicien en charge').':</b> '.$techrow['firstname'].' '.$techrow['lastname'].'</font></td>';}
								echo '
							</tr>
							<tr>
								<td><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('État').':</b> '.T_($staterow[0]).'</font></td>
								<td><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Date de la demande').':</b> '.$date_create.'</font></td>	
							</tr>
							'.$place;
							//invert resolution and description part for antechono case
							if($rparameters['mail_order']==1)
							{
								echo '
									<tr>
										<td colspan="2"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Résolution').':</b><br />'.$resolution.'</font></td>
									</tr>
									<tr>
										<td colspan="2"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Description').':</b> '.$description.'</font></td>
									</tr>
								';
							} else {
								echo '
									<tr>
										<td colspan="2"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Description').':</b> '.$description.'</font></td>
									</tr>
									<tr>
										<td colspan="2"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Résolution').':</b>'.$resolution.'</font></td>
									</tr>
								';
							}
							echo '
							<tr>
								<td width="400"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Date de résolution estimé').':</b></b> '.$date_hope.'</font></td>
								<td width="400"><font color="'.$rparameters['mail_color_text'].'"><b>'.T_('Date de résolution').':</b> '.$date_res.'</font></td>
							</tr>
						</table>
					  </td>
					</tr>
				</table>
			</font>
		</body>
	</html>';
} else {
	echo '<div class="alert alert-danger"><strong><i class="icon-remove"></i>'.T_('Erreur').':</strong> '.T_('Vous n\'avez pas les droits d\'accès à cette page. Contacter votre administrateur').'.<br></div>';
}
//function date conversion
function date_convert ($date) 
{return  substr($date,8,2) . '/' . substr($date,5,2) . '/' . substr($date,0,4) . ' '.T_('à').' ' . substr($date,11,2	) . 'h' . substr($date,14,2	);}
$db = null;
?>