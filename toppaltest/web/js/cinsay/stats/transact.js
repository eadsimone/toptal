/*globals jQuery, AreaChartManager, analyticsData, ServiceBusDataAddapter, RatiosChartManager, MapChartManager, ColumnChartManager, TotalTransactionsChartManager, tooltipsEnabled */

var currentTab = C.ssm.stats.transact = function ($) {
    'use strict';

    var chartData;

    // Set small charts titles
    // Do not translate titles here. They are translated in CurrentTab.setChartTitle().
//    CurrentTab.setChartTitle('header-area-chart2', 'Summary Transact Performance');
//    CurrentTab.setChartTitle('small-chart-1', 'Transaction Interactions');
//    CurrentTab.setChartTitle('small-chart-2', 'Revenue by GEO Location');
//    CurrentTab.setChartTitle('small-chart-3', 'Revenue Performance Snapshot');
//    CurrentTab.setChartTitle('small-chart-4', 'Direct vs. Viral Revenue');
//    CurrentTab.setChartTitle('header-area-chart', 'Summary Transact Breakout');

    var dateBegin = $('#date-from').val();
    var dateEnd = $('#date-to').val();

//    var changeDateFormat = function (barSeparatedDate) {
//        var parts = barSeparatedDate.match(/(\d\d)\/(\d\d)\/(\d\d\d\d)/);
//
//        return parts[3] + "-" + parts[1] + "-" + parts[2];
//    };

    //////////////////////////// Main area chart
    try {
        if (typeof analyticsData.containerTransactBreakoutSummary !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptAreaChartData(analyticsData.containerTransactBreakoutSummary, {
                totalDonationTransactions: '#4C4C4C',
                takeActionTransactions:   '#B182B8' ,
                totalEcomTransactions: '#FF0000' ,
                totalTransactions:    '#63B544',
                totalLeadTransactions: '#0074CC'
            }, changeDateFormat($('#date-from').val()), changeDateFormat($('#date-to').val()));

            $.each(chartData, function(index, element){
                element.key = element.key.toLocaleLowerCase().replace('total', '');
            });

            var html = chartsFunctionality.matchStatsWithCharts(chartData, 'transact', []);//'area-chart');
            $('#statistics-summary').html(html);

            TotalTransactionsChartManager.createChart(chartData, 'area-chart-transact', {dateBegin: dateBegin, dateEnd: dateEnd});
        }
    } catch(err) {
        // Invalid data
    }

    //////////////////////////// Small chart 1
    try {
        if (typeof analyticsData.containerTakeActionsLeadSummary !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptRatiosChartData(analyticsData.containerTakeActionsLeadSummary);
            RatiosChartManager.createChart(chartData, 'small-chart-1-container-transact', { isRatio: false, showBullets: false, tooltipsEnabled: tooltipsEnabled  });
        }
    } catch(err) {
        // Invalid data
    }

    //////////////////////////// Small chart 2
    try {
        if (typeof analyticsData.containerRevenueByState !== 'undefined') {
            var mapName = (currentLanguage == 'en_US') ? 'us' : 'world';
            chartData = ServiceBusDataAddapter.addaptMapChartData(analyticsData.containerRevenueByState, mapName);
            MapChartManager.createChart(chartData, 'small-chart-2-container-transact', null, mapName, 'containerRevenue', function(){
                $('#small-chart-4-container').height($('#small-chart-2-container').parent().height());
            });
        }
    } catch(err) {
        // Invalid data
    }

    //////////////////////////// Small chart 3
    try {
        if (typeof analyticsData.containerRevenueSummaryRatios !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptRatiosChartData(analyticsData.containerRevenueSummaryRatios);
            RatiosChartManager.createChart(chartData, 'small-chart-3-container-transact', { isRatio: false, showBullets: false, tooltipsEnabled: tooltipsEnabled  });
        }
    } catch(err) {
       // Invalid data
    }

    //////////////////////////// Small chart 4
    try {
        if (typeof analyticsData.containerTransactSummaryDirect !== 'undefined' || typeof analyticsData.containerTransactSummaryViral !== 'undefined') {
            chartData = ServiceBusDataAddapter.addaptColumnChartData([analyticsData.containerTransactSummaryDirect, analyticsData.containerTransactSummaryViral]);
            ColumnChartManager.createChart(ServiceBusDataAddapter.reFormatData(chartData), 'small-chart-4-container-transact', { enable3Deffect: false });
        }
    } catch(err) {
       // Invalid data
    }

    //////////////////////////// Secondary area chart
    try {
        if (typeof analyticsData.containerTransactSummary !== 'undefined') {
            $('#statistics-summary2').css('visibility', 'visible');

            chartData = ServiceBusDataAddapter.addaptAreaChartData(analyticsData.containerTransactSummary, {
                grossRevenue: '#63B544',
                grossEcommRevenue: '#0074CC',
                grossDonationRevenue: '#4C4C4C'
            }, changeDateFormat($('#date-from').val()), changeDateFormat($('#date-to').val()));

            for (var i = chartData.length - 1; i >= 0; i--) {
                chartData[i].summary_title = chartData[i].key;
            }
            var html = chartsFunctionality.matchStatsWithCharts(chartData, 'transact', ['allLabels']);
            $('#statistics-summary2').html(html);

            AreaChartManager.createChart(chartData, 'area-chart-2-transact', {dateBegin: dateBegin, dateEnd: dateEnd}, function(){
                resizeLeftBottomBar(
                    $('#small-chart-3-container').parent(),
                    $('#area-chart-2'),
                    0
                );
            });
        }
    } catch(err) {
       // Invalid data
    }
};