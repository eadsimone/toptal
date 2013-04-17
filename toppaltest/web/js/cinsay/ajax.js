

/**
 * Wrapper for handling AJAX Calls
 *
 * @class ajax
 */

// Module pattern from https://confluence.cinsay.com/display/DEV/Javascript+Module+Scaffold
C.ssm.ajax = C.ssm.ajax || ( function( $ ) {
    var _ = {};

    /**
     * Set up our ajax defaults when this module loads.
     * @constructor
     */
    ( function() {
        $.ajaxSetup( {
            type: 'POST',
            dataType: 'json'
        } );
    } () );


    /**
     * Track request number for quick log reference
     *
     * @public
     */
    var requestIndex = 0;


    /**
     * Master AJAX wrapper/handler. Returns promise object.
     *
     * @param {Object} ajaxOptions Options to pass to jQuery AJAX
     * @param {String} ajaxOptions.url The URL to request (required)
     * @return {jQuery.Deferred} A promise object to attach callbacks with .then(), .done(), .fail(), and .always()
     *   See: http://api.jquery.com/category/deferred-object/
     * @public
     */
    _.request = function( ajaxOptions ) {

        var logData,
            deferred = new $.Deferred(),
            thisRequestIndex = requestIndex++,
            missingUrlErrMsg = 'AJAX Request [' + thisRequestIndex + ']: FAILED: Missing ajaxOptions.url';

        // Make sure we have URL to send request to
        if( !ajaxOptions.url ) {

            // Log, and trigger .fail() callbacks
            deferred.reject( missingUrlErrMsg, { status: -1, statusText: missingUrlErrMsg } );
            throw new Error( missingUrlErrMsg );
        }

        // Default to sending AND receiving JSON from server
        if( !ajaxOptions.dataType || ajaxOptions.dataType.toLowerCase() == 'json' ) {

            // JSON.stringify if request data is not a string
            if( ajaxOptions.data && typeof ajaxOptions.data != "string" ) ajaxOptions.data = JSON.stringify( ajaxOptions.data );
        }

        // Log AJAX attempt to console
        logData = ajaxOptions.data ? ajaxOptions.data : '-- none --';
        C.ssm.log( 'AJAX Request [' + thisRequestIndex + ']: INIT to "' + ajaxOptions.url + '" with data:', logData );

        // Make request
        $.ajax( ajaxOptions )

            // AJAX Got a good HTTP response
            .done( function( data, status, xhr ) {

                // Log success
                C.ssm.log( 'AJAX Request [' + thisRequestIndex + ']: HTTP SUCCESS.' );

                // Trigger .done() callbacks
                deferred.resolve( data, status, xhr, thisRequestIndex );
            } )

            // HTTP Request Failed
            .fail( function( xhr, status ) {

                // Log error
                if( xhr.status === 0 ) xhr.statusText = "Cross-domain blocked?";
                C.ssm.error( 'AJAX Request [' + thisRequestIndex + ']: HTTP FAILED: (jQuery ' + status + ') HTTP ' + xhr.status + ' ' + xhr.statusText );

                // Trigger .fail() callbacks
                deferred.reject( status, xhr, thisRequestIndex );
            } );

        return deferred;
    };


    /**
     * AJAX wrapper for making service calls.  Handles service errors correctly
     * @param ajaxOptions
     * @return {$.Deferred}
     */
    _.service = function( ajaxOptions ) {

        var deferred = new $.Deferred();

        // Needed when using Service Bus instead of SSM as controller
//        // Default to sending AND receiving JSON from server
//        if( !ajaxOptions.dataType || ajaxOptions.dataType.toLowerCase() == 'json' ) {
//            ajaxOptions.accept = "application/json";
//            ajaxOptions.contentType = "application/json";
//        }

        // Make request
        _.request( ajaxOptions )

            // Got a successful HTTP response.
            .done( function( data, status, xhr, thisRequestIndex ) {

                // Found an error object in the response
                if( data.error ) {

                    // Log error
                    C.ssm.error( 'AJAX Request [' + thisRequestIndex + ']: SERVICE FAILED: Controller gave error: ' + data.responseText );

                    // Trigger .fail() callbacks
                    deferred.reject( status, xhr, thisRequestIndex );
                }

                // No errors from service, trigger .done() callbacks
                else {
                    deferred.resolve( data, status, xhr, thisRequestIndex );
                }
            } );

        return deferred;
    };


    return  _;
} ( jQuery ) );
