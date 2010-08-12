				<div class="cb">{$corner.start}
{if $place}
					<h1>{$place->title}</h1>
					<h2>{$place->street_name} {$place->street_number} <small>{$place->zip} {$place->city}</small></h2>
					
					{"Price range"|__}: {$place->price_from} - {$place->price_to}
					
					<table style="width:100%;">
						<tr>
{foreach from=$hours item=item}
							<td>
								<p><strong>{$item.days}</strong></p>
{foreach from=$item.hours item=hour}
								<p>{$hour.open|substr:0:2}:{$hour.open|substr:2} - {$hour.close|substr:0:2}:{$hour.close|substr:2}</p>
{/foreach}
							</td>
{/foreach}
						</tr>
					</table>
					
					
				{$corner.end}</div>
{**

				// FOOD TYPES
**}
				<div class="cb">{$corner.start}
					<h3>{"Food types"|__}</h3>
					<table>
{foreach from=$place->foods->find_all() item=item}
						<tr>
							<td>{php}echo ucfirst(__(Inflector::plural($this->_tpl_vars['item']->title)));{/php}</td>
						</tr>
{/foreach}
					</table>
				{$corner.end}</div>
{**

				// MAP
**}
				<div class="cb">{$corner.start}
					<h3>{"Directions"|__}</h3>
					<img src="{$map}" alt="MAP" />
				{$corner.end}</div>
{**

				// DESCRIPTION
**}
				<div class="cb">{$corner.start}
					<h3>{"Description"|__}</h3>
					<p>{$place->description}</p>
					<br />
				{$corner.end}</div>
{**

				// INFORMATION
**}
				<div class="cb">{$corner.start}
					<ul>
{if !empty($place->website)}
						<li><strong>{"Website"|__}</strong><span>{$place->website}</span></li>
{/if}
{if !empty($place->email)}
						<li><strong>{"Email"|__}</strong><span>{$place->email}</span></li>
{/if}
{if !empty($place->phone)}
						<li><strong>{"Phone"|__}</strong><span>{$place->phone}</span></li>
{/if}
{if !empty($place->fax)}
						<li><strong>{"Fax"|__}</strong><span>{$place->fax}</span></li>
{/if}
					</ul>
{else}
					<div class="errors">
						<p>{"Error"|__}: {"Could not find place"|__}.</p>
					</div>
{/if}
					<div class="clear"><br /></div>
				{$corner.end}</div>
