<nav class="menu">
	<ul>
		<?php foreach ($categories as $category): ?>
			<li><a href="<?=URL::base();?>places/category/<?=$category->alias;?>"><?=$i18n->translate($category->title, 'category');?></a></li>
		<?php endforeach; ?>
	</ul>
</nav>
