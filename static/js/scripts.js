$().ready(function() {
	$('.show-modal').click(function (e) {
		var $this = $(this);
		if ($this.is('a')) {
			e.preventDefault();
		}
		var $modal_id = $this.attr('data-modal-id') || 'main';
		var $modal = $('#' + $modal_id + 'Modal');
		if($modal.length) {
			$modal.find('.modalOKButton').data('modal-origin', $this);

			var param = $this.attr('data-modal-param');
			if(param) {
				var ary = param.split(',');
				for (var index = 0; index < ary.length && index < 9; ++index) {
					var value = ary[index];
					$($modal).find('span.modalP' + (index+1)).text(value);
				}
			}
			scroll(0, 0);
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

	$('.modalOKButton').click(function(e) {
		var $this = $(this);
		var $origin = $this.data('modal-origin');
		if ($origin.is('a')) {
			window.location = $origin.attr('href');
		} else {
			$origin.next('input[type=hidden]').attr('value', 1);
			$origin.closest('form').submit();
		}
		return false;
	});
	$('select.multiselect').multiselect({
		includeSelectAllOption: true,
		maxHeight: 400,
		enableCaseInsensitiveFiltering: true
	});

	psm_flash_message();
	psm_tooltips();

	// popularPorts
    // initial
    $('.portGroup').hide();
    var portInput = $('#port').val();

    if (portInput != '') {
        var findPopularPorts = $('#popularPorts').find('option[value=' + portInput + ']');
        if(findPopularPorts.length) {
            $(findPopularPorts).attr("selected", "selected");
        } else {
            $('#popularPorts').find('option[value=custom]').attr("selected", "selected");
            $('.portGroup').slideDown();
        }
    }

	$('#popularPorts').change(function () {
		changePopularPorts($(this).val(), false, $('#type').val());
	});

	// server type
	$('.types').hide();
	changeTypeSwitch($('#type').val());

	$('#type').change(function () {
		changeTypeSwitch($('#type').val());
		changePopularPorts($('#popularPorts').val(), true, $('#type').val());
	});
});

function changeTypeSwitch(typeInput) {
	switch (typeInput) {
		case 'service':
			$('.types').slideUp();
			$('.typeService').slideDown();
			break;

		case 'website':
			$('.types').slideUp();
			$('.typeWebsite').slideDown();
			break;

		default:
			$('.types').hide();
	}
}

function changePopularPorts(popularPorts, changeType, typeInput) {
	if (changeType === true) {
		if (typeInput == 'service') {
			if (popularPorts == 'custom') {
				$('.portGroup').slideDown();
			} else {
				$('.portGroup').hide();
			}
		}
	} else {
		if (popularPorts == 'custom') {
			$('.portGroup').slideDown();
		} else {
			$('#port').val(popularPorts);
			$('.portGroup').slideUp();
		}
	}
}

function psm_xhr(mod, params, method, on_complete, options) {
	method = (typeof method == 'undefined') ? 'GET' : method;

	var xhr_options = {
		data: params,
		type: method,
		success: on_complete,
		error: function(jqjqXHR, textStatus, errorThrown) {
			psm_flash_message(errorThrown);
		}
	};
	$.extend(xhr_options, options);

	var result = $.ajax('index.php?xhr=1&mod=' + mod, xhr_options);

	return result;
}

function psm_saveLayout(layout) {
	var params = {
		action: 'saveLayout',
		csrf: $("input[name=saveLayout_csrf]").val(),
		layout: layout
	};
	psm_xhr('server_status', params, 'POST');
}

function psm_tooltips() {
	$('input[data-toggle="tooltip"]').tooltip({
		'trigger':'hover',
		'placement': 'right',
		'container': 'body'
	});
	$('i[data-toggle="tooltip"]').tooltip({
		'trigger':'hover',
		'placement': 'bottom'
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