<?php
/*
 *
 * http://editablegrid.net
 *
 * Copyright (c) 2011 Webismymind SPRL
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://editablegrid.net/license
 */
$db->exec("set names utf8");

// Get all parameter provided by the javascript
$user = $_POST['user'];
$type = $_POST['type'];
$service = $_POST['service'];
$periode = $_POST['periode'];
$date_debut = $_POST['date_debut'];
$date_fin = $_POST['date_fin'];
$temps_souscrit = $_POST['temps_souscrit'];
$montantheure = $_POST['montantheure'];
$tarifcontrat = $_POST['tarifcontrat'];
if(!isset($_POST['prepaye'])){ $prepaye=0;}else {$prepaye = $_POST['prepaye'];}
$name = $_POST['name'];

print_r($_POST);

$return = false;

$requete = $db->prepare("INSERT INTO tcontrats SET
		user = :user,
		type = :type,
		service = :service,
		periode = :periode,
		date_souscription = :date_debut,
		date_fin = :date_fin,
		temps_souscrit = :temps_souscrit,
		tarif = :montantheure,
		tarifcontrat= :tarifcontrat,
        prepaye= :prepaye,
		nom = :nom,
        status = 1
		");

$requete->bindValue(':user', $user);
$requete->bindValue(':type', $type);
$requete->bindValue(':service', $service);
$requete->bindValue(':periode', $periode);
$requete->bindValue(':date_debut', $date_debut);
$requete->bindValue(':date_fin', $date_fin);
$requete->bindValue(':temps_souscrit', $temps_souscrit);
$requete->bindValue(':montantheure', $montantheure);
$requete->bindValue(':tarifcontrat', $tarifcontrat);
$requete->bindValue(':prepaye', $prepaye);
$requete->bindValue(':nom', $name);

$return = $requete->execute();
$requete = null;
echo $return ? "ok" : "error";
