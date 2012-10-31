<h2>{if $category->category_id}Edit category{else}New category{/if} <a class="back" href="/admin/categories">Cancel</a></h2>
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
					<dt><label for="_category_title">Title</label></dt>
						<dd><input type="text" name="title" value="{$category->title}" id="_category_title" size="80" /></dd>
					<dt><label for="_category_alias">Alias</label></dt>
						<dd><input type="text" name="alias" value="{$category->alias}" id="_category_alias" size="80" /></dd>
				</dl>
			</fieldset>
		</div>
	</div>
	<br />
	<input class="button large" type="submit" name="" value="Save category" />
</form>