			<div class="cb"><?php echo $corner['start']; ?>
				<form method="post" action="/location/save">
					<fieldset>
						<dl>
							<dt><label for="fieldset_location"><?php echo __('Location'); ?></label></dt>
							<dd><input type="text" name="location" id="fieldset_location" value="<?php if (isset($status) AND $status == FALSE AND isset($_REQUEST['location'])): ?><?php echo $_REQUEST['location']; ?><?php else: ?><?php echo $address; ?><?php endif; ?>" /></dd>
						</dl>
					</fieldset>
					<input type="button" name="gps" value="<?php echo __("Use GPS"); ?>" onclick="useGPS();" style="float:left;margin-left:-4px;" />
					<input type="submit" name="save" value="<?php echo __("Save"); ?>" />
					<div class="clear"></div>
				</form>
				<br />
<?php if (isset($status) AND $status == FALSE): ?>
				<p><?php echo ("We could not understand the location"); ?> <strong><?php echo $_REQUEST['location']; ?></strong></p>
				<br />
				<p><?php echo __("Suggestions:"); ?></p>
				<ul class="text">
					<li><?php echo __("Make sure all street and city names are spelled correctly."); ?></li>
					<li><?php echo __("Make sure your address includes a city and street."); ?></li>
					<li><?php echo __("Try entering a zip code."); ?></li>
				</ul>
<?php elseif (isset($map)): ?>
				<img src="<?php echo $map; ?>" alt="<?php echo $address; ?>" style="width:100%;" />
<?php endif; ?>
			<?php echo $corner['end']; ?></div>
			<script type="text/javascript">
			function useGPS()
			{
				if (navigator.geolocation)
				{
					navigator.geolocation.getCurrentPosition( processLocation );
				}
				else
				{
					alert("You do not have GPS tracking.");
				}
			}
			function processLocation(position)
			{
				if (window.XMLHttpRequest)
				{
					xmlhttp=new XMLHttpRequest();
				}
				else
				{
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				var lng = position.coords.longitude;
				var lat = position.coords.latitude;
				xmlhttp.open("GET","/location/set?lng="+lng+"&lat="+lat,false);
				xmlhttp.send();
				xmlDoc=xmlhttp.responseXML;
				window.location="/location";
			}
			</script>
