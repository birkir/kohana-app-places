<ul class="places">
{foreach from=$items item=item}
	<li>
		<a href="/places/view/{if empty($item->alias)}{$item->place_id}{else}{$item->alias}{/if}" title="{$item->title}">
			<div class="cb">{$corner.start}
				<div class="stars">
{foreach from=$item->rating->stars() item=star}
					<div class="{$star}"></div>
{/foreach}
				</div>
				<h3>{$item->title}</h3>
				<div class="price_range">
					{$item->price_from} - {$item->price_to} ISK
				</div>
				<h5>{$item->zip} {$item->city}</h5>
				<h6>{$item->street_name} {$item->street_number}{if isset($item->distance)} <span class="distance">({$item->distance|number_format:2} km)</span>{/if}</h6>
<!--
				<ul>
{foreach from=$item->foods->find_all() item=food}
					<li>{$food->title}</li>
{/foreach}
				</ul>
-->
			<div class="clear"></div>
			{$corner.end}</div>
		</a>
	</li>
{/foreach}
</ul>