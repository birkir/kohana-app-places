<h2>Edit/Add place</h2>
<div id="place">
	<ul>
		<li><a href="#place-details">Details</a></li>
		<li><a href="#place-description">Description</a></li>
		<li><a href="#place-hours">Hours</a></li>
	</ul>
	<form method="post" action="">
		<div id="place_details">
			<fieldset>
				<dl>
					<dt><label for="_place_title">Title</label></dt>
						<dd><input type="text" name="title" value="" id="_place_title" size="80" /></dd>
					<dt><label for="_place_street_name">Address</label></dt>
						<dd>
							<input type="text" name="street_name" value="" id="_place_street_name" size="60" />
							<label for="_place_street_number">&nbsp; No.</label>
							<input type="text" name="street_number" value="" id="_place_street_number" size="8" />
						</dd>
					<dt><label for="_place_city">City</label></dt>
						<dd>
							<select name="city" id="_place_city" style="width:516px;">
							</select>
						</dd>
					<dt><label for="_place_webite">Website</label></dt>
						<dd><input type="text" name="website" value="" id="_place_website" size="80" /></dd>
					<dt><label for="_place_email">Email</label></dt>
						<dd><input type="text" name="email" value="" id="_place_email" size="80" /></dd>
					<dt><label for="_place_phone">Phone</label></dt>
						<dd><input type="text" name="phone" value="" id="_place_phone" size="80" /></dd>
					<dt><label for="_place_fax">Fax</label></dt>
						<dd><input type="text" name="fax" value="" id="_place_fax" size="80" /></dd>
					<dt><label for="_place_price_from">Price</label></dt>
						<dd>
							<input type="text" name="price_from" value="" id="_place_price_from" size="15" />
							&nbsp;to&nbsp;
							<input type="text" name="price_to" value="" id="_place_price_to" size="15" />
						</dd>
					<dt><label for="_place_food">Food types</label></dt>
						<dd><input type="text" name="food" value="" id="_place_food" size="80" /></dd>
					<dt><label for="_place_categories">Categories</label></dt>
						<dd><input type="text" name="categories" value="" id="_place_categories" size="80" /></dd>
				</dl>
			</fieldset>
		</div>
		<div id="place-description">
			<fieldset>
				<dl>
					<dt><label for="_place_description">Description</label></dt>
						<dd>
							<textarea name="description" id="_place_description" rows="10" cols="83"></textarea>
						</dd>
				</dl>
			</fieldset>
		</div>
		<div id="place-hours">
			<fieldset>
				<dl>
					<dt><label for="_place_hour_1">Opening hours</label></dt>
					<dd>
						<select name="hour[1][day]" id="_place_hour_1" style="width:150px;">
							<option value="0">Monday</option>
							<option value="1">Tuesday</option>
							<option value="2">Wednesday</option>
						</select>
						<label for="_place_hour_1_open">Open</label>
						<input type="text" name="hour[1][open]" value="" id="_place_hour_1_open" size="18" />
						<label for="_place_hour_1_close">Close</label>
						<input type="text" name="hour[1][close]" value="" id="_place_hour_1_open" size="18" />
					</dd>
				</dl>
				<input class="button" type="button" id="_add_hour_row" value="Add row" />
			</fieldset>
		</div>
	</form>
</div>