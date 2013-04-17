/*globals jQuery, $jq, AreaChartManager, BarChartManager, MapChartManager, RatiosChartManager, ColumnChartManager, ServiceBusDataAddapter, analyticsData, $jq, , tooltipsEnabled */

var currentTab = C.ssm.stats.interact = function ($) {
    'use strict';

    var chartData;

    // Set small charts titles.
    // Do not translate titles here. They are translated in CurrentTab.setChartTitle().
//    CurrentTab.setChartTitle('header-area-chart', 'Summary Interact Performance');
//    CurrentTab.setChartTitle('small-chart-1', 'Top Places Shared To');
//    CurrentTab.setChartTitle('small-chart-2', 'Shares by GEO Location');
//    CurrentTab.setChartTitle('small-chart-3', 'Share Interactions Snapshot');
//    CurrentTab.setChartTitle('small-chart-4', 'Direct vs. Viral Shares');

    var dateBegin = $('#date-from').val();
    var dateEnd = $('#date-to').val();

    //////////////////////////// Main area chart
    var changeDateFormat = function (barSeparatedDate) {
        var parts = barSeparatedDate.match(/(\d\d)\/(\d\d)\/(\d\d\d\d)/);
        return parts[3] + "-" + parts[1] + "-" + parts[2];
    };
    try {
        if (typeof analyticsData.playerInteractSummary !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptAreaChartData(analyticsData.playerInteractSummary, {playerShares: '#63B544', socialShares: '#0074CC', emailShares: '#4C4C4C', embedShares: '#B182B8'}, changeDateFormat(
                dateBegin), changeDateFormat(dateEnd)
            );

            for (var i = chartData.length - 1; i >= 0; i--) {
                chartData[i].summary_title = 'Total ' + chartData[i].key.toLowerCase();
            }

            var html = chartsFunctionality.matchStatsWithCharts(chartData,'interact');
            $('#statistics-summary').html(html);

            AreaChartManager.createChart(chartData, 'area-chart-interact',{dateBegin: dateBegin, dateEnd: dateEnd});
        }
    } catch(err) {
        throw new Error(err);
       // Invalid data
    }

    //////////////////////////// Small chart 1
    try {
        if (typeof analyticsData.playerTopSocialSites !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptHBarChartData(analyticsData.playerTopSocialSites, 'playerTopSocialSites');

            BarChartManager.createChart(chartData, 'small-chart-1-container-interact', { barSeparation: 6, minWidth: 105, zeroBarWidth: 150,
                iconCssClasses: {
                    'icon-sharing-cinsay'    : "cinsay.com",
                    'icon-sharing-facebook'  : "facebook",
                    'icon-sharing-twitter'   : "twitter",
                    'icon-sharing-blogger'   : "blogger",
                    'icon-sharing-googleplus': "google_plusone_share",
                    'icon-sharing-myspace'   : "myspace",
                    'icon-sharing-youtube'   : "youtube.com",
                    'icon-sharing-linkedin'  : "linkedin",
                    'icon-sharing-email'     : "email",
                    'icon-sharing-embed'     : "embed",
                    'icon-sharing-other'     : ""
                }
            });
        }
    } catch(err) {
        throw new Error(err);
       // Invalid data
    }

    //////////////////////////// Small chart 2
    try {
        if (typeof analyticsData.topPlayerSharesByState !== 'undefined') {
            var mapName = (currentLanguage == 'en_US') ? 'us' : 'world';
            chartData = ServiceBusDataAddapter.addaptMapChartData(analyticsData.topPlayerSharesByState, mapName);
            MapChartManager.createChart(chartData, 'small-chart-2-container-interact', null, mapName, 'topPlayerShares', function(){
                $('#small-chart-2-container').parent().height(247);
                var newHeight = $('#small-chart-2-container').parent().height();
                $('#small-chart-4-container').height(newHeight);
                resizeLeftBottomBar($('#small-chart-3-container').parent(), $('#small-chart-4-container').parent(),0);
            });
        }
    } catch(err) {
        throw new Error(err);
      // Invalid data
    }

    //////////////////////////// Small chart 3
    try {
        if (typeof analyticsData.playerInteractSummaryViewsRatio !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptRatiosChartData(analyticsData.playerInteractSummaryViewsRatio);
            RatiosChartManager.createChart(chartData, 'small-chart-3-container-interact', { isRatio: false, showBullets: false, tooltipsEnabled: tooltipsEnabled  });
        }
    } catch(err) {
        throw new Error(err);
       // Invalid data
    }

    //////////////////////////// Small chart 4
    try {
        if (typeof analyticsData.playerPerformanceSummaryDirect !== 'undefined' || typeof analyticsData.playerPerformanceSummaryViral !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptColumnChartData([analyticsData.playerPerformanceSummaryDirect, analyticsData.playerPerformanceSummaryViral]);
            ColumnChartManager.createChart(ServiceBusDataAddapter.reFormatData(chartData), 'small-chart-4-container-interact', { enable3Deffect: false });
        }
    } catch(err) {
        throw new Error(err);
      // Invalid data
    }
};