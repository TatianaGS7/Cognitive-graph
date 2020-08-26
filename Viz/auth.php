<?php require ("data/mysql.inc"); 
session_start(); 

$_POST['login'] = preg_replace("/[^A-Za-z0-9.]/i", "-", $_POST['login']);  //  защита от SQL-инъекции
$_POST['password'] = preg_replace("/[^A-Za-z0-9.]/i", "-", $_POST['password']);


$res=mysql_query("SELECT * FROM Users WHERE Login='".$_POST['login']."' AND Password='".$_POST['password']."'", $db);
if(mysql_num_rows($res)!=1){	                 
		$_SESSION['log_error']="Проверьте правильность логина и пароля!";
		Header("Location: index.php");
}
else{
		$_SESSION['login']=$_POST['login'];
		$_SESSION['pass']=$_POST['password'];
		$_SESSION['log_error']='';

		Header("Location: elements.php");
		
}
?>
