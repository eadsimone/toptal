(function ($) {

$(function() {
    'use strict';

    var categoryInput = $('#category-input');

    // Internationalization function
    var __ = function (originalText) {
        if (typeof i18n === 'object' && i18n.hasOwnProperty(originalText)) {
            return i18n[originalText];
        } else {
            return originalText;
        }
    };

    var collectionDiff = function (collectionA, collectionB) {
        var diffResult = [];

        for (var indexA = 0; indexA < collectionA.length; indexA++) {
            var itemA = collectionA[indexA];
            var isItemInCollectionB = false;
            for (var indexB = 0; indexB < collectionB.length; indexB++) {
                var itemB = collectionB[indexB];

                if (itemA.value === itemB.value) {
                    isItemInCollectionB = true;
                    break;
                }
            }
            if (!isItemInCollectionB) {
                diffResult.push(itemA);
            }
        }

        return diffResult;
    };

    var showCategorySelectionMessage = function (message, type) {
        if (type === 'error') {
            categoryInput
                .stop(true, true)
                .addClass('input-error', 'fast')
                .removeClass('input-error', 'slow');
        }

        $('.category-list-' + type + '-message')
            .text(message)
            .stop(true, true)
            .slideDown('fast')
            .delay(1500)
            .slideUp('slow');
    };

    var showCategorySelectionError = function (message) {
        showCategorySelectionMessage(message, 'error');
    };

    var showCategorySelectionInfo = function (message) {
        showCategorySelectionMessage(message, 'info');
    };

    var getSuggestions = function (filter) {
        var matchingItems = [];

        for (var i = 0; i < categories.length; i++) {
            var category = categories[i];
            if (typeof filter === 'undefined') {
                matchingItems.push(category);
            } else if (typeof filter === 'object' &&
                category[filter.by].toString().toLowerCase() == filter.value.toString().toLowerCase()) {
                matchingItems.push(category);
            }
        }

        return matchingItems;
    };

    categoryInput.autocomplete({
        minLength: 0,
        source: categories,
        select: function(event, ui) {
            categoryInput.val(ui.item.label);
            return false;
        },
        focus:function() {
            return false;
        }
    }).keydown(function (event) {
        if (event.keyCode === 13) {
            $('#add-category-button').click();
        }
    }).data('autocomplete')._renderItem = function(ul, item) {
            var itemMarkup = '<a href="#">' + item.label + '<br/><span class="ui-autocomplete-item-desc">' + item.desc + '</span></a>';

            return $('<li></li>')
                .data('item.autocomplete', item)
                .append(itemMarkup)
                .appendTo(ul);
    };

    $('#tag-list-container').taglist({
        add: function () {
            showCategorySelectionInfo(__("Category added OK"));
        },
        remove: function () {
            //showCategorySelectionInfo(__("Category removed OK"));
        },
        sort: function () {
            //showCategorySelectionInfo(__("Sorted OK"));
        }
    });

    $('#add-category-button').button({
        icons: {
            primary: "ui-icon-plus"
        },
        text: false
    }).click(function () {
        var dataItem = categoryInput.data('autocomplete').selectedItem;
        var cancelAddItem = false;

        // If no item selected from the suggestions, try to guess from the text in the input
        if (typeof dataItem === 'undefined' || dataItem === null) {
            var categoryLabel = $.trim(categoryInput.val());

            if (categoryLabel === "") {
                showCategorySelectionError(__("Please, enter a category to add"));
                cancelAddItem = true;
            } else {
                // Get the list of data items (categories) that match with the text in the input
                var filter = {by: 'label', value: categoryLabel, caseSensitive: false};
                var matchingItems = getSuggestions(filter);

                if (matchingItems.length === 0) {
                    showCategorySelectionError(__("The specified category does not exist"));
                    cancelAddItem = true;
                } else if (matchingItems.length >= 1) {
                    var matchingAlreadyAddedItems = $('#tag-list-container').taglist('getItems', filter);
                    var matchingItemsNotAdded = collectionDiff(matchingItems, matchingAlreadyAddedItems);

                    if (matchingItemsNotAdded.length === 0) {
                        showCategorySelectionError(__("Can not add a duplicated category"));
                        cancelAddItem = true;
                    } else if (matchingItemsNotAdded.length === 1) {
                        dataItem = matchingItemsNotAdded[0];
                    } else if (matchingItemsNotAdded.length > 1) {
                        categoryInput.autocomplete('search');
                        cancelAddItem = true;
                    }
                }
            }
        } else {
            filter = {by: 'value', value: dataItem.value};
            matchingAlreadyAddedItems = $('#tag-list-container').taglist('getItems', filter);

            if (matchingAlreadyAddedItems.length === 1) {
                showCategorySelectionError(__("The category is already in the list"));
                cancelAddItem = true;
            }
        }

        if (!cancelAddItem) {
            $('#tag-list-container').taglist('addItem', dataItem);
            categoryInput.data('autocomplete').selectedItem = null;
            categoryInput.val("");
        }

        return false;
    });
});

}(jQuery));