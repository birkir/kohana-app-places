<?php $r = $item->rating->average(); ?>

<section id="place-details" class="place-details">
	<div class="stars" title="<?=__('Rating');?>: <?=$r;?>">
		<?php for ($i = 1; $i <= 5; $i++): ?>
			<div class="star
				<?php if ($i == ceil($r)):?>
					<?=(ceil($r) - $r < 0.75 ? (ceil($r) - $r < 0.25 ? 'empty' : 'half') : NULL);?>
				<?php elseif ($i >= ceil($r)): ?>
					empty
				<?php endif; ?>
			"></div>
		<?php endfor; ?>
	</div>
	<h1><?=$item->title;?></h1>
        <ul class="specs">
		<li><?=$item->street_name;?> <?=$item->street_number;?></li>
		<li><?=$item->zip->id;?> <?=$item->zip->title;?></li>
                <?php if ( ! empty($item->website)): ?>
                        <li>
                                <strong><?=__('Website');?>:</strong>
                                <a href="<?=$item->website;?>"><?=$item->website;?></a>
                        </li>
                <?php endif;?>
                <?php if ( ! empty($item->email)): ?>
                        <li>
                                <strong><?=__('Email');?>:</strong>
                                <span><?=$item->email;?></span>
                        </li>
                <?php endif;?>
                <?php if ( ! empty($item->phone)): ?>
                        <li>
                                <strong><?=__('Phone');?>:</strong>
                                <span><?=substr($item->phone,0,3);?>-<?=substr($item->phone,3);?></span>
                        </li>
                <?php endif;?>
                <?php if ( ! empty($item->fax)): ?>
                        <li>
                                <strong><?=__('Fax');?>:</strong>
                                <span><?=$item->fax;?></span>
                        </li>
                <?php endif;?>
        </ul>
</section>

<section class="place-food-types">
	<ul class="tags">
		<?php foreach ($item->foods->find_all() as $food): ?>
			<li><a href="<?=URL::base();?>places/foods/<?=$food->alias;?>"><?=$i18n->translate($food->title, 'Food');?></a></li>
		<?php endforeach; ?>
		<?php foreach ($item->categories->find_all() as $category): ?>
			<li><a href="<?=URL::base();?>places/category/<?=$category->alias;?>"><?=$i18n->translate($category->title, 'Category');?></a></li>
		<?php endforeach; ?>
	</ul>
	<div class="clearfix"></div>
</section>

<?php if ( ! Cookie::get('address', FALSE)): ?>
<section><p><a href="<?=URL::base();?>location">You have to set location to use directions.</a></p></section>
<?php else: ?>
<section id="place-directions" class="place-directions">
	<div id="place-directions-map" style="height: 320px;"></div>
	<div id="place-directions-address" style="display: none;"><?=$item->latitude;?>,<?=$item->longitude;?></div>
</section>
<?php endif; ?>

<?php if ( ! empty($item->description)): ?>
<section>
	<h3><?=__('Description');?></h3>
	<p><?=$item->description;?></p>
</section>
<?php endif; ?>
