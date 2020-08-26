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
    <title>Граф</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />

		<link rel="stylesheet" href="css/bootstrap.min.css" />
      <script src="js/jquery-2.1.3.min.js"></script>
      <link rel="stylesheet" href="css/graph.css">

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
						<li>Здравствуйте, <?php echo $welcome; ?>!<a href="logout.php" class="button">Выход</a></li>
					</ul>
				</nav>
			</header>

	<div id="content" style="text-align:justify; text-indent:20px;">
<div id="Zag">Когнитивная карта курса</div><h4> 
<?php   
$error = "";
if (is_numeric($_GET['d']))
{
$c_id=$_GET['d'];// получение номера курса

$courses = mysql_query("SELECT * FROM disciplines WHERE d_id='".$c_id."'", $db);
    
if (!$courses) {
    die("Query to show fields from table failed!");
}

$i=0;

while ($cr = mysql_fetch_object($courses) )
    {
    $id = $cr -> d_id;
    $title = $cr -> discipline;
    $i++;
    }

$err="";
if ($i!=1) $err = "<h4>Такого курса не существует!</h4>";

}
?>
<?php

if (empty($err)) {

if  (!(isset($_POST['ok'])))
{
echo "
  Ниже представлена когнитивная карта курса &quot;<b>".$title."</b>&quot;:
";
// Вызов файла domain_ pl
$goal = "kurs_de.";
$cmd = "/software/swipl/bin/swipl -f domain_".$c_id.".pl -g ".$goal." -t halt";
if (exec($cmd)) {$output = exec($cmd);}
else {echo "Возникли ошибки!";}
// Получение значений ДЕ
$output = str_replace(array("[","]"), "", $output);
$convertedOutput = mb_convert_encoding($output, 'utf-8', 'windows-1251'); 
$des = explode(",", $convertedOutput);
$descnt = count($des); 

//Получение взаимоотношений ДЕ и веса связей
$goal = "de_rel('".$c_id."').";
$cmd = "/software/swipl/bin/swipl -f domain_".$c_id.".pl -g ".$goal." -t halt";
if (exec($cmd)) {$output = exec($cmd);}
else {echo "Возникли ошибки!";}
$output = str_replace(array("[","]"), "", $output);
$convertedOutput = mb_convert_encoding($output, 'utf-8', 'windows-1251'); 
$rels = explode(",", $convertedOutput);
$relscnt = count($rels); 

for ($i=0; $i<$relscnt; $i++) {
$e1[$i]= explode(":", $rels[$i]);
$e2[$i]= explode("-", $e1[$i][1]);
}
}
}
?>
</h4>
				<!-- ГРАФ С ЛЕГЕНДОЙ -->
     <div class="containergraph">
        <div class="row">
            <div class="col-md-5">
            <!-- ЛЕГЕНДА -->
                <div class="panel panel-primary">
                <!--НАЗВАНИЕ ДЕ -->
                    <div class="panel-heading">Параметры элемента</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <strong id="lblSelectedNode">Не выбрана ДЕ</strong>
                        </div>
                        <div class="form-group">
                            <strong id="lblSelectedNodeName"></strong>
                        </div>
                        <div id="pnlNodeName" style="display: none">
                            <div class="form-group">
                            <!-- ВВОД НАЗВАНИЯ ДЕ -->
                                <input type="text" id="cntNodeName" placeholder="Введите название дидактической единицы" class="form-control" spellcheck="true"/>
                            </div>
                            <div class="form-group">
                            <!-- КНОПКА НАЗНАЧЕНИЯ -->
                                <button id= "Znach" class="btn btn-success" onclick="SetNodeName(cntNodeName.value)">Назначить</button>
                            </div>
                        </div>
                        <!-- СВЯЗИ -->
                        <div class="form-group">
                            <strong id="lblSelectedLink">Не выбрана связь</strong>
                        </div>
                        <div class="form-group">
                            <strong id="lblSelectedLinkVal"></strong>
                        </div>
                        <div id="pnlLinkVal" style="display: none">
                            <div class="form-group">
                            <!-- ВВОД СВЯЗИ -->
                                <input type="text" id="cntNodeLinkValue" placeholder="Введите вес связи от 0 до 1" class="form-control"  />
                            </div>
                           <strong id="ErrorLink" style="color:#990033"></strong> 
                     
                            <div class="form-group">
                            <!-- КНОПКА НАЗНАЧЕНИЯ-->
                                <button id= "Ves" class="btn btn-success" onclick="SetNodeLinkVal(cntNodeLinkValue.value)">Назначить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
                   <!-- ГРАФ -->
            <div class="col-md-7">
                <div class="panel panel-default">

