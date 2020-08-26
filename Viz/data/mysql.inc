<?php 
$db_host = 'localhost';
$db_user = 'root';
$db_pwd = '';
$database = 'viz-service';

if (!mysql_connect($db_host, $db_user, $db_pwd))
    die("Can't connect to database!");

mysql_query('SET NAMES utf8');

if (!mysql_select_db($database))
    die("Can't select database!");

$db = mysql_connect ($db_host, $db_user, $db_pwd);
mysql_select_db($database, $db);

ini_set('session.gc_maxlifetime', 28800);
ini_set('session.cookie_lifetime', 28800);
ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'] .'/ses/');
?>