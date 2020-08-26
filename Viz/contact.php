<!DOCTYPE HTML>
<html>
	<head>
    <title>��������</title>
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
	// ��� ���� ����� ������
jQuery(function($){
		   
	$('#send').submit(function(){
		
		var valid = true;
		var errormsg = '��� ���� ����������� � ����������!';
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
			<h1> <img src="images/logo.png"  height="50%" /> ������������ ����������� ����</h1>
				<nav id="nav">
					<ul>
						<li><a href="index.php">�������</a></li>
					</ul>
				</nav>
			</header>

		<!-- Main -->
			<section id="main" class="container 75%">
				<header>
					<h2>��������� � ����</h2>
					<p>���� � ��� �������� �����������, �� ������ ��� ������ </p>
				</header>
				<div class="box">
					<form id="send" method="post" action="post.php">
						<div class="row uniform 50%">
							<div class="6u 12u(mobilep)">
								<input type="text" name="name" id="name" value="" placeholder="���" class="field required" title="����������, ������� ���!" />
							</div>
							<div class="6u 12u(mobilep)">
								<input type="email" name="email" id="email" value="" placeholder="Email" class="field required" title="����������, ������� e-mail!" />
							</div>
						</div>
						<div class="row uniform 50%">
							<div class="12u">
								<input type="text" name="subject" id="subject" value="" placeholder="����" />
							</div>
						</div>
						<div class="row uniform 50%">
							<div class="12u">
								<textarea name="message" id="message" placeholder="����� ������ ������" rows="6" class="field required" title="����������, ������� ����� ���������!"></textarea>
							</div>
						</div>
						<div class="row uniform">
							<div class="12u">
								<ul class="actions align-center">
									<li><input type="submit" value="��������� ���������" /></li>
								</ul>
							</div>
						</div>
					</form>
				</div>
			</section>

		<!-- Footer -->
			<footer id="footer">
				<ul class="copyright">
					<li><a href="instruction.php">����������</a></li>
					<li><a href="elements.php">����������</a></li>
					<li><a href="contact.php">��������</a></li>
				</ul>
			<p>	2015 &copy; ������� ������� </p>
		    </footer>

	</body>
</html>
