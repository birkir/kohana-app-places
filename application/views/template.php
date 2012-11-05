<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Eat.is</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600,800" rel="stylesheet">
		<link href="/media/css/styles.css" rel="stylesheet">
		<link rel="shortcut icon" href="/media/ico/favico.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/media/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/media/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/media/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="/media/ico/apple-touch-icon-57-precomposed.png">
	</head>
	<body onload="App.init();">
		<div class="container">
			<header>
				<a href="/" class="logo" title="Eat.is"></a>
				<nav class="top">
					<ul>
						<li><a href="/location" title="Location" class="icon-location<?=(Cookie::get('address', NULL) ? '-active' : NULL);?>"></a></li>
						<li><a href="/language" title="Language" class="icon-language" style="background-image: url(/media/img/i18n/<?=Cookie::get('language', 'en-uk');?>.png);"></a></li>
					</ul>
				</nav>
				<div class="clearfix"></div>
			</header>
			<div id="main">
<?=isset($view) ?$view : NULL; ?>
<?php if ($debug === TRUE): ?>
		<?=View::factory('profiler/stats');?>
<?php endif; ?>
			</div>
			<footer></footer>
		</div>
		<?php if ($maps): ?>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
		<?php endif; ?>
		<script src="/media/js/lib.js"></script>
		<script src="/media/js/app.js"></script>
	</body>
</html>
