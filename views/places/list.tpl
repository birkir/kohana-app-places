<ul>
{foreach from=$items item=item}
	<li>{$corner.start}
		{$item->title}
	{$corner.end}</li>
{/foreach}
</ul>