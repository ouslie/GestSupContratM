<?php 
################################################################################
# @Name : attachement.php
# @Description : attach file to ticket
# @Call : /ticket.php
# @Parameters : 
# @Author : Flox
# @Create : 06/03/2013
# @Update : 26/03/2019
# @Version : 3.1.40
################################################################################

//initialize variables 
if(!isset($_GET['delimg'])) $_GET['delimg']= ''; 
if(!isset($_GET['id'])) $_GET['id']= ''; 
if(!isset($file_size)) $file_size= ''; 
if(!isset($globalrow['id'])) $globalrow['id']= ''; 

$db_id=strip_tags($db->quote($_GET['id']));
$db_delimg=strip_tags($db->quote($_GET['delimg']));
if($_GET['delimg']=='img1' || $_GET['delimg']=='img2' || $_GET['delimg']=='img3' || $_GET['delimg']=='img4' || $_GET['delimg']=='img5' ) {$db_delimg=$_GET['delimg'];} else {$db_delimg=0;}

//database delete
if ($db_delimg)
{
	//get name of file to delete
	$query=$db->query("SELECT $db_delimg as filename FROM tincidents WHERE id LIKE $db_id");
	$row=$query->fetch();
	$query->closeCursor();

	if($_GET['id'] && $row['filename'])	{if(file_exists('./upload/'.$_GET['id'].'/'.$row['filename'])) {unlink('./upload/'.$_GET['id'].'/'.$row['filename']);}} 
	$db->exec("UPDATE `tincidents` SET $db_delimg='' WHERE `id`=$globalrow[id];");
	
	//redirection vers la page d'accueil
	$www = "./index.php?page=ticket&id=$globalrow[id]&userid=$_GET[userid]&technician=$_GET[technician]";
			echo '<script language="Javascript">
			<!--
			document.location.replace("'.$www.'");
			// -->
			</script>';
}

$qry=$db->prepare("SELECT `img1`,`img2`,`img3`,`img4`,`img5` FROM `tincidents` WHERE id=:id");
$qry->execute(array('id' => $_GET['id']));
$row=$qry->fetch();
$qry->closeCursor();

//find first free slot else not display attach input
if ($row['img1']=="") {$freeslot="1";}
else if ($row['img2']=="") {$freeslot="2";}
else if ($row['img3']=="") {$freeslot="3";}
else if ($row['img4']=="") {$freeslot="4";}
else if ($row['img5']=="") {$freeslot="5";}
else {$freeslot="0";}

if ($freeslot!="0" && ($globalrow['state']!=3 || ($_SESSION['profile_id']==0 || $_SESSION['profile_id']==4)))
{
	echo "
		<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000000\" />
		<input  style=\"display:inline;\" id=\"file$freeslot\" type=\"file\" name=\"file$freeslot\" /> &nbsp;
	";
	if($_GET['action']=='new' && ($_SESSION['profile_id']==1 || $_SESSION['profile_id']==2)) {echo'';}else{echo '<button class="btn btn-minier btn-success" title="'.T_('Charger le fichier').'" name="upload" value="upload" type="submit" id="upload"><i class="icon-upload bigger-140"></i></button>';}
	echo "<br />";
	
	//check size
	$upload_max_size_error=T_('Le fichier est joint est trop volumineux, la taille maximum est ').ini_get('post_max_size');
	$upload_max_size=(preg_replace('/[^0-9.]+/', '', ini_get('post_max_size')))*1024*1024;
	
	if($_GET['action']!='adduser' && $_GET['action']!='edituser'  && $_GET['action']!='addcat' && $_GET['action']!='editcat' && $_GET['action']!='template')
	{
		echo "
		<script>
			$('form').submit(function( e ) {    
				if(!($('#file$freeslot')[0].files[0].size < $upload_max_size )) { 
					//Prevent default and display error
					 alert('$upload_max_size_error');
					e.preventDefault();
				}
			});
		</script>
		";
	}
	
}

if ($row['img1']!='')
{
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  target=\"_blank\" title=\"$row[img1]\" href=\"./upload/$_GET[id]/$row[img1]\" style=\"text-decoration:none\"><i style=\"vertical-align: middle;\" class=\"icon-file blue bigger-200\" ></i>&nbsp;</a>&nbsp;<a target=\"_blank\" title=\"$row[img1]\" href=\"./upload/$_GET[id]/$row[img1]\" >$row[img1]</a>" ;
	if ($_GET['page']!="ticket_u" && ($globalrow['state']!=3 || ($_SESSION['profile_id']==0 || $_SESSION['profile_id']==4))) echo '<a title="'.T_('Supprimer').'" href="./index.php?page=ticket&amp;&userid='.$_GET['userid'].'&amp;&technician='.$_GET['technician'].'&amp;id='.$globalrow['id'].'&amp;delimg=img1"> <i class="icon-trash red bigger-140"></i></a>';
	if (is_dir("./upload/$_GET[id]/")) {
		if(file_exists("./upload/$_GET[id]/$row[img1]"))
		{
			$file_size = filesize("./upload/$_GET[id]/$row[img1]");
			$file_size=round($file_size/1024,0);
			echo " ($file_size Ko)<br />";
		} else {
			echo ' ('.T_('Le fichier a été supprimé du serveur').')<br />';
		}
	} else {echo ' ('.T_('Le repertoire de ce ticket a été supprimé du serveur').')<br />';}
}

