
/**
 * Product With Options table handler thingy
 */

// Module pattern from https://confluence.cinsay.com/display/DEV/Javascript+Module+Scaffold
C.ssm.pwo = C.ssm.pwo || ( function( $ ) {
    var _ = {};

    /**
     * Initialize options object
     * @type {Object}
     * @private
     */
    var pwoOptions = {};

    /**
     * Construct (kinda)
     */
    ( function() {
        C.ssm.ajax.service( { url: C.ssm.settings.serviceUrlPrefix + 'getPwoPresets.php' } )
            .done( function( responseData ) {
                pwoOptions = responseData.pwodata;
            } );
    } () );

    /**
     * Load the table into an element
     * @param {Object} selEl The DOM element of the select being changed
     */
    _.loadTable = function( selEl ) {

        var tableData = { options: [] },
            selectedValue = $( selEl ).val(),
            defaultOptions = [ { name: '', sku: '', price: '', quantity: '', weight: '' } ],
            optionsToUse = defaultOptions;

        if( pwoOptions[selectedValue] ) {
            optionsToUse = pwoOptions[selectedValue];
        }

        for( var i in optionsToUse ) {
            for( var prop in optionsToUse[i] ) {
                if( !tableData.options[i] ) tableData.options[i] = {};
                tableData.options[i][prop] = C.ssm.loadPartial.formField( C.ssm.fields.pwo[prop], { value: optionsToUse[i][prop] } );
            }
        }

        C.ssm.loadPartial.mustache( 'product-options-table-container', 'product/pwo.html', tableData );
    };

    /**
     * Trigger change... SOOO BAAADDDDD!!!! :( -BB
     */
    _.triggerOptionChange = function() {
        $( '#options' ).change();
    };


    /**
     * Position helpers below here
     */

    _.addRow = function() {
        var lastRow = $( '.pwo-item' ).last();
        var newRow = lastRow.clone();
        newRow.find( ':text' ).val( '' );
        newRow.appendTo( '#pwo-grid' );
    };

    _.removeRow = function( elem ) {
        var rowCount = $( elem ).parents( 'tr' ).siblings().length;
        if( rowCount == 0 ) {
            _.addRow();
        }
        $( elem ).parents( 'tr' ).remove();
    };

    _.moveRowDown = function( elem ) {
        var currentRow = $( elem ).parents( 'tr' );
        currentRow.insertAfter( currentRow.next() );
    };

    _.moveRowUp = function( elem ) {
        var currentRow = $( elem ).parents( 'tr' );
        currentRow.insertBefore( currentRow.prev() );
    };


    return _;
} ( jQuery ) );