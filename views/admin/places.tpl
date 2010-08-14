<h2>{if $place->place_id}Edit "{$place->title}"{else}New place{/if} <a class="back" href="/admin/places">Cancel</a></h2>
<form method="post" action="">
	<div id="place" class="ui-tabs">
		<ul class="ui-tabs-nav">
			<li><a href="#place-details">Details</a></li>
			<li><a href="#place-description">Description</a></li>
			<li><a href="#place-hours">Hours</a></li>
		</ul>
		<div class="clearfix"></div>
		<div id="place-details" class="ui-tabs-panel">
			<fieldset>
				<dl>
					<dt><label for="_place_title">Title</label></dt>
						<dd><input type="text" name="title" value="{$place->title}" id="_place_title" size="80" /></dd>
					<dt><label for="_place_street_name">Address</label></dt>
						<dd>
							<input type="text" name="street_name" value="{$place->street_name}" id="_place_street_name" size="60" />
							<label for="_place_street_number">&nbsp; No.</label>
							<input type="text" name="street_number" value="{$place->street_number}" id="_place_street_number" size="8" />
						</dd>
					<dt><label for="_place_city">City</label></dt>
						<dd>
							<select name="zip" id="_place_city" style="width:516px;">
{foreach from=$zips key=key item=item}
								<option value="{$key}"{if $place->zip == $key} selected="selected"{/if}>{$key} {$item}</option>
{/foreach}
							</select>
						</dd>
					<dt><label for="_place_webite">Website</label></dt>
						<dd><input type="text" name="website" value="{$place->website}" id="_place_website" size="80" /></dd>
					<dt><label for="_place_email">Email</label></dt>
						<dd><input type="text" name="email" value="{$place->email}" id="_place_email" size="80" /></dd>
					<dt><label for="_place_phone">Phone</label></dt>
						<dd><input type="text" name="phone" value="{$place->phone}" id="_place_phone" size="80" /></dd>
					<dt><label for="_place_price_from">Price</label></dt>
						<dd>
							<input type="text" name="price_from" value="{$place->price_from}" id="_place_price_from" size="15" />
							&nbsp;to&nbsp;
							<input type="text" name="price_to" value="{$place->price_to}" id="_place_price_to" size="15" />
						</dd>
					<dt><label for="_place_food">Food types</label></dt>
						<dd><input type="text" name="food" value="{if isset($food)}{$food}{/if}" id="_place_food" size="80" /></dd>
					<dt><label for="_place_categories">Categories</label></dt>
						<dd><input type="text" name="categories" value="{if isset($categories)}{$categories}{/if}" id="_place_categories" size="80" /></dd>
				</dl>
			</fieldset>
		</div>
		<div id="place-description" class="ui-tabs-hide">
			<fieldset>
				<dl>
					<dt><label for="_place_description">Description</label></dt>
						<dd>
							<textarea name="description" id="_place_description" rows="10" cols="83">{$place->description}</textarea>
						</dd>
				</dl>
			</fieldset>
		</div>
		<div id="place-hours" class="ui-tabs-hide">
			<fieldset>
				<dl>
{foreach from=$place->hours->find_all() key=key item=item}
					<dt><input type="button" class="button _remove_hour_row" value="Remove row" /></dt>
					<dd>
						<select name="hour[{$item->hour_id}][day]" id="_place_hour_{$item->hour_id}" style="width:150px;float:left;margin:-1px 15px 0;">
{foreach from=$days key=d item=day}
							<option value="{$d}"{if $item->day_of_week == $d} selected="selected"{/if}>{$day}</option>
{/foreach}
						</select>
						<label for="_place_hour_{$item->hour_id}_open">Open</label>
						<input type="text" name="hour[{$item->hour_id}][open]" value="{$item->open|str_pad:4:"0":STR_PAD_LEFT|substr:0:2}:{$item->open|str_pad:4:"0":STR_PAD_LEFT|substr:2}" id="_place_hour_{$item->hour_id}_open" size="18" />
						<label for="_place_hour_{$item->hour_id}_close">Close</label>
						<input type="text" name="hour[{$item->hour_id}][close]" value="{$item->close|str_pad:4:"0":STR_PAD_LEFT|substr:0:2}:{$item->close|str_pad:4:"0":STR_PAD_LEFT|substr:2}" id="_place_hour_{$item->hour_id}_close" size="18" />
					</dd>
{/foreach}
				</dl>
				<input class="button" type="button" id="_add_hour_row" value="Add row" />
			</fieldset>
		</div>
	</div>
	<br />
	<input class="button large" type="submit" name="" value="Save place" />
</form>