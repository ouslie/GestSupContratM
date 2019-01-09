<?php

if ($_POST["submit"]=="Envoyer")
	{
require "connect.php";



	 $name = $_POST["name"];

	 $hostftp = $_POST["hostftp"];
	 $userftp = $_POST["userftp"];

	 $hostsql = $_POST["hostsql"];
	 $usersql = $_POST["usersql"];


	 $hostsite = $_POST["adresseadmin"];
	 $usersite = $_POST["useradmin"];
	 $passwordsite = $_POST["passwordadmin"];

	$query = "INSERT INTO `tidentif` (`nom`, `ftphost`, `ftpuser`, `ftppass`,`sqlhost`, `sqluser`, `sqlpass`, `sitehost`, `siteuser`, `sitepass`) VALUES ('$name', '$hostftp', '$userftp', '$passwordftp', '$hostsql', '$usersql', '$passwordsql', '$hostsite', '$usersite', '$passwordsite')";

	
							$query = $db->query($query);


  echo '<META http-equiv="refresh" content="3; URL=https://www.arnaudguy.fr/merci">';


	}
	else
	{
	?>
	<META http-equiv="refresh" URL="https://www.arnaudguy.fr/">
	<?
	}
?>
