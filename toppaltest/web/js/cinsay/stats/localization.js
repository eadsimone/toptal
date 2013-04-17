/*globals translations*/

function __(originalText) {
    'use strict';

    if (typeof translations === 'undefined' || !translations.hasOwnProperty(originalText)) {
        return originalText;
    } else {
        var translatedText = translations[originalText];

        if (translatedText.length === 0) {
            return originalText;
        } else {
            return translatedText;
        }
    }
}