<?php
session_start();
$_SESSION['uid']='1';
$session_uid=$_SESSION['uid'];
define("SITE_KEY", "yoursitekey");

function getDB() {
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="";
	$dbname="socialproject";
	$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbConnection;
}
/* API key encryption */
function apiKey($session_uid)
{
$key=md5(SITE_KEY.$session_uid);
return hash('sha256', $key.$_SERVER['REMOTE_ADDR']);
}

$apiKey=apiKey($session_uid);
?>
