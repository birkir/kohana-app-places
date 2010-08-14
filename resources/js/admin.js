/**
 * Admin interface javascript
 *
 * @author Birkir R Gudjonsson
 */
$(document).ready(function(){
	
	$(".ui-tabs").tabs({
		cookie: {
				expires: 1
			}
	});
	
	function split(val)
	{
		return val.split(/,\s*/);
	}
	function extractLast(term)
	{
		return split(term).pop();
	}
	
	$("#_place_food").autocomplete({
		source: function(request, response) {
			$.getJSON("/admin/places/food", {
				term: extractLast(request.term)
			}, response);
		},
		search: function() {
			var term = extractLast(this.value);
			if (term.length < 1)
			{
				return false;
			}
			
			return true;
		},
		focus: function() {
			return false;
		},
		select: function(event, ui) {
			var terms = split( this.value );
			terms.pop();
			terms.push( ui.item.value );
			terms.push("");
			this.value = terms.join(", ");
			return false;
		}
	});
	
	$("#_place_categories").autocomplete({
		source: function(request, response) {
			$.getJSON("/admin/places/categories", {
				term: extractLast(request.term)
			}, response);
		},
		search: function() {
			var term = extractLast(this.value);
			if (term.length < 1)
			{
				return false;
			}
			
			return true;
		},
		focus: function() {
			return false;
		},
		select: function(event, ui) {
			var terms = split( this.value );
			terms.pop();
			terms.push( ui.item.value );
			terms.push("");
			this.value = terms.join(", ");
			return false;
		}
	});
	
	$("dl").delegate("._remove_hour_row", "click", function(){
		var _dt = $(this).parent("dt");
		var _dd = _dt.next("dd");
		_dt.fadeOut(220);
		_dd.fadeOut(220);
		setTimeout(function(){
			_dt.remove();
			_dd.remove();
		}, 500);
	});
	
	var _i = 99999999;
	$("#_add_hour_row").click(function(){
		
		var _dt_button = $(document.createElement("input"));
		_dt_button.addClass("_remove_hour_row");
		_dt_button.addClass("button");
		_dt_button.attr("type", "button");
		_dt_button.val("Remove row");
		
		var _dt = $(document.createElement("dt")).append(_dt_button);
		
		var _dd_select = $(document.createElement("select"));
		_dd_select.attr("name", "new_hour[day][]");
		_dd_select.attr("id", "_place_hour_"+_i);
		_dd_select.css({ width:150, float:"left", margin: "-1px 15px 0" });
		
		$.getJSON("/admin/places/days", function(data){
			for (i=0;i<data.length;i++)
			{
				var _dd_select_option = $(document.createElement("option"));
				_dd_select_option.text(data[i]);
				_dd_select_option.val(i);
				_dd_select.append(_dd_select_option);
			}
		});
		
		var _dd_label_open = $(document.createElement("label"));
		_dd_label_open.attr("for", "_place_hour_"+_i+"_open");
		_dd_label_open.text(" Open ");
		
		var _dd_input_open = $(document.createElement("input"));
		_dd_input_open.attr("size", "18");
		_dd_input_open.attr("id", "_place_hour_"+_i+"_open");
		_dd_input_open.attr("type", "text");
		_dd_input_open.attr("name", "new_hour[open][]");
		
		var _dd_label_close = $(document.createElement("label"));
		_dd_label_close.attr("for", "_place_hour_"+_i+"_close");
		_dd_label_close.text(" Close ");
		
		var _dd_input_close = $(document.createElement("input"));
		_dd_input_close.attr("size", "18");
		_dd_input_close.attr("id", "_place_hour_"+_i+"_close");
		_dd_input_close.attr("type", "text");
		_dd_input_close.attr("name", "new_hour[close][]");
		
		var _dd = $(document.createElement("dd"));
		_dd.append(_dd_select);
		_dd.append(_dd_label_open);
		_dd.append(_dd_input_open);
		_dd.append(_dd_label_close);
		_dd.append(_dd_input_close);
		
		$(this).parent().children("dl").append(_dt).append(_dd);
		
		_i++;
	});
	
});