if ($row['img2']!='')
{
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  target=\"_blank\" href=\"./upload/$_GET[id]/$row[img2]\" title=\"$row[img2]\" style=\"text-decoration:none\"><i style=\"vertical-align: middle;\" class=\"icon-file blue bigger-200\" ></i>&nbsp;</a>&nbsp;<a target=\"_blank\" href=\"./upload/$_GET[id]/$row[img2]\" title=\"$row[img2]\">$row[img2]</a>";
	if ($_GET['page']!="ticket_u" && ($globalrow['state']!=3 || ($_SESSION['profile_id']==0 || $_SESSION['profile_id']==4))) echo '<a title="'.T_('Supprimer').'" href="./index.php?page=ticket&amp;&userid='.$_GET['userid'].'&amp;&technician='.$_GET['technician'].'&amp;id='.$globalrow['id'].'&amp;delimg=img2"> <i class="icon-trash red bigger-140"></i></a>';
	if (is_dir("./upload/$_GET[id]/")) {
		if(file_exists("./upload/$_GET[id]/$row[img2]"))
		{
			$file_size = filesize("./upload/$_GET[id]/$row[img2]");
			$file_size=round($file_size/1024,0);
			echo " ($file_size Ko)<br />";
		} else {
			echo ' ('.T_('Le fichier a été supprimé du serveur').')<br />';
		}
	} else {echo ' ('.T_('Le repertoire de ce ticket a été supprimé du serveur').')<br />';}
}

if ($row['img3']!='')
{
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  target=\"_blank\" href=\"./upload/$_GET[id]/$row[img3]\" title=\"$row[img3]\" style=\"text-decoration:none\"><i style=\"vertical-align: middle;\" class=\"icon-file blue bigger-200\" ></i>&nbsp;</a>&nbsp;<a target=\"_blank\" href=\"./upload/$_GET[id]/$row[img3]\" title=\"$row[img3]\" >$row[img3]</a>";
	if ($_GET['page']!="ticket_u" && ($globalrow['state']!=3 || ($_SESSION['profile_id']==0 || $_SESSION['profile_id']==4))) echo '<a title="'.T_('Supprimer').'" href="./index.php?page=ticket&amp;&userid='.$_GET['userid'].'&amp;&technician='.$_GET['technician'].'&amp;id='.$globalrow['id'].'&amp;delimg=img3"> <i class="icon-trash red bigger-140"></i></a>';
	if (is_dir("./upload/$_GET[id]/")) {
		if(file_exists("./upload/$_GET[id]/$row[img3]"))
		{
			$file_size = filesize("./upload/$_GET[id]/$row[img3]");
			$file_size=round($file_size/1024,0);
			echo " ($file_size Ko)<br />";
		} else {
			echo ' ('.T_('Le fichier a été supprimé du serveur').')<br />';
		}
	} else {echo ' ('.T_('Le repertoire de ce ticket a été supprimé du serveur').')<br />';}
}

if ($row['img4']!='')
{
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  target=\"_blank\" href=\"./upload/$_GET[id]/$row[img4]\" title=\"$row[img4]\" style=\"text-decoration:none\"><i style=\"vertical-align: middle;\" class=\"icon-file blue bigger-200\" ></i>&nbsp;</a>&nbsp;<a target=\"_blank\" href=\"./upload/$_GET[id]/$row[img4]\" title=\"$row[img4]\" >$row[img4]</a>";
	if ($_GET['page']!="ticket_u" && ($globalrow['state']!=3 || ($_SESSION['profile_id']==0 || $_SESSION['profile_id']==4))) echo '<a title="'.T_('Supprimer').'" href="./index.php?page=ticket&amp;&userid='.$_GET['userid'].'&amp;&technician='.$_GET['technician'].'&amp;id='.$globalrow['id'].'&amp;delimg=img4"> <i class="icon-trash red bigger-140"></i></a>';
	if (is_dir("./upload/$_GET[id]/")) {
		if(file_exists("./upload/$_GET[id]/$row[img4]"))
		{
			$file_size = filesize("./upload/$_GET[id]/$row[img4]");
			$file_size=round($file_size/1024,0);
			echo " ($file_size Ko)<br />";
		} else {
			echo ' ('.T_('Le fichier a été supprimé du serveur').')<br />';
		}
	} else {echo ' ('.T_('Le repertoire de ce ticket a été supprimé du serveur').')<br />';}
}
if ($row['img5']!='')
{
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a target=\"_blank\" href=\"./upload/$_GET[id]/$row[img5]\" title=\"$row[img5]\" style=\"text-decoration:none\"><i style=\"vertical-align: middle;\" class=\"icon-file blue bigger-200\" ></i>&nbsp;</a>&nbsp;<a target=\"_blank\" href=\"./upload/$_GET[id]/$row[img5]\" title=\"$row[img5]\" >$row[img5]</a>";
	if ($_GET['page']!="ticket_u" && ($globalrow['state']!=3 || ($_SESSION['profile_id']==0 || $_SESSION['profile_id']==4))) echo '<a title="'.T_('Supprimer').'" href="./index.php?page=ticket&amp;&userid='.$_GET['userid'].'&amp;&technician='.$_GET['technician'].'&amp;id='.$globalrow['id'].'&amp;delimg=img5"> <i class="icon-trash red bigger-140"></i></a>';
	if (is_dir("./upload/$_GET[id]/")) {
		if(file_exists("./upload/$_GET[id]/$row[img5]"))
		{
			$file_size = filesize("./upload/$_GET[id]/$row[img5]");
			$file_size=round($file_size/1024,0);
			echo " ($file_size Ko)<br />";
		} else {
			echo ' ('.T_('Le fichier a été supprimé du serveur').')<br />';
		}
	} else {echo ' ('.T_('Le repertoire de ce ticket a été supprimé du serveur').')<br />';}
}
?>