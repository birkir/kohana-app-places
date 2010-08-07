<ul>
{foreach from=$items item=item}
	<li>{$corner.start}
		<ul class="stars">
{foreach from=$item->rating->stars() item=star}
			<li><a class="{$star}">&nbsp;</a></li>
{/foreach}
		</ul>
		{$item->title} {$item->zip} {$item->city}
		{$item->price_from} - {$item->price_to}
		<ul>
{foreach from=$item->foods->find_all() item=food}
			<li>{$food->title}</li>
{/foreach}
		</ul>
	{$corner.end}</li>
{/foreach}
</ul>