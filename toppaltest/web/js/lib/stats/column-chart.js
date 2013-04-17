/*globals Highcharts*/

var ColumnChartManager = (function ($) {
    'use strict';

    var _chart = null;

    var _chartData = null;

    var _containerId = null;

    var _enable3Deffect = null;

    var _barColors = [[99, 181, 68], [0, 116, 204], [140, 140, 140], [0, 0, 0]]; // Format: [[R1, G1, B1], [R2, G2, B2], ...]

    var _setBarColors = function () {
        var i;
        if (_enable3Deffect) {
            // Generate the shadow colors
            var barShadowColors = [], shadowIntensity = 0.6; // Between 0.0 and 1.0
            for (i = 0; i < _barColors.length; i++) {
                var barShadowColor = _barColors[i].slice();
                barShadowColor[0] = Math.round(shadowIntensity * barShadowColor[0]);
                barShadowColor[1] = Math.round(shadowIntensity * barShadowColor[1]);
                barShadowColor[2] = Math.round(shadowIntensity * barShadowColor[2]);
                barShadowColors.push(barShadowColor);
            }

            // Function to generate the Highcharts gradients for 3D shadow
            var convertToHighchartsGradient = function (arrayRgbColor, arrayRgbShadowColor) {
                var cssColor = 'rgb(' + arrayRgbColor[0] + ', ' + arrayRgbColor[1] + ', ' + arrayRgbColor[2] + ')';
                var cssShadowColor = 'rgb(' + arrayRgbShadowColor[0] + ', ' + arrayRgbShadowColor[1] + ', ' + arrayRgbShadowColor[2] + ')';
                return {
                    linearGradient: { x1: 0, y1: 0, x2: 1, y2: 0 },
                    stops: [
                        [0,    cssColor],
                        [0.75, cssColor],
                        [0.8,  cssShadowColor],
                        [1,    cssShadowColor]
                    ]
                };
            };

            // Set the colors to Highcharts options.
            var gradientColors = [];
            for (i = 0; i < _barColors.length; i++) {
                gradientColors.push(convertToHighchartsGradient(_barColors[i], barShadowColors[i]));
            }
            Highcharts.getOptions().colors = gradientColors;
        } else {
            var planeColors = [];
            for (i = 0; i < _barColors.length; i++) {
                planeColors.push('rgb(' + _barColors[i][0] + ', ' + _barColors[i][1] + ', ' + _barColors[i][2] + ')');
            }
            Highcharts.getOptions().colors = planeColors;
        }
    };

    var _createChart = function (chartData, containerId, options) {
        _chartData = chartData;
        _containerId = containerId;
        _enable3Deffect = options.enable3Deffect;

        if (typeof colors !== 'undefined') {
            _barColors = options.colors;
        }

        var prevColors = Highcharts.getOptions().colors;
        _setBarColors();
        _chart = new Highcharts.Chart({
            chart: {
                renderTo: _containerId,
                type: 'column',
                animation: { duration: 300 }
            },
            title: { text: null },
            legend: { enabled: false },
            credits: { enabled: false },
            yAxis: { title: { text: null } },

            tooltip: {
                formatter: function () {
                    return '<b>' +  this.series.data[this['point']['x']]['name'] + '</b>: ' + this.y;
                }
            },

            plotOptions: {
                series: {
                    groupPadding: 0.1,
                    pointPadding: 0.025,
                    borderWidth: 0
                }
            },

            xAxis: [{
                categories: ['Direct', 'Viral'],
                labels: {
                    y: 15
                }
            },{
                offset: 20
            }],

            series: _chartData
        });
        Highcharts.getOptions().colors = prevColors;
    };

    var _updateChartData = function (newData) {
        while (_chart.series[0] && _chart.series[0].remove) {
            _chart.series[0].remove();
        }
        for (var i = 0; i < newData.length; i++) {
            _chart.addSeries(newData[i]);
        }
    };

    return {
        // Fields
        chart           : _chart,
        chartData       : _chartData,
        containerId     : _containerId,

        // Methods
        createChart     : _createChart,
        updateChartData : _updateChartData
    };

})(jQuery);