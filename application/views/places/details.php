<section id="place-details">
	<h1><?=$item->title;?></h1>
	<h2><?=$item->street_name;?> <?=$item->street_number;?> <small><?=$item->zip->id;?> <?=$item->zip->title;?></small></h2>
</section>

<section>
	<h3><?=__('Food types');?></h3>
</section>

<section id="place-directions">
	<div id="place-directions-map" style="height: 320px;"></div>
	<div id="place-directions-address" style="display: none;"><?=$item->latitude;?>,<?=$item->longitude;?></div>
</section>

<section>
	<h3><?=__('Description');?></h3>
	<p><?=$item->description;?></p>
</section>

<section>
	<h3><?=__('Information');?></h3>
	<ul>
		<?php if ( ! empty($item->website)): ?>
			<li>
				<strong><?=__('Website');?></strong>
				<span><?=$item->website;?></span>
			</li>
		<?php endif;?>
		<?php if ( ! empty($item->email)): ?>
			<li>
				<strong><?=__('Email');?></strong>
				<span><?=$item->email;?></span>
			</li>
		<?php endif;?>
		<?php if ( ! empty($item->phone)): ?>
			<li>
				<strong><?=__('Phone');?></strong>
				<span><?=$item->phone;?></span>
			</li>
		<?php endif;?>
		<?php if ( ! empty($item->fax)): ?>
			<li>
				<strong><?=__('Fax');?></strong>
				<span><?=$item->fax;?></span>
			</li>
		<?php endif;?>
	</ul>
</section>