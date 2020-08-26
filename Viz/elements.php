<?php  header("Content-Type: text/html; charset=utf-8");
require ("data/mysql.inc");
session_start();

$res=mysql_query("SELECT * FROM Users WHERE Login='".$_SESSION['login']."'
    AND Password='".$_SESSION['pass']."'", $db);

if(mysql_num_rows($res)!=1){	
	Header("Location: index.php");}

$name = $_SESSION['login'];	
$person = mysql_query("SELECT Surname, Name, Middle_name FROM UProfile WHERE Login='".$name."'", $db);
	
if (!$person) {
    die("Query failed!");
}

while ($cr = mysql_fetch_object($person) )
	{
	$sur = $cr -> Surname;
	$n = $cr -> Name;
	$mn = $cr -> Middle_name;
	}

$welcome=$sur." ".$n." ".$mn;

?>

<!DOCTYPE HTML>
<html>
	<head>
    <title>Дисциплины</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.dropotron.min.js"></script>
		<script src="js/jquery.scrollgress.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>

		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-wide.css" />
		</noscript>

	</head>
	<body>

		<!-- Header -->
			<header id="header" class="skel-layers-fixed">
			<h1> <img src="images/logo.png"  height="50%" />Визуализатор когнитивных карт</h1>
				<nav id="nav">
					<ul>
						<li>Здравствуйте, <?php echo $welcome; ?>!<a href="logout.php" class="button">Выход</a></li>
					</ul>
				</nav>
			</header>


		<!-- Main -->
			<section id="main" class="container">
				<header>
					<h2>Дисциплины</h2>
					<p> Выберите из списка нужную дисциплину</p>
				</header>
				<div class="row">
					<div class="12u">

						<!-- ВЫВОД ДИСЦИПЛИН -->
							<section class="box">
					<h4>		
					<ol class="actions vertical small">
					
					
<?php
$courses = mysql_query("SELECT * FROM Disciplines WHERE creator='".$_SESSION['login']."'", $db);
	
if (!$courses) {
    die("Query to show fields from table failed!");
}

$i=1;

while ($cr = mysql_fetch_object($courses) )
	{
	$id[$i]	= $cr -> d_id;
	$title[$i] = $cr -> discipline;
	$i++;
	}

$count = $i-1;
if ($count > 0)
{
for  ($i=1; $i<=$count;  $i++)
{
echo "<li><a href='graph.php?d=".$id[$i]."'>".$title[$i]."</a></li>";  // !!!!!!!!!!!!
}
}

?>
					
					
					</ol>
                    </h4>

					</div>
				</div>
			</section>

		<!-- Footer -->
			<footer id="footer">
				<ul class="copyright">
					<li><a href="instruction.php">Инструкция</a></li>
					<li><a href="elements.php">Дисциплины</a></li>
					<li><a href="contact.php">Контакты</a></li>
				</ul>
			<p>	2015 &copy; Грушина Татьяна</p>
		    </footer>

	</body>
</html>