function updateScale(chart, min, unit) {
        chart.options.scales.xAxes[0].time.min = min;
        chart.options.scales.xAxes[0].time.unit = unit;
        chart.update(0);
}

document.addEventListener('DOMContentLoaded', () => {
        const shortInputs = document.querySelectorAll('input[name="timeframe_short"]');
        const longInputs = document.querySelectorAll('input[name="timeframe_long"]');

        const applySelection = (inputs, chart) => {
                const selected = Array.from(inputs).find((input) => input.checked);
                if (selected && chart) {
                        updateScale(chart, parseInt(selected.value, 10), selected.id);
                }
        };

        shortInputs.forEach((input) => {
                input.addEventListener('change', () => applySelection(shortInputs, historyShort));
        });

        longInputs.forEach((input) => {
                input.addEventListener('change', () => applySelection(longInputs, historyLong));
        });

        applySelection(shortInputs, historyShort);
        applySelection(longInputs, historyLong);
});
