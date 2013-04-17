
/**
 * Cinsay Smart Logger class. Will fall back to "alert" if can't console.log()
 * - Adds shorthand methods C.ssm.log() and C.ssm.error() at the bottom of this file
 */

// Module pattern from https://confluence.cinsay.com/display/DEV/Javascript+Module+Scaffold
C.ssm.logger = C.ssm.logger || ( function() {
    var _ = {};


    /**
     * Set debug mode to true or false based on env settings
     *
     * @public
     * @type {Boolean}
     */
    _.inDebugMode = !!C.ssm.settings.debug;


    /**
     * For #!?%$^@ IE < 9...
     *
     * @private
     * @type {Boolean}
     */
    var canLog = !!( window.console && window.console.log ),
        canError = !!( window.console && window.console.error ),
        canLogApply = !!( canLog && window.console.log.apply );


    /**
     * Static console logging function, takes one or more strings or objects to log
     *
     * @public
     */
    _.log = function() {

        if( _.inDebugMode ) {

            // If any error arguments were passed, redirect to error().
            for( var i = 0; i < arguments.length; i++ ) {
                if( arguments[i] && ( arguments[i].stack || arguments[i].error ) ) {
                    _.error( arguments );
                    return;
                }
            }

            // Log to console
            sendToUser( arguments );
        }
    };


    /**
     * Static console error logging function, takes one or more strings or objects to log
     *
     * @public
     */
    _.error = function() {

        if( _.inDebugMode ) {

            // Re-assign any arguments that are Error() instances to only log their
            //   stack property, which includes the verbose error message
            for( var i = 0; i < arguments.length; i++ ) {
                if( arguments[i] && arguments[i].stack ) {
                    arguments[i] = arguments[i].stack;
                }
            }

            // Log to console
            sendToUser( arguments, true );
        }
    };


    /**
     * Send to browser's appropriate console logging method.
     *
     * @private
     * @param {Array} argsArr Arguments from callee
     * @param {Boolean} [isError] Whether or not to try to call the console.error() method
     */
    var sendToUser = function( argsArr, isError ) {

        var i,
            defaultMethod = 'log',
            type = isError ? 'error' : defaultMethod,
            consoleMethod = canError ? type : defaultMethod;

        // Most modern browsers.  Can console.log, and apply args
        if( canLogApply ) {
            window.console[ consoleMethod ].apply( window.console, argsArr );
        }

        // Older browser, can't .apply(), iterate over each
        else {
            for( i = 0; i < argsArr.length; i++ ) {

                // At least we have some kind of console to log to
                if( canLog ) {
                    window.console[ consoleMethod ]( argsArr[i] );
                }

                // Hella old. Fall back to "alert()".
                else {
                    alert( " - DEBUG [" + type + "] - \n" + argsArr[i] );
                }
            }
        }
    };

    return _;
} () );


/**
 * Add shorthand methods
 */
C.ssm.log = C.ssm.logger.log;
C.ssm.error = C.ssm.logger.error;