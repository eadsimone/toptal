/**
 * Created with JetBrains PhpStorm.
 * User: joanbellusci
 * Date: 12/04/13
 * Time: 16:48
 * To change this template use File | Settings | File Templates.
 */

var reports = {

    listenSelect: function() {
        $('#filter-report').on('change', function(){
            if($.trim($(this).val()) != '') {
                reports.getReport($(this).val());
            }
        });
    },

    getReport: function(report) {

        if(
            $.trim($('#date-from').val()) == '' ||
            $.trim($('#date-to').val()) == ''   ||
            report == ''
        ) {
            return;
        }
        $.ajax(
            {
                url: '../src/jsapiCalls/getReports.php?search=true',
                dataType: 'json',
                data: {
                    'reportName' : report,
                    'date-from' : $.trim($('#date-from').val()),
                    'date-to' : $.trim($('#date-to').val())
                },
                type: 'post',
                success: function(json) {
                    console.log(json);
                }
            }
        )
    }

};
