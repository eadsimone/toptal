/*!
 * jQuery Tag List plugin
 *
 * Creates a pretty tag list from a simple markup of the form DIV > UL > LI.
 * Main features:
 * - Permits sorting by dragging and dropping the tags.
 * - Permits tag deletion by clicking on the individual "x" buttons.
 *
 * Requirements:
 * - jQuery
 * - jQuery UI
 * - jQuery slide effect
 *
 * @author Daniel Duarte <dduarte@summasolutions.net>
 */

/*globals jQuery, $*/

(function ($) {
    'use strict';

    /**
     * Possible calls:
     * - taglist(): Initialized the widget
     * - taglist(options): Initialized the widget with specific options
     * - taglist(method, params): Executes a method on the widget. The widget must be initialized.
     */
    $.fn.taglist = function (options, params) {

        var settings = {
            tagRenderer: function (item) {
                if (typeof item.label === 'string') {
                    return item.label;
                } else {
                    return "---";
                }
            },
            add: function () {},
            remove: function () {},
            sort: function () {}
        };

        var utilityMethods = {
            createDataItemFromElem: function (tagElem) {
                var label = tagElem.data('taglist-label');
                if (typeof label === 'undefined') {
                    label = tagElem.html();
                }
                return {
                    value: tagElem.data('taglist-value'),
                    label: label,
                    desc: tagElem.data('taglist-desc')
                };
            },

            createDataItemFromAnyValue: function (jsValue) {
                var value, label, desc;

                if (typeof jsValue === 'string' || typeof jsValue === 'undefined') {
                    value = label = desc = jsValue;
                } else if (typeof jsValue === 'boolean' || typeof jsValue === 'number') {
                    value = jsValue
                    label = desc = jsValue.toString();
                } else if (jsValue === null) {
                    value = null;
                    label = desc = undefined;
                } else if (typeof jsValue === 'object') {
                    value = jsValue.value;
                    label = jsValue.label;
                    desc = jsValue.desc;
                } else {
                    value = label = desc = undefined;
                }

                return {
                    value: value,
                    label: label,
                    desc: desc
                };
            }
        };

        var privateMethods = {
            init: function (tagListContainer, options) {
                var isTaglist = tagListContainer.data('taglist');
                if (isTaglist !== true) {
                    $.extend(settings, options);

                    var tagList = $('ul', tagListContainer);
                    var tags = $('li', tagList);

                    tagListContainer.addClass('ui-taglist-container');
                    tagList.addClass('ui-taglist');

                    // Intidivual tag initialization
                    tags.each(function () {
                        var tag = $(this);
                        var dataItem = utilityMethods.createDataItemFromElem(tag);
                        tag.data('taglist-data-item', dataItem);

                        var title = typeof dataItem.desc === 'string' ? $.trim(dataItem.desc) : null;
                        title = title !== "" ? title : null;
                        tag.attr('title', title);

                        tag.html(settings.tagRenderer(dataItem));
                    });
                    tags.addClass('ui-state-default')
                        .append('<span class="ui-icon ui-icon-circle-close ui-taglist-remove-button"></span>');

                    tagList.sortable({
                        placeholder: 'ui-state-highlight',
                        cursor: 'move',
                        stop: settings.sort
                    }).disableSelection();

                    var removeButtons = $('.ui-taglist-remove-button', tagList);
                    removeButtons.click(function () {
                        var listItem = $(this).parent();
                        listItem.fadeTo(75, 0.5).hide('slide', {}, 150, function () {
                            listItem.remove();
                            settings.remove();
                        });
                    });

                    tagListContainer.data('taglist', true);
                    tagListContainer.data('taglist-settings', settings);
                }
            },

            executePublicMethod: function (tagListContainer, methodName, methodParams) {
                if (publicMethods.hasOwnProperty(methodName)) {
                    return publicMethods[methodName](tagListContainer, methodParams);
                } else {
                    throw new Error("Unknowk 'taglist' method: '" + methodName + "'");
                }
            }
        };

        var publicMethods = {
            addItem: function (tagListContainer, item) {
                var tagList = $('ul', tagListContainer);

                var newRemoveButton = $('<span class="ui-icon ui-icon-circle-close ui-taglist-remove-button"></span>').click(function () {
                    var listItem = $(this).parent();
                    listItem.fadeTo(75, 0.5).hide('slide', {}, 150, function () {
                        listItem.remove();
                        settings.remove();
                    });
                });

                var settings = tagListContainer.data('taglist-settings');

                var dataItem = utilityMethods.createDataItemFromAnyValue(item);

                var title = item !== null && typeof item.desc === 'string' ? $.trim(item.desc) : null;
                title = title !== "" ? title : null;

                var newItem = $('<li class="ui-state-default"' + (title !== null ? ' title="' + title + '" ' : '') + '>' + settings.tagRenderer(dataItem) + '</li>');
                newItem.data('taglist-data-item', dataItem);
                newItem.append(newRemoveButton);

                tagList.append(newItem);
                settings.add();
            },

            getItems: function (tagListContainer, filter) {
                var tagList = $('ul', tagListContainer);
                var tags = $('li', tagList);

                var items = [];

                tags.each(function () {
                    var itemElem = $(this);
                    var dataItem = itemElem.data('taglist-data-item');
                    if (typeof filter === 'undefined') {
                        items.push(dataItem);
                    } else if (typeof filter === 'object') {
                        var value = dataItem[filter.by];
                        var filterValue = filter.value;
                        if (value === filterValue) {
                            items.push(dataItem);
                        } else if (filter.hasOwnProperty('caseSensitive') && filter.caseSensitive === false && value.toString().toLowerCase() === filterValue.toString().toLowerCase()) {
                            items.push(dataItem);
                        }
                    }
                });

                return items;
            }
        };

        if (typeof options === 'undefined') { // Empty call to initialize the widget
            return $(this).each(function () {
                var tagListContainer = $(this);
                privateMethods.init(tagListContainer, {});
            });
        } else if (typeof options === 'object') { // Call to initialize the widget with specific options
            return $(this).each(function () {
                var tagListContainer = $(this);
                privateMethods.init(tagListContainer, options);
            });
        } else if (typeof options === 'string') { // Call to call a method on the widget
            var tagListContainer = $(this);
            var methodName = options;
            return privateMethods.executePublicMethod(tagListContainer, methodName, params);
        } else {
            throw new Error("Erroneous call to 'taglist'. The 'options' parameter type is invalid");
        }
    };

}(jQuery));