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
    <title>Инструкция</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8 " />
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
			<h1> <img src="images/logo.png"  height="50%" /> Визуализатор когнитивных карт</h1>
				<nav id="nav">
					<ul>
						<li><a href="index.php">Главная</a></li>
						<li>
							<a href="elements.php" >Дисциплины</a>
							<ul>

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
echo "<li><a href='graph.php?d=".$id[$i]."'>".$title[$i]."</a></li>";
}
}

?>
						</ul>
						</li>
						<li>Здравствуйте, <?php echo $welcome; ?>! <a href="logout.php" class="button">Выход</a></li>
					</ul>
				</nav>
			</header>


	<!-- Main -->
			<section id="main" class="container">
				<header>
					<h2>Иструкция</h2>
					<p>Как пользоваться когнитивной картой</p>
				</header>

				
								
				<div class="box">
					<span class="image featured"><img src="images/pic1.jpg" /></span>
					<h3>Когнитивныя карта предметной области</h3>
					<p>Когнитивная карта &#8212; это модель предметной области (МПО), которая представлена в виде в графа с отношениями &quot;предыдущий &#8211; последующий&quot; между дидактическими единицами (ДЕ) и назначением этим отношениям веса, характеризующего важность знания одной ДЕ при изучении другой. ДЕ &#8212; минимальная структурная единица учебного материала, используемая для описания изучаемой дисциплины.</p>
					<div class="row">
						<div class="6u 12u(mobilep)">
							<h3>Как пользоваться графом</h3>
							<ul>В данный проект вложены следующие функции:
		                   <li>Создание новых ДЕ щелчком мыши</li>
		                   <li>Установка однонаправленных связей между ними</li>
		                   <li>Изменение направления связи (с помощью клавиш L и R)</li>
		                   <li>Возможность перемещения по полю объектов (при нажатии Ctrl)</li>
		                   <li>Удаление узлов и связей (клавиша Delete)</li>
		                       </ul>
 						</div>

						<div class="6u 12u(mobilep)">
							<h3>Как устанавливать значения</h3>
							<p>При выделении нужной ДЕ, если не прописано значение, появляется поле ввода. Также при выборе связи появляется вес отношения между узлами. Нажав на кнопку &quot;Назначить&quot; Вы присваиваете введенное значение элементу графа.</p>
						</div>
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