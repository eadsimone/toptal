<?php

namespace Localization;

/**
 * Class Translator.
 * Used to translate texts on server side.
 *
 * @author Daniel David Duarte <danielddu@hotmail.com>
 */
class Translator {

    /**
     * Dictionary of translations loaded from the locale configuration.
     *
     * @var array of 'string' => 'string'.
     */
    protected $translations;

    /**
     * Creates an instance of the translator for the specified locale.
     *
     * @param string $locale The ISO locale code to initialize the instance.
     *     Example locale codes: en_US, es_AR, ru_RU.
     */
    public function __construct($locale) {
        $translationFilepath = $this->documentRoot() . "locale/$locale/server-translations.php";

        if (file_exists($translationFilepath)) {
            include $translationFilepath;
        } else {
            $translations = array();
        };

        $this->translations = $translations;
        unset($translations);
    }

    /**
     * Translates the original text. If ther is no translation for the required
     * text, the same text is returned.
     *
     * @param strinf $originalText
     *
     * @return string The translated text.
     */
    public function __($originalText)
    {
        if (array_key_exists($originalText, $this->translations)) {
            $translatedText = $this->translations[$originalText];
        } else {
            $translatedText = $originalText;
        }

        return $translatedText;
    }

    /**
     * Returns the path to the document root directory of the site.
     *
     * @return string The document root path.
     */
    private function documentRoot()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }
}