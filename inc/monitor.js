function sm_delete(id, type) {
        var del = confirm("Are you sure you want to delete this record?");
        if (del == true) {
                var loc = 'index.php?delete=' + id + '&type=' + type;
                window.location = loc;
        }
}
function sm_highlight_label(elem) {
    label = elem.parentNode;

    if (elem.checked) {
		label.className = 'active';
	} else {
		label.className = 'inactive';
	}
}

function sm_switch_tab(active) {
	categories = new Array();
	categories[0] = 'status';
	categories[1] = 'email';
	categories[2] = 'sms';

	for(var i = 0; i < categories.length; i++) {
		if(categories[i] == active) {
			document.getElementById('tabs_content_' + categories[i]).style.display = 'block';
			document.getElementById('tabs_title_' + categories[i]).className = 'selected';
		} else {
			document.getElementById('tabs_content_' + categories[i]).style.display = 'none';
			document.getElementById('tabs_title_' + categories[i]).className = '';
		}
	}
}