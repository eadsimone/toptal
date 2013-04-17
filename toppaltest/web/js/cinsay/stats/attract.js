/*globals jQuery, Highcharts, AreaChartManager, PieChartManager, RatiosChartManager, ServiceBusDataAddapter, MapChartManager, analyticsData, tooltipsEnabled, CurrentTab, __ */

var currentTab = C.ssm.stats.attract =  function ($) {
    'use strict';

    var chartData;

    // Set small charts titles
    // Do not translate titles here. They are translated in CurrentTab.setChartTitle().
//    CurrentTab.setChartTitle('header-area-chart', 'Summary Attract Performance');
//    CurrentTab.setChartTitle('small-chart-1', 'Visitor Summary');
//    CurrentTab.setChartTitle('small-chart-2', 'Container Impressions by GEO Location');
//    CurrentTab.setChartTitle('small-chart-3', 'Visitor Interactions Snapshot');
//    CurrentTab.setChartTitle('small-chart-4', 'Browser & OS Versions');

    var dateBegin = $('#date-from').val();
    var dateEnd = $('#date-to').val();

    //////////////////////////// Main area chart
    var changeDateFormat = function (barSeparatedDate) {
        var parts = barSeparatedDate.match(/(\d\d)\/(\d\d)\/(\d\d\d\d)/);
        return parts[3] + "-" + parts[1] + "-" + parts[2];
    };
    try {
        if (typeof analyticsData.playerAttractSummary !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptAreaChartData(analyticsData.playerAttractSummary, {playerViews: '#63B544', videoViews: '#0074CC', itemViews: '#4C4C4C', playerVisits: '#B182B8'}, changeDateFormat(dateBegin), changeDateFormat(dateEnd));

            for (var i = chartData.length - 1; i >= 0; i--) {
                chartData[i].summary_title = 'Total ' + chartData[i].key.toLowerCase();
            }

            var html = chartsFunctionality.matchStatsWithCharts(chartData,'attract');
            $('#statistics-summary').html(html);

            AreaChartManager.createChart(chartData, 'area-chart-attract',{dateBegin: dateBegin, dateEnd: dateEnd});
        }
    } catch(err) {
        // Invalud data
    }

    //////////////////////////// Small chart 1
    try {
        if (typeof analyticsData.playerAttractVisitorSummary !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptRatiosChartData(analyticsData.playerAttractVisitorSummary);
            RatiosChartManager.createChart(chartData, 'small-chart-1-container-attract', { isRatio: false, showBullets: false, tooltipsEnabled: tooltipsEnabled  });
        }
    } catch(err) {
        // Invalud data
    }

    //////////////////////////// Small chart 2
    try {
        if (typeof analyticsData.topPlayerViewsByState !== 'undefined') {
            var mapName = (currentLanguage == 'en_US') ? 'us' : 'world';
            chartData = ServiceBusDataAddapter.addaptMapChartData(analyticsData.topPlayerViewsByState, mapName);

            MapChartManager.createChart(chartData, 'small-chart-2-container-attract', null, mapName, 'topPlayerViews', function(){
                $('#small-chart-2-container').parent().height(364);
                var newHeight = $('#small-chart-2-container').parent().height();
                $('#small-chart-4-container').height(newHeight);
                $('#small-chart-4-container-part-1').height((parseInt(newHeight) - 5) / 2);
                $('#small-chart-4-container-part-2').height((parseInt(newHeight) - 5) / 2);

                resizeLeftBottomBar($('#small-chart-3'), $('#small-chart-4-container-part-1').parent(), 11);
            });
        }
    } catch(err) {
        // Invalud data
    }

    //////////////////////////// Small chart 3
    try {
        if (typeof analyticsData.containerAttractSummaryViewsRatio !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptRatiosChartData(analyticsData.containerAttractSummaryViewsRatio);
            RatiosChartManager.createChart(chartData, 'small-chart-3-container-attract', { isRatio: false, showBullets: false, tooltipsEnabled: tooltipsEnabled  });
        }
    } catch(err) {
        // Invalud data
    }

    //////////////////////////// Small chart 4
    try {
        if (typeof analyticsData.playerBrowserSummary !== 'undefined' || typeof analyticsData.playerOperatingSystemSummary !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptPieChartData([analyticsData.playerBrowserSummary, analyticsData.playerOperatingSystemSummary]);
            PieChartManager.createChart(chartData, 'small-chart-4-container');
        }
    } catch(err) {
        alert(err);
       // Invalud data
    }
};