<?php if (isset($_GET['redirect'])): ?>
<section>
	<p><?=__('You have to set location for this part of the website.');?></p>
</section>
<?php endif; ?>
<section class="location">
	<?=Form::open(URL::base().'location', array('id' => 'location'));?>
		<fieldset>
			<dl>
				<dt><?=Form::label('location', __('Location'));?></dt>
				<dd><?=Form::input('location', $address, array('id' => 'location'));?></dd>
			</dl>
		</fieldset>
		<?=Form::submit(NULL, __('Save'));?>
		<?=Form::button('gps', __('Use GPS'), array('id' => 'location_gps', 'style' => 'float: right;'));?>
		<div class="clear"></div>
	<?=Form::close();?>

	<?php if (isset($failed)): ?>
		<p><?=__('We could not understand the location');?><strong><?=Arr::get($_POST, 'location');?></strong></p>
		<br />
		<p><?=__('Suggestions');?></p>
		<ul class="text">
			<li><?=__('Make sure all street and city names are spelled correctly.');?></li>
			<li><?=__('Make sure your address includes a city and street.');?></li>
			<li><?=__('Try entering a zip code.');?></li>
		</ul>
	<?php elseif ( ! empty($address)): ?>
		<img src="http://maps.google.com/maps/api/staticmap?center=<?=$coords['latitude'];?>,<?=$coords['longitude'];?>&amp;zoom=14&amp;size=480x320&amp;maptype=roadmap&amp;sensor=false&amp;markers=color:blue|label:S|<?=$coords['latitude'];?>,<?=$coords['longitude'];?>" alt="<?=$address;?>" class="map" />
	<?php endif; ?>
</section>
