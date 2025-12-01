function updateScale(chart, min, unit) {
        chart.options.scales.xAxes[0].time.min = min;
        chart.options.scales.xAxes[0].time.unit = unit;
        chart.update(0);
}

function updateGauge(unit) {
        if (typeof window.historyUptimeRanges === 'undefined') {
                return;
        }

        const value = window.historyUptimeRanges[unit];
        if (typeof value === 'undefined') {
                return;
        }

        const meter = document.getElementById('meter');
        const needle = document.getElementById('needle');

        if (!meter || !needle) {
                return;
        }

        const clamped = Math.max(0, Math.min(100, value));
        meter.setAttribute('data-value', value.toFixed(3));
        if (typeof window.historyUptimeLabel !== 'undefined') {
                meter.setAttribute('translation', window.historyUptimeLabel);
        }
        needle.style.transform = `rotate(${(clamped / 100) * 180}deg)`;
}

document.addEventListener('DOMContentLoaded', () => {
        const shortInputs = document.querySelectorAll('input[name="timeframe_short"]');
        const longInputs = document.querySelectorAll('input[name="timeframe_long"]');

        const applySelection = (inputs, chart) => {
                const selected = Array.from(inputs).find((input) => input.checked);
                if (selected && chart) {
                        updateScale(chart, parseInt(selected.value, 10), selected.id);
                        if (inputs === shortInputs) {
                                updateGauge(selected.id);
                        }
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
