/*globals jQuery, currentTab, tooltipData, tooltipsEnabled, Highcharts, __*/
var CurrentTab = (function ($) {
    'use strict';

    return {

        createCharts: function (tab) {
            Highcharts.setOptions({
                lang: {
                    shortMonths: [__('Jan'), __('Feb'), __('Mar'), __('Apr'), __('May'), __('Jun'), __('Jul'), __('Aug'), __('Sep'), __('Oct'), __('Nov'), __('Dec')],
                    weekdays: [__('Sunday'), __('Monday'), __('Tuesday'), __('Wednesday'), __('Thursday'), __('Friday'), __('Saturday')]
                }
            });

            if(tab != null) {
                C.ssm.stats[tab]($);
            } else {
                currentTab($);
            }
        },

        updateCharts: function (tab) {
            var tab = tab || null;
            this.createCharts(tab);
        },

        setChartTitle: function (chartHeaderId, title) {
            var chartHeader = $('#' + chartHeaderId);
            var graphTitle = $('.graph-title', chartHeader);

            graphTitle.html(__(title));

            if (tooltipsEnabled) {
                graphTitle.attr('id', chartHeaderId + '_tooltipZone').addClass('tooltip');
                var tooltipValue = tooltipData.hasOwnProperty(title) ? tooltipData[title] : "";

                graphTitle.attr('title', tooltipValue);
            }
        }
    };

}(jQuery));