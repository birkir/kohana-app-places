			<div id="menu">
				<ul class="menu">
<?php foreach ($menu as $item): ?>
					<li>
						<a href="/<?php if ( ! empty($prefix)): ?><?php echo $prefix; ?><?php endif; ?><?php echo $item->alias; ?>" title="<?php echo __($item->title); ?>">
						<div class="cb"><?php echo $corner['start']; ?>
							<ins>&nbsp;</ins><?php echo __($item->title); ?>
						<?php echo $corner['end']; ?></div>
					</a></li>
<?php endforeach; ?>
				</ul>
			</div>
