/*globals jQuery*/

/**
 * Module ServiceBusClient.
 */
var ServiceBusClient = (function ($) {
    'use strict';

    // @todo Add "playerInteractSummaryViewsRatio",\n\ to the following request when SB SQL error is fixed.
    var _requestTemplate = '{' +
        '"requestObject": {' +
            '"clientId": "__CLIENT_ID__",' +
            '"storeId": null,' +
            '"playerIds": __PLAYER_IDS_,' +
            '"startDate": "__DATE_FROM__",' +
            '"stopDate": "__DATE_TO__",' +
            '"statList": [' +
                '"playerPerformanceSummary",' +
                '"topContainerHostedSites",' +
                '"topPlayerViewsByState",' +
                '"playerPerformanceSummaryRatios",' +
                '"playerConversionsByProductType",' +
                '"playerAttractSummary",' +
                '"playerAttractVisitorSummary",' +
                '"containerAttractSummaryViewsRatio",' +
                '"playerOperatingSystemSummary",' +
                '"playerBrowserSummary",' +
                '"playerInteractSummary",' +
                '"playerTopSocialSites",' +
                '"playerInteractSummaryViewsRatio",' +
                '"topPlayerSharesByState",' +
                '"playerPerformanceSummaryDirect",' +
                '"playerPerformanceSummaryViral",' +
                '"containerTransactSummary",' +
                '"containerTakeActionsLeadSummary",' +
                '"containerRevenueSummaryRatios",' +
                '"containerRevenueByState",' +
                '"containerTransactSummaryDirect",' +
                '"containerTransactSummaryViral",' +
                '"containerTransactBreakoutSummary"' +
            '],' +
            '"typeName": "stats_request"' +
        '},' +
        '"params": null,' +
        '"clientId": "__CLIENT_ID__",' +
        '"apiKey": "__PUBLIC_API_KEY__"' +
    '}';

    var _serviceBusUrl = 'https://services.int.cinsay.com/rest/stats';
    var _currentUrl = location.href;
    if (_currentUrl.indexOf(".int.") !== -1) {
        _serviceBusUrl = 'https://services.int.cinsay.com/rest/stats';
    } else if (_currentUrl.indexOf(".intrap.") !== -1) {
        _serviceBusUrl = 'https://services.intrap.cinsay.com/rest/stats';
    } else if (_currentUrl.indexOf(".qa.") !== -1) {
        _serviceBusUrl = 'https://services.qa.cinsay.com/rest/stats';
    } else if (_currentUrl.indexOf(".stag.") !== -1) {
        _serviceBusUrl = 'https://services.stag.cinsay.com/rest/stats';
    } else if (_currentUrl.indexOf(".preprod.") !== -1) {
        _serviceBusUrl = 'https://services.preprod.cinsay.com/rest/stats';
    } else if (_currentUrl.indexOf("manage.cinsay.") !== -1) {
        _serviceBusUrl = 'https://services.cinsay.com/rest/stats';
    }

    var _serviceBusObserver = (function () {
        return {
            afterRequest          : function (requestJson) {},
            beforeProcessResponse : function (responseJson) {},
            afterProcessResponse  : function (responseJson) {}
        };
    }());

    var _onSuccess = function (responseObject) {
        console.log("Response OK:", responseObject);
    };

    var _onError = function (message, errObject) {
        console.log(message);
    };

    var _processRequestResponse = function (rawResponse) {
        _serviceBusObserver.beforeProcessResponse(JSON.stringify(rawResponse));

        if (rawResponse !== null && typeof rawResponse !== 'undefined') {
            var responseCode = parseInt(rawResponse.responseCode, 10);
            if (1000 === responseCode) {
                var responseObject = rawResponse.responseObject;
                if (responseObject !== null && typeof responseObject !== 'undefined') {
                    _onSuccess(responseObject);
                } else {
                    _onError("Empty response object from Service Bus.", null);
                }
            } else {
                _onError("Response with error from Service Bus. Error code: " + responseCode + " (" + rawResponse.responseText + ")", null);
            }
        } else {
            _onError("Empty response from Service Bus.", null);
        }

        _serviceBusObserver.afterProcessResponse();
    };

    var _processRequestError = function (errObject) {
        _onError("Service Bus request error. Status: " + errObject.status.toString(), errObject);
    };

    var _preparePlayerIdsJsonParam = function (playerIds) {
        if (playerIds === null || typeof playerIds === 'undefined' || typeof playerIds === 'function') {
            playerIds = "null";
        } else if (typeof playerIds === 'string') {
            playerIds = $.trim(playerIds);
            if (playerIds.length === 0) {
                playerIds = "null";
            } else {
                playerIds = "[\"" + playerIds + "\"]";
            }
        } else if (typeof playerIds === 'number') {
            if (playerIds === 0) {
                playerIds = "null";
            } else {
                playerIds = "[\"" + playerIds.toString() + "\"]";
            }
        } else {
            if (typeof playerIds === 'object' && typeof playerIds.length === 'number') {
                var ids = "";
                for (var i = 0; i < playerIds.length; i++) {
                    ids = ids + (ids.length === 0 ? "" : ",") + "\"" + playerIds[i].toString() + "\"";
                }
                playerIds = "[" + ids + "]";
            } else {
                playerIds = "null";
            }
        }

        return playerIds;
    };

    var _preparePlayerIdsUrlParam = function (playerIds) {
        if (playerIds === null || typeof playerIds === 'undefined' || typeof playerIds === 'function') {
            playerIds = "all";
        } else if (typeof playerIds === 'string') {
            playerIds = $.trim(playerIds);
            if (playerIds.length === 0) {
                playerIds = "all";
            }
        } else if (typeof playerIds === 'number') {
            if (playerIds === 0) {
                playerIds = "all";
            } else {
                playerIds = playerIds.toString();
            }
        } else {
            if (typeof playerIds === 'object' && typeof playerIds.length === 'number') {
                var ids = "";
                for (var i = 0; i < playerIds.length; i++) {
                    ids = ids + (ids.length === 0 ? "" : ",") + "\"" + playerIds[i].toString() + "\"";
                }
                playerIds = ids;
            } else {
                playerIds = "all";
            }
        }

        return playerIds;
    };

    var _request = function (options) {
        var strDateFrom        = options.from;
        var strDateTo          = options.to;
        var onSuccess          = options.onSuccess;
        var onError            = options.onError;
        var serviceBusObserver = options.serviceBusObserver;
        var playerIds          = options.playerIds;
        var directRequest      = options.directRequest;
        var formatDate = function (strDate) {
            var dateInputFormat = /(\d\d)\/(\d\d)\/(\d\d\d\d)/;

            if( !dateInputFormat.test(strDate) ) {
                return strDate;
            }

            var month = strDate.replace(dateInputFormat, '$1');
            var day   = strDate.replace(dateInputFormat, '$2');
            var year  = strDate.replace(dateInputFormat, '$3');

            return year + "-" + month + "-" + day;
        };

        _onSuccess          = onSuccess            !== null && typeof onSuccess            !== 'undefined' ? onSuccess            : _onSuccess;
        _onError            = onError              !== null && typeof onError              !== 'undefined' ? onError              : _onError;
        _serviceBusObserver = serviceBusObserver   !== null && typeof serviceBusObserver   !== 'undefined' ? serviceBusObserver   : _serviceBusObserver;

        var ajaxCallOptions = {
            format      : 'json',
            dataType    : 'json',
            contentType : 'application/json',
            success     : _processRequestResponse,
            error       : _processRequestError
        };

        // If Service Bus is called directly from JavaScript
        if (directRequest) {
            var requestData = _requestTemplate;
            requestData = requestData.replace(/__DATE_FROM__/g      , formatDate(strDateFrom))
            requestData = requestData.replace(/__DATE_TO__/g        , formatDate(strDateTo))
            requestData = requestData.replace(/__PUBLIC_API_KEY__/g , 'cinsay99Public');
            requestData = requestData.replace(/__CLIENT_ID__/g      , clientId)
            requestData = requestData.replace(/__PLAYER_IDS_/g      , _preparePlayerIdsJsonParam(playerIds))

            ajaxCallOptions.type = 'POST';
            ajaxCallOptions.url  = _serviceBusUrl;
            ajaxCallOptions.data = requestData;

            _serviceBusObserver.afterRequest("POST " + ajaxCallOptions.url + "\nData sent:\n\n" + requestData);
        } else { // If Service Bus is called indirectly through the App Server
            ajaxCallOptions.type = 'GET';
            ajaxCallOptions.url  = statsUrlPattern.replace(/__TAB__/g, currentTabName)
                                                  .replace(/__DATE_FROM__/g  , formatDate(strDateFrom))
                                                  .replace(/__DATE_TO__/g    , formatDate(strDateTo))
                                                  .replace(/__PLAYER_IDS__/g , _preparePlayerIdsUrlParam(playerIds));

            _serviceBusObserver.afterRequest("GET " + ajaxCallOptions.url);
        }
        $.ajax(ajaxCallOptions);
    };

    return {
        // Public methods
        request : _request
    };

}(jQuery));
