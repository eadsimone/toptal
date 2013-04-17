

/**
 * Mustache Template wrapper
 *
 * @class
 */

    // Module pattern from https://confluence.cinsay.com/display/DEV/Javascript+Module+Scaffold
C.ssm.mustache = C.ssm.mustache || ( function( $ ) {
    var _ = {};


    var templateCache = {};


    /**
     * Mustache utility to get a mustache template from cache if exists, or from service, then adding to cache.
     *
     * @param {String} templatePath Path to template file
     * @param {Boolean} useDeferred Whether or not to use/return a deferred promise object
     * @return {Object|String} The deferred promise object, or template string to use with Mustache
     */
    _.getTemplate = function( templatePath, useDeferred ) {

        if( useDeferred ) {
            var deferred = new $.Deferred();
        }

        // Found in cache
        if( templateCache[ templatePath ] ) {

            // Trigger .done() handlers if using Deferred promise
            if( useDeferred ) {
                deferred.resolve( templateCache[ templatePath ], templatePath );
            }

            // Or just return template string
            else {
                return templateCache[ templatePath ];
            }
        }

        // Not in cache.  Make AJAX request to get template, and store in cache
        else {

            // Warn user in console that this is BADDD!!
            C.ssm.error( 'Mustache template "' + templatePath + '" not pre-fetched; fetching now.  Please add to pre-loader.' );

            // Then make the actual request
            C.ssm.ajax.request( {
                async: !!useDeferred,
                dataType: 'text',
                url: C.ssm.settings.templateUrlPrefix + templatePath
            } )
                .done( function( data ) {

                    // Store in cache
                    templateCache[ templatePath ] = data;

                    // Trigger .done() handlers if using deferred promise
                    if( useDeferred ) {
                        deferred.resolve( templateCache[ templatePath ], templatePath );
                    }
                } )
                .fail( function() {

                    // Trigger .fail() handlers if using deferred promise
                    if( useDeferred ) {
                        deferred.reject( templatePath );
                    }
                } );
        }

        // Return the deferred promise object
        if( useDeferred ) {
            return deferred;
        }

        // Or just the template string
        else {
            return templateCache[ templatePath ];
        }
    };


    /**
     * Setter to add template(s) to cache
     *
     * @param {Object} templates Name value pairs of one or more templates
     */
    _.addTemplates = function( templates ) {

        for( templatePath in templates ) {
            templateCache[ templatePath ] = templates[ templatePath ];
        }
    };


    /**
     * Render Mustache template with locale object and other data
     *
     * @public
     * @param {String} template The mustache template to render data into
     * @param {Object} [data] Content to render into template
     * @param {Object} [partials] More Mustache templates to render within this template
     * @return {String} The rendered template
     */
    _.render = function( template, data, partials ) {

        // Add locale content to data object
        if( !data ) data = {};
        $.extend( data, { locale: C.ssm.locale } );

        // Render incoming data with template, then put in wrapper
        renderResult = Mustache.to_html( template, data, partials );

        return renderResult;
    };

    return _;
} ( jQuery ) );