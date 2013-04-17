
/**
 * Various partial content loaders.
 *
 * @class
 */

// Module pattern from https://confluence.cinsay.com/display/DEV/Javascript+Module+Scaffold
C.ssm.loadPartial = C.ssm.loadPartial || ( function( $ ) {
    var _ = {};


    /**
     * Put prepared content into a pre-existing DOM element
     *
     * @param {String} elementId The ID of the DOM element to add content to
     * Todo: Make elementId dynamic to allow jQuery selector, or real DOM element(s)
     * @param {String|Object} content The content to add to the DOM element
     * @private
     */
    var addToElement = function( elementId, content ) {

        // Wrap in try/catch to handle invalid DOM element(s)
        try {
            // Find element(s)
            // Todo: Make this a method that evaluates element param, and gets dom elements
            var domElement = document.getElementById( elementId );

            // Insert into element(s)
            // Todo: Insert into each
            domElement.innerHTML = content;
        } catch( e ) {
            C.ssm.error( 'loadPartial.addToElement() could not add content to element ID: "' + elementId + '".' );
        }
    };


    /**
     * Put static HTML content into a DOM element
     *
     * @param {String} elementId The ID of the DOM element to insert HTML into
     * @param {String} html The HTML content to put in the DOM element
     * @public
     */
    _.html = function( elementId, html ) {

        addToElement( elementId, html );
    };


    /**
     * Use Mustache JS to render HTML Template, and insert it into DOM element
     *
     * @param {String} elementId The ID of the DOM element to insert HTML into
     * @param {String} templatePath The mustache template to render data into
     * @param {Object} [data] Content to render into template
     * @param {Object} [partials] More Mustache templates to render within this template
     * @public
     */
    _.mustache = function( elementId, templatePath, data, partials ) {

        var deferred = new $.Deferred();

        // Get template from path first
        C.ssm.mustache.getTemplate( templatePath, true )

            .done( function( template ) {

                rendered = C.ssm.mustache.render( template, data, partials );

                addToElement( elementId, rendered );

                deferred.resolve();
            } )

            .fail( function() {
                deferred.reject();
            } );

        return deferred;
    };


    /**
     * Unique index of field being generated
     *
     * @private
     * @type {Number}
     */
    var fieldIndex = 0;


    /**
     * Add rendered field and values to form field object
     *
     * @param {Object} source Source field object
     * @param {String} source.templatePath Mustache template to render field with
     * @param {Object} [defaults] Additional defaults to extend source object on to
     * @public
     */
    _.formField = function( source, defaults ) {

        if( !defaults ) defaults = {};

        var i, mustacheTemplate,

            // Initialize new object for return that has a unique ID that can be overridden by the template or controller data
            fieldObj = {
                id: 'field-' + fieldIndex++
            };

        // Merge additional (typically controller) data onto default properties
        $.extend( true, fieldObj, defaults, source );

        // Mustache template check
        if( !fieldObj.templatePath ) {
            C.ssm.error( "Fatal: loadPartial.formField() missing templatePath." );
            return;
        }

        // Does this field have <option>'s?  Set it's value if so
        // Todo: Break this view out of here!
        if( fieldObj.options && fieldObj.options.length && fieldObj.value ) {
            for( i = 0; i < fieldObj.options.length; i++ ) {
                if( fieldObj.options[i].value == fieldObj.value ) {
                    fieldObj.options[i].selected = true;
                }
            }
        }

        // Try to get mustache template
        mustacheTemplate = C.ssm.mustache.getTemplate( fieldObj.templatePath );

        // Finally, add rendered field to object
        fieldObj.field = C.ssm.mustache.render( mustacheTemplate, fieldObj );

        // All done successfully; return
        return fieldObj;
    };


    /**
     * Shorthand method that is a quick way to handle "most" partial loads...
     * @param {Object} options Object of parameters to use
     * @param {String} options.url Url to request from service/controller
     * @param {String} options.elementId Id of the DOM element to insert the partial in to
     * @param {String} options.template File of the mustache template to use
     * @param {Object} [options.data] Data to use for mustache merge.  Will use service response object by default
     * @return {jQuery.promise}
     */
    _.helper = function( options ) {

        return C.ssm.ajax.service( { url: C.ssm.settings.serviceUrlPrefix + options.url } )
            .done( function( responseData ) {

                if( !options.data ) {
                    options.data = responseData;
                }

                C.ssm.loadPartial.mustache(
                    options.elementId,
                    options.template,
                    options.data
                );
            } );
    };


    return _;
} ( jQuery ) );