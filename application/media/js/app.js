var App = {

	/**
	 * Initailization
	 */
	init: function()
	{
		// loop through misc functions
		for (var func in App.misc)
		{
			// call function if its a function
			App.misc.hasOwnProperty(func) ? App.misc[func]() : null;
		}

		// check if places
		var main = document.getElementById('main');
		var navNode = main.childNodes.length > 1 &&  main.childNodes[1].nodeName == 'NAV' ? 1 : 0;
		App.autoload = (main && main.childNodes.length > 0 && main.childNodes[navNode].nodeName == 'NAV' && (main.childNodes[navNode].getAttribute('class')).indexOf('autoload') > 0);
		App.autoloading = false;

		// resize init
		App.resize();
		window.onresize = App.resize;

		// initialization successed
		return true;
	},

	/**
	 * Resize event
	**/
	resize: function()
	{
		// bottomize footer
		var body = document.body, html = document.documentElement;
		var height = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
		document.getElementsByTagName('footer')[0].style.bottom = -(height - html.clientHeight) + 'px';
	},

	/**
	 * Misc
	 */
	misc:
	{
		/**
		 * Cookies (read-only)
		 */
		cookies: function()
		{
			var cookielist = {};
			var cookies = document.cookie.split('; ');
			var decode = function(s) { return decodeURIComponent(s.replace(/\+/g, ' '));}
			for (var i = 0, l = cookies.length; i < l; i++) {
				var parts = cookies[i].split('=');
				cookielist[decode(parts.shift())] = decode(parts.join('=')).substr(decode(parts.join('=')).indexOf('~') + 1);
			}
			App.cookies = cookielist;
		},

		/**
		 * Directions
		 */
		directions: function()
		{
			if (document.getElementById('place-directions'))
			{
				var that = this;

				// load directions service and renderer
				this.directions_service = new google.maps.DirectionsService();
				this.directions_display = new google.maps.DirectionsRenderer();

				// get coords
				this.destination = (document.getElementById('place-directions-address').innerHTML).split(',');

				// map options
				this.map_options = {
					zoom: 14,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: new google.maps.LatLng(this.destination[0], this.destination[1])
				};

				// boot google map
				this.map = new google.maps.Map(document.getElementById('place-directions-map'), this.map_options);

				// load map to directions display
				this.directions_display.setMap(this.map);

				// directions service route
				this.directions_service.route({
					origin: App.cookies.lat + ', ' + App.cookies.lng,
					destination: document.getElementById('place-directions-address').innerHTML,
					travelMode: google.maps.DirectionsTravelMode.DRIVING
				},
				function(response, status) {
					if (status == google.maps.DirectionsStatus.OK) {
						that.directions_display.setDirections(response);
					} else {
						new google.maps.Marker({
							position: new google.maps.LatLng(that.destination[0], that.destination[1]),
							map: that.map
						});
					}
				});
			}
		},

		/**
		 * Geolocation
		 */
		geolocation: function()
		{
			if (document.getElementById('location_gps'))
			{
				document.getElementById('location_gps').onclick = function()
				{
					// check if browser supports geolocation
					if (navigator.geolocation)
					{
						// ask for location
						navigator.geolocation.getCurrentPosition(function(position){

							// build hidden fields
							var fields = {lat: position.coords.latitude, lng: position.coords.longitude, gps: 'true'};

							// loop through fields
							for (var field in fields)
							{
								// create hidden field
								var hidden = document.createElement('input');
								hidden.name = field;
								hidden.value = fields[field];
								hidden.type = 'hidden';

								// attach to location
								document.getElementById('location').appendChild(hidden);
							}

							// submit form
							document.getElementById('location').submit();
						}, function(error){
							alert('Location not retrieved. Make sure GPS is on, has good signal then try again.');
						}, {
							enableHighAccuracy: false,
							maximumAge: 600000,
							timeout: 10000
						});
					}
					else
					{
						alert('Device does not support location or user rejected permission to get location.');
					}

					return false;
				}
			}
		}
	}
};
