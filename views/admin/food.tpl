<h2>{if $food->food_id}Edit food{else}New food{/if} <a class="back" href="/admin/food">Cancel</a></h2>
{if isset($errors)}
<div id="errors">
	<h6>You have the following errors:</h6>
	<ul>
{foreach from=$errors item=item}
		<li>{$item|__|ucfirst}</li>
{/foreach}
	</ul>
	<br />
</div>
{/if}
<form method="post" action="">
	<div class="ui-tabs">
		<div class="ui-tabs-panel">
			<fieldset>
				<dl>
					<dt><label for="_food_title">Title</label></dt>
						<dd><input type="text" name="title" value="{$food->title}" id="_food_title" size="80" /></dd>
					<dt><label for="_food_alias">Alias</label></dt>
						<dd><input type="text" name="alias" value="{$food->alias}" id="_food_alias" size="80" /></dd>
				</dl>
			</fieldset>
		</div>
	</div>
	<br />
	<input class="button large" type="submit" name="" value="Save food" />
</form>