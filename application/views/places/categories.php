<nav class="menu">
	<ul>
		<?php foreach ($categories as $category): ?>
			<li><a href="<?=URL::base();?>places/category/<?=$category->alias;?>"><?=$category->title;?></a></li>
		<?php endforeach; ?>
	</ul>
</nav>