<?php
################################################################################
# @Name : ./core/ping.php
# @Description : test if asset is connected
# @Call : ./core/asset.php or via windows or linux command line
# @Parameters : GET_[ip] or globalping and server key for command line execution
# @Author : Flox
# @Create : 19/12/2015
# @Update : 23/03/2018
# @Version : 3.1.32
################################################################################

//initialize variables 
if(!isset($_GET['server_key'])) $_GET['server_key'] = '';
if(!isset($rparameters['server_private_key'])) $rparameters['server_private_key'] = '';
if(!isset($_GET['iptoping'])) $_GET['iptoping'] = '';
if(!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) $_SERVER['HTTP_ACCEPT_LANGUAGE']=0;

if(!isset($argv[1])) $argv[1] = '';
if(!isset($argv[2])) $argv[2] = '';

//call via external script for cron 
if(!$rparameters['server_private_key'])
{
	//database connection
	require_once(__DIR__."/../connect.php");
	
	//load parameters table
	$qry=$db->prepare("SELECT * FROM `tparameters`");
	$qry->execute();
	$rparameters=$qry->fetch();
	$qry->closeCursor();
	
	//locales
	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	if ($lang=='fr') {$_GET['lang'] = 'fr_FR';}
	else {$_GET['lang'] = 'en_US';}
	define('PROJECT_DIR', realpath('../'));
	define('LOCALE_DIR', PROJECT_DIR .'/locale');
	define('DEFAULT_LOCALE', '($_GET[lang]');
	require_once(__DIR__.'/../components/php-gettext/gettext.inc');
	$encoding = 'UTF-8';
	$locale = (isset($_GET['lang']))? $_GET['lang'] : DEFAULT_LOCALE;
	T_setlocale(LC_MESSAGES, $locale);
	T_bindtextdomain($_GET['lang'], LOCALE_DIR);
	T_bind_textdomain_codeset($_GET['lang'], $encoding);
	T_textdomain($_GET['lang']);
}

$today=date("Y-m-d");

