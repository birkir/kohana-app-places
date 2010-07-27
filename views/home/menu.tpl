			<div id="menu">
				<ul class="menu">
{foreach from=$menu item=item}
					<li>
						<div class="cb">{$corner.start}
							<a href="/{$item->alias}" title="{$item->title|__}"><ins>&nbsp;</ins>{$item->title|__}</a>
						{$corner.end}</div>
					</li>
{/foreach}
				</ul>
			</div>
