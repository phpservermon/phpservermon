function sm_delete(id, mod) {
    var del = confirm("Are you sure you want to delete this record?");
    if (del === true) {
        var loc = 'index.php?action=delete&id=' + id + '&mod=' + mod;
        window.location = loc;
    }
}

function psm_tooltips() {
	$('input[data-toggle="tooltip"]').tooltip({
		'trigger':'hover',
		'placement': 'right',
		'container': 'body'
	});
}

function trim(str) {
    return str.replace(/^\s+|\s+$/g,"");
}

//left trim
function ltrim(str) {
	return str.replace(/^\s+/,"");
}

//right trim
function rtrim(str) {
	return str.replace(/\s+$/,"");
}

function psm_flash_message(message) {
	var flashmessage = $('#flashmessage');
	if(flashmessage.length){
		if(typeof message != 'undefined') {
			flashmessage.html(message);
		}
		var t = flashmessage.html();
		var c = trim(t);
		var t = c.replace('&nbsp;', '');
		if(t){
			flashmessage.slideDown();
		}
	}
}