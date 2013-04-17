
/**
 * Initialize Cinsay ("C") and Smart Store Manager ("ssm") namespace.
 */
var C = C || {};


/**
 * Initialize ssm and settings
 */

// Module pattern from https://confluence.cinsay.com/display/DEV/Javascript+Module+Scaffold
C.ssm = C.ssm || ( function() {
    var _ = {};


    /**
     * "Global" SSM settings
     *
     * @public
     * @type {Object}
     */
    _.settings = {
        debug: false,
        templateUrlPrefix: '../src/views/',
        serviceUrlPrefix: '../src/jsapiCalls/'
    };

    return _;
} () );