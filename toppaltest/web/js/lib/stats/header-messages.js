/*globals jQuery*/

jQuery(function () {
    'use strict';

    (function ($) {
        window.HeaderMessages = {
            addError: function (message) {
                this.addMessage(message, 'error');
            },

            addSuccess: function (message) {
                this.addMessage(message, 'success');
            },

            addNotice: function (message) {
                this.addMessage(message, 'notice');
            },

            addMessage: function (message, type) {
                if (typeof type === 'undefined') {
                    type = 'notice';
                }

                var messagesContainer = $('#messages');

                var messagesList = $('.messages', messagesContainer);
                if (0 === messagesList.length) {
                    messagesContainer.append('<ul class="messages"></ul>');
                    messagesList = $('.messages', messagesContainer);
                }

                var messagesListByType = $('.' + type + '-msg > ul', messagesList);
                if (0 === messagesListByType.length) {
                    messagesList.append('<li class="' + type + '-msg"><ul></ul></li>');
                    messagesListByType = $('.' + type + '-msg > ul', messagesList);
                }

                var newErrorMessage = $("<li><span></span></li>");
                $('span', newErrorMessage).text(message);
                messagesListByType.append(newErrorMessage);
            }
        };
    }(jQuery));
});