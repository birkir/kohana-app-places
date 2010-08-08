<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset=utf-8 />
		<meta name="viewport" content="user-scalable=no, width=device-width" /> 
		<title>{$title|__} | {$project->title}</title>
		<link rel="shortcut icon" href="/resources/img/favico.ico" />
		<link type="text/css" href="/resources/css/style.main.css" rel="stylesheet" />
	</head>
	<body>
		<div id="page">
			<div id="head">
				<div id="logo">
					<a href="/" title="">
						<img src="/resources/img/logo.png" alt="" id="_logo_img" style="width:230px;height:60px;"  />
					</a>
				</div>
				<div id="shortcuts">
					<ul>
						<li><a href="/location" title="{"Location"|__}"><img src="/resources/img/icon-location{if $location->longitude == NULL}-unselected{/if}.png" id="_location_img" alt="" style="width:64px;height:64px;" /></a></li>
						<li><a href="/language" title="{"Language"|__}"><img src="/resources/img/i18n/{$language}.png" id="_language_img" alt="" style="width:64px;height:64px;" /></a></li>
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
		<div id="footoffset"></div>
		<div id="foot"></div>
{if isset($js)}
	<script type="text/javascript">{$js}</script>
{/if}
{if isset($profiler)}{$profiler}{/if}
	</body>
</html>
