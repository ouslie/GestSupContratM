<?php
################################################################################
# @Name : connect.php
# @Desc : database connection parameters
# @call :
# @parameters :
# @Author : Flox
# @Create : 07/03/2007
# @Update : 05/01/2017
# @Version : 3.1.15
################################################################################

//database connection parameters
$host='localhost'; //SQL server name
$port='3306'; //SQL server port
$db_name='support2'; //database name
$charset='utf8'; //database charset default utf8
$user='pozjdpoje'; //database user name
$password='iM6@am42'; //database password

//database connection
try {$db = new PDO("mysql:host=$host;port=$port;dbname=$db_name;charset=$charset", "$user", "$password" , array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));}
catch (Exception $e)
{die('Error : ' . $e->getMessage());}