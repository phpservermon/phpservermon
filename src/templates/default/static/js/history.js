function updateScale(chart, min, unit) {
	chart.options.scales.xAxes[0].time.min = min;
	chart.options.scales.xAxes[0].time.unit = unit;
	// 0 to disable animation
	chart.update(0);
}

$('input[name=timeframe_short]').change(function () {
	updateScale(historyShort, parseInt($('input[name=timeframe_short]:checked').val()), $('input[name=timeframe_short]:checked')[0].id);
});
updateScale(historyLong, parseInt($('input[name=timeframe_long]:checked').val()), $('input[name=timeframe_long]:checked')[0].id);
$('input[name=timeframe_long]').change(function () {
	updateScale(historyLong, parseInt($('input[name=timeframe_long]:checked').val()), $('input[name=timeframe_long]:checked')[0].id);
});