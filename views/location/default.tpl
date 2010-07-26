			<div class="cb">{$corner.start}
				<form method="post" action="/location">
					<fieldset>
						<dl>
							<dt><label for="fieldset_location">{"Location"|__}</label></dt>
							<dd><input type="text" name="location" id="fieldset_location" value="{if isset($status) AND $status == false AND isset($smarty.request.location)}{$smarty.request.location}{else}{$address}{/if}" /></dd>
						</dl>
					</fieldset>
					<input type="button" name="gps" value="{"Use GPS"|__}" onclick="useGPS();" style="float:left;margin-left:-4px;" />
					<input type="submit" name="save" value="{"Save"|__}" />
					<div class="clear"></div>
				</form>
				<br />
{if isset($status) AND $status == false}
				<p>{"We could not understand the location"|__} <strong>{$smarty.request.location}</strong></p>
				<br />
				<p>{"Suggestions:"|__}</p>
				<ul class="text">
					<li>{"Make sure all street and city names are spelled correctly."|__}</li>
					<li>{"Make sure your address includes a city and street."|__}</li>
					<li>{"Try entering a zip code."|__}</li>
				</ul>
{elseif isset($map)}
				<img src="{$map}" alt="{$address}" style="width:100%;" />
{/if}
			{$corner.end}</div>
{literal}
			<script type="text/javascript">
			function useGPS()
			{
				if (navigator.geolocation)
				{
					navigator.geolocation.getCurrentPosition( processLocation );
				}
				else
				{
					alert("You do not have GPS tracking.");
				}
			}
			function processLocation(position)
			{
				if (window.XMLHttpRequest)
				{
					xmlhttp=new XMLHttpRequest();
				}
				else
				{
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				var lng = position.coords.longitude;
				var lat = position.coords.latitude;
				xmlhttp.open("GET","/location/set?lng="+lng+"&lat="+lat,false);
				xmlhttp.send();
				xmlDoc=xmlhttp.responseXML;
				window.location="/location";
			}
			</script>
{/literal}