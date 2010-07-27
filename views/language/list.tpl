			<div id="menu">
				<ul class="menu">
{foreach from=$languages key=key item=item}
					<li>
						<div class="cb">{$corner.start}
							<a href="/language/set/{$key}" title="{$item|__}" style="padding-left:38px;"><ins style="width:48px;height:48px;position:absolute;top:-19px;left:-6px;z-index:3000;"><img src="/img/i18n/{$key}.png" style="width:48px;height:48px;" /></ins>{$item|__}</a>
						{$corner.end}</div>
					</li>
{/foreach}
				</ul>
			</div>
