/*globals tooltipData*/

var RatiosChartManager;

(function ($) {

    var _chartContainer, _chartContainerId, _isRatio, _container, _showBullets, _tooltipsEnabled;

    var _createChart = function(jsonData, chartContainerId, options){
        _chartContainerId = chartContainerId;
        _chartContainer = $('#' + chartContainerId);
        _isRatio = options.isRatio;
        _showBullets = options.showBullets;
        _tooltipsEnabled = options.hasOwnProperty('tooltipsEnabled') ? !!options.tooltipsEnabled : false;

        _destroyChart();
        _createItems(jsonData);
    };

    var _updateChartData = function(jsonData){
        _destroyChart();
        _createItems(jsonData);
    };

    var _createBaseContainer = function () {
        _container = $('<div></div>').attr('id', 'list-chart-item').attr('class', 'list-chart-item-container');
        var ratioValue = $('<span><span class="ratio-value"></span></span>').attr('class', 'list-chart-ratio-value');
        var ratioLegend = $('<span></span>').attr('class', 'list-chart-ratio-legend');

        if (_showBullets) {
            var bullet = $('<div></div>').attr('class', 'list-chart-bullet');
            _container.append(bullet, ratioValue, ratioLegend);
        } else {
            _container.append(ratioValue, ratioLegend);
        }
    };

    var _createItems = function (jsonData) {
        _createBaseContainer();

        if ( _isRatio === true ) {
            var containerViews = jsonData.container['value'];
        }
        $.each(jsonData, function (index, obj) {
            if (obj.name == 'container' && _isRatio) {
                return true;
            }

            var value = obj.value;
            var spanValue;
            if (_isRatio === true) {
                spanValue = (value / containerViews).toFixed(2);
            } else {
                spanValue = _parseValue(index,value);
            }

            var cloned = _container.clone();
            var ratioSpan = $('span.list-chart-ratio-value .ratio-value', cloned).html(spanValue);
            $('span.list-chart-ratio-legend', cloned).html(obj.title);

            if (_tooltipsEnabled) {
                var tooltipZoneId = _chartContainerId + "_item_" + index + '_tooltipZone';
                var tooltipZone = $('span.list-chart-ratio-value .ratio-value', cloned).attr('id', tooltipZoneId);
                var tooltipKey = $('.list-chart-ratio-legend', cloned).text();
                var tooltipValue = tooltipData.hasOwnProperty(tooltipKey) ? tooltipData[tooltipKey] : "";

                tooltipZone.attr('title', tooltipValue);
            }
            _setNumberColors(spanValue, ratioSpan);

            _chartContainer.append(cloned);
        });
    };

    var _parseValue = function (index,value) {
        var v;
        switch (index){
            case "videoViewsPerPlayerVisit":
            case "itemViewsPerPlayerVisit":
            case "conversionsPerPlayerVisit":
            case "itemViewsPerVideoView":
            case "conversionsPerVideoView":
            case "sharesPerPlayerVisit":
            case "sharesPerVideoView":
            case "sharesPerItemView":
            case "takeActionTransactionsPerVisit":
            case "takeActionTransactionsPerVideoView":
            case "leadTransactionsPerVisit":
            case "leadTransactionsPerVideoView":
                v = Math.round(value*100) + '%';
                break;
            case "grossRevenuePerPlayerVisit":
            case "grossRevenuePerVideoView":
            case "meanRevenuePerTransaction":
                v = currencySymbolInfo.symbolPosition === 'right' ?
                    value + currencySymbolInfo.symbol :
                    currencySymbolInfo.symbol + value;
                break;
            default: v = value;
        }
        return v;
    };

    var _setNumberColors = function (ratio, ratioSpan) {
        switch (true) {
        case (ratio <= 0):
            ratioSpan.css('color', 'rgb(255,0,0)');
            break;
        case (ratio < 0.33):
            ratioSpan.css('color', 'rgb(242,169,10)');
            break;
        case (ratio < 0.66):
            ratioSpan.css('color', 'rgb(162,220,44)');
            break;
        case (ratio < 1):
            ratioSpan.css('color', 'rgb(115,195,201)');
            break;
        case (ratio < 1000):
            ratioSpan.css('color', 'rgb(242,169,10)');
            break;
        case (ratio < 3000):
            ratioSpan.css('color', 'rgb(162,220,44)');
            break;
        case (ratio >= 3000):
            ratioSpan.css('color', 'rgb(115,195,201)');
            break;
        default:
            ratioSpan.css('color', 'rgb(242,169,10)');
        }
    };

    var _destroyChart = function (jsonData) {
        _chartContainer.empty();
    };

    return RatiosChartManager = {
        createChart: _createChart,
        updateChartData: _updateChartData
    }

})(jQuery);