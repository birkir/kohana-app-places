var _w = window;
var _h = window;
var d = document;
var w = get_width();
var ratio = w/480;
if(w>480)
{
	ratio = 1;
}

function offset_top(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
	do {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}
	return curtop;
}

function get_height()
{
        if (typeof(_h.innerHeight) == 'number')
        {
          __h = _h.innerHeight;
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
	h = get_height();
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
