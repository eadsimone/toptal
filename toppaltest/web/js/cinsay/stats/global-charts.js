/*globals jQuery, ServiceBusClient, CurrentTab, MapChartManager, analyticsData, chartsFunctionality*/
C.ssm.stats = {};
C.ssm.statsLoaded = ['summary'];

Array.prototype.search = function (v) {
    'use strict';

    for (var i = 0; i < this.length; i++) {
        if (this[i] == v)  {
            return true;
        }
    }
    return false;
}

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

String.prototype.parseDate = function () {
    var parts = this.match(/(\d\d)\/(\d\d)\/(\d\d\d\d)/);
    return parts[3] + "-" + parts[1] + "-" + parts[2];
};


var changeDateFormat = function (barSeparatedDate) {
    var parts = barSeparatedDate.match(/(\d\d)\/(\d\d)\/(\d\d\d\d)/);
    return parts[3] + "-" + parts[1] + "-" + parts[2];
};

var getToday = function() {

    var date = new Date();
    var month = (date.getMonth() < 9) ? '0' + date.getMonth():date.getMonth();
    var day = (date.getDay() < 9) ? '0' + date.getDay(): date.getDay();
    var year = date.getFullYear();

    return  [month, day, year].join('/');
}

var loadChart = function(tab, date) {

    var regExpTab = new RegExp(tab);

    if ( regExpTab.test(dashboardUrlPattern) ) {
        dashboardUrlPattern = '/__LOCALE__/' + tab + '/';
    }

    statsUrlPattern     = '/src/jsapiCalls/getStat' + tab.capitalize()  + '.php?players=__PLAYER_IDS__&from=__DATE_FROM__&to=__DATE_TO__';
    ServiceBusClient.request({
        from               : date.from,
        to                 : date.to,
        playerIds          : $('#container').val(),
        serviceBusObserver : {
            afterRequest            : function (requestJson) {},
            beforeProcessResponse   : function (responseJson) {},
            afterProcessResponse    : function (responseJson) {}
        },
        directRequest      : false,

        onSuccess : function (responseObject) {
            analyticsData = responseObject;
            if(typeof C.ssm.stats[tab] != 'undefined') {
                CurrentTab.updateCharts(tab);
                $('#loading-'+tab).hide();
                $('#loading-'+tab).next('.dashboard-container').show();
            }

            //fix to highcharts resize issue
            setTimeout(function(){
                $(window).resize();
            },0);
        },

        onError   : function (message, errObject) {
            throw new Error(message);
        }
    });
}

var resizeLeftBottomBar = function(gleft, gcenter, pleft) {
    return;
    'use strict';

    var h1left = gleft.height();
    var t1left = gleft.position()['top'];
    var b1left = h1left + t1left;
    var p1left = pleft;

    var h2left = gcenter.height();
    var t2left = gcenter.position()['top'];
    var b2left = h2left + t2left;

    var difference = b2left - b1left;

    gleft.height( gleft.height() - p1left + difference );
};

var charts = {
    area_chart : []
};

