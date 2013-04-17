/*globals Highcharts*/

var MapChartManager;

(function ($) {
    var _chart, _chartOptions, _chartData, _containerId, _mapName, _datasetName;

    var _colorSchema = {
        minValue: 0, // Number or 'auto' to use the minimum series value.
        maxValue: 'auto', // Number or 'auto' to use the maximum series value.
        minColor: [200, 200, 200], // [r, g, b]
        maxColor: [120, 120, 120], // [r, g, b]
        rangesCount: 10
    };

    /**
     *
     * @param chartData
     * @param containerId
     * @param colorSchema
     * @param afterCreateChart is a callback
     * @private
     */
    var _createChart = function (chartData, containerId, colorSchema, mapName, datasetName, afterCreateChart) {
//        if (typeof _chartData === 'object') {
//            _destroyChart();
//        }

        if (typeof colorSchema !== 'undefined' && colorSchema !== null) {
            _colorSchema = colorSchema;
        }

        if (mapName === 'world' || mapName === 'us') { // For now, only world and us maps supported.
            _mapName = mapName;
        } else {
            throw new Error("Invalid map name '" + mapName + "'. Possible values: 'world', 'us'.");
        }

        _chartData = chartData;
        _containerId = containerId;
        _datasetName = datasetName;

        _generateChartOptions();
        _populateChartSeries();

        _chart = new Highcharts.Map(_chartOptions);

        _createZoomOutButton(_mapName);
        afterCreateChart = afterCreateChart || function () {};
        afterCreateChart();
    };

    var _createZoomOutButton = function () {
        var buttonId = _containerId + '_zoom-button';

        if ($(buttonId).length === 0) {
            var zoomButton = $('<a></a>')
                .attr('id', buttonId)
                .attr('title', __("Zoom Out", false))
                .addClass('map-zoom-button')
                .click(function () { _transitionToMap('world'); });

            if (_mapName === 'world') {
                zoomButton.hide();
            }

            zoomButton.appendTo($('#' + _containerId));
        }
    };

    var _transitionToMap = function (mapName) {
        var chartContainer = $('#' + _containerId);
        chartContainer.animate({'opacity': '0.05'}, 150, function () {
            var chartData = ServiceBusDataAddapter.addaptMapChartData(getAnalyticsDataByMapName(mapName), mapName);
            MapChartManager.createChart(chartData, _containerId, null, mapName, _datasetName);
            chartContainer.animate({'opacity': '1'});
        });
    };

    var _createChartFromJson = function (rawJsonChartData, containerId, colorSchema) {
        var rawChartData = (typeof rawJsonChartData === "string") ? $.parseJSON(rawJsonChartData) : rawJsonChartData;
        _createChart(rawChartData, containerId, colorSchema);
    };

    var _updateChartData = function (newData) {
        if (typeof _chartData === 'object') {
            _destroyChart();
        }

        _generateChartOptions();

        _chartData = newData;
        _populateChartSeries();

        // 'try' sentence needed because the Highcharts map chars still are in dev stage.
        try {
            _chart = new Highcharts.Map(_chartOptions);
        } catch (err) {};

        _createZoomOutButton(_mapName);
    };

    var getAnalyticsDataByMapName = function (mapName) {
        if (typeof analyticsData === 'undefined') {
            return null;
        } else if (mapName === 'world') {
            return analyticsData.hasOwnProperty(_datasetName + 'ByCountry') ? analyticsData[_datasetName + 'ByCountry'] : null; // -'ByCountry' data should be added to analyticsData.
        } else if (mapName === 'us') {
            return analyticsData.hasOwnProperty(_datasetName + 'ByState') ? analyticsData[_datasetName + 'ByState'] : null;
        } else {
            return null; // No map data for the required map
        }
    };

    var onMapRegionClick = function (currentMap, clickedRegionCode) {
        if (currentMap === 'world') {
            var rawChartData = getAnalyticsDataByMapName(clickedRegionCode);
            if (rawChartData !== null) {
                _transitionToMap(clickedRegionCode);
            } // else: No zoom available for clicked region.
        }
    };

    var _generateChartOptions = function () {
        var aspectRatio = 548.0 / 798.0; // US map aspect ratio for proportional rendering
        var container = $('#' + _containerId);
        var width = container.width() * 0.9;
        var height = width * aspectRatio;

        _chartOptions = {
            chart : {
                renderTo : _containerId,
                type : 'map',
                width: width,
                height: height
            },
            title : { text : null },
            legend: { enabled: false },
            credits: { enabled: false },
            tooltip: {
                formatter: function() {
                    var tooltip = '<b>' + this.key + ':</b>' + this.y;

                    var supportsZoom = this.point.key === 'us';
                    if (supportsZoom) {
                        tooltip += '<br/><i>Click to Zoom In</i>';
                    }

                    return tooltip;
                }
            },
            series : [{
                data : [],
                name: 'Container Impressions',
                cursor: 'pointer',
                color: '#333333',
                valueRanges: [],
                point: {
                    events: {
                        click: function (event) {
                            onMapRegionClick(_mapName, event.currentTarget.key);
                        }
                    }
                }
            }]
        };
    };

    var _createColorRanges = function (minValue, maxValue) {
        if ('auto' !== _colorSchema.minValue) { minValue = _colorSchema.minValue; }
        if ('auto' !== _colorSchema.maxValue) { maxValue = _colorSchema.maxValue; }

        var calculateRangeLimit = function (rangeNumber) {
            return Math.round((maxValue - minValue) / _colorSchema.rangesCount * rangeNumber + minValue);
        };
        var interpolateColor = function (minColor, maxColor, minRangeNum, maxRangeNum, rangeNum) {
            var fullRangeWidth = maxRangeNum - minRangeNum;
            return [
                Math.round((maxColor[0] - minColor[0]) / fullRangeWidth * rangeNum + minColor[0]), // R
                Math.round((maxColor[1] - minColor[1]) / fullRangeWidth * rangeNum + minColor[1]), // G
                Math.round((maxColor[2] - minColor[2]) / fullRangeWidth * rangeNum + minColor[2]) // B
            ];
        };

        // Ranges creation
        for (var i = 0; i < _colorSchema.rangesCount; i++) {
            var interpolatedColor = interpolateColor(_colorSchema.minColor, _colorSchema.maxColor, 0, _colorSchema.rangesCount - 1, i);
            _chartOptions.series[0].valueRanges.push({
                from: calculateRangeLimit(i),
                to: calculateRangeLimit(i + 1),
                color: 'rgb(' + interpolatedColor[0].toString() + ',' + interpolatedColor[1].toString() + ',' + interpolatedColor[2].toString() + ')'
            });
        }
        // Additional ranges added (at the beginning and the end) to avoid overflowed values to be always black in the map.
        _chartOptions.series[0].valueRanges.push({
            to: calculateRangeLimit(0),
            color: 'rgb(' + _colorSchema.minColor[0].toString() + ',' + _colorSchema.minColor[1].toString() + ',' + _colorSchema.minColor[2].toString() + ')'
        });
        _chartOptions.series[0].valueRanges.push({
            from: calculateRangeLimit(_colorSchema.rangesCount),
            color: 'rgb(' + _colorSchema.maxColor[0].toString() + ',' + _colorSchema.maxColor[1].toString() + ',' + _colorSchema.maxColor[2].toString() + ')'
        });
    };

    var _populateChartSeries = function () {
        var currentValue, minValue = null, maxValue = null;
        var mapShapes = window[_mapName + '_shapes'];

        $.each(_chartData, function(index, object){
            _chartOptions.series[0].data.push({
                y: object.value,
                name : object.title,
                key: object.key,
                path : Highcharts.pathToArray(mapShapes[object.key])
            });
            currentValue = parseInt(object.value, 10);
            minValue = null === minValue || currentValue < minValue ? currentValue : minValue;
            maxValue = null === maxValue || currentValue > maxValue ? currentValue : maxValue;
        });

        _createColorRanges(minValue, maxValue);
    };

    var _destroyChart = function() {
        if (typeof _chart !== 'undefined' && _chart !== null) {
            // 'try' sentence needed because the Highcharts map chars still are in dev stage.
            try {
                _chart.destroy();
            } catch (err) {};
        }
    };

    return MapChartManager = {
        chartData           : _chartData,
        containerId         : _containerId,

        createChart         : _createChart,
        createChartFromJson : _createChartFromJson,
        updateChartData     : _updateChartData,
        getChart            : function () { return _chart; },
        redraw              : function () {
            // @todo improve this method using size recalculation and redraw instead of _updateChartData.
            _updateChartData(_chartData);
        }
    };

})(jQuery);
