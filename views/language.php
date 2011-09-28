			<div id="menu">
				<ul class="menu">
<?php foreach ($languages as $key => $item): ?>
					<li>
						<div class="cb"><?php echo $corner['start']; ?>
							<a href="/language/set/<?php echo $key; ?>" title="<?php echo __($item); ?>" style="padding-left:38px;"><ins style="width:48px;height:48px;position:absolute;top:-19px;left:-6px;z-index:3000;"><img src="/media/img/i18n/<?php echo $key; ?>.png" style="width:48px;height:48px;" /></ins><?php echo __($item); ?></a>
						<?php echo $corner['end']; ?></div>
					</li>
<?php endforeach; ?>
				</ul>
			</div>
