

<?php
// Fonction aujout contrat 
if(isset($_POST['ajoutcontrat']) ){
 $demandeur =   $_POST['demandeur'];
 $namecontrat = $_POST['namecontrat'];
   $_POST['date_debut']; 
   $_POST['date_fin'];
   $_POST['temps_souscrit'];
   $_POST['montantheure'];
    
   
  $query = "INSERT INTO tcontrats (user, status, nom) VALUES ('$demandeur', '1', '$namecontrat' )";
  $query = $db->query($query);	
  echo '<meta http-equiv="refresh" content="0">';
}
?>

