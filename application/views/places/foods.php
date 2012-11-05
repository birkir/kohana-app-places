<nav class="menu">
	<ul>
		<?php foreach ($items as $item): ?>
			<li>
				<a href="<?=URL::base();?>places/food/<?=$item->alias;?>"><?=$i18n->translate($item->title, 'food');?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>