(function ($) {
    //'use strict';

    var _clearHeaderMessages = function () {
        $('#messages').empty();
    };

    var _returnActualTab = (function(){
        var tabs = ['summary','attract','interact','transact'];
        var indexTab = null;
        $('.param-bar-left a div.param-tab ').each(function(i, e){
            if ($(e).hasClass('param-tab-active')) {
                indexTab = i;
                return false;
            }
        });

        return tabs[indexTab];
    });

    var sbObserver = {

        afterRequest  : function (requestJson) {
            $('#servicebus-debugger-request').val(requestJson);
        },

        beforeProcessResponse : function (responseJson) {
            $('#servicebus-debugger-response').val(responseJson);
        },

        afterProcessResponse : function () {
            // Fix for the absolutelly positioned right bar
            var rightBarHeight = $('.param-bar-right').height();
            var dashboardHeight = $('.dashboard-container').height();
            var height = Math.max(rightBarHeight, dashboardHeight);
            $('.dashboard-container').css('height', height);

            switch (_returnActualTab()) {
                case 'attract':
                    $('.param-bar-left').css('height', (height + parseInt($('.dashboard-container').css('padding-bottom'), 10)) - 30 );
                    break;
                case 'transact':
                    $('.param-bar-left').css('height', (height + parseInt($('.dashboard-container').css('padding-bottom'), 10)) - 31 );
                    break;
                default:
                    break;
            }
        }
    };

    var _setTooltips = function () {
        $('.tooltip').tooltip({
            track: false,
            delay: 200,
            showURL: false,
            showBody: " - ",
            fixPNG: true,
            left: -120
        });
    };

    var _updateCharts = function () {
//        $("#loading-mask").fadeIn();
//        $("#spinner").slideDown();

        ServiceBusClient.request({
            from               : $('#date-from').val().parseDate(),
            to                 : $('#date-to').val().parseDate(),
            playerIds          : $('#container').val(),
            serviceBusObserver : sbObserver,
            directRequest      : false,

            onSuccess : function (responseObject) {
                $("#loading-mask").fadeOut();
                $("#spinner").slideUp();
                _clearHeaderMessages();

                analyticsData = responseObject;
                CurrentTab.updateCharts();
                if (tooltipsEnabled) {
                    _setTooltips();
                }
            },

            onError   : function (message, errObject) {
                $("#loading-mask").fadeOut();
                $("#spinner").slideUp();
                _clearHeaderMessages();

                if ((errObject == null) || (errObject != null && errObject.status != 0 && errObject.readyState != 0 && errObject.responseText != '' && errObject.statusText != 'error')) {
                    HeaderMessages.addError(message);
                }
            }
        });
    };

    var _onDateSelect = function () {

        var changeDateFormat = function (barSeparatedDate) {
            var parts = barSeparatedDate.match(/(\d\d)\/(\d\d)\/(\d\d\d\d)/);
            if (parts === null || parts.length < 4) { return null; }
            return parts[3] + "-" + parts[1] + "-" + parts[2];
        };

        var addZero = function (num) {
            (String(num).length < 2) ? num = String("0" + num) :  num = String(num);
            return num;
        };

        var dateFrom = changeDateFormat($('#date-picker-from').val());
        var dateTo   = changeDateFormat($('#date-picker-to').val());
        if (dateFrom !== null && dateTo !== null && dateFrom > dateTo) { // Swap dates
            var tempDate = $('#date-picker-from').val();
            $('#date-picker-from').val($('#date-picker-to').val());
            $('#date-picker-to').val(tempDate);
        } else if (dateFrom !== null && dateTo !== null && dateFrom == dateTo) { // Set a from a day before to
            var prevDay = new Date($('#date-picker-to').val());
            prevDay.setDate(prevDay.getDate() - 1);
            $('#date-picker-from').val(addZero(parseInt(prevDay.getMonth() + 1, 10)) + "/" + addZero(prevDay.getDate()) + "/" + (prevDay.getFullYear()));
        }

        _updateCharts();
    };

    var _initUI = function () {
        // Container selector
//        $('#container').dropdown({
//            parentSelector: '#player-selector-container'
//        }).change(function () {
//                _updateCharts();
//            });

        // Date range selector
        $(".datepicker").datepicker({
            dateFormat : 'mm/dd/yy',
            onSelect   : _onDateSelect,
            maxDate    : new Date()
        });

        // Draggable legends in area charts
        $("#statistics-summary, #statistics-summary2").draggable();

        // Maps resizing on windows resize
//        $(window).resize(function () {
//            // This is needed because the char maps are not redrawed automatically by Highcharts.
//            MapChartManager.redraw();
//        });

        // SB debugger activation/deactivation
        $('#activate-servicebus-debugger').change(function () {
            var active = $(this).is(':checked');
            if (active) {
                $('#servicebus-debugger').show();
            } else {
                $('#servicebus-debugger').hide();
            }
        });

        $('#interface-locale').change(function () {
            var localeCode = $(this).val();
            var langLoockup = {
                'en_US': 'en',
                'es_AR': 'es',
                'ru_RU': 'ru'
            };
            var lang = langLoockup.hasOwnProperty(localeCode) ? langLoockup[localeCode] : localeCode;

            var dashboardUrl = dashboardUrlPattern.replace(/__LOCALE__/g, lang);
            window.location = dashboardUrl;
        });
    };

    var getInitialDates = function () {
        'use strict';

        var formatDate = function (date) {
            var day   = date.getDate();
            var month = date.getMonth() + 1; //January is 0
            var year  = date.getFullYear();

            if (day   < 10) {day   = '0' + day;}
            if (month < 10) {month = '0' + month;}
            var string = month + '/' + day + '/' + year;

            return string;
        };
        var today = new Date();
        var todayString = formatDate(today);

        var monthAgo = today;
        monthAgo.setMonth(monthAgo.getMonth() - 1);

        var monthAgoString = formatDate(monthAgo);

        return [monthAgoString, todayString];
    };

    var _initDates = function () {
        var dates = getInitialDates();
        var dataPeriods = [dates[0], dates[1]];

        if (typeof dataPeriods  !== 'undefined') {
            if ($.trim($('#date-picker-from').val()) == '') {
                $('#date-picker-from').val(dataPeriods[0]);
            }

            if ($.trim($('#date-picker-to').val()) == '') {
                $('#date-picker-to').val(dataPeriods[1]);
            }
        }
    };

    var _setHTMLtoMatchData = function (index, label, value, section, color) {
        var html;
        html  = '<div class="key-container key-' + index + '">';
        html += '<div class="key-bar"></div>';
        html += '<div class="key-text">';
        html += '<div class="value" style="color:' +  color + '"id="stats-' + $.trim(label.toLowerCase().replace(/\s/g, '-')) + '-' + section + '">' + value  + '</div>';
        html += '<div class="legend">' + label + '</div>';
        html += '</div>';
        html += '<div class="key-tendence">';
        html += '<div class="key-tendence-image up"></div>';
        html += '<div class="key-tendence-value">0%</div>';
        html += '</div>';
        html += '</div>';
        return html;
    };

    var matchStatsWithCharts = function (chartStats, section, labelPrice) {
        labelPrice = labelPrice || [];
        var html = '';
        //Iterate the All charts
        var keyIndex = 1;

        var orderColorsArray = {
            '#63B544': '',
            '#0074CC': '',
            '#4C4C4C': '',
            '#B182B8': ''
        };

        $.each(chartStats, function (index, chart) {
            var totalData = 0;
            if (chart.key.toLowerCase() !== 'x-axis') {
                $.each(chart.data, function (i, value) {
                    totalData += parseFloat(value);
                });
                totalData = (Math.round(totalData * 100) / 100); // Fix legend rounding issue

                if (labelPrice.search(chart.key) || labelPrice.search('allLabels')) {
                    totalData = currencySymbolInfo.symbolPosition === 'right' ?
                        totalData + currencySymbolInfo.symbol :
                        currencySymbolInfo.symbol + totalData;
                }

                orderColorsArray[chart.lineColor] = _setHTMLtoMatchData(keyIndex, chart.key, totalData, section, chart.lineColor);
                keyIndex++;
            }
        });

        $.each(orderColorsArray,  function (color, htmlData) {
            html += htmlData;
        });

        return html;
    };

    $(function () {
       // _initUI();
       // _initDates();

        // First data retrieval on page loading

        $('#date-to').val(getToday());
        _updateCharts();

//        $(window).resize(function(){
//            var newHeight = $('#small-chart-2-container').parent().height();
//
//            $('#small-chart-4-container').height(newHeight);
//            $('#small-chart-4-container').width($('#small-chart-2-container').width()).css({'margin' : '0 auto'});
//
//            if($('#small-chart-4-container-part-1')) {
//                newHeight = newHeight -5;
//                $('#small-chart-4-container-part-1').height(newHeight / 2);
//                $('#small-chart-4-container-part-2').height(newHeight / 2);
//            }
//        });

    });

    chartsFunctionality = {
        matchStatsWithCharts: matchStatsWithCharts
    };
}(jQuery));