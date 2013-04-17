/*globals window, Highcharts, jQuery, charts*/

var AreaChartManager = (function ($) {
    'use strict';

    var _chart = null;

    var _chartData = null;

    var _containerId = null;

    // Default series colors
    var _chartSeriesInfo = [
        {'color': '#63b544'},
        {'color': '#0074CC'},
        {'color': '#4C4C4C'},
        {'color': '#B182B8'}
    ];

    var _updateSeries = function (data) {
        $.each(_chart.series, function (index, serie) {
            var color = null;
            $.each(data, function (i, e) {
                if($.trim(serie.name.toLowerCase()) == $.trim(e.summary_title.toLowerCase().replace('total', ''))) {
                    color = e.lineColor;
                    return false;
                }
            });

            if (color != null) {
                serie.color = color;
                serie.graph.attr('stroke', color);
            }
        });
    };

    var _updateGraphInfo = function (data) {
        _updateSeries(data);
    };

    var _destroyChart = function () {
        _chart.destroy();
        _chart = null;
    };

    var _addaptRawData = function (rawData) {
        $.each(rawData, function (index, serie) {
            serie.name = serie.key;
            delete serie.key;
        });
        return rawData;
    };

    var _createChart = function (rawChartData, containerId, chartSeriesOptions, afterRender) {
//        if (_chart !== null) {
//            _destroyChart();
//        }
        if (typeof chartSeriesOptions !== 'undefined') {
            _chartSeriesInfo = chartSeriesOptions;
        }

        _chartData = _addaptRawData(rawChartData);
        _containerId = containerId;

        if (typeof chartSeriesOptions.dateBegin === 'undefined') {
            throw new Error("Date begin isn\'t defined");
        }

        if (typeof chartSeriesOptions.dateEnd === 'undefined') {
            throw new Error("Date End isn\'t defined");
        }

        var dateBegin = chartSeriesOptions.dateBegin.split('/');
        var dateEnd = chartSeriesOptions.dateEnd.split('/');

        // Min and max dates for the X axis (in milliseconds from 01/01/1970, UTC time)
        var startPoint = Date.UTC(dateBegin[2], parseInt(dateBegin[0], 10) - 1, dateBegin[1]);
        var endPoint   = Date.UTC(dateEnd[2], parseInt(dateEnd[0], 10) - 1, dateEnd[1]);

        // Range based calculus for the step in the X axis
        var rangeDays = (endPoint - startPoint) / (1000 * 60 * 60 * 24);
        var xAxisStep = (rangeDays > 14 ? 2 :
                        (rangeDays >  6 ? 1 :
                        (rangeDays >  3 ? 2 :
                        (rangeDays >  2 ? 3 :
                        (rangeDays >  1 ? 4 : 8)))));

        _chart = new Highcharts.Chart({
            chart: {
                renderTo: _containerId,
                defaultSeriesType: 'area',
                borderRadius: 0
            },
            title: { text: null },
            credits: { enabled: false },
            legend: { enabled: false },

            xAxis: {
                type: 'datetime',
                labels: {
                    step: xAxisStep,
                    formatter: function () {
                        return Highcharts.dateFormat('%b %d', this.value);
                    }
                },
                minPadding: 0.0255
            },

            yAxis: {
                title: { text: null },
                labels: { align: 'left', x: 0, y: -2 }
            },

            plotOptions: {
                area: {
                    pointStart: startPoint,
                    pointEnd: endPoint,
                    pointInterval: 86400000, // 1 day = 24 * 60 * 60 * 1000
                    fillOpacity: 0.07,
                    lineWidth: 6,
                    marker: { enabled: false }
                }
            },

            series: _chartData
        });

        _updateGraphInfo(_chartData);

        charts.area_chart = {
            chart: _chart,
            options : {
                width : [200, 1075],
                height: [400, 500]
            }
        };

        afterRender = typeof(afterRender) != 'undefined' ? afterRender() : function(){};
    };

    var _createChartFromJson = function (rawJsonChartData, containerId, chartSeriesOptions) {
        var rawChartData = (typeof rawJsonChartData === "string") ? $.parseJSON(rawJsonChartData) : rawJsonChartData;
        _createChart(rawChartData, containerId, chartSeriesOptions);
    };

    var _updateChartData = function (newData) {
        while (_chart.series[0] && _chart.series[0].remove) {
            _chart.series[0].remove();
        }
        var newDataLength = newData.length, i;
        for (i = 0; i < newDataLength; i++) {
            _chart.addSeries(newData[i]);
        }

        _updateGraphInfo(newData);
    };

    return {
        // Public fields
        chart               : _chart,
        chartData           : _chartData,
        containerId         : _containerId,

        // Public methods
        createChart         : _createChart,
        createChartFromJson : _createChartFromJson,
        updateChartData     : _updateChartData
    };

}(jQuery));