//multi ping for update all assets last ping value
if ($argv[1]=='globalping')
{
	if($argv[2]==$rparameters['server_private_key'] && $rparameters['server_private_key'])
	{
		//load all enabled iface of all enabled assets with ip adresse
		$qry=$db->prepare("SELECT tassets.id, tassets.netbios, tassets_iface.ip FROM tassets_iface,tassets WHERE tassets.id=tassets_iface.asset_id AND tassets_iface.ip!=:ip AND tassets.state=:state AND tassets.disable=:tassets_disable AND tassets_iface.disable=:tassets_iface_disable ORDER BY tassets.id");
		$qry->execute(array(
			'ip' => '',
			'state' => 2,
			'tassets_disable' => 0,
			'tassets_iface_disable' => 0
		));
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') //windows server case
		{
			while ($row=$qry->fetch())
			{
				//check if ipv4 is well formed
				$error='';
				$cnt=0;
				if(!preg_match('#\.#', $row['ip'])) {$error='error no point detected';}
				foreach (explode('.',$row['ip']) as $val) {$cnt++;if (!is_numeric($val)) { $error='not numeric value'; break;} if($val>254) { $error='error bloc more than 255'; break;}}
				if(!$error) {if ($cnt!=4) {$error='error not 4 blocs';}}
				
				if (!$error)
				{
					echo '[WIN] ping '.$row['netbios'].' (id:'.$row['id'].') on IP '.$row['ip'].':';
					$result=exec("ping -n 1 -w 1 $row[ip]");
					if((preg_match('#ms#', $result)))
					{
						echo ' OK (updating asset last ping flag)'.PHP_EOL;
						$db->exec('UPDATE tassets SET date_last_ping=\''.$today.'\' WHERE id=\''.$row['id'].'\'');
					} else {
						echo ' KO '.PHP_EOL;
					}
					sleep(1); //timeout 1 seconds to limit network trafic
				} else {
					echo '[WIN] ping '.$row['netbios'].' (id:'.$row['id'].') on IP '.$row['ip'].': no check, invalid ip address ('.$error.')'.PHP_EOL;
				}
			}
			$qry->closeCursor();
		} else { //linux server case
			while ($row=$qry->fetch())
			{
				//check if ipv4 is well formed
				$error='';
				$cnt=0;
				if(!preg_match('#\.#', $row['ip'])) {$error='error no point detected';}
				foreach (explode('.',$row['ip']) as $val) {$cnt++;if (!is_numeric($val)) { $error='not numeric value'; break;} if($val>254) { $error='error bloc more than 255'; break;}}
				if(!$error) {if ($cnt!=4) {$error='error not 4 blocs';}}
				
				if (!$error)
				{
					echo '[LINUX] ping '.$row['netbios'].' (id:'.$row['id'].') on IP '.$row['ip'].':';
					$result=exec("ping -W 1 -c 1  $row[ip]");
					if((preg_match('#min#', $result)))
					{
						echo ' OK (updating asset last ping flag)'.PHP_EOL;
						$db->exec('UPDATE tassets SET date_last_ping=\''.$today.'\' WHERE id=\''.$row['id'].'\'');
					} else {
						echo ' KO '.PHP_EOL;
					}
					sleep(1); //timeout 1 seconds to limit network trafic
				} else {
					echo '[LINUX] ping '.$row['netbios'].' (id:'.$row['id'].') on IP '.$row['ip'].': no check, invalid ip address ('.$error.')'.PHP_EOL;;
				}
			}
			$qry->closeCursor();
		}
	} else {echo "ERROR: Wrong server key go to application system page to get your key";}
} elseif($_GET['iptoping']) { //single ping from ticket with OS detection
	//test each iface with ip
	$qry=$db->prepare("SELECT `id`,`ip`,`date_ping_ok`,`date_ping_ko` FROM `tassets_iface` WHERE asset_id=:asset_id AND disable=:disable");
	$qry->execute(array(
		'asset_id' => $globalrow['id'],
		'disable' => 0
		));
	while($row=$qry->fetch()) 
	{
		if($row['ip'])
		{
			$test_ip=$row['ip'];
			//check if ipv4 is well formed
			$error='';
			$cnt=0;
			if(!preg_match('#\.#', $test_ip)) {$error='error no point detected';}
			foreach (explode('.',$test_ip) as $val) {$cnt++;if (!is_numeric($val)) { $error='not numeric value'; break;} if($val>254) { $error='error bloc more than 255'; break;}}
			if(!$error) {if ($cnt!=4) {$error='error not 4 blocs';}}
			
			if (!$error)
			{
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
					$result=exec("ping -n 1 -w 1 $test_ip");	
					//test result
					if((preg_match('#Minimum#', $result)))
					{
						//display message
						echo '<div class="alert alert-block alert-success"><i class="icon-exchange bigger-130 green"></i>&nbsp; <strong>'.T_('PING').'</strong> de <b>'.$test_ip.'</b> : OK <span style="font-size: x-small;">('.$result.')</span></div>';
						//update asset flag
						$db->exec('UPDATE tassets SET date_last_ping=\''.$today.'\' WHERE id=\''.$globalrow['id'].'\'');
						$db->exec('UPDATE tassets_iface SET date_ping_ok=\''.date('Y-m-d H-i-s').'\' WHERE id=\''.$row['id'].'\'');
					} else {
						$result=mb_convert_encoding($result, "UTF-8");
						//display message
						echo '<div class="alert alert-danger"><i class="icon-remove"></i> <strong>'.T_('PING').'</strong> de <b>'.$test_ip.'</b> : KO <span style="font-size: x-small;">('.$result.')</span></div>';
						$db->exec('UPDATE tassets_iface SET date_ping_ko=\''.date('Y-m-d H-i-s').'\' WHERE id=\''.$row['id'].'\'');
				}
				} else {
					$result=exec("ping -W 1 -c 1 $test_ip");
					//test result
					if((preg_match('#min#', $result)))
					{
						//display message
						echo '<div class="alert alert-block alert-success"><i class="icon-exchange bigger-130 green"></i>&nbsp; <strong>'.T_('PING').'</strong> de <b>'.$test_ip.'</b> : OK <span style="font-size: x-small;">('.$result.')</span></div>';
						//update asset flag
						$db->exec('UPDATE tassets SET date_last_ping=\''.$today.'\' WHERE id=\''.$globalrow['id'].'\'');
						$db->exec('UPDATE tassets_iface SET date_ping_ok=\''.date('Y-m-d H-i-s').'\' WHERE id=\''.$row['id'].'\'');
					} else {
						$result=mb_convert_encoding($result, "UTF-8");
						//display message
						echo '<div class="alert alert-danger"><i class="icon-remove"></i><strong>'.T_('PING').'</strong> de <b>'.$test_ip.'</b> : KO <span style="font-size: x-small;">('.$result.')</span> </div>';
						$db->exec('UPDATE tassets_iface SET date_ping_ko=\''.date('Y-m-d H-i-s').'\' WHERE id=\''.$row['id'].'\'');
					}
				}
			} else {
				echo '<div class="alert alert-danger"><i class="icon-remove"></i> <strong>'.T_('PING').'</strong> de <b>'.$test_ip.'</b> : KO <span style="font-size: x-small;">(Invalid IPv4 address: '.$error.')</span> </div>';
			}
		}
	}
	$qry->closeCursor();
}
?>