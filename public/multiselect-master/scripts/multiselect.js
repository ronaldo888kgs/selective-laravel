//multiselect collection
window.multiselects = [];

{
	document.multiselect = function(selector) {
		var res = [];
		if (!window.multiselects._items) {
			window.multiselects._items = [];
		}
		
		m_helper.each(document.querySelectorAll(selector), function(e) {
			var index = window.multiselects._items.indexOf(e);
			if (index == -1) {
				var inputItem = new Multiselect(e);
				window.multiselects.push(inputItem);
				window.multiselects._items.push(e);

				res.push(inputItem)
			} else {
				res.push(window.multiselects[index]);
			}
		});
		
		return res.length == 1 ? res[0] : res;
	}
	
	window.onclick = function(event) {
		hideMultiselects(event);
	};
}

function hideMultiselects(event) {
	m_helper.each(window.multiselects, function(e) {
		if (document.getElementById(e._getItemListIdentifier()).offsetParent &&
				!m_helper.parent(event.target, e._getIdentifier())) {
			e._hideList(e, event);
		}
	});
}