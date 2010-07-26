<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset=utf-8 />
		<meta name="viewport" content="user-scalable=no, width=device-width" /> 
		<title>{$title|__} | {$project->title}</title>
		<link rel="shortcut icon" href="/img/favicon.ico" />
		<link type="text/css" href="/css/style.main.css" rel="stylesheet" />
		<script type="text/javascript" src="/js/eat.js"></script>
	</head>
	<body>
		<div id="page">
			<div id="head">
				<div id="logo">
					<a href="/" title="">
						<img src="/img/logo.png" alt="" id="_logo_img" style="width:230px;height:60px;"  />
					</a>
				</div>
				<div id="shortcuts">
					<ul>
						<li><a href="/location" title="{"Location"|__}"><img src="/img/icon-location{if $location->longitude == NULL}-unselected{/if}.png" id="_location_img" alt="" style="width:64px;height:64px;" /></a></li>
						<li><a href="/language" title="{"Language"|__}"><img src="/img/i18n/{$language}.png" id="_language_img" alt="" style="width:64px;height:64px;" /></a></li>
					</ul>
				</div>
				<script type='text/javascript'>
					d.getElementById("_logo_img").style.width = 230*ratio + "px";
					d.getElementById("_logo_img").style.height = 60*ratio + "px";
					d.getElementById("_location_img").style.width = 64*ratio + "px";
					d.getElementById("_location_img").style.height = 64*ratio + "px";
					d.getElementById("_language_img").style.width = 64*ratio + "px";
					d.getElementById("_language_img").style.height = 64*ratio + "px";
					d.getElementById("head").style.height = 90*ratio + "px";
				</script>
			</div>
			<div id="frame">
{if isset($view)}
{$view}
{/if}
			</div>
		</div>
		<div id="foot"></div>
	</body>
</html>