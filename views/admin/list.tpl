<h2>{$controller|ucfirst}</h2>
<table class="ui-table noborder">
	<thead>
		<tr>
			<th>Title</th>
{if isset($fields)}
{foreach from=$fields key=key item=field}
			<th>{$field}</th>
{/foreach}
{/if}
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=item}
		<tr data-id="{$item}">
			<td>{$item->title}</td>
{if isset($fields)}
{foreach from=$fields key=key item=field}
			<td>{$item->$key}</td>
{/foreach}
{/if}
		</tr>
{/foreach}
	</tbody>
</table>
<div class="ui-paging">
{$pagination}
</div>
<br />
<a href="/admin/{$controller}/new" class="button floatl">New {$control}</a>