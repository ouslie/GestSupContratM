<?php
################################################################################
# @Name : stat.php
# @Desc : Display Statistics
# @call : /menu.php
# @parameters :
# @Author : Flox
# @Create : 12/01/2011
# @Update : 28/12/2016
# @Version : 3.1.15
################################################################################
//secure ticket access page
//ini_set("display_errors", "1");
$token_export =uniqid();
$db->exec("INSERT INTO ttoken (token) VALUES ('$token_export')");
?>

<style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
/* Modal Content */
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 80%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
}
/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}
@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}
/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.modal-header {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}
.modal-body {padding: 2px 16px;}
.modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}
</style>

<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Ajouter un nouveau contrat</h2>
<?php echo $_POST["id"];
 echo $_GET["id"]; ?>
    </div>
    <div class="modal-body">
						<form  method="post">
							<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right" for=""><?php echo T_('Demandeur'); ?>:</label>
							</label>
							<div class="col-sm-8">
							<?php

$query="SELECT * FROM tusers";
$query = $db->query($query);
$option = '';
while ($row = $query->fetch())
{
$option .= '<option value = "'.$row['id'].'">'.$row['firstname'].'&nbsp;'.$row['lastname'].'</option>';
}
?>
<html>
<body>
<form>
 <select id="demandeur" name="demandeur">
<?php echo $option; ?>
</select>
							</div>
							</div>
							<br></br>

						<br></br>
							<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right" for=""><?php echo T_('Type de contrat'); ?>:</label>
							</label>
							<div class="col-sm-8">
							<?php

$query="SELECT * FROM tcontratstype WHERE fonction = 'type'";
$query = $db->query($query);
$option = '';
while ($row = $query->fetch())
{
$option .= '<option value = "'.$row['id'].'">'.$row['nom'].'</option>';
}
?>
<html>
<body>
<form>
 <select id="type" name="type">
<?php echo $option; ?>
</select>
							</div>
							</div>
							<br></br>
							<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right" for=""><?php echo T_('Service'); ?>:</label>
							</label>
							<div class="col-sm-8">

<html>
<body>
<form>
 <select id="service" name="service">
<option value="Webmastering"> Webmastering </option>
<option value="Infogérance"> Infogérance </option>
<option value="Infogérance + Webmastering"> Infogérance + Webmastering </option>
</select>
							</div>
							</div>
							<br></br>

																				<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right" for=""><?php echo T_('Période'); ?>:</label>
							</label>
							<div class="col-sm-8">


 <select id="periode" name="periode">
<option value="Mensuel">Mensuel</option>
<option value="Annuel">Annuel</option>

</select>
							</div>
							</div>
							<br></br>

							<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right" for=""><?php echo T_('Date de début'); ?>:</label>
							<div class="col-sm-8">
								<input  type="text" id="date_debut" name="date_debut" >
							</div>
						</div>
						<br></br>
						<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right" for=""><?php echo T_('Date de fin'); ?>:</label>
							<div class="col-sm-8">
								<input  type="text" id="date_fin" name="date_fin" >
							</div>
						</div>
						<br></br>

							<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right" for=""><?php echo T_('Temps souscrit en min'); ?>:</label>
							<div class="col-sm-8">
								<input  type="text" id="temps_souscrit" name="temps_souscrit" >
							</div>
						</div>
						<br></br>
							<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right" for=""><?php echo T_('Montant par heure'); ?>:</label>
							<div class="col-sm-8">
								<input  type="text" id="montantheure" name="montantheure" >
							</div>
						</div>
						<br></br>
							<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right" for=""><?php echo T_('Tarif Contrat'); ?>:</label>
							<div class="col-sm-8">
								<input  type="text" id="tarifcontrat" name="tarifcontrat" >
							</div>
						</div>
						<br></br>
						<div class="form-group">
						<input type="submit" name="ajoutcontrat" value="OK">
						</div>
						</form>

    </div>
   </div>
</div>

