<div id="login">{$corner.start}
	<form method="post" action="">
		<fieldset>
			<dl>
				<dt><label for="login_username">{"Email"|__}</label></dt>
					<dd><input type="text" name="email" value="" id="login_username" /></dd>
				<dt><label for="login_password">{"Password"|__}</label></dt>
					<dd><input type="password" name="password" value="" id="login_password" /></dd>
			</dl>
		</fieldset>
		<input type="submit" name="login" value="{"Login"|__}" />
		<div class="clear"></div>
	</form>
{$corner.end}</div>