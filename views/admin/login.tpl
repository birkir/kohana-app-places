<!doctype html>
<html lang="en" class="no-js login">
	<head>
		<meta charset="utf-8">
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
		<title>{if $title}{$title} | {/if}Eat Admin</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
		<link rel="shortcut icon" href="/resources/img/favico.ico">
		<link rel="stylesheet" href="/resources/css/style.admin.css?v=1">
		<script src="/resources/js/modernizr-1.5.min.js"></script>
	</head>
<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body> <!--<![endif]-->
		<div id="container">
			<header>
				<div class="wrap">
					<div id="logo">Eat Admin</div>
				</div>
			</header>
			<div id="main" class="wrap">
				<div class="login"> 
					<fieldset> 
						<dl> 
							<dt><label for="_login_username">{"Username"|__}</label></dt> 
							<dd><input type="text" name="_u" value="" id="_login_username" /></dd> 
							<dt><label for="_login_password">{"Password"|__}</label></dt> 
							<dd><input type="password" name="_p" value="" id="_login_password" /></dd> 
							<dt>&nbsp;</dt> 
							<dd><button id="start">{"Login"|__}</button></dd> 
						</dl> 
					</fieldset> 
				</div> 
			</div>
			<footer>
			</footer>
		</div>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script>!window.jQuery && document.write('<script src="js/jquery-1.4.2.min.js"><\/script>')</script>
		<script src="/resources/js/admin.js?v=1"></script>
		<!--[if lt IE 7 ]><script src="/resources/js/dd_belatedpng.js?v=1"></script><![endif]-->
	</body>
</html>