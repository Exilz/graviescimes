<?php

require 'config.php';

$host = $config['db_host'];
$dbname = $config['db_name'];
$user = $config['db_user'];
$password = $config['db_password'];

try{
	$db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
	$db->exec("SET CHARACTER SET utf8");
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(Exception $e){
	echo 'Impossible de se connecter à la base de données';
	echo $e->getMessage();
	die();
}