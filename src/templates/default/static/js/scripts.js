$().ready(function () {
	$('.show-modal').click(function (e) {
		var $this = $(this);
		if ($this.is('a')) {
			e.preventDefault();
		}
		var $modal_id = $this.attr('data-modal-id') || 'main';
		var $modal = $('#' + $modal_id + 'Modal');
		if ($modal.length) {
			$modal.find('.modalOKButton').data('modal-origin', $this);

			var param = $this.attr('data-modal-param');
			if (param) {
				var ary = param.split(',');
				for (var index = 0; index < ary.length && index < 9; ++index) {
					var value = ary[index];
					$($modal).find('span.modalP' + (index + 1)).text(value);
				}
			}
			$modal.modal();
		} else {
			// Just in case we forgot the dialog box
			var conf = confirm("Are you sure?");
			if (conf === true) {
				window.location = href;
			}
		}
		return false;
	});

	$('.modalOKButton').click(function (e) {
		var $origin = $(this).data('modal-origin');
		if ($origin.is('a')) {
			window.location = $origin.attr('href');
		} else {
			$origin.next('input[type=hidden]').attr('value', 1);
			$origin.closest('form').submit();
		}
		return false;
	});

	if ($('#list-layout').length > 0) {
		$("#list-layout").hide();
		$("#flow-layout").hide();
		if ($("#list-layout").hasClass('active')) {
			$("#list-layout").show();
		}
		if ($("#flow-layout").hasClass('active')) {
			$("#flow-layout").show();
		}
	}
	$('#label').focus();
});

$("#type").change(function () {
	switch ($("select#type option:checked").val()) {
		case "website":
			$('.typeService').slideUp();
			$('.typeWebsite').slideDown();
			$("select#popular_request_methods").change();
			break;
		case "service":
			$('.typeWebsite').slideUp();
			$('.typeService').slideDown();
			$("select#popular_ports").change();
			break;
		default:
			$('.types').slideUp();
	}
}).change();

$("select#popular_request_methods").change(function () {
	if ($("select#type option:checked").val() != "website") return;
	switch ($("select#popular_request_methods option:checked").val()) {
		case "":
			$('.requestMethod').slideUp();
			$('#request_method').val($("select#popular_request_methods option:checked").val());
			break;
		case "custom":
			$('.requestMethod').slideDown();
			$('#request_method').focus();
			break;
		default:
			$('#request_method').val($("select#popular_request_methods option:checked").val());
			$('.requestMethod').slideUp();
	}
}).change();

$("select#popular_ports").change(function () {
	if ($("select#type option:checked").val() != "service") return;
	switch ($("select#popular_ports option:checked").val()) {
		case "0":
		case "":
			$('#port').val($("select#popular_ports option:checked").val());
			$('.port').slideUp();
			break;
		case "custom":
			$('.port').slideDown();
			$('#port').focus();
			break;
		default:
			$('#port').val($("select#popular_ports option:checked").val());
			$('.port').slideUp();
	}
}).change();

$("#user_name").change(function ()
{
    switch ($("#user_name").val()) {
        case "__PUBLIC__":
            $('#password').parent().slideUp();
            $('#password_repeat').parent().slideUp();
            $("select#level").val('30');
            $("#name").val('Public page');
            break;
        default:
            $('#password').parent().slideDown();
            $('#password_repeat').parent().slideDown();
    }
}).change();


function psm_xhr(mod, params, method, on_complete, options) {
	method = (typeof method === 'undefined') ? 'GET' : method;

	var xhr_options = {
		data: params,
		type: method,
		success: on_complete,
		error: function (jqjqXHR, textStatus, errorThrown) {
			psm_flash_message(errorThrown);
		}
	};
	$.extend(xhr_options, options);

	var result = $.ajax('index.php?xhr=1&mod=' + mod, xhr_options);

	return result;
}

function psm_setLayout(layout) {
	if (layout) {
		$("#list-layout").show();
		$("#flow-layout").hide();
		$("#block-layout").removeClass('active');
		$("#table-layout").addClass('active');
	} else {
		$("#list-layout").hide();
		$("#flow-layout").show();
		$("#block-layout").addClass('active');
		$("#table-layout").removeClass('active');
	}
}

function psm_saveLayout(layout) {
	psm_setLayout(layout)

	var params = {
		action: 'saveLayout',
		csrf: $("input[name=csrf]").val(),
		layout: layout
	};
	psm_xhr('server_status', params, 'POST');
}

if ($(".search_input").length > 0) {
	$.getScript("src/templates/default/static/js/search.js");
	$('<link>')
		.appendTo('head')
		.attr({
			type: 'text/css',
			rel: 'stylesheet',
			href: 'src/templates/default/static/css/search.min.css'
		});
}

if ('serviceWorker' in navigator) {
    navigator.serviceWorker
             .register('./service-worker.js')
             .then(function() { console.log('Service Worker Registered'); });
}