<script type="text/javascript" src="./template/assets/js/jquery-2.0.3.min.js"></script>
<script src="./components/Highcharts/js/highcharts.js"></script>
<script src="./components/Highcharts/js/modules/exporting.js"></script>
<?php
//Verification droit
if ($rright['admin_contrat']!=0)
	{
	//include
//	include("contratsajout.php");
	//Recupération variable
	$view = $_GET['view'];

	function selectcontrat($view)
		{
		global $db;
		global $query;
		if ($view==1)
			{
			$query="SELECT sum(time) AS timeused, tcontrats.id, tusers.firstname, tusers.lastname, tcontrats.status,tcontrats.nom as nomcontrat,tcontrats.date_souscription,tcontrats.date_fin ,tcontrats.temps_souscrit, 					tcontrats.tarif, tcontratstype.nom as nomtype, tcontrats.periode as nomperiode, tcontrats.prepaye, tcontrats.tarifcontrat, tcontrats.facturelink
			FROM tincidents
			INNER JOIN tusers ON (tincidents.user=tusers.id)
			INNER JOIN tcontrats ON (tincidents.contrats=tcontrats.id)
			INNER JOIN tcontratstype ON (tcontrats.type=tcontratstype.id)
			WHERE tcontratstype.id = 1 AND tcontrats.status = 1
			GROUP BY tincidents.user, tcontrats.id
			ORDER BY tcontrats.id DESC";
			}
		if ($view==2)

			{
			$query="SELECT tcontrats.id , tcontrats.user, tcontrats.status, tcontrats.nom AS nomcontrat,tcontrats.type,tcontrats.date_souscription,tcontrats.date_fin,tcontrats.tarifcontrat,tusers.lastname,tusers.firstname,tcontratstype.nom AS nomtype, tcontrats.temps_souscrit, tcontrats.periode as nomperiode, tcontrats.facturelink
			FROM tcontrats
			INNER JOIN tusers ON (tcontrats.user=tusers.id)
			INNER JOIN tcontratstype ON (tcontrats.type=tcontratstype.id)
			WHERE tcontratstype.id = $view AND tcontrats.status = 1
			ORDER BY tcontrats.id DESC";
			}

				if ($view==4)
					{
					$query="SELECT sum(time) AS timeused, tcontrats.id, tusers.firstname, tusers.lastname, tcontrats.status,tcontrats.nom as nomcontrat,tcontrats.date_souscription,tcontrats.date_fin ,tcontrats.temps_souscrit, 					tcontrats.tarif, tcontratstype.nom as nomtype, tcontrats.periode as nomperiode, tcontrats.prepaye, tcontrats.tarifcontrat, tcontrats.facturelink
					FROM tincidents
					INNER JOIN tusers ON (tincidents.user=tusers.id)
					INNER JOIN tcontrats ON (tincidents.contrats=tcontrats.id)
					INNER JOIN tcontratstype ON (tcontrats.type=tcontratstype.id)
					WHERE tcontratstype.id = 1 AND tcontrats.status = 0
					GROUP BY tincidents.user, tcontrats.id
					ORDER BY tcontrats.id DESC";
					}
					if ($view==3)
						{
							$query="SELECT tcontrats.id , tcontrats.user, tcontrats.status, tcontrats.nom AS nomcontrat,tcontrats.type,tcontrats.date_souscription,tcontrats.date_fin,tcontrats.tarifcontrat,tusers.lastname,tusers.firstname,tcontratstype.nom AS nomtype, tcontrats.temps_souscrit, tcontrats.periode as nomperiode, tcontrats.facturelink
							FROM tcontrats
							INNER JOIN tusers ON (tcontrats.user=tusers.id)
							INNER JOIN tcontratstype ON (tcontrats.type=tcontratstype.id)
							WHERE tcontratstype.id = 2 AND tcontrats.status = 0
							ORDER BY tcontrats.id DESC";
						}
		}
	function hour_min($minutes)
		{
		if($minutes == 0){return '';}
		else
    		{
			$hours  = round(intval($minutes/60) , 2); //round down to nearest minute.
			$minutes = $minutes % 60; return sprintf("%02d", $hours).'h'.sprintf("%02d", $minutes).'min';
			}
		}
	function hour_min2($minutes)
		{
		if($minutes == 0){return '';}
		else
			{
			$hours  = round(intval($minutes/60) , 2); //round down to nearest minute.
			$minutes = $minutes % 60; return  $hours.','.sprintf("%02d", $minutes).'';
			}
		}
	function nbrecontrattype($typecontrat, $status)
		{
		global $db;
		global $query;
		$query = "SELECT * FROM tcontrats WHERE type = '$typecontrat' AND status = '$status'";
		$query = $db->query($query);
		$count = $query->rowCount();
		echo $count;
		$query->closecursor();
		}
	function addcontrat()
		{
		global $db;
		global $query;
		$demandeur =   $_POST['demandeur'];
		$type =   $_POST['type'];
		$periode =   $_POST['periode'];
		$date_debut =  $_POST['date_debut'];
		$date_fin =  $_POST['date_fin'];
		$temps_souscrit = $_POST['temps_souscrit'];
		$montantheure =   $_POST['montantheure'];
		$tarifcontrat =   $_POST['tarifcontrat'];
		$service =   $_POST['service'];
		$query = "INSERT INTO tcontrats (user, status, date_souscription, date_fin, temps_souscrit, tarif, tarifcontrat, type, periode,nom) VALUES ('$demandeur', '1' , STR_TO_DATE('$date_debut', '%d/%m/%Y'),STR_TO_DATE('$date_fin', '%d/%m/%Y'), '$temps_souscrit', '$montantheure','$tarifcontrat', '$type', '$periode','$service')";
		$query = $db->query($query);
		echo '<meta http-equiv="refresh" content="0">';
		}
	function cloturecontrat()
		{
		global $db;
		global $query;
		global $mail;
		global $rparameters;
		global $emetteur;
		global $tomail;
		global $sujet;
		global $messages;
		$var = $_POST['peer-id'];
		$notificationmail = $_POST['notificationmail'];
		$query = "UPDATE tcontrats SET status='0' WHERE id='$var'";
		$query = $db->query($query);
		$query = "SELECT tcontrats.user, tcontrats.id, tusers.id, tusers.mail, tcontrats.type, tcontrats.nom,tcontrats.facturelink,tcontrats.prepaye,tcontrats.periode, tcontratstype.nom AS typecontrat  FROM tcontrats INNER JOIN tusers ON (tcontrats.user=tusers.id) INNER JOIN tcontratstype ON (tcontrats.type = tcontratstype.id) WHERE tcontrats.id='$var'";
		$query = $db->query($query);
		while ($row = $query->fetch()) {
 		$mailuser = $row['mail']; $nomcontrat = $row['nom']; $periode = $row['periode']; $typecontrat = $row['type'];  $prepaye = $row['prepaye'];
    if (isset($facturelink)){}else{$facturelink = $row['facturelink'];}
  }
		if ($typecontrat==2){
			$subject   ="Notifications de clôture contrat";
			$messages  = "Bonjour,  </br> </br>";
			$messages .="Votre contrat ". $nomcontrat ." ". $periode ." à été clôturé. </br>";
			$messages .="Vous trouverez ci-dessous le lien pour la facture :  </br>";
			$messages .=" $facturelink  </br> </br>";
			$messages .="Je reste à votre disposition, </br> ";
			$messages .="Arnaud GUY </br>";
			$messages .="www.arnaudguy.fr </br>";
		}
		if ($typecontrat==1){
			if ($prepaye==0){
				$subject   ="Notifications clôture décompte d'heure mensuel";
				$messages  = "Bonjour,  </br></br>";
				$messages .="Votre décompte d'heure mensuel à été cloturé.</br>";
				$messages .="Vous trouverez ci-dessous le lien pour la facture : </br>";
				$messages .=" $facturelink </br></br>";
				$messages .="Je reste à votre disposition,</br>";
				$messages .="Arnaud GUY</br>";
				$messages .="www.arnaudguy.fr</br>";

			} else {
				$subject   ="Notifications de clôture contrat";
				$messages  = "Bonjour,  </br> </br>";
				$messages .="Votre contrat ". $nomcontrat ." ". $periode ." est arrivé à expiration et à donc été cloturé. </br> </br>";
				$messages .="Je reste à votre disposition, </br> ";
				$messages .="Arnaud GUY </br>";
				$messages .="www.arnaudguy.fr </br>";

			}


		}
		include('components/PHPMailer/src/PHPMailer.php');
		include('components/PHPMailer/src/SMTP.php');
		include('components/PHPMailer/src/Exception.php');
		/*
		require_once('components/PHPMailer/src/PHPMailer.php');
		require_once('components/PHPMailer/src/SMTP.php');
		require_once('components/PHPMailer/src/Exception.php');
		*/
		$mail = new PHPMailer\PHPMailer\PHPMailer(true);
		$mail->AddAddress("$mailuser");
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
		$mail->Password = "$rparameters[mail_password]";
		$mail->IsHTML(true);
		if($rparameters['mail_from_adr']==''){$emetteur=$creatorrow['mail'];} else {$emetteur=$rparameters['mail_from_adr'];}

		$mail->From = "notifications@arnaudguy.fr";
		$mail->FromName = "Arnaud GUY | Notifications";
		$mail->AddCC('contact@arnaudguy.fr', 'Arnaud GUY | Notifications');
		$mail->Subject = "$subject";
		$mail->Body = "$messages";

		if ($notificationmail==on){
		//mail($mailuser,$subject,$messages,implode("\r\n", $headers));
		if (!$mail->Send()){
				echo '<div class="alert alert-block alert-danger"><center><i class="icon-remove red"></i> <b>'.T_('Message non envoyé, vérifier la configuration de votre serveur de messagerie').'.</b> (';
						echo $mail->ErrorInfo;
				echo ')</center></div>';
		} elseif(isset($_SESSION['user_id'])) {
			echo '<div class="alert alert-block alert-success"><center><i class="icon-envelope green"></i> '.T_('Message envoyé').'.</center></div>';
			//redirect

		}
		$mail->SmtpClose();

		echo '<meta http-equiv="refresh" content="0">';

		}
		}
	//Ajout contrat
	if(isset($_POST['ajoutcontrat']) )
		{
		addcontrat();
		}

  //Ajoute $facturelink

  if(isset($_POST['addfacture']) )
    {
      $var = $_POST['peer-id'];
      $facturelink = $_POST['facturelink'];
      echo $var;
      echo $facturelink;
      $query = "UPDATE tcontrats SET facturelink='$facturelink' WHERE id='$var'";
      $query = $db->query($query);
    }

	// cloture du contrat


	if(isset($_POST['formSubmitdelete'])||  isset($_POST['formSubmitcloture']) )
		{
		$var = $_POST['peer-id'];?>
		<div class="page-header position-relative">
			<h1><i class="icon-briefcase"></i>Cloture contrats numéro &nbsp;<?php echo $var; ?></h1>
		</br>
    <?php

    $query = "SELECT facturelink FROM tcontrats WHERE id='$var'";
    $query = $db->query($query);
    while ($row = $query->fetch()) {
    $facturerecup = $row['facturelink'];
  }
     ?>
		<form id="myformaddfact" method="POST" action="">
			<p> Lien facture : <input type="text" name="facturelink" value="<?php echo $facturerecup;?>">
        <input type="hidden" name="peer-id" value="<?php echo $var;?>" >
        <button type="submit" name="addfacture" value="addfact" class="btn btn-sm btn-success">Ajouter</button>
      </p>
    </form>

    <form id="myFormcloture" method="POST" action="">
			<p> Notification mail : <input type="checkbox" name="notificationmail">
			<input type="hidden" name="peer-id" value="<?php echo $var;?>" >
				<button type="submit" name="formSubmitcloture" value="Clore" class="btn btn-sm btn-danger">
					<i class="icon-remove icon-on-right bigger-110"></i>
					&nbsp;Clore
				</button>
        </p>
		</form>
	</div>
		<?php
		if(isset($_POST['formSubmitcloture']) )
			{
			cloturecontrat();
			}
		}
		else
			{

				?>

			<div class="page-header position-relative">
				<h1><i class="icon-briefcase"></i>  <?php echo T_('Contrats'); ?></h1>
				<button id="myBtn" name="myBtn" class="btn btn-sm btn-success" dataid="3">
					<i class="icon-plus bigger-120"></i> Nouveau contrat
				</button>

				<a href=index.php?page=contratsadmin&view=1>
					<button class="btn btn-sm btn-success">
						Décompte d'heure
						</br>
						Actif	<?php nbrecontrattype(1,1);?>
					</button>
				</a>

				<a href=index.php?page=contratsadmin&view=2>
					<button class="btn btn-sm btn-success">
						&nbsp;
						Contrats maintenance
						</br>
						Actif
						<?php nbrecontrattype(2,1);?>
					</button>
					<a href=index.php?page=contratsadmin&view=3>
						<button class="btn btn-sm btn-danger">
							&nbsp;
							Contrats maintenance Inactif
							</br>
							Actif
							<?php nbrecontrattype(2,0);?>
						</button>
						<a href=index.php?page=contratsadmin&view=4>
							<button class="btn btn-sm btn-danger">
								&nbsp;
								Décompte d'heure
								</br>
								Inactif
								<?php nbrecontrattype(1,0);?>
							</button>
				</a>
			</div>
			<div class="col-sm-12">
				<div class="widget-body">
					<div class="widget-main no-padding">
						<table class="table  table-bordered ">
							<thead class="thin-border-bottom">
							<tr>
								<th>
									ID Contrat
								</th>
								<th>
									Utilisateur
								</th>
								<th>
									Status
								</th>
								<th w>
									Type
								</th>
								<th w>
									Service
								</th>
								<th w>
									Période
								</th>
								<?php if($view==1 || $view==4 ){echo "<th>Prépayé</th>";}?>
								<th w>
									Date de souscription
								</th>
								<th w>
									Date de fin
								</th>
								<?php if($view==1 || $view ==4 ){ echo "<th w>Temps souscrit</th><th w>Temps consommé</th><th w>Temps restant</th>";}?>
								<th w>
									Tarif
								</th>
								<th w>
									Facture
								</th>
								<th w>
								Actions
								</th>
							</tr>
							</thead>
						<tbody>
							<?php
							selectcontrat($view);
							if ($rparameters['debug']==1) {echo $query;}
							$query = $db->query($query);
							while ($row = $query->fetch())
							{
								if ($row['status']==0) {$row['status']="Inactif"; $color="#d15b47";};
								if ($row['status']==1) {$row['status']="Actif"; $color="#87b87f";};
								if ($row['prepaye']==0) {$row['prepaye']="Non"; };
								if ($row['prepaye']==1) {$row['prepaye']="Oui"; };
								$temps_restant = $row['temps_souscrit'] - $row['timeused'] ;
								$temps_souscrit = hour_min($row['temps_souscrit']);
								$temps_conso = hour_min($row['timeused']);
								if ($temps_restant == 0){ $temps_restant = "Terminé";}
								else {$temps_restant = hour_min($temps_restant);}
								if($row['timeused']<>"")
									{
									$tarif = $row['timeused'] * $row['tarif'] ;
									$tarif = $tarif / 60;
									$tarif  = round($tarif, 2);
									}
									?>
									<tr bgcolor=<?php echo $color;?>>
										<td><?php echo $row['id'];?></td>
										<td><?php echo $row['firstname']; echo "&nbsp;"; echo $row['lastname'];?> </td>
										<td><?php echo $row['status'];?></td>
										<td><?php echo $row['nomtype'];?></td>
										<td><?php echo $row['nomcontrat'];?></td>
										<td><?php echo $row['nomperiode'];?></td>
										<?php if($view==1 || $view==4){echo "<td>"; echo $row['prepaye'];echo"</td>";}?>
										<td><?php echo $row['date_souscription'];?></td>
										<td><?php echo $row['date_fin'];?></td>
										<?php if ($view==1 || $view==4)
											{
											echo "<td>"; if ($row['prepaye']=="Oui") {echo $temps_souscrit;} else { echo "--";} echo "</td>";
											echo "<td>"; echo $temps_conso; echo "</td>";
											echo "<td>"; if ($row['prepaye']=="Oui"){echo $temps_restant;} else {echo "--";}echo"</td>";
											}?>
										<td><?php if ($view==1 || $view==4 ){echo $tarif;echo "€";} else { echo $row['tarifcontrat']; echo "€";} ?> </td>
										<td><?php if (!empty($row['facturelink']))
											{?> <a href="<?php echo $row['facturelink'];?>" target=_blank>
												<button type="submit" name="formSubmitdelete" value="Clore" class="btn btn-sm btn-success">
													<i class="icon-file icon-on-right bigger-110"></i>
													&nbsp;Voir
												</button></a><?php
											}
											else {echo "Non disponible";}?>
										</td>
										<td>
											<form id="myForm" method="POST" action="">
												<input type="hidden" name="peer-id" value="<?php echo $row['id'];?>" >
												<button type="submit" name="formSubmitdelete" value="Clore" class="btn btn-sm btn-danger">
													<i class="icon-remove icon-on-right bigger-110"></i>
													&nbsp;Clore
												</button>
											</form>
										</td>
									</tr>
							<?php
							}
							$query->closecursor();
							?>
						</tbody>
						</table>
					</div>
					</div>
			</div>


<?php }} ?>
<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
	var id = $(this).attr('dataid');
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";

}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<!-- date picker script -->
<script type="text/javascript">
	window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>
