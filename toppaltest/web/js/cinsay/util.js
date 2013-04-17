
/**
 * Generic utility class
 */

// Module pattern from https://confluence.cinsay.com/display/DEV/Javascript+Module+Scaffold
C.ssm.util = C.ssm.util || function( $ ) {
    var _ = {};


    /**
     * Recursively merge source object in to target object ONLY merging properties that exist in target.
     *
     * NOTICE: This function does not return anything, because it directly modifies the original
     *   target object (which gets passed by reference).
     *
     * @public
     * @param {Object} target
     * @param {Object} source
     */
    _.exclusiveExtend = function( target, source ) {

        for( var prop in target ) {

            if( typeof target[prop] == "object" && typeof source[prop] == "object" ) {

                _.exclusiveExtend( target[prop], source[prop] );

            } else if( prop in source ) {

                target[prop] = source[prop];
            }
        }
    };


    /**
     * Substitute characters for their HTML escape code equivalent. Like http://php.net/htmlspecialchars
     *
     * @public
     * @param {String} string The string to escape
     * @return {String} The escaped string
     */
    _.htmlSpecialChars = function( string ) {
        return string
            .replace( /&/g, "&amp;" )
            .replace( /</g, "&lt;" )
            .replace( />/g, "&gt;" )
            .replace( /"/g, "&quot;" )
            // Apostrophes don't need to be escaped as long as ALL HTML attributes are in double quotes,
            //   but it also doesn't hurt anything (just in case)
            .replace( /'/g, "&#039;" );
    };


    /**
     * Test each property of an object for type and non-emptiness (sp?)
     *
     * @public
     * @param {Object} requiredParams An object with arrays of required strings, or arrays
     * @param {Array} requiredParams.strings An array of values that must be non-empty strings
     * @param {Array} requiredParams.arrays An array of arrays that must have more than 0 elements
     * @return {Boolean} False if ANY requirements failed.
     */
    _.paramTest = function( requiredParams ) {

        var i;

        // Test strings
        if( requiredParams.string !== undefined ) {
            requiredParams.strings = [ requiredParams.string ];
        }
        if( requiredParams.strings !== undefined ) {
            for( i = 0; i < requiredParams.strings.length; i++ ) {
                if( typeof requiredParams.strings[i] !== 'string'
                    || !requiredParams.strings[i] ) return false;
            }
        }

        // Test arrays
        if( requiredParams.array !== undefined ) {
            requiredParams.arrays = [ requiredParams.array ];
        }
        if( requiredParams.arrays !== undefined ) {
            for( i = 0; i < requiredParams.arrays.length; i++ ) {
                if( Object.prototype.toString.call( requiredParams.arrays[i] ) !== '[object Array]'
                    || requiredParams.arrays[i].length < 1 ) return false;
            }
        }

        return true;
    };

    return _;
}( jQuery );
