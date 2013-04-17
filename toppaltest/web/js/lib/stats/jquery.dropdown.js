/*globals jQuery*/

(function ($) {
    'use strict';

    var _defaultOptions = {
        parentSelector: undefined
    };

    $.extend($.fn, {
        dropdown: function (options) {
            // Process options
            var mergedOptions = $.extend(_defaultOptions, options);
            var self = $(this);
            var parent = typeof mergedOptions.parentSelector === 'undefined' ? self.parent() : $(mergedOptions.parentSelector);

            // Prepare items markup
            var itemsMarkup = '';
            $('option', this).each(function (index, element) {
                var value = element.value;
                var text = element.innerHTML;

                var itemTemplate = '<div class="container-name-option" data-value="__VALUE__">__TEXT__</div>';
                var itemMarkup = itemTemplate.replace(/__VALUE__/g, value).replace(/__TEXT__/g, text);

                itemsMarkup += itemMarkup;
            });

            // Prepare full markup
            var selectedOption = $('option:selected', this);
            var value = selectedOption.val();
            var text = selectedOption.text();
            var markup = '<div class="container-name">'
                       +     '<span id="selected-container-name" data-value="' + value + '">' + __(text) + '</span>'
                       +     '<span class="caret">&#9660;</span>'
                       +     '<div class="container-names">'
                       +         itemsMarkup
                       +     '</div>'
                       +     '<div class="container-options-caret"></div>'
                       + '</div>';

            // Add new markup to the DOM, and hide original select
            var selectorContainer = parent.append(markup);
            self.hide();

            // Event handlers
            self.change(function () {
                var value = $('option:selected', this).val();
                var text = $('option:selected', this).text();

                var selectedPlayer = $('#selected-container-name');
                selectedPlayer.text(text);
                selectedPlayer.data('value', value);
                selectedPlayer.attr('data-value', value);
            });

            $('.container-name-option', selectorContainer).click(function () {
                self.val($(this).data('value')).change();
            });

            return self;
        }
    });
}(jQuery));