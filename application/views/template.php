<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset=utf-8 />
		<meta name="viewport" content="user-scalable=no, width=device-width" /> 
		<title>{$title|__} | {$project->title}</title>
		<link rel="shortcut icon" href="/media/img/favico.ico" />
		<link type="text/css" href="/media/css/style.main.css" rel="stylesheet" />
	</head>
	<body>
		<div id="page">
			<div id="head">
				<div id="logo">
					<a href="/" title="">
						<img src="/media/img/logo.png" alt="" id="_logo_img" 
style="width:230px;height:60px;"  />
					</a>
				</div>
				<div id="shortcuts">
					<ul>
						<li><a href="/location" title="{"Location"|__}"><img src="/media/img/icon-location{if $location->longitude == NULL}-unselected{/if}.png" id="_location_img" alt="" style="width:64px;height:64px;" /></a></li>
						<li><a href="/language" title="{"Language"|__}"><img src="/media/img/i18n/{$language}.png" id="_language_img" alt="" style="width:64px;height:64px;" /></a></li>
					</ul>
				</div>
			</div>
{if isset($js)}
	<script type="text/javascript">{$js}</script>
{/if}
			<div id="frame">
{if isset($back)}
				<div id="goback">
					<a href="/{$back}" title="Go back">
						<div class="cb">{$corner.start}<p><span>&laquo;</span> Go back</p>{$corner.end}</div>
					</a>
				</div>
				<div id="home">
					<a href="/" title="Go home">
						<div class="cb">{$corner.start}<p>Home</p>{$corner.end}</div>
					</a>
				</div>
				<div class="clear"></div>
{/if}
{if isset($view)}
{$view}
{/if}
			</div>
		</div>
		<div id="footoffset"></div>
		<div id="foot"></div>
{if isset($profiler)}
{$profiler}
{/if}
	</body>
</html>
