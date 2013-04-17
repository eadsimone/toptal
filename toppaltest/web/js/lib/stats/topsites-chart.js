/*globals jQuery, BarChart*/

var BarChartManager = (function ($) {
    'use strict';

    var _chart = null;

    var _createChart = function (topSitesData, chartContainerId, options) {

        if (typeof BarChart === 'undefined') {
            console.log('BarChart library not included. You must include \'bar-chart.js\' before create a BarChart.');
            return;
        }

        _chart = new BarChart({

            selectors: {
                chartContainerId  : chartContainerId,
                barContainerClass : 'top-site-container',
                barClass          : 'top-site-bar',
                legendClass       : 'top-site-legend',
                valueClass        : 'top-site-value'
            },

            metrics: {
                minWidth      : options.minWidth,
                maxWidth      : 223,
                zeroBarWidth  : options.zeroBarWidth,
                stepWidth     : 10,
                maxValueWidth : 26, // Used only when options.valuesPosition = 'after-bar'.
                barSeparation : options.barSeparation // Optional default: 6.
            },

            style: {
                upperColor           : {r: 99.0, g: 181.0, b: 68.0},
                bottomColor          : {r: 99.0, g: 181.0, b: 68.0},
                iconClasses          : options.iconCssClasses, // Used only when options.useIcons is true.

                legendFormatFunction : function (label, barIndex, lengthLabel) {
                    lengthLabel = lengthLabel || undefined;

                    if (typeof lengthLabel === 'undefined') {
                        return label;
                    }

                    var title = label;
                    if (label.length > lengthLabel) {
                        label = label.substr(0, lengthLabel) + '...';
                    }

                    return '<span title="' + title + '">' + label + '</span>';
                },
                valueFormatFunction  : function (value) { return value.toString(); }
            },

            options: {
                animation      : true,
                useUpDownIcons : false,
                sorted         : true,
                useIcons       : true,
                valuesPosition : 'after-bar' // Valid values: 'top-right', 'after-bar'.
            },

            data: topSitesData
        });
    };

    var _updateChartData = function (newData) {
        _chart.updateChartData(newData);
    };

    return {
        // Fields
        chart           : _chart,

        // Methods
        createChart     : _createChart,
        updateChartData : _updateChartData
    };

}(jQuery));