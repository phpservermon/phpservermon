$().ready(function() {
	$('.show-modal').click(function (e) {
		var $this = $(this);
		if ($this.is('a')) {
			e.preventDefault();
		}
		var $modal_id = $this.attr('data-modal-id') || 'main';
		var $modal = $('#' + $modal_id + 'Modal');
		var href = $this.attr('href');
		if($modal.length) {
			$modal.find('.modalOKButton').attr('href', href);

			var param = $this.attr('data-modal-param');
			if(param) {
				var ary = param.split(',');
				for (var index = 0; index < ary.length && index < 9; ++index) {
					var value = ary[index];
					$($modal).find('span.modalP' + (index+1)).text(value);
				}
			}
			$modal.modal('show');
		} else {	
			// Just in case we forgot the dialog box
			var conf = confirm("Are you sure?");
			if (conf === true) {
				window.location = href;
			}
		}
		return false;
	});
});

function psm_tooltips() {
	$('input[data-toggle="tooltip"]').tooltip({
		'trigger':'hover',
		'placement': 'right',
		'container': 'body'
	});
}

function psm_goTo(url) {
	window.location = url;
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