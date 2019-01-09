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
//initialize variables
function hour_min($minutes){
       if($minutes == 0){return '';}else{
        $hours  = round(intval($minutes/60) , 2); //round down to nearest minute.
        $minutes = $minutes % 60; return sprintf("%02d", $hours).'h'.sprintf("%02d", $minutes).'min';
       }
 }
function hour_min2($minutes){
       if($minutes == 0){return '';}else{
        $hours  = round(intval($minutes/60) , 2); //round down to nearest minute.
        $minutes = $minutes % 60; return  $hours.','.sprintf("%02d", $minutes).'';       }
 }

?>

<script type="text/javascript" src="./template/assets/js/jquery-2.0.3.min.js"></script>
<script src="./components/Highcharts/js/highcharts.js"></script>
<script src="./components/Highcharts/js/modules/exporting.js"></script>

<div class="page-header position-relative">
	<h1>
		<i class="icon-briefcase"></i>  <?php echo T_('Contrats'); ?>

			<?php
			$token_export =uniqid(); //secure ticket access page
			$db->exec("INSERT INTO ttoken (token) VALUES ('$token_export')");

			?>

	</h1>
	<h4>Contrats de maintenance</h4>

	</div>
<?php


if ($rright['contrat_displayuser']!=0){

$userid = $_SESSION['user_id'];

$query = "SELECT tcontrats.id AS idcontrat, type, user, tusers.firstname, tusers.lastname, tcontrats.status, tcontratstype.nom, date_souscription, date_fin, temps_souscrit, tarifcontrat, tarif, tcontrats.periode, tcontrats.facturelink FROM tcontrats INNER JOIN tusers ON (tcontrats.user=tusers.id)
INNER JOIN tcontratstype ON (tcontrats.type=tcontratstype.id)
WHERE user = $userid AND tcontrats.type<> 1 "  ;
$query = $db->query($query);
 echo'
					<table class="table table-bordered">
						<thead class="thin-border-bottom">
					<tr>
								<th>
									<i class="icon-barcode"></i>
									'.T_('ID Contrat').'
								</th>
								<th>
									<i class="icon-user"></i>
									'.T_('Utilisateur').'
								</th>
									<th>
									<i class="icon-tasks"></i>
									'.T_('Status').'
								</th>


								<th w>
									<i class="icon-briefcase"></i>
									'.T_('Type').'
								</th>
									<th w>
									<i class="icon-briefcase"></i>
									'.T_('Période').'
								</th>
								<th w>
									<i class="icon-calendar"></i>
									'.T_('Date de souscription').'
								</th>
								<th w>
									<i class="icon-calendar"></i>
									'.T_('Date de fin').'
								</th>

								<th w>
									<i class="icon-time"></i>
									'.T_('Tarif').'
								</th>
									<th w>
									<i class="icon-time"></i>
									'.T_('Facture').'
								</th>

							</tr>

						</thead>
						<tbody>
						';
while ($row = $query->fetch())
{
						if ($row['status']==0) {$row['status']="Inactif"; $color="#d15b47";};
						if ($row['status']==1) {$row['status']="Actif"; $color="#87b87f";};

						$temps_restant = $row['temps_souscrit'] - $row['timeused'] ;
						$temps_restant = hour_min($temps_restant);
						$temps_souscrit = hour_min($row['temps_souscrit']);
						$temps_conso = hour_min($row['timeused']);
						$tarif = hour_min2($row['timeused']) * $row['tarif'];
							$tarif = $row['timeused'] * $row['tarif'] ;
												$tarif = $tarif / 60;
												$tarif  = round($tarif, 2);



					?>
						<tr bgcolor=<?php echo $color;?>><td><?php echo $row['idcontrat'];?></td><td><?php echo $row['firstname'];?> <?php echo $row['lastname'];?>  </td><td><?php echo $row['status'];?></td><td><?php $row['nom'];?></td><td><?php echo $row['periode'];?></td><td><?php echo $row['date_souscription'];?></td><td><?php echo $row['date_fin'];?></td><td><?php echo $row['tarifcontrat'];?>€</td><td><?php
											 if (!empty($row['facturelink'])) {?> <a href="<?php echo $row['facturelink'];?>" target=_blank>
												<button type="submit" name="formSubmitdelete" value="Clore" class="btn btn-sm btn-success">
													<i class="icon-file icon-on-right bigger-110"></i>
													&nbsp;Voir
												</button></a> <?php } else {echo "Non disponible";}?></td>


						</tr>

							<?php
}


					$query="SELECT sum(time) AS timeused, tcontrats.id, tusers.firstname, tusers.lastname, tcontrats.status,tcontrats.nom as nomcontrat,tcontrats.date_souscription,tcontrats.date_fin ,tcontrats.temps_souscrit, tcontrats.tarif, tcontratstype.nom as nomtype, tcontrats.periode as nomperiode, tcontrats.facturelink		FROM tincidents
						INNER JOIN tusers ON (tincidents.user=tusers.id)
                        INNER JOIN tcontrats ON (tincidents.contrats=tcontrats.id)
						INNER JOIN tcontratstype ON (tcontrats.type=tcontratstype.id)
						WHERE tusers.id = $userid
						GROUP BY tincidents.user, tcontrats.id
						ORDER BY tcontrats.id
							";

$query = $db->query($query);
?>

<?php
 echo'

					<table class="table table-bordered">
					<h4> Ticket </h4>

						<thead class="thin-border-bottom">
					<tr>
								<th>
									<i class="icon-barcode"></i>
									'.T_('ID Contrat').'
								</th>
								<th>
									<i class="icon-user"></i>
									'.T_('Utilisateur').'
								</th>
									<th>
									<i class="icon-tasks"></i>
									'.T_('Status').'
								</th>


								<th w>
									<i class="icon-briefcase"></i>
									'.T_('Type').'
								</th>
									<th w>
									<i class="icon-briefcase"></i>
									'.T_('Période').'
								</th>
								<th w>
									<i class="icon-calendar"></i>
									'.T_('Date de souscription').'
								</th>
								<th w>
									<i class="icon-calendar"></i>
									'.T_('Date de fin').'
								</th>
								<th w>
									<i class="icon-calendar"></i>
									'.T_('Temps souscrit').'
								</th>
									<th w>
									<i class="icon-calendar"></i>
									'.T_('Temps conso').'
								</th>
								<th w>
									<i class="icon-calendar"></i>
									'.T_('Temps restant').'
								</th>
								<th w>
									<i class="icon-time"></i>
									'.T_('Tarif').'
								</th>
								<th w>
									<i class="icon-time"></i>
									'.T_('Facture').'
								</th>

							</tr>

						</thead>
						<tbody>
						';
while ($row = $query->fetch())
{
						if ($row['status']==0) {$row['status']="Inactif"; $color="#d15b47";};
						if ($row['status']==1) {$row['status']="Actif"; $color="#87b87f";};

						$temps_restant = $row['temps_souscrit'] - $row['timeused'] ;
						$temps_restant = hour_min($temps_restant);
						$temps_souscrit = hour_min($row['temps_souscrit']);
						$temps_conso = hour_min($row['timeused']);
												if ($temps_restant == 0){ $temps_restant = "Terminé";}

						$tarif = hour_min2($row['timeused']) * $row['tarif'];
							$tarif = $row['timeused'] * $row['tarif'] ;
												$tarif = $tarif / 60;
												$tarif  = round($tarif, 2);




						echo "<tr bgcolor=$color><td>$row[id]</td><td>$row[firstname] $row[lastname]  </td><td>$row[status]</td><td>$row[nomtype]</td><td>$row[nomperiode]</td><td>$row[date_souscription]</td><td>$row[date_fin]</td><td>";

					if($row['temps_souscrit']==0){ echo "---";}	else { echo $temps_souscrit; }
					echo"</td><td>$temps_conso</td><td>";
					if($row['temps_souscrit']==0){ echo "---";}	else { echo $temps_restant; }
					echo"</td><td>$row[tarif] €</td><td>";

					 if (!empty($row['facturelink'])) {?> <a href="<?php echo $row['facturelink'];?>" target=_blank>
												<button type="submit" name="formSubmitdelete" value="Clore" class="btn btn-sm btn-success">
													<i class="icon-file icon-on-right bigger-110"></i>
													&nbsp;Voir
												</button></a><?php } else {echo "Non disponible";}?></td>


					</tr>
					<?php
}










					}


						echo '

					</table>
				</div>
			</div>';


							$query->closecursor();

	?>
</br>

</br>
	</div>
