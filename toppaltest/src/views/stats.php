
<div class="main-content">

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joan
 * Date: 1/03/13
 * Time: 11:39
 * To change this template use File | Settings | File Templates.
 */

echo $mustache->render('_common/breadcrumb',array('pageInfo' => $page));

$tabs = array (
    array(
        "title" => __("Summary"),
        "slug" => "summary",
        "active" => "active"
    ),
    array(
        "title" => __("Attract"),
        "slug"  => "attract"
    ),
    array(
        "title" => __("Transact"),
        "slug"  => "transact"
    ),
    array(
        "title" => __("Interact"),
        "slug"  => "interact"
    )
);

echo
    $mustache->render('_common/tabs',array('tabs' => $tabs, 'stats' => true, 'hideSaveButton' => 'false'));
    $mustache->render('stats/datepicker',array('tabs' => array()));

$templates = loadTemplateCache(
    '_common/inputClosedTag.html',
    '_common/inputWrappedTag.html',
    'stats/datepicker.html',
    'stats/summary.html',
    'stats/attract.html',
    'stats/transact.html',
    'stats/interact.html'
);

?>

<script>
        var analytics = function() {};

        (function($, cinsay) {

            analytics.deferredObjects = [];

            analytics.init = function() {

                this.loadSummary();
                this.loadAttract();
                this.loadInteract();
                this.loadTransact();
                this.addTemplates();

                return this;
            };

            analytics.loadTemplate = function(url, template, elementId) {
                this.deferredObjects.push(
                    cinsay.ssm.loadPartial.helper({
                        url: url,
                        template: template,
                        elementId: elementId
                    })
                );
            };

            analytics.loadSummary = function(){
                this.loadTemplate('getStatSummary.php', 'stats/summary.html', 'summary');
            };

            analytics.loadAttract = function(){
                this.loadTemplate('getStatAttract.php', 'stats/attract.html', 'attract');
            };

            analytics.loadInteract = function(){
                this.loadTemplate('getStatInteract.php', 'stats/interact.html', 'interact');
            };

            analytics.loadTransact = function(){
                this.loadTemplate('getStatTransact.php', 'stats/transact.html', 'transact');
            };

            analytics.addTemplates = function() {
                cinsay.ssm.mustache.addTemplates( <?php echo $templates; ?> );
            };

            analytics.ready = function(callback) {
                $.when.apply(this.deferredObjects).then(callback);
            };

            analytics.regExpDate = /(\d\d)\/(\d\d)\/(\d\d\d\d)/;

            analytics.formatDate = function(date) {

                if( !this.regExpDate.test(date.from) || !this.regExpDate.test(date.from)) {
                    return false;
                }

                var from = date.from.match(this.regExpDate);
                var to = date.to.match(this.regExpDate);

                date.from = from[3] + "-" + from[1] + "-" + from[2];
                date.to   = to[3] + "-" + to[1] + "-" + to[2];

                return date;
            };

            analytics.renderChart = function(tab, dates) {
                var withPush = withPush || false;

                if( dates.from == false && dates.to == false) {
                    return;
                }


                if(typeof C.ssm.statsLoaded[tab] == 'undefined') {
                    C.ssm.statsLoaded.push(tab)
                }

                $('#loading-'+tab).fadeIn('fast');
                $('#loading-'+tab).next('.dashboard-container').hide();
                loadChart(tab, dates);
            }




            analytics.loadStat = function(tab, dates, refresh) {

                var refresh = refresh || false;
                var dates = dates || {from: '2011-01-01', to: '2013-01-01'};


                //data changed by datepicker
                if(refresh == true && dates.from != '' && dates.to != '') {
                    analytics.renderChart(tab, this.formatDate(dates));
                }

                //first click on tab
                if( refresh == false && C.ssm.statsLoaded.search(tab) == false) {
                    analytics.renderChart(tab, dates);
                }

                //fix to highcharts resize issue
                setTimeout(function(){
                    $(window).resize();
                },0);

            }
        })(jQuery, C);

        $(function() {
            analytics.init().ready(function(){

                $('.nav-tabs a').on('click', function(){
                    var tab = $(this).attr('id').replace('-tab', '');
                    analytics.loadStat(tab);
                });

                $('.inputDates').on('change', function(){
                    var dateFrom = $('#date-from').val();
                    var dateTo = $('#date-to').val();
                    var tab = $('.nav-tabs li.active a').attr('id').replace('-tab', '');

                    analytics.loadStat(tab, {from: dateFrom, to: dateTo}, true);
                });
            });
        });
</script>
