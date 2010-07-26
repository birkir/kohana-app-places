			<div id="menu">
				<ul class="menu">
{foreach from=$places key=key item=item}
					<li><a href=""><ins>{$item->distance|number_format:2}km</ins>{$item->title} <span style='font-family:arial;font-size:12px;text-transform:none;'>{$item->street_name} {$item->street_number}</span></a></li>
{/foreach}
				</ul>
			</div>