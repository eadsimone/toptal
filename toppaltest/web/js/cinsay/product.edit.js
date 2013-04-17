

/**
 * Product Edit
 */

// Module pattern from https://confluence.cinsay.com/display/DEV/Javascript+Module+Scaffold
C.ssm.productedit = C.ssm.productedit || function( $ ) {
    var _ = {};

    var getBaseRow = function(){
        var tr = $('<tr />');

        var inputAmount = $('<input class="input-block-level" type="text" name="amount[]" />');
        var tdInput = $('<td />').html(inputAmount);

        var buttonRemove = $('<span class="btn btn-mini btn-danger removeAmount"><a href="#"><span class="icon-remove-sign icon-white"></span></a></span>');
        var tdRemove = $('<td />').html(buttonRemove);

        tr.append(tdInput, tdRemove);

        var row = tr.clone();

        return row;
    };

    var insertAmount = function(){
        var row = getBaseRow();

        $('#table-amounts tbody').append(row);
    };

    var removeAmount = function(elem){
        var tr = $(elem).closest('tr');

        tr.remove();
    };

    _.handleElements = function(){
        handleAddAmount();
        handleRemoveAmount();
    };

    var handleAddAmount = function(){
        $('#addAmount').click(function(e){
            e.preventDefault();

            insertAmount();
        });
    };

    var handleRemoveAmount = function(){
        $('.removeAmount').live('click',function(e){
            e.preventDefault();

            removeAmount(this);
        });
    };


    return _;
}( jQuery );