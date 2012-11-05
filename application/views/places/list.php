<nav class="places menu autoload" data-limit="<?=Arr::get(Request::current()->query(), 'limit', 20);?>">
	<ul>
		<?php if ($items->count() > 0): ?>
			<?php foreach ($items as $i => $item): ?>
			<?php $r = $item->rating->average(); ?>
				<li>
					<a href="<?=URL::base();?>places/details/<?=$item->id;?>" title="<?=$item->title;?>" onclick="return false;">
						<div class="col left">
							<h3><?=$item->title;?></h3>
							<h5><?=$item->zip->id;?> <?=$item->zip->title;?></h5>
							<h6><?=$item->street_name;?> <?=$item->street_number;?></h6>
						</div>
						<div class="col right">
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
							<div class="clearfix"></div>
							<?php if ($item->price_to > 0): ?>
								<div class="price-range">
									<?=number_format($item->price_from, 0, NULL, '.');?>-<?=number_format($item->price_to, 0, NULL, '.');?>kr.
								</div>
							<?php endif; ?>
							<?php if (isset($item->distance)): ?>
								<span class="distance"><?=number_format(ceil(intval($item->distance * 10)) * 10, 0, NULL, '.');?>m</span>
							<?php endif; ?>
						</div>
						<div class="clearfix"></div>
					</a>
				</li>
			<?php endforeach; ?>
		<?php else: ?>
			<li class="lastnode"><a title="" class="error"><?=__('No places available');?></a></li>
		<?php endif; ?>
	</ul>
</nav>
