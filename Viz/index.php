<?php session_start();  ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    <title>Визуализатор когнитивных карт</title>
		<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
		<meta name="description" content="" />  
		<meta name="keywords" content="" />  
     
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.scrollgress.min.js"></script>
		<script src="js/jquery.dropotron.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-wide.css" />
		</noscript>


<script>
	// Для поля ввода данных
jQuery(function($){
		   
	$('#login').submit(function(){
		
		var valid = true;
		var errormsg = 'Эти поля обязательны к заполнению!';
		var errorcn = 'error';
		
		$('.' + errorcn, this).remove();			
		
		$('.required', this).each(function(){
			var parent = $(this).parent();
			if( $(this).val() == '' ){
				var msg = $(this).attr('title');
				msg = (msg != '') ? msg : errormsg;
				$('<span class="'+ errorcn +'">'+ msg +'</span>')
					.appendTo(parent)
					.fadeIn('fast')
					.click(function(){ $(this).remove(); })
				valid = false;
			};
		});
		return valid;
	});	
})	
</script>

	</head>
	<body class="landing">

		<!-- Header -->
			<header id="header" class="alt">

				<nav id="nav">
					<ul>
						<li><a href="help.php">Помощь</a></li>
					</ul>
				</nav>
			</header>

		<!-- Banner -->
<section id="banner">

				<h2> <img src="images/logo.png" /> 
			
				Визуализатор когнитивных карт</h2>
				<p>Вход для преподавателей</p>
    <!-- Вход для преподавателей -->   
		<form id="login" method="post" action="auth.php"> 


    <div>
    	<label for="login_username">Логин</label> 
    	<input type="text" name="login" id="login_username" class="field required" title="Пожалуйста, введите свой логин!" />
    </div>			

    <div>
    	<label for="login_password">Пароль</label>
    	<input type="password" name="password" id="login_password" class="field required" title="Пожалуйста, введите свой пароль!" />
    </div>	
    
   <div class="submit">
        <button type="submit">Вход</button>   
   </div>
  </form>	
  
 <?php
if(!empty($_SESSION['log_error']))
{
	echo ("<div id='error'><p>");
	echo $_SESSION['log_error'];
	echo ("</p></div>");
	$_SESSION['log_error']='';
}
?>

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