<nav class="menu icons">
	<ul>
		<?php foreach ($languages as $key => $item): ?>
			<li>
				<a href="/language/set/<?=$key;?>" title="<?=__($item);?>" style="background-image: url(/media/img/i18n/<?=$key;?>.png);">
					<?=__($item);?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>