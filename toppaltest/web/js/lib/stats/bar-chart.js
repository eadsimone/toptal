/**
 * BarChart
 *
 * @author Daniel Duarte <dduarte@summasolutions.net>
 */

var BarChart = function (chartParameters) {
    'use strict';

    // Parameters
    var selectors = chartParameters.selectors;
    var data      = chartParameters.data;
    var metrics   = chartParameters.metrics;
    var style     = chartParameters.style;
    var options   = chartParameters.options;

    // Affected elements
    var chartContainer = null;
    var chartBarContainers = null;

    var _updateChartData = function (newData) {
        data = newData.slice();

        var findIcon = function (label) {
            for (var iconClass in style.iconClasses) if (style.iconClasses.hasOwnProperty(iconClass)) {
                var iconClassTest = style.iconClasses[iconClass];
                var iconFound = label.indexOf(iconClassTest) != -1;
                if (iconFound) {
                    return iconClass;
                }
            }

            return null;
        };

        if (options.useIcons) {
            for (var dataIndex = 0; dataIndex < data.length; dataIndex++) {
                data[dataIndex].iconClass = findIcon(data[dataIndex].label);
            }
        }

        if (options.sorted) {
            data.sort(function (item1, item2) {
                return item1.value > item2.value ? -1 : 1;
            });
        }

        for (var i = 0; i < chartBarContainers.length; i++) {
            var chartBarContainer = chartBarContainers[i];
            var barData = data[i];

            if (typeof barData !== 'undefined') {
                jQuery(chartBarContainer).show();

                var realMaxBarWidth = metrics.maxWidth;//'after-bar' !== options.valuesPosition ? metrics.maxWidth : metrics.maxWidth - metrics.maxValueWidth;

                var barWidth = metrics.zeroBarWidth + metrics.stepWidth * barData.value;
                barWidth = barWidth >= metrics.minWidth ? barWidth : metrics.minWidth;
                barWidth = barWidth <= realMaxBarWidth ? barWidth : realMaxBarWidth;

                // Color bar calculus
                var position = i.toFixed(2);
                var maxPosition = (chartBarContainers.length - 1).toFixed(2);
                var colorR = (style.bottomColor.r - style.upperColor.r) / maxPosition * position + style.upperColor.r;
                var colorG = (style.bottomColor.g - style.upperColor.g) / maxPosition * position + style.upperColor.g;
                var colorB = (style.bottomColor.b - style.upperColor.b) / maxPosition * position + style.upperColor.b;
                var chartBar = jQuery('.' + selectors.barClass, chartBarContainer);
                chartBar.css('background-color', 'rgb(' + colorR.toString() + ',' + colorG.toString() + ',' + colorB.toString() + ')');

                // Set the legend
                var formatedLegend = style.legendFormatFunction(barData.label, i, 25);
                if (options.useIcons) {
                    var iconSpan = "";
                    if (style.iconClasses.hasOwnProperty(barData.iconClass)) {
                        iconSpan = '<span class="bar-chart-icon ' + barData.iconClass + '"></span>';
                    }
                    formatedLegend = iconSpan + formatedLegend;
                }
                var barLegend = jQuery('.' + selectors.legendClass, chartBarContainer);
                barLegend.html(formatedLegend);

                // Set the value
                var barValue = jQuery('.' + selectors.valueClass, chartBarContainer);
                barValue.html(style.valueFormatFunction(barData.value));
                var valueClass = barData.value > 0 ? 'value_up' : (barData.value < 0 ? ' value_down' : null);
                if (null !== valueClass) {
                    barValue.addClass(valueClass);
                }

                // Set the bar width
                if (options.animation) {
                    jQuery(chartBarContainer).css('width', metrics.minWidth.toString() + 'px').animate({
                        width: barWidth.toString() + 'px'
                    }, 'slow');
                } else {
                    jQuery(chartBarContainer).css('width', barWidth.toString() + 'px');
                }
                barLegend.css('width', (barWidth - 46).toString() + 'px');
            } else {
                jQuery(chartBarContainer).hide();
            }
        }
    }

    var _init = function () {
        // View initialization
        chartContainer = jQuery('#' + selectors.chartContainerId);
        chartBarContainers = jQuery('.' + selectors.barContainerClass, chartContainer)
            .addClass('bar-chart-container values-position-' + options.valuesPosition)
            .each(function () {
                if (typeof metrics.barSeparation !== 'undefined') {
                    jQuery(this).css('margin-top', metrics.barSeparation);
                }

                // Bars initialization
                var bars = jQuery('.' + selectors.barClass, this)
                    .addClass('bar-chart-bar');

                // Legends initialization
                jQuery('.' + selectors.legendClass, this).addClass('bar-chart-legend');

                // Values initialization
                var values = jQuery('.' + selectors.valueClass, this)
                    .addClass('bar-chart-value' + (options.useUpDownIcons ? ' icon' : ''));

                if ('after-bar' === options.valuesPosition) {
                    bars.css('margin-right', (metrics.maxValueWidth + 4).toString() + 'px'); // Values padding-left = 2px when position = after-bar.
                    values.css('width', metrics.maxValueWidth.toString() + 'px');
                }
            });

        // Data initialization
        _updateChartData(data);
    };

    _init();

    return {
        // Methods
        updateChartData : _updateChartData
    };
};