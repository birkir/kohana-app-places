var _w = window;
var d = document;
var w = get_width();
var h = get_height();
var x = null;
var xx = null;
var ratio = w/480;
if(w>480)
{
	ratio = 1;
}
img_corners = new Image(10,10);
img_corners.src="/resources/img/corners.png";
img_borders = new Image(10,10);
img_borders.src="/resources/img/borders.png";

function setHeight()
{
	x = d.getElementById("foot");
	xx = d.getElementById("footoffset");
	if ((get_top(xx)+225) < h)
	{
		x.setAttribute("class", "bottom");
	}else
	{
		x.setAttribute("class", "");
	}
}

function get_top(elm)
{
	var y = 0;
	y = elm.offsetTop;
	elm = elm.offsetParent;
	while(elm != null)
	{
		y = parseInt(y) + parseInt(elm.offsetTop);
		elm = elm.offsetParent;
	}
	
	return y;
}

function get_height()
{
	if (typeof(_w.innerHeight) == 'number')
	{
	  __h = _w.innerHeight;
	}
	else if (d.documentElement && d.documentElement.clientHeight)
	{
		 __h = d.documentElement.clientHeight;
	}
	else if (d.body && d.body.clientHeight)
	{
	  __h = d.body.clientHeight;
	}
	return __h;
}

function get_width()
{
	if (typeof(_w.innerWidth) == 'number')
	{
	  __w = _w.innerWidth;
	}
	else if (d.documentElement && d.documentElement.clientWidth)
	{
		 __w = d.documentElement.clientWidth;
	}
	else if (d.body && d.body.clientWidth)
	{
	  __w = d.body.clientWidth;
	}
	return __w;
}

function addEvent( obj, type, fn )
{
	if (obj.addEventListener)
		obj.addEventListener( type, fn, false );
	else if (obj.attachEvent)
	{
		obj["e"+type+fn] = fn;
		obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
		obj.attachEvent( "on"+type, obj[type+fn] );
	}
}

function resizeEat()
{
	w = get_width();
	h = get_height();
	
	if ((get_top(xx)+225) < h)
	{
		x.setAttribute("class", "bottom");
	}
	else
	{
		x.setAttribute("class", "");
	}
	
	ratio = w/480;
	if(w>480)
	{
		ratio = 1;
	}
	d.getElementById("_logo_img").style.width = 230*ratio + "px";
	d.getElementById("_logo_img").style.height = 60*ratio + "px";
	d.getElementById("_location_img").style.width = 64*ratio + "px";
	d.getElementById("_location_img").style.height = 64*ratio + "px";
	d.getElementById("_language_img").style.width = 64*ratio + "px";
	d.getElementById("_language_img").style.height = 64*ratio + "px";
	d.getElementById("head").style.height = 90*ratio + "px";
}

if(document.getElementById && document.createTextNode)
{
	addEvent(window, 'resize', resizeEat);
	addEvent(window, 'load', setHeight);
}

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-17874812-1']);
_gaq.push(['_setDomainName', '.eat.is']);
_gaq.push(['_trackPageview']);

(function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();