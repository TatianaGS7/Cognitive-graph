<?php header("Content-Type: text/html; charset=charset=utf-8");
 
$adminemail="admin@mail.ru";  // e-mail � 
 
 
$date=date("d.m.y"); 
 
$time=date("H:i"); 
 
$backurl="index.php";  

 
$name=$_POST['name']; 
 
$email=$_POST['email'];

$sub=$_POST['subject'];  
 
$msg=$_POST['message']; 
 

$msg=" 
 
���: $name
  
E-mail: $email
 
����: $sub

���������: $msg
 
 "; 
 
  
mail("$adminemail", "$date $time ��������� �� $name", "$email", "$sub", "$msg"); 
 
  
 
$f = fopen("message.txt", "a+"); 
 
fwrite($f," \n $date $time ��������� �� $name");
 
fwrite($f,"\n $msg "); 
 
fwrite($f,"\n ---------------"); 
 
fclose($f); 
 
Header("Location: index.php");

 
?>