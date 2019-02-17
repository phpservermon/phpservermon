$('.search_icon p').hide();
$(".search_input").keyup(function () {
    var searchTerm = $(".search_input").val().toLowerCase();
    $("table tbody tr").each(function (e) {
        col1 = this.cells[0].innerText.toLowerCase().indexOf(searchTerm);
        col2 = this.cells[1].innerText.toLowerCase().indexOf(searchTerm);
        if (col1 >= 0) {
            $(this).attr('visible', 'true');
        } else if (col2 >= 0) {
            $(this).attr('visible', 'true');
        } else {
            $(this).attr('visible', 'false');
        }
    });

    var jobCount = $('table tbody tr[visible="true"]').length;
    if ($(".search_input").is(":placeholder-shown")) {
        $('.search_icon i').show();
        $('.search_icon p').hide();
    } else {
        $('.search_icon i').hide();
        $('.search_icon p').show();

    }
    $('.search_icon p').text(jobCount);

    if (jobCount == '0') {
        $('.no-result').show();
    } else {
        $('.no-result').hide();
    }
});