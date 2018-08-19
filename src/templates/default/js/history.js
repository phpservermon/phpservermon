$().ready(function()
{
	$('.chart').each(function() {
		var $this = $(this);
		create_plot($this);
	});

	$(window).resize(function(){
		$('.chart').each(function() {
			var plot = $(this).data('psm_plot');
			if(plot)
				plot.replot( );
		});
	});

	$('.chart-selector .btn').click(function(){
		var $btn = $(this);
		var chartID = $btn.attr('data-chartId');
		var chartMode = $btn.attr('data-chartMode');
		create_plot($('#chart' + chartID), chartMode);
		$btn.siblings('.btn-info').removeClass('btn-info');
		$btn.addClass('btn-info');
	});
});

function create_plot($this, mode)
{
	if(!$this) return;

	var plot = $this.data('psm_plot');
	if(plot) {
		plot.destroy();
		$this.removeData('psm_plot');
	}

	if($this.attr('data-endTime')) {
		var d = new Date(parseInt($this.attr('data-endTime')));
	} else {
		var d = new Date();
	}
	var time = d.getTime();

	var lines = $this.attr('data-lines');
	if(!lines) {
		lines = [[[0, 0]]];
	}
	else if(typeof(lines) == 'string') {
		lines = eval(lines);
	}

	mode = mode || $this.attr('data-plotMode') || 'hour';
	$this.attr('data-plotMode', mode);
	var timeStamp, tickFormat;
	var showMarker = false;
	var showLegend = true;
	switch(mode)
	{
		case 'year':
			timeStamp = 1000 * 60 * 60 * 24 * 365.25;
			tickFormat = day_format;
			break;
		case 'month':
			timeStamp = 1000 * 60 * 60 * 24 * 30;
			tickFormat = day_format;
			break;
		case 'week':
		case 'week2':
			timeStamp = 1000 * 60 * 60 * 24 * 7;
			tickFormat = short_date_format;
			showMarker = (mode == 'week2');
			break;
		case 'day':
			timeStamp = 1000 * 60 * 60 *24;
			tickFormat = short_time_format;
			break;
		case 'hour':
		default:
			showMarker = true;
			timeStamp = 1000 * 60 * 60;
			tickFormat = short_time_format;
			break;
	}

	var downArray = new Array();
	var down = $this.attr('data-down');
	if(down) {
		if(typeof(down) == 'string') {
			down = eval(down);
		}
		for (var index = 0; index < down.length; ++index) {
			var interval = down[index];
			var d = new $.jsDate(interval[0]);
			downArray.push({rectangle: {
				xmin: interval[0],
				xmax: interval[1] || time,
				yOffset: '1px',
				color: '#fe5d5d',
				showTooltip: true,
				showTooltipPrecision: 1.0,
				tooltipFormatString: "&darr; " + d.strftime(long_date_format)
			}});
		}
	}

	var series = eval($this.attr('data-series'));
	if(Array.isArray(series)) {
		for (var i=0; i<series.length; i++)
		{
			$.extend(true, series[i], {
				markerOptions: {
					show: showMarker
				},
				lineWidth: 1
			});
		}
	} else {
		series = [{}];
		showLegend = false;
	}

	plot = $.jqplot($this.attr('id'), lines, {
		title: $this.attr('data-title'),
        series: series,
		legend: {
			show: showLegend,
			placement: 'insideGrid',
			location: 'nw'
		},
		axes : {
			xaxis:{
				renderer:$.jqplot.DateAxisRenderer,
				tickOptions : {	formatString: tickFormat },
				min: time - timeStamp,
				max: time
			},
			yaxis:{
				min: 0
			}
		},
		highlighter: {
			show: true,
			sizeAdjust: 7.5,
			useAxesFormatters: false,
			tooltipContentEditor: function(str, seriesIndex, pointIndex, plot)
			{
				var point = plot.series[seriesIndex].data[pointIndex];
				var d = new $.jsDate(point[0]);
				return "&uarr; " + d.strftime(long_date_format) + ' - ' + $.jqplot.sprintf('%.3fs', point[1]);
			}
		},
		canvasOverlay: {
			show: true,
			objects: downArray
		},
		cursor:{
			show: true,
			zoom: true,
			showTooltip:false,
			dblClickReset: true,
			constrainZoomTo: 'x'
		}
	});
	$this.data('psm_plot', plot);
}
