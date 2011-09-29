				<div class="place">
				<div class="cb"><?php echo $corner['start']; ?>
<?php if ($place): ?>
					<div class="stars">
<?php foreach ($place->rating->stars() as $star): ?>
						<div class="<?php echo $star; ?>"></div>
<?php endforeach; ?>
					</div>
					<h1><?php echo $place->title; ?></h1>
					<div class="price_range right"><?php echo $place->price_from; ?> - <?php echo $place->price_to; ?> ISK</div>
					<h2><?php echo $place->street_name; ?> <?php echo $place->street_number; ?>, <small><?php echo $place->zip; ?> <?php echo $zip[$place->zip]; ?></small></h2>
				<?php echo $corner['end']; ?></div>

<?php if (count($hours) > 0): ?>
				<div class="cb"><?php echo $corner['start']; ?>
					<table class="opening_hours">
						<tr>
<?php foreach ($hours as $item): ?>
							<td>
								<strong><?php echo $item['days']; ?></strong>
							</td>
							<td>
<?php foreach ($item['hours'] as $hour): ?>
								<span><?php echo substr($hour['open'], 0, 2); ?>:<?php echo substr($hour['open'], 2); ?> - <?php echo substr($hour['close'], 0, 2); ?>:<?php echo substr($hour['close'], 2); ?></span>
<?php endforeach; ?>
							</td>
<?php endforeach; ?>
						</tr>
					</table>
				<?php echo $corner['end']; ?></div>
<?php endif; ?>

<?php if ($place->foods->count_all() > 0): ?>
				<div class="cb"><?php echo $corner['start']; ?>
					<ul class="food_types">
<?php foreach ($place->foods->find_all() as $item): ?>
						<li><a href="/places/food/<?php echo $item->alias; ?>"><?php echo $item->title; ?></a></li>
<?php endforeach; ?>
					</ul>
					<div class="clear"></div>
				<?php echo $corner['end']; ?></div>
<?php endif; ?>
				<div class="cb"><?php echo $corner['start']; ?>
<?php if (Cookie::get('address', NULL) == NULL): ?>
					<button onclick="window.location='/location'">Set your location for directions</button>
<?php else: ?>
					<div id="directions"></div>
					<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;key=<?php echo Kohana::$config->load('eat_is')->google['maps']; ?>"></script>
					<script type="text/javascript">
					var latLng = new google.maps.LatLng(<?php echo $place->latitude; ?>, <?php echo $place->longitude; ?>);
					var map = new google.maps.Map(document.getElementById('directions'), {
						zoom: 13,
						center: latLng,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					});
					var dirService = new google.maps.DirectionsService();
					var dirRenderer = new google.maps.DirectionsRenderer();
					var dirRequest = {
						origin: '<?php echo Cookie::get('address', NULL); ?>',
						destination: '<?php echo $place->latitude; ?>, <?php echo $place->longitude; ?>',
						travelMode: google.maps.DirectionsTravelMode.DRIVING,
						unitSystem: google.maps.DirectionsUnitSystem.METRIC,
						provideRouteAlternatives: true
					};
					var showDirections = function(dirResult, dirStatus) {
						if (dirStatus != google.maps.DirectionsStatus.OK) {
						  alert('Could not get directions: ' + dirStatus);
						  return;
						}
						dirRenderer.setMap(map);
						dirRenderer.setDirections(dirResult);
					};
					dirService.route(dirRequest, showDirections);
					</script>
<?php endif; ?>
					<div class="clear"></div>
				<?php echo $corner['end']; ?></div>

<?php if ( ! empty($place->description)): ?>
				<div class="cb"><?php echo $corner['start']; ?>
					<p><?php echo $place->description; ?></p>
					<br />
				<?php echo $corner['end']; ?></div>
<?php endif; ?>
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
					<div class="clear"><br /></div>
<?php endif; ?>
				<?php echo $corner['end']; ?></div>
				</div>