<script src="template/assets/js/date-time/bootstrap-timepicker.min.js" charset="UTF-8"></script>
<script type="text/javascript">
jQuery(function($) {

    	$('#start_availability_h').timepicker({
    	        minuteStep: 1,
				showSeconds: true,
				showMeridian: false
			});
		$('#end_availability_h').timepicker({
	        minuteStep: 1,
			showSeconds: true,
			showMeridian: false
		});
		<?php
		echo '
			$.datepicker.setDefaults( $.datepicker.regional["fr"] );
			jQuery(function($){
			   $.datepicker.regional["fr"] = {
				  closeText: "Fermer",
				  prevText: "'.T_('<Préc').'",
				  nextText: "'.T_('Suiv>').'",
				  currentText: "Courant",
				  monthNames: ["'.T_('Janvier').'","'.T_('Février').'","'.T_('Mars').'","'.T_('Avril').'","'.T_('Mai').'","'.T_('Juin').'","'.T_('Juillet').'","'.T_('Août').'","'.T_('Septembre').'","'.T_('Octobre').'","'.T_('Novembre').'","'.T_('Décembre').'"],
				  monthNamesShort: ["Jan","Fév","Mar","Avr","Mai","Jun",
				  "Jul","Aoû","Sep","Oct","Nov","Déc"],
				  dayNames: ["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"],
				  dayNamesShort: ["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"],
				  dayNamesMin: ["'.T_('Di').'","'.T_('Lu').'","'.T_('Ma').'","'.T_('Me').'","'.T_('Je').'","'.T_('Ve').'","'.T_('Sa').'"],
				  weekHeader: "Sm",
				  dateFormat: "dd/mm/yy",
				  timeFormat:  "hh:mm:ss",
				  firstDay: 1,
				  isRTL: false,
				  showMonthAfterYear: false,
				  yearSuffix: ""};
			   $.datepicker.setDefaults($.datepicker.regional["fr"]);
				});
		';


				echo '
				$( "#date_debut" ).datepicker({
					dateFormat: \'dd/mm/yy\'
				});
				';


				echo '
				$( "#date_fin" ).datepicker({
					dateFormat: \'dd/mm/yy\'
				});
				';

		?>
		$( "#start_availability_d" ).datepicker({
			dateFormat: 'dd/mm/yy'
		});
		$( "#end_availability_d" ).datepicker({
			dateFormat: 'dd/mm/yy'
		});
	});
</script>
