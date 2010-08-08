			<div id="menu">
				<ul class="menu">
{foreach from=$menu item=item}
					<li><a href="/{if isset($prefix)}{$prefix}{/if}{$item->alias}" title="{$item->title|__}">
						<div class="cb">{$corner.start}
							<ins>&nbsp;</ins>{$item->title|__}
						{$corner.end}</div>
					</a></li>
{/foreach}
				</ul>
			</div>
