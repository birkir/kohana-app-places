var _w = window;
var d = document;
var w = get_width();
var ratio = w/480;
if(w>480)
{
	ratio = 1;
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
}