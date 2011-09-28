<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset=utf-8 />
		<meta name="viewport" content="user-scalable=no, width=device-width" /> 
		<title><?php echo __($title); ?> | <?php echo $project->title; ?></title>
		<link rel="shortcut icon" href="/media/img/favico.ico" />
		<link type="text/css" href="/media/css/style.main.css" rel="stylesheet" />
	</head>
	<body>
		<div id="page">
			<div id="head">
				<div id="logo">
					<a href="/" title="">
						<img src="/media/img/logo.png" alt="" id="_logo_img" style="width:230px;height:60px;"  />
					</a>
				</div>
				<div id="shortcuts">
					<ul>
						<li><a href="/location" title="<?php echo __('Location'); ?>"><img src="/media/img/icon-location<?php if ($location->longitude == NULL): ?>-unselected<?php endif; ?>.png" id="_location_img" alt="" style="width:64px;height:64px;" /></a></li>
						<li><a href="/language" title="<?php echo __('Language'); ?>"><img src="/media/img/i18n/<?php ecgo $language; ?>.png" id="_language_img" alt="" style="width:64px;height:64px;" /></a></li>
					</ul>
				</div>
			</div>
<?php if (isset($js)): ?>
	<script type="text/javascript"><?php echo $js; ?></script>
<?php endif; ?>
			<div id="frame">
<?php if (isset($back)): ?>
				<div id="goback">
					<a href="/<?php echo $back; ?>" title="Go back">
						<div class="cb"><?php echo $corner['start']; ?><p><span>&laquo;</span> Go back</p><?php echo $corner['end']; ?></div>
					</a>
				</div>
				<div id="home">
					<a href="/" title="<?php echo __('Go home'); ?>">
						<div class="cb"><?php echo $corner['start']; ?><p>Home</p><?php echo $corner['end']; ?></div>
					</a>
				</div>
				<div class="clear"></div>
<?php endif; ?>
<?php if (isset($view)): ?>
<?php echo $view; ?>
<?php endif; ?>
			</div>
		</div>
		<div id="footoffset"></div>
		<div id="foot"></div>
<?php if (isset($profiler)): ?>
<?php echo $profiler; ?>
<?php endif; ?>
	</body>
</html>
