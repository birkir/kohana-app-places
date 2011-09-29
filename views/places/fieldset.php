			<div class="cb"><?php echo $corner['start']; ?>
<?php if (isset($errors)): ?>
				<div class="errors">
					<p><?php echo __("You have following errors:"); ?></p>
					<ul>
<?php foreach ($errors as $item): ?>
						<li><?php echo UTF8::ucfirst($item); ?></li>
<?php endforeach; ?>
					</ul>
				</div>
<?php endif; ?>
				<form method="post" action="/places/new">
					<fieldset>
						<dl>
							<dt><label for="_places_title"><?php echo __("Title"); ?>*</label></dt>
								<dd><input type="text" name="title" value="<?php if (isset($p['title'])): echo $p['title']; endif; ?>" id="_places_title" />
							<dt><label for="_places_opening_hours"><?php echo __("Opening hours"); ?>*</label></dt>
								<dd><input type="text" name="opening_hours" value="<?php if (isset($p['opening_hours'])): echo $p['opening_hours']; endif; ?>" id="_places_opening_hours" />
							<dt><label for="_places_description"><?php echo __("Description"); ?></label></dt>
								<dd><textarea name="description" id="_places_description" rows="3" cols="50"></textarea></dd>
							<dt><label for="_places_city"><?php echo __("City"); ?>*</label></dt>
								<dd><input type="text" name="city" id="_places_city" /></dd>
							<dt><label for="_places_zip"><?php echo __("Zip"); ?>*</label></dt>
								<dd><input type="text" name="zip" id="_places_zip" style="width:30%;" /></dd>								
							<dt><label for="_places_street_name"><?php echo __("Street name"); ?>*</label></dt>
								<dd><input type="text" name="street_name" id="_places_street_name" /></dd>
							<dt><label for="_places_street_number"><?php echo __("Street number"); ?></label></dt>
								<dd><input type="text" name="street_number" id="_places_street_number" style="width:50%;" /></dd>
							<dt><label><?php echo __("Food types"); ?>*</label></dt>
								<dd>
									<table>
										<tr>
<?php foreach ($food as $key => $item): ?>
											<td class="aleft"><input type="checkbox" name="food_types[]" value="<?php echo $item->food_id; ?>" id="_places_food_types_<?php echo $item->food_id; ?>" /><label for="_places_food_types_<?php echo $item->food_id; ?>"><?php echo __($item->title); ?></label></td>
<?php if ($key % 2 == 1): ?>
										</tr>
										<tr>
<?php endif; ?>
<?php endforeach; ?>
										</tr>
									</table>
								</dd>
							<dt><label for="_places_price_from"><?php echo __("Price from"); ?></label></dt>
								<dd><input type="text" name="price_from" id="_places_price_from" style="width:50%;" /></dd>
							<dt><label for="_places_price_to"><?php echo __("Price to"); ?></label></dt>
								<dd><input type="text" name="price_to" id="_places_price_to" style="width:50%;" /></dd>
							<dt><label for="_places_website"><?php echo __("Website"); ?></label></dt>
								<dd><input type="text" name="website" id="_places_website" /></dd>
							<dt><label for="_places_email"><?php echo __("Email"); ?></label></dt>
								<dd><input type="text" name="email" id="_places_email" /></dd>
							<dt><label for="_places_phone"><?php echo __("Phone"); ?></label></dt>
								<dd><input type="text" name="phone" id="_places_phone" /></dd>
							<dt><label for="_places_fax"><?php echo __("Fax"); ?></label></dt>
								<dd><input type="text" name="fax" id="_places_fax" /></dd>
						</dl>
					</fieldset>
					<input type="submit" name="save" value="<?php echo __("Save"); ?>" />
					<div class="clear"></div>
				</form>
			<?php echo $corner['end']; ?></div>
