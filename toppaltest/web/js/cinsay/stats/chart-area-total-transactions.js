/*globals window, Highcharts, jQuery, charts*/

var TotalTransactionsChartManager = (function ($) {
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
                if (typeof e.summary_title != 'undefined' && $.trim(serie.name.toLowerCase()) == $.trim(e.summary_title.toLowerCase())) {
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

        //_updateMainMetrics(data);
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

    var _createChart = function (chartData, containerId, options) {
        _chartSeriesInfo = [
            {'color': '#0074CC'},
            {'color': '#4C4C4C'},
            {'color': '#63b544'},
            {'color': '#AAAAAA'}
        ];

        if (typeof _chartData === 'object' && _chartData !== null) {
            _destroyChart();
        }

        if (typeof options !== 'undefined') {
            _chartSeriesInfo = options;
        }

        _chartData = _addaptRawData(chartData);
        _containerId = containerId;


        if (typeof options.dateBegin === 'undefined') {
            throw new Error("Date begin isn\'t defined");
        }

        if (typeof options.dateEnd === 'undefined') {
            throw new Error("Date End isn\'t defined");
        }

        var dateBegin = options.dateBegin.split('/');
        var dateEnd = options.dateEnd.split('/');

        var startPoint = Date.UTC(dateBegin[2], parseInt(dateBegin[0], 10) - 1, dateBegin[1]);
        var endPoint   = Date.UTC(dateEnd[2], parseInt(dateEnd[0], 10) - 1, dateEnd[1]);

        var rangeDays = (endPoint - startPoint) / (1000 * 60 * 60 * 24);
        var xAxisStep = (rangeDays > 14 ? 2 :
            (rangeDays >  6 ? 1 :
                (rangeDays >  3 ? 2 :
                    (rangeDays >  2 ? 3 :
                        (rangeDays >  1 ? 4 : 8
                            )))));

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
                    pointStart: Date.UTC(dateBegin[2], parseInt(dateBegin[0], 10) - 1, dateBegin[1]),
                    pointEnd: Date.UTC(dateEnd[2], parseInt(dateEnd[0], 10) - 1, dateEnd[1]),
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
                //height: [100, _chart.chartHeight]
                height: [400, 500]
            }
        };
    };

    var _createChartFromJson = function (rawJsonChartData, containerId, chartSeriesOptions) {
        var rawChartData = (typeof rawJsonChartData === "string") ? $.parseJSON(rawJsonChartData) : rawJsonChartData;
        _createChart(rawChartData, containerId, chartSeriesOptions);
    };

    var _updateChartData = function (newData) {
        while (_chart.series[0] && _chart.series[0].remove) {
            _chart.series[0].remove();
        }
        for (var i = 0; i < newData.length; i++) {
            _chart.addSeries(newData[i]);
        }

        _updateSeries();
    };

    return {
        // Public fields
        chart               : _chart,
        chartData           : _chartData,
        containerId         : _containerId,

        // Public methods
        createChart         : _createChart,
        updateChartData     : _updateChartData
    };

}(jQuery));