<!-- КНОПКА СОХРАНИТЬ -->
      <form action="" method="post" name="form" style="float:right" > 
      <input name="Save" type="button" value="Сохранить" class="btn btn-success" onclick="SaveNodes(<?php echo $c_id; ?>)" >
      </form>
                       <div class="panel-body">
                        <div class="graph" id="graph"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

		<!-- Footer -->
			<footer id="footer">
				<ul class="copyright">
					<li><a href="instruction.php">Инструкция</a></li>
					<li><a href="elements.php">Дисциплины</a></li>
					<li><a href="contact.php">Контакты</a></li>
				</ul>
			<p>	2015 &copy; Грушина Татьяна </p>
		    </footer>

 <script>

    //Проверка на ввод букв в поле ввода для веса связи
        var svaz = document.getElementById("cntNodeLinkValue");
        if(svaz.addEventListener){
 svaz.addEventListener("keyup", function()
    {i = 0; while(i<svaz.value.length)
        {if (((svaz.value[i]<='z')&(svaz.value[i]>='a')||(svaz.value[i]<='я')&(svaz.value[i]>='а')))
        {vesnaz();break;}
        else {Novalue();}
        i = i + 1;
        }
    },
    false);
        }
            
        //Можно назначить
        var vesnaz = function(){
            var b = document.getElementById('Ves');
            b.setAttribute('disabled','');
        }
        
        //Нельзя назначить - кнопка не реагирует
        var Novalue = function(){
            var b = document.getElementById('Ves');
            b.removeAttribute('disabled','');
        }

     </script>

     
 <!-- СОЗДАНИЕ ДЕ И СВЯЗЕЙ -->    
      <script>

      /*  установка начальных узлов(ДЕ) - nodes и связей - links
-ДЕ -это id (не индекс в массиве)
- связь - target;  направления установлены 'левым' и 'правым'.
*/

    var nodes = [  
    <?php
    // Назначение свойств узлов из Prolog
    if ($descnt > 0)
    {
        for  ($i=0; $i<$descnt;  $i++)
        {   
        $ti=$i+1;
            echo '{id: '.$ti.' ,  Name: "'.$des[$i].'"}, ';
        }
    }

    ?>
    ],
    nodeLastId = <?php echo $descnt; ?>,

    
    links = [  //установка связей-стрелок
    <?php 
    
    if ($descnt > 0)
    { 
        for ($i=0; $i<$descnt;  $i++)
        {   
        for ($j=0; $j<$relscnt;  $j++)
            {
                if ($des[$i]==$e1[$j][0])
                {
                    for ($k=0; $k<$descnt;  $k++)
                        {   
                          if ($des[$k]==$e2[$j][0])
                          
                          {
                            $s_node=$i;
                            $t_node=$k;
                            $weight=$e2[$j][1];
                            //Диплом
                        echo '{source: nodes['. $s_node.'], target: nodes['.$t_node.'], Val: "'.$weight.'" }, ';                   
                          }
                        }
            
                }
            }
        }
    } 
    
    ?>
   ];


    </script> 

  <script src="js/d3/d3.min.js"></script>
  <script src="js/graph.js"></script>	
    
	</body>
</html>