			<div class="cb">{$corner.start}
{if isset($errors)}
				<div class="errors">
					<p>{"You have following errors:"}</p>
					<ul>
{foreach from=$errors item=item}
						<li>{$item|ucfirst}</li>
{/foreach}
					</ul>
				</div>
{/if}
				<form method="post" action="/places/new">
					<fieldset>
						<dl>
							<dt><label for="_places_title">{"Title"|__}*</label></dt>
								<dd><input type="text" name="title" value="{if isset($p.title)}{$p.title}{/if}" id="_places_title" />
							<dt><label for="_places_opening_hours">{"Opening hours"|__}*</label></dt>
								<dd><input type="text" name="opening_hours" value="{if isset($p.opening_hours)}{$p.opening_hours}{/if}" id="_places_opening_hours" />
							<dt><label for="_places_description">{"Description"|__}</label></dt>
								<dd><textarea name="description" id="_places_description" rows="3" cols="50"></textarea></dd>
							<dt><label for="_places_city">{"City"|__}*</label></dt>
								<dd><input type="text" name="city" id="_places_city" /></dd>
							<dt><label for="_places_zip">{"Zip"|__}*</label></dt>
								<dd><input type="text" name="zip" id="_places_zip" style="width:30%;" /></dd>								
							<dt><label for="_places_street_name">{"Street name"|__}*</label></dt>
								<dd><input type="text" name="street_name" id="_places_street_name" /></dd>
							<dt><label for="_places_street_number">{"Street number"|__}</label></dt>
								<dd><input type="text" name="street_number" id="_places_street_number" style="width:50%;" /></dd>
							<dt><label>{"Food types"|__}*</label></dt>
								<dd>
									<table>
										<tr>
{foreach from=$food key=key item=item}
											<td class="aleft"><input type="checkbox" name="food_types[]" value="{$item->food_id}" id="_places_food_types_{$item->food_id}" /><label for="_places_food_types_{$item->food_id}">{$item->title|__}</label></td>
{if $key mod 2}
										</tr>
										<tr>
{/if}
{/foreach}
										</tr>
									</table>
								</dd>
							<dt><label for="_places_price_from">{"Price from"|__}</label></dt>
								<dd><input type="text" name="price_from" id="_places_price_from" style="width:50%;" /></dd>
							<dt><label for="_places_price_to">{"Price to"|__}</label></dt>
								<dd><input type="text" name="price_to" id="_places_price_to" style="width:50%;" /></dd>
							<dt><label for="_places_website">{"Website"|__}</label></dt>
								<dd><input type="text" name="website" id="_places_website" /></dd>
							<dt><label for="_places_email">{"Email"|__}</label></dt>
								<dd><input type="text" name="email" id="_places_email" /></dd>
							<dt><label for="_places_phone">{"Phone"|__}</label></dt>
								<dd><input type="text" name="phone" id="_places_phone" /></dd>
							<dt><label for="_places_fax">{"Fax"|__}</label></dt>
								<dd><input type="text" name="fax" id="_places_fax" /></dd>
						</dl>
					</fieldset>
					<input type="submit" name="save" value="{"Save"|__}" />
					<div class="clear"></div>
				</form>
			{$corner.end}</div>
