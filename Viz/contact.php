<!DOCTYPE HTML>
<html>
	<head>
    <title>Контакты</title>
		<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
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

<script>
	// Для поля ввода данных
jQuery(function($){
		   
	$('#send').submit(function(){
		
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
	<body>

		<!-- Header -->
			<header id="header" class="skel-layers-fixed">
			<h1> <img src="images/logo.png"  height="50%" /> Визуализатор когнитивных карт</h1>
				<nav id="nav">
					<ul>
						<li><a href="index.php">Главная</a></li>
					</ul>
				</nav>
			</header>

		<!-- Main -->
			<section id="main" class="container 75%">
				<header>
					<h2>Связаться с нами</h2>
					<p>Если у Вас возникли затруднения, Вы можете нам письмо </p>
				</header>
				<div class="box">
					<form id="send" method="post" action="post.php">
						<div class="row uniform 50%">
							<div class="6u 12u(mobilep)">
								<input type="text" name="name" id="name" value="" placeholder="Имя" class="field required" title="Пожалуйста, введите имя!" />
							</div>
							<div class="6u 12u(mobilep)">
								<input type="email" name="email" id="email" value="" placeholder="Email" class="field required" title="Пожалуйста, введите e-mail!" />
							</div>
						</div>
						<div class="row uniform 50%">
							<div class="12u">
								<input type="text" name="subject" id="subject" value="" placeholder="Тема" />
							</div>
						</div>
						<div class="row uniform 50%">
							<div class="12u">
								<textarea name="message" id="message" placeholder="Текст Вашего письма" rows="6" class="field required" title="Пожалуйста, введите текст сообщения!"></textarea>
							</div>
						</div>
						<div class="row uniform">
							<div class="12u">
								<ul class="actions align-center">
									<li><input type="submit" value="Отправить сообщение" /></li>
								</ul>
							</div>
						</div>
					</form>
				</div>
			</section>

		<!-- Footer -->
			<footer id="footer">
				<ul class="copyright">
					<li><a href="instruction.php">Инструкция</a></li>
					<li><a href="elements.php">Дисциплины</a></li>
					<li><a href="contact.php">Контакты</a></li>
				</ul>
			<p>	2015 &copy; Грушина Татьяна </p>
		    </footer>

	</body>
</html>
