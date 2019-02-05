
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
