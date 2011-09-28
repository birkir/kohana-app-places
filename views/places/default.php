				<div class="cb"><?php echo $corner['start']; ?>
<?php if ($place): ?>
					<h1><?php echo $place->title; ?></h1>
					<h2><?php echo $place->street_name; ?> <?php echo $place->street_number; ?> <small><?php echo $place->zip; ?> <?php echo $zip[$place->zip]; ?></small></h2>

					<?php echo __("Price range"); ?>: <?php echo $place->price_from; ?> - <?php echo $place->price_to; ?>

					<table style="width:100%;">
						<tr>
<?php foreach ($hours as $item): ?>
							<td>
								<p><strong><?php echo $item['days']; ?></strong></p>
<?php foreach ($item['hours'] as $hour): ?>
								<p><?php echo substr($hour['open'], 0, 2); ?>:<?php echo substr($hour['open'], 2); ?> - <?php echo substr($hour['close'], 0, 2); ?>:<?php echo substr($hour['close'], 2); ?></p>
<?php endforeach; ?>
							</td>
<?php endforeach; ?>
						</tr>
					</table>

				<?php echo $corner['end']; ?></div>
				<div class="cb"><?php echo $corner['start']; ?>
					<h3><?php echo __("Food types"); ?></h3>
					<table>
<?php foreach ($place->foods->find_all() as $item): ?>
						<tr>
							<td><?php echo ucfirst(__(Inflector::plural($item))); ?></td>
						</tr>
<?php endforeach; ?>
					</table>
				<?php echo $corner['end']; ?></div>
<?php if (isset($map)): ?>
				<div class="cb"><?php echo $corner['start']; ?>
					<h3><?php echo __("Directions"); ?></h3>
					<a href="/places/directions/<?php echo $place->place_id; ?>" ><img src="<?php echo $map; ?>" alt="<?php echo ("Directions"); ?>" style="width:100%;" /></a>
				<?php echo $corner['end']; ?></div>
<?php endif; ?>
				<div class="cb"><?php echo $corner['start']; ?>
					<h3><?php echo __("Description"); ?></h3>
					<p><?php echo $place->description; ?></p>
					<br />
				<?php echo $corner['end']; ?></div>
				<div class="cb"><?php echo $corner['start']; ?>
					<ul>
<?php if ( ! empty($place->website)): ?>
						<li><strong><?php echo __("Website"); ?></strong><span><?php echo $place->website; ?></span></li>
<?php endif; ?>
<?php if ( ! empty($place->email)): ?>
						<li><strong><?php echo __("Email"); ?></strong><span><?php echo $place->email; ?></span></li>
<?php endif; ?>
<?php if ( ! empty($place->phone)): ?>
						<li><strong><?php echo __("Phone"); ?></strong><span><?php echo $place->phone; ?></span></li>
<?php endif; ?>
<?php if ( ! empty($place->fax)): ?>
						<li><strong><?php echo __("Fax"); ?></strong><span><?php echo $place->fax; ?></span></li>
<?php endif; ?>
					</ul>
<?php else: ?>
					<div class="errors">
						<p><?php echo __("Error"); ?>: <?php echo __("Could not find place"); ?>.</p>
					</div>
<?php endif; ?>
					<div class="clear"><br /></div>
				<?php echo $corner['end']; ?></div>
