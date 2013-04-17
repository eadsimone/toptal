/**
 * Created with JetBrains PhpStorm.
 * User: joan
 * Date: 1/03/13
 * Time: 15:56
 * To change this template use File | Settings | File Templates.
 */

/*globals jQuery, $jq, Highcharts, AreaChartManager, BarChartManager, PieChartManager, RatiosChartManager, MapChartManager, ServiceBusDataAddapter, analyticsData, tooltipsEnabled, CurrentTab*/
var currentTab = C.ssm.stats.summary = function ($) {
    'use strict';

    var chartData;

    // Set small charts titles
    // Do not translate titles here. They are translated in CurrentTab.setChartTitle().
//    CurrentTab.setChartTitle('header-area-chart', 'Summary Performance');
//    CurrentTab.setChartTitle('small-chart-1', 'Top Sites Viewed');
//    CurrentTab.setChartTitle('small-chart-2', 'Container Impressions by GEO Location');
//    CurrentTab.setChartTitle('small-chart-3', 'Performance Snapshot');
//    CurrentTab.setChartTitle('small-chart-4', 'Conversions by Product Type');

//    //////////////////////////// Main area chart
    var dateBegin = $('#date-from').val();
    var dateEnd = $('#date-to').val();

    try {
        if (typeof analyticsData.playerPerformanceSummary !== 'undefined') {
            chartData =
                ServiceBusDataAddapter.addaptAreaChartData(
                    analyticsData.playerPerformanceSummary,
                    {playerVisits: '#63B544', playerShares: '#0074CC', grossRevenue: '#4C4C4C'}, changeDateFormat(dateBegin), changeDateFormat(dateEnd));

            for (var i = chartData.length - 1; i >= 0; i--) {
                chartData[i].summary_title = 'Total ' + chartData[i].key.toLowerCase();
            }

            var html = chartsFunctionality.matchStatsWithCharts(chartData,'summary',['Gross revenue']);
            $('#statistics-summary').html(html);
            AreaChartManager.createChart(chartData, 'area-chart', {dateBegin: dateBegin, dateEnd: dateEnd});
        }
    } catch(err) {
        throw new Error(err);
        // Invalid data
    }

    //////////////////////////// Small chart 1
    try {
        if (typeof analyticsData.topContainerHostedSites !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptHBarChartData(analyticsData.topContainerHostedSites, 'topContainerHostedSites');
            BarChartManager.createChart(chartData, 'small-chart-1-container', { barSeparation: 6, minWidth: 105, zeroBarWidth: 150,
                iconCssClasses: {
                    'icon-sharing-cinsay'    : "cinsay.com",
                    'icon-sharing-facebook'  : "facebook",
                    'icon-sharing-twitter'   : "twitter",
                    'icon-sharing-blogger'   : "blogger",
                    'icon-sharing-googleplus': "google_plusone_share",
                    'icon-sharing-myspace'   : "myspace",
                    'icon-sharing-youtube'   : "youtube",
                    'icon-sharing-linkedin'  : "linkedin",
                    'icon-sharing-email'     : "@",
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
        if (typeof analyticsData.topPlayerViewsByState !== 'undefined') {
            var mapName = (currentLanguage == 'en_US') ? 'us' : 'world';
            chartData = ServiceBusDataAddapter.addaptMapChartData(analyticsData.topPlayerViewsByState, mapName);

            MapChartManager.createChart(chartData, 'small-chart-2-container', null, mapName, 'topPlayerViews', function(){
//                $('#small-chart-2-container').parent().height(246);
//                var newHeight = $('#small-chart-2-container').parent().height();
//                $('#small-chart-4-container').height(newHeight);
//                resizeLeftBottomBar($('#small-chart-3'), $('#small-chart-4-container').parent(), 11);
            });
        }
    } catch(err) {
        throw new Error(err);
        // Invalid data
    }

    //////////////////////////// Small chart 3
    try {
        if (typeof analyticsData.playerPerformanceSummaryRatios !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptRatiosChartData(analyticsData.playerPerformanceSummaryRatios)
            RatiosChartManager.createChart(chartData, 'small-chart-3-container', { isRatio: false, showBullets: false, tooltipsEnabled: tooltipsEnabled });
        }
    } catch(err) {
        throw new Error(err);
        // Invalid data
    }

    //////////////////////////// Small chart 4
    try {
        if (typeof analyticsData.playerConversionsByProductType !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptPieChartData([analyticsData.playerConversionsByProductType]);
            PieChartManager.createChart(chartData, 'small-chart-4-container');
        }
    } catch(err) {
        throw new Error(err);
        // Invalid data
    }
};