/*globals window, jQuery, Highcharts*/

window['PieChartManager'] = (function ($) {
    'use strict';

    var _charts = [];

    var _chartData = null;

    var _containerId = null;

    // Set series colors
    Highcharts.setOptions({
        colors: ['#0074CC', '#444444', '#63B544', '#AAAAAA', '#3D96AE', '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92']
    });

    var _renderOptions = {
        spacingTop    : 20,
        spacingRight  : 0,
        spacingBottom : 40,
        spacingLeft   : 0
    };

    var _createChartPart = function (chartDataPart, containerId) {
        return new Highcharts.Chart({
            chart: {
                renderTo            : containerId,
                plotBackgroundColor : null,
                plotBorderWidth     : null,
                plotShadow          : false,
                spacingTop          : _renderOptions.spacingTop,
                spacingRight        : _renderOptions.spacingRight,
                spacingBottom       : _renderOptions.spacingBottom,
                spacingLeft         : _renderOptions.spacingLeft
            },
            title: { text: null },
            credits: { enabled: false },

            tooltip: {
                formatter: function () {
                    return '<strong>' + this.point.name + '</strong>: ' + (Math.round(this.percentage * 100) / 100) + ' %';
                }
            },

            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
                        color: '#000',
                        connectorColor: '#000',
                        formatter: function () {
                            return '<strong>' + this.point.name + '</strong>: ' + (Math.round(this.percentage * 100) / 100) + ' %';
                        }
                    }
                }
            },

            series: [{ type: 'pie', data: chartDataPart }]
        });
    };

    var _createChart = function (chartData, containerId) {
        _chartData = chartData;
        _containerId = containerId;

        var chartPartCount = _chartData.length, i;
        if (1 === chartPartCount) {
            _charts.push(_createChartPart(chartData[0], containerId));
        } else {
            _renderOptions = { spacingTop: 0, spacingRight: 0, spacingBottom: 0, spacingLeft: 0 };
            for (i = 0; i < chartPartCount; i++) {
                _charts.push(_createChartPart(chartData[i], containerId + '-part-' + (i + 1).toString()));
            }
        }
    };

    var _createChartFromJson = function (rawJsonChartData, containerId) {
        var rawChartData = [];

        for(var i = 0; i < rawJsonChartData.length; i++){
            var rawJsonChartDataPart = rawJsonChartData[i];
            var rawChartDataPart = (typeof rawJsonChartDataPart === "string") ? $.parseJSON(rawJsonChartDataPart) : rawJsonChartDataPart;
            rawChartData.push(rawChartDataPart);
        }

        _createChart(rawChartData, containerId);
    };

    var _updateChartDataPart = function (chartPart, newData) {
        if (chartPart.series[0] && chartPart.series[0].remove) {
            chartPart.series[0].remove();
        }
        chartPart.addSeries({ type: 'pie', data: newData });
    };

    var _updateChartData = function (newData) {
        var chartPartCount = _chartData.length, i;
        for (i = 0; i < chartPartCount; i++) {
            _updateChartDataPart(_charts[i], newData[i]);
        }
    };

    return {
        // Pulibc fields
        charts              : _charts,
        chartData           : _chartData,
        containerId         : _containerId,

        // Public methods
        createChart         : _createChart,
        createChartFromJson : _createChartFromJson,
        updateChartData     : _updateChartData
    };

}(jQuery));
