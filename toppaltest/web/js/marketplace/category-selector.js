var CategorySelector = (function ($) {
    'use strict';

    var categoryParents = {};

    var _fillExtraInfo = function (categories, currentPath, parent) {
        for (var i = 0; i < categories.length; i++) {
            var category = categories[i];
            categoryParents[category.value.toString()] = parent;

            category.desc = currentPath.length === 0 ? "(Root Category)" : currentPath;
            category.originalLabel = category.label;
            category.label = __(category.label, false);

            if (category.hasOwnProperty('children')) {
                _fillExtraInfo(category.children, (currentPath.length === 0 ? "" : currentPath + " &#9658; ") + category.label, category);
            }
        }
    };

    var fillExtraInfo = function (categories) {
        return _fillExtraInfo(categories, "", null);
    };

    return {
        init: function (categoriesTree) {
            if (categoriesTree === null) {
                categoriesTree = [];
                MagentoMessages.addError(__("Error trying to get the category list. If you save the current player you could lose its assigned categories."));
            }

            fillExtraInfo(categoriesTree);

            var categoryInput = $('#category-input');

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
                    .html(message)
                    .stop(true, true)
                    .slideDown('fast')
                    .delay(2500)
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

                var currentCategories = categoryInput.autocomplete('option', 'source');//-expanded');

                for (var i = 0; i < currentCategories.length; i++) {
                    var category = currentCategories[i];
                    if (typeof filter === 'undefined') {
                        matchingItems.push(category);
                    } else if (typeof filter === 'object' &&
                        category[filter.by].toString().toLowerCase() == filter.value.toString().toLowerCase()) {
                        matchingItems.push(category);
                    }
                }

                return matchingItems;
            };

            var updateEmptyListMessage = function () {
                var items = $('#tag-list-container').taglist('getItems');
                if (items.length === 0) {
                    $('#empty-category-list-label').show();
                } else {
                    $('#empty-category-list-label').hide();
                }
            };

            var addCurrentElement = function () {
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
                        var filter = {by: 'label', value: categoryLabel, caseSensitive: false, preProcess: function (value) { return __(value); } };

                        var matchingItems = getSuggestions(filter);

                        if (matchingItems.length === 0) {
                            showCategorySelectionError(__("The specified category does not exist"));
                            cancelAddItem = true;
                        } else if (matchingItems.length >= 1) {
                            var matchingAlreadyAddedItems = $('#tag-list-container').taglist('getItems', filter);
                            var matchingItemsNotAdded = collectionDiff(matchingItems, matchingAlreadyAddedItems);

                            if (matchingItemsNotAdded.length === 0) {
                                showCategorySelectionError(__("The category is already in the list"));
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
                    filter = { by: 'value', value: dataItem.value };
                    matchingAlreadyAddedItems = $('#tag-list-container').taglist('getItems', filter);

                    if (matchingAlreadyAddedItems.length === 1) {
                        showCategorySelectionError(__("The category is already in the list"));
                        cancelAddItem = true;
                    }
                }

                var maxCategoryCount = 5; // @todo parametrize this constant
                var privateCategoryCount = $jq('#tag-list-container .ui-taglist li.private').length;
                var publicCategoryCount = $jq('#tag-list-container .ui-taglist li').length - privateCategoryCount;
                if (dataItem.isPublic && publicCategoryCount >= maxCategoryCount) {
                    showCategorySelectionError(__("You can not add more than __MAX__ categories").replace(/__MAX__/g, maxCategoryCount.toString()));
                    cancelAddItem = true;
                }

                if (!cancelAddItem) {
                    $('#tag-list-container').taglist('addItem', {
                        desc: __(dataItem.desc, false),
                        label: dataItem.originalLabel,
                        value: dataItem.value,
                        cssClass: dataItem.isPublic ? null : 'private'
                    });
                    categoryInput.data('autocomplete').selectedItem = null;
                    categoryInput.val("");
                }

                return false;
            };

            var expandTree = function (treeSource) {
                var expandedSource = [];

                for (var i = 0; i < treeSource.length; i++) {
                    var item = treeSource[i];
                    expandedSource.push(item);

                    if (item.hasOwnProperty('children')) {
                        var childExpanded = expandTree(item.children);
                        for (var j = 0; j < childExpanded.length; j++) {
                            var child = childExpanded[j];
                            expandedSource.push(child);
                        }
                    } else {

                    }
                }

                return expandedSource;
            };

            var convertSelectToDropdown = function (selectElem) {
                var items = [];
                var options = $('option', selectElem);

                for (var i = 0; i < options.length; i++) {
                    var option = $(options[i]);
                    items.push({
                        value: option.val(),
                        label: option.text()
                    });
                }

                var selectedOption = $('option:selected', selectElem);

                var dropdownButton = '<span href="#" class="ui-dropdown-button ui-button ui-widget ui-state-default ui-button-icon-only ui-corner-right" ><span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-s"></span></span>';
                var selectedElem = '<span class="ui-dropdown-text">' + __(selectedOption.text()) + '</span>';
                var dropdown = $('<span class="ui-dropdown" tabindex="-1">' + selectedElem + dropdownButton + '</span>')
                    .click(function() {
                        $(this).autocomplete({
                            minLength: 0,
                            source: items,
                            select: function(event, ui) {
                                if (selectElem.val() !== ui.item.value) {
                                    selectElem.val(ui.item.value).change();
                                    $('.ui-dropdown-text', this).html(__(ui.item.label));
                                }
                            }
                        }).data('autocomplete')._renderItem = function(ul, item) {
                            return $('<li></li>')
                                .data('item.autocomplete', item)
                                .append($('<a></a>').html(__(item.label)))
                                .appendTo(ul);
                        };

                        $(this).autocomplete('search', '');
                    });

                selectElem.prop('associatedDropdown', dropdown).hide();
                dropdown.insertBefore(selectElem);
            };

            /**
             * Creates a <select> element (returns a jQuery object) with the
             * options containing the 'category' param and its siblings.
             * Only includes categories that have children, not leaves.
             * The element will have 'category' as the selected option.
             */
            var createSelectElementFromCategory = function (category) {
                var newParentCategorySelector = $('<select class="parent-category-selector"></select>');

                var parentCategory = categoryParents[category.value.toString()];
                var items = parentCategory != null ? parentCategory.children : categoriesTree;
                for (var i = 0; i < items.length; i++) {
                    var item = items[i];

                    // Only add the categories with children
                    if (item.hasOwnProperty('children')) {
                        var newParentCategoryOption = $('<option></option>');

                        newParentCategoryOption.text(item.label)
                            .attr('value', item.value)
                            .data('autocomplete-source', item);

                        newParentCategorySelector.append(newParentCategoryOption);
                    }
                }

                newParentCategorySelector.val(category.value);
                newParentCategorySelector.change(function () {
                    $(this).nextAll().remove();
                    var selectedOption = $('option[value=' + this.value + ']', this);
                    var selectedOptionChildren = selectedOption.data('autocomplete-source').children;

                    categoryInput.autocomplete('option', 'source-original', selectedOptionChildren);
                    categoryInput.autocomplete('option', 'source-expanded', expandTree(selectedOptionChildren));
                    categoryInput.autocomplete('option', 'source', selectedOptionChildren);
                    categoryInput.autocomplete('option', 'using-source-expanded', false);

                    $('.ui-dropdown-text', $(this).prop('associatedDropdown')).text(selectedOption.text());
                });

                return newParentCategorySelector;
            };

            categoryInput.autocomplete({
                minLength: 0,
                source: categoriesTree,
                'source-original': categoriesTree,
                'source-expanded': expandTree(categoriesTree),
                'using-source-expanded': false,
                select: function(event, ui) {
                    var selectedCategory = ui.item;

                    if (selectedCategory.hasOwnProperty('children')) {
                        var previousSource = categoryInput.autocomplete('option', 'source-original');

                        var categoryPath = [selectedCategory];
                        var parentCategory = categoryParents[selectedCategory.value.toString()];
                        while (parentCategory !== null) {
                            categoryPath.unshift(parentCategory);
                            parentCategory = categoryParents[parentCategory.value.toString()];
                        }

                        $('#categories-navigation-reset').show();
                        $('#parent-categories-list').empty();
                        for (var i = 0;i < categoryPath.length;i++) {
                            parentCategory = categoryPath[i];
                            var newParentCategorySelector = createSelectElementFromCategory(parentCategory);
                            $('#parent-categories-list').append(newParentCategorySelector);
                            convertSelectToDropdown(newParentCategorySelector);
                        }

                        categoryInput.autocomplete('option', 'source-original', selectedCategory.children);
                        categoryInput.autocomplete('option', 'source-expanded', expandTree(selectedCategory.children));
                        categoryInput.autocomplete('option', 'source', selectedCategory.children);
                        categoryInput.autocomplete('option', 'using-source-expanded', false);
                    } else {
                        categoryInput.val(ui.item.label);
                        $('#add-category-button').click();
                    }

                    return false;
                },
                focus:function() {
                    return false;
                }
            }).keydown(function (event) {
                    if (event.keyCode === 13) {
                        //$('#add-category-button').click();
                    } else {
                        var usingExpandedSource = $(this).autocomplete('option', 'using-source-expanded') === true;
                        if (!usingExpandedSource) {
                            var expandedSource = $(this).autocomplete('option', 'source-expanded');

                            $(this).autocomplete('option', 'source', expandedSource);
                            $(this).autocomplete('option', 'using-source-expanded', true)
                        }
                    }
                }).data('autocomplete')._renderItem = function(ul, item) {
                var label = item.originalLabel;
                var hasChildren = item.hasOwnProperty('children');
                var addButton = "";

                if (hasChildren) {
                    label = '<strong>' + label + '</strong> &#0187; ' + __("Parent Category");
                    addButton = $('<span class="ui-autocomplete-add-button">' + __("Add this Category") + '</span>')
                        .click(function (event) {
                            if (event && event.stopPropagation) {
                                event.stopPropagation();
                            } else if (window.event && window.event.cancelBubble) {
                                window.event.cancelBubble = true;
                            }

                            categoryInput.val(item.label);
                            $('#add-category-button').click();

                            categoryInput.autocomplete('close');

                            return false;
                        });
                }

                var cssClass = item.isPublic ? '' : ' class="private"';
                var desc = '<br/><span class="ui-autocomplete-item-desc">' + __(item.desc) + '</span>';
                var itemElem = $('<a' + cssClass + ' href="#">' + label + desc + '</a>').append(addButton);

                return $('<li></li>')
                    .data('item.autocomplete', item)
                    .append(itemElem)
                    .appendTo(ul);
            };

            var tagListChange = function () {
                var selectedCategories = $.map($('#tag-list-container').taglist('getItems'), function (category) {
                    return category.value;
                });
                $('#selected-categories-id-list').val(selectedCategories.join(','));
            };
            $('#tag-list-container').taglist({
                add: function () {
                    showCategorySelectionInfo(__("Category added OK"));
                    $('#empty-category-list-label').hide();
                    tagListChange();
                },
                remove: function () {
                    updateEmptyListMessage();
                    tagListChange();
                    //showCategorySelectionInfo(__("Category removed OK"));
                },
                sort: function () {
                    tagListChange();
                    //showCategorySelectionInfo(__("Sorted OK"));
                },
                tagRenderer: function (item) {
                    if (typeof item.label === 'string') {
                        return __(item.label);
                    } else {
                        return "---";
                    }
                }
            });

            $('#add-category-button').button({
                icons: {
                    primary: "ui-icon-plus"
                },
                text: false
            }).click(addCurrentElement);

            var nativePlaceholderSupport = !!('placeholder' in document.createElement('input'));

            $('#expand-suggestions-button').button({
                icons: {
                    primary: "ui-icon-triangle-1-s"
                },
                text: false
            })
                .removeClass("ui-corner-all")
                .addClass("ui-corner-right")
                .click(function () {
                    if ($$('*[translate]') != '') {
                        $('.ui-autocomplete').css("max-height","1500px");
                    }
                    return false;
                })
                .mousedown(function (event) {
                    if (categoryInput.autocomplete('widget').is(':visible')) {
                        categoryInput.autocomplete('close');
                    } else {
                        var originalSource = categoryInput.autocomplete('option', 'source-original');
                        categoryInput.autocomplete('option', 'source', originalSource);
                        categoryInput.autocomplete('option', 'using-source-expanded', false);

                        // Fix for IE
                        var searchVal = categoryInput.val();
                        if (!nativePlaceholderSupport && categoryInput.val() === categoryInput.attr('placeholder')) {
                            searchVal = '';
                        }
                        categoryInput.autocomplete('search', searchVal).focus();
                    }

                    return false;
                });

            $('#categories-navigation-reset').click(function () {
                $('#categories-navigation-reset').slideUp('fast');
                $('#parent-categories-list').slideUp(function () {
                    $(this).show();
                });

                $('#parent-categories-list').empty();
                categoryInput.autocomplete('option', 'source-original', categoriesTree);
                categoryInput.autocomplete('option', 'source-expanded', expandTree(categoriesTree));
                categoryInput.autocomplete('option', 'source', categoriesTree);
                categoryInput.autocomplete('option', 'using-source-expanded', false);

                return false;
            });

            updateEmptyListMessage();
            tagListChange();
        }
    };

}(jQuery));