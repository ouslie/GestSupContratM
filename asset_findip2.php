<?php
################################################################################
# @Name : asset_findip2.php
# @Desc : search free ip
# @call : ./asset.php
# @parameters :  
# @Author : Flox
# @Create : 22/12/2015
# @Update : 04/02/2017
# @Version : 3.1.17
################################################################################

//initialize variables 
if(!isset($_GET['id'])) $_GET['id'] = ''; 
if(!isset($_POST['Ajouter'])) $_POST['Ajouter'] = ''; 
if(!isset($_POST['network'])) $_POST['network'] = '';
if(!isset($_POST['add'])) $_POST['add'] = ''; 

if ($_POST['add'] && $_POST['ip2']!='')
{
	//redirect to close modal
	$www = "./index.php?page=asset&id=$_GET[id]&findip2=$_POST[ip2]";
	echo '<script language="Javascript">
	<!--
	document.location.replace("'.$www.'");
	// -->
	</script>';
} 

if($_POST['network']!='')
{
	//get selected network informations
	$query=$db->query("SELECT * FROM `tassets_network` WHERE id=$_POST[network]");
	$row=$query->fetch();
	$query->closeCursor();
	$netmask=$row['netmask'];
	$network=$row['network'];
	$network=explode('.',$network);
	
	//find free ip in this network
	for ($i = 1; $i < 254; $i++) {
		//generate test ip
		$test_ip=$network[0].'.'.$network[1].'.'.$network[2].'.'.$i;
		//check if this ip exist
		$exist_ip=0;
		$query = $db->query("SELECT * FROM `tassets` WHERE (ip='$test_ip' OR ip2='$test_ip') AND disable='0' AND state='2'");
		$row=$query->fetch(); 
		$query->closeCursor();
		if($row[0]) {$exist_ip=1;} 
		if ($exist_ip!=1) {break;}
	}
	$findip=$test_ip;
	
} else {$findip=$_POST['ip2'];}

$boxtitle="<i class='icon-globe blue bigger-120'></i>".T_('Recherche d\'adresse IP');
$boxtext='
<form name="form" method="POST" action="" id="form">
	<input  name="add" type="hidden" value="1">
	<label for=\"network\" >'.T_('Réseau').':</label> 
	<select id="network" name="network" style="width:133px" onchange="submit();">
		';
			$boxtext= $boxtext.'<option value="">'.T_('Aucun').'</option>';
			$query = $db->query("SELECT * FROM `tassets_network` WHERE disable='0' ORDER BY name ASC");
			while ($row = $query->fetch()) {
				if ($_POST['network']==$row['id']) 
				{
					$boxtext= $boxtext.'<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
				} else {
					$boxtext= $boxtext.'<option value="'.$row['id'].'">'.$row['name'].'</option>';	
				}
			} 
			$query->closeCursor(); 
        	$boxtext= $boxtext.'		
	</select>
	<br />
	<label for="ip2">IP:</label> 
	<input  name="ip2" type="text" value="'.$findip.'" size="26">
</form>
';
$valid=T_('Ajouter');
$action1="$('form#form').submit(); ";
$cancel=T_('Fermer');
$action2="$( this ).dialog( \"close\" ); ";
include "./modalbox.php"; 
?>