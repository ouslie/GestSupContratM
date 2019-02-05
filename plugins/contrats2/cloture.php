<?php
function cloturecontrat($id_contrat,$notificationmail)
{
    global $db;
    global $query;
    global $mail;
    global $rparameters;
    global $emetteur;
    global $tomail;
    global $sujet;
    global $messages;
    $var = $id_contrat;
    $query = "UPDATE tcontrats SET status='0' WHERE id=$var";
    $query = $db->query($query);
    $query = "SELECT tcontrats.user,tcontrats.service, tcontrats.id, tcontrats.date_souscription, tcontrats.date_fin,tcontrats.tarif, tcontrats.tarifcontrat, tusers.id, tusers.mail, tusers.useridfacture, tcontrats.type, tcontrats.nom,tcontrats.facturelink,tcontrats.prepaye,tcontrats.periode, tcontratstype.nom AS typecontrat  FROM tcontrats INNER JOIN tusers ON (tcontrats.user=tusers.id) INNER JOIN tcontratstype ON (tcontrats.type = tcontratstype.id) WHERE tcontrats.id=$var";
    $query = $db->query($query);
    while ($row = $query->fetch()) {
        $mailuser = $row['mail'];
        $nomcontrat = $row['nom'];
        $periode = $row['periode'];
        $typecontrat = $row['type'];
        $service = $row['service'];
        $prepaye = $row['prepaye'];
        $useridfacture = $row['useridfacture'];
        $date_debut = $row['date_souscription'];
        $date_fin = $row['date_fin'];
        $tarifcontrat = $row['tarifcontrat'];
        $tarif = $row['tarif'];
        $contratid = $row['id'];
        $facturelink = $row['facturelink'];
    }
    $query = "SELECT * FROM webservice WHERE name = 'prod'";
    $query = $db->query($query);
    $webservice = $query->fetch();
    $facturelink = $webservice['url'];
    $facturelink .= "facture.php?id_fact=";

    if ($typecontrat == 2) {

        $date_debut = date("d-m-Y", strtotime($date_debut));
        $date_fin = date("d-m-Y", strtotime($date_fin));

        $designation = <<<EOD
         <p> $service <br> Du : $date_debut Au : $date_fin 
EOD;

        $id_facture = WebserviceFacture($useridfacture, $designation, $tarifcontrat, $webservice['token'], 1, $webservice['url'], 46);
        echo "Facture ID :";
        echo $id_facture;
        $facturelink .= $id_facture;
        $query = "UPDATE tcontrats SET facturelink = '$facturelink' WHERE id=$var";
        $query = $db->query($query);

        $subject = "Notifications de clôture contrat";
        $messages = "Bonjour,  </br> </br>";
        $messages .= "Votre contrat " . $nomcontrat . " " . $periode . " à été clôturé. </br>";
        $messages .= "Vous trouverez ci-dessous le lien pour la facture :  </br>";
        $messages .= "<a href=$facturelink> Ma facture</a> </br> </br>";
        $messages .= "Retouvez vos tickets et factures< sur <a href='https://support.arnaudguy.fr'> ICI</a>";
        $messages .= "Je reste à votre disposition, </br> ";
        $messages .= "Arnaud GUY </br>";
        $messages .= "www.arnaudguy.fr </br>";

    }
    if ($typecontrat == 1) {
        $query = "SELECT sum(time) AS timeused, tcontrats.id FROM tincidents
             INNER JOIN tcontrats ON (tincidents.contrats=tcontrats.id)
             WHERE  tcontrats.id = $var
             ";
        $query = $db->query($query);
        $row = $query->fetch();

        $quantity = round($row['timeused'] / 60, 2);

        $formatter = new IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'Europe/Paris',
            IntlDateFormatter::GREGORIAN
        );
        $formatter->setPattern("MMMM y");
        $date = new DateTime($date_debut);

        $month = $formatter->format($date);//affiche 14 février 2012
        $designation = <<<EOD
             <p> $service $tarif €/H<br> $month 
EOD;

        $id_facture = WebserviceFacture($useridfacture, $designation, $tarif, $webservice['token'], $quantity, $webservice['url'], 44);
         echo "Facture ID :";
        echo $id_facture;
        $facturelink .= $id_facture;
        $query = "UPDATE tcontrats SET facturelink = '$facturelink' WHERE id='$var'";
        $query = $db->query($query);

        $subject = "Notifications clôture décompte d'heure mensuel";
        $messages = "Bonjour,  </br></br>";
        $messages .= "Votre décompte d'heure mensuel à été cloturé.</br>";
        $messages .= "Vous trouverez ci-dessous le lien pour la facture : </br>";
        $messages .= "<a href=$facturelink> Ma facture</a> </br> </br>";
        $messages .= "Retouvez vos tickets et factures< sur <a href='https://support.arnaudguy.fr'> ICI</a>";
        $messages .= "Je reste à votre disposition,</br>";
        $messages .= "Arnaud GUY</br>";
        $messages .= "www.arnaudguy.fr</br>";
        $messages .= "www.arnaudguy.fr</br>";

    }

    if ($typecontrat == 3) {
        $subject = "Notifications de clôture contrat";
        $messages = "Bonjour,  </br> </br>";
        $messages .= "Votre contrat " . $service . " " . $periode . " est arrivé à expiration et à donc été cloturé. </br> </br>";
        $messages .= "Je reste à votre disposition, </br> ";
        $messages .= "Arnaud GUY </br>";
        $messages .= "www.arnaudguy.fr </br>";

    }

    include 'components/PHPMailer/src/PHPMailer.php';
    include 'components/PHPMailer/src/SMTP.php';
    include 'components/PHPMailer/src/Exception.php';
    require_once './core/crypt.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    $mail->AddAddress("$mailuser");
    $mail->CharSet = 'UTF-8'; //ISO-8859-1 possible if string problems
    if ($rparameters['mail_smtp_class'] == 'IsSendMail()') {
        $mail->IsSendMail();
    } else {
        $mail->IsSMTP();
    }
    if ($rparameters['mail_secure'] == 'SSL') {
        $mail->Host = "ssl://$rparameters[mail_smtp]";
    } elseif ($rparameters['mail_secure'] == 'TLS') {
        $mail->Host = "tls://$rparameters[mail_smtp]";
    } else {
        $mail->Host = "$rparameters[mail_smtp]";
    }
    $mail->SMTPAuth = $rparameters['mail_auth'];
    if ($rparameters['debug'] == 1) {
        $mail->SMTPDebug = 4;
    }

    if ($rparameters['mail_secure'] != 0) {
        $mail->SMTPSecure = $rparameters['mail_secure'];
    }

    if ($rparameters['mail_port'] != 25) {
        $mail->Port = $rparameters['mail_port'];
    }

    $mail->Username = "$rparameters[mail_username]";
    if (preg_match('/gs_en/', $rparameters['mail_password'])) {
        $rparameters['mail_password'] = gs_crypt($rparameters['mail_password'], 'd', $rparameters['server_private_key']);
    }
    $mail->Password = "$rparameters[mail_password]";
    $mail->IsHTML(true);

    $mail->From = "notifications@arnaudguy.fr";
    $mail->FromName = "Arnaud GUY | Notifications";
    $mail->AddCC('contact@arnaudguy.fr', 'Arnaud GUY | Notifications');
    $mail->Subject = "$subject";
    $mail->Body = "$messages";
    if ($notificationmail == "on") {
        if (!$mail->Send()) {
            echo '<div class="alert alert-block alert-danger"><center><i class="icon-remove red"></i> <b>' . T_('Message non envoyé, vérifier la configuration de votre serveur de messagerie') . '.</b> (';
            echo $mail->ErrorInfo;
            echo ')</center></div>';
        } elseif (isset($_SESSION['user_id'])) {
            echo '<div class="alert alert-block alert-success"><center><i class="icon-envelope green"></i> ' . T_('Message envoyé') . '.</center></div>';
    
        }
        $mail->SmtpClose();

    }
}
?>