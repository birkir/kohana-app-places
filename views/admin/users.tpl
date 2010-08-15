<h2>{if $user->user_id}Edit user{else}New user{/if} <a class="back" href="/admin/users">Cancel</a></h2>
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
	<div id="users" class="ui-tabs">
		<ul class="ui-tabs-nav">
			<li><a href="#users-details">Details</a></li>
			<li><a href="#users-roles">Roles</a></li>
		</ul>
		<div class="clearfix"></div>
		<div id="users-details" class="ui-tabs-panel">
			<fieldset>
				<dl>
					<dt><label for="_user_title">Full name</label></dt>
						<dd><input type="text" name="title" value="{$user->title}" id="_user_title" size="80" /></dd>
					<dt><label for="_user_username">Username</label></dt>
						<dd><input type="text" name="username" value="{$user->username}" id="_user_username" size="80" /></dd>
					<dt><label for="_user_email">Email</label></dt>
						<dd><input type="text" name="email" value="{$user->email}" id="_user_email" size="80" /></dd>
					<dt><label for="_user_password">Password</label></dt>
						<dd><input type="text" name="password" value="" id="_user_password" size="80" /></dd>
					<dt><label for="_user_confirm_password">Confirm password</label></dt>
						<dd><input type="text" name="confirm_password" value="" id="_user_confirm_password" size="80" /></dd>
					<dt><label for="_user_enabled">Enabled</label></dt>
						<dd>
							<input type="radio" name="enabled" value="1" id="_user_enabled_yes"{if $user->enabled == 1} checked="checked"{/if} /><label for="_user_enabled_yes">Yes</label>
							<input type="radio" name="enabled" value="0" id="_user_enabled_no"{if $user->enabled == 0} checked="checked"{/if} /><label for="_user_enabled_no">No</label>
						</dd>
				</dl>
			</fieldset>
		</div>
		<div id="users-roles" class="ui-tabs-hide">
			<fieldset>
				<table class="ui-table">
					<thead>
						<tr>
							<th colspan="2">Check</th>
							<th>Title</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
{foreach from=$roles item=item}
{if isset($my_roles) AND in_array($item->role_id, $my_roles)}
						<tr>
							<td style="width:20px;text-align:center;">{if $item->name|strrpos:"/" != TRUE}<input type="checkbox" name="roles[{$item->role_id}]" id="_user_role_{$item->role_id}"{if isset($user_roles) AND in_array($item->role_id, $user_roles)} checked="checked"{/if} />{/if}</td>
							<td style="width:20px;text-align:center;">{if $item->name|strrpos:"/" == TRUE}<input type="checkbox" name="roles[{$item->role_id}]" id="_user_role_{$item->role_id}"{if isset($user_roles) AND in_array($item->role_id, $user_roles)} checked="checked"{/if} />{/if}</td>
							<td><label for="_user_role_{$item->role_id}">{$item->title}</label></td>
							<td><label for="_user_role_{$item->role_id}">{$item->description}</label></td>
						</tr>
{/if}
{/foreach}
					</tbody>
				</table>
				<br />
				Check:
				<input type="button" class="button check_all" value="All" id="_user_check_all" />
				<input type="button" class="button check_none" value="None" id="_user_check_none" />
			</fieldset>
		</div>
	</div>
	<br />
	<input class="button large" type="submit" name="" value="Save user" />
</form>