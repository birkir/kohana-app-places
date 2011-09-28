<ul class="places">
<?php if ($items->count() > 0): ?>
<?php foreach ($items as $item): ?>
	<li>
		<a href="/places/view/<?php echo empty($item->alias) ? $item->place_id : $item->alias; ?>" title="<?php echo $item->title; ?>">
			<div class="cb"><?php echo $corner['start']; ?>
				<div class="stars">
<?php foreach ($item->rating->stars() as $star): ?>
					<div class="<?php echo $star; ?>"></div>
<?php endforeach; ?>
				</div>
				<h3><?php echo $item->title; ?></h3>
				<div class="price_range">
					<?php echo $item->price_from; ?> - <?php echo $item->price_to; ?> ISK
				</div>
				<h5><?php echo $item->zip; ?> <?php echo $zip[$item->zip]; ?></h5>
				<h6><?php echo $item->street_name; ?> <?php echo $item->street_number; ?><?php if (isset($item->distance)): ?> <span class="distance">(<?php echo number_format($item->distance, 2); ?> km)</span><?php endif; ?></h6>
			<div class="clear"></div>
			<?php echo $corner['end']; ?></div>
		</a>
	</li>
<?php endforeach; ?>
<?php else: ?>
	<li><div class="cb"><?php echo $corner['start']; ?>
		<span style="font-size:16px;"><?php echo __("Nothing was found"); ?></span>
	<?php echo $corner['end']; ?></div></li>
<?php endif; ?>
</ul>
