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

?>
<script type="text/javascript" src="./template/assets/js/jquery-2.0.3.min.js"></script>
<script src="./components/Highcharts/js/highcharts.js"></script>
<script src="./components/Highcharts/js/modules/exporting.js"></script>

<div class="page-header position-relative">
	<h1>
		<i class="icon-briefcase"></i>  <?php echo T_('Identifiants'); ?>
		<div class="pull-right">
			<?php
			$token_export =uniqid(); //secure ticket access page
			$db->exec("INSERT INTO ttoken (token) VALUES ('$token_export')");
			?>
		</div>
	</h1>
</div>
<div class="col-sm-12">




<?php

	if ($rright['identifiants']!=0){

	echo'
	<div class="widget-body">
				<div class="widget-main no-padding">';

		echo '
					<table class="table  table-bordered">
						<thead class="thin-border-bottom">
							<tr>
								<th width = "10px">
									<i class="icon-barcode"></i>
									'.T_('ID').'
								</th>
								<th>
									<i class="icon-user"></i>
									'.T_('Nom').'
								</th>
									<th>
									<i class="icon-tasks"></i>
									'.T_('Host FTP').'
								</th>


								<th w>
									<i class="icon-briefcase"></i>
									'.T_('UserFTP').'
								</th>
								<th w>
									<i class="icon-calendar"></i>
									'.T_('PasswordFTP').'
								</th>

														<th>
									<i class="icon-tasks"></i>
									'.T_('Host SQL').'
								</th>


								<th w>
									<i class="icon-briefcase"></i>
									'.T_('UserSQL').'
								</th>
								<th w>
									<i class="icon-calendar"></i>
									'.T_('PasswordSQL').'
								</th>

														<th>
									<i class="icon-tasks"></i>
									'.T_('Host siteadmin').'
								</th>


								<th w>
									<i class="icon-briefcase"></i>
									'.T_('usersite').'
								</th>
								<th w>
									<i class="icon-calendar"></i>
									'.T_('passwordsite').'
								</th>

							</tr>
						</thead>
						<tbody>
						';



						$query="SELECT * FROM tidentif";


						if ($rparameters['debug']==1) {echo $query;}

						$query = $db->query($query);

						while ($row = $query->fetch())
						{
						//if ($row['status']==0) {$row['status']="Inactif"; $color="#d15b47";};
						//if ($row['status']==1) {$row['status']="Actif"; $color="#87b87f";};


						echo "<tr><td>$row[id]</td><td>$row[nom]</td><td>$row[ftphost]</td><td>$row[ftpuser]</td><td>$ftppass</td><td>$row[sqlhost]</td><td>$row[sqluser]</td><td>$row[sqlpass]</td><td>$row[sitehost]</td><td>$row[siteuser]</td><td>$row[sitepass]</td></tr>";




						}

						$query->closecursor();









						}

						else

						{
						echo '<div class="alert alert-danger"><strong><i class="icon-remove"></i>'.T_('Erreur').':</strong> '.T_('Vous n\'avez pas accès à cette page, contacter votre administrateur').'.<br></div>';};



						echo '
					</table>
				</div>
			</div>';

?>
</div>
