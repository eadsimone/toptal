<?php

namespace Localization;

/**
 * Class Currency.
 * Used to get localized information about the currency used.
 *
 * @author Daniel David Duarte <danielddu@hotmail.com>
 */
class Currency {

    /**
     * The currency symbol.
     *
     * @var string
     */
    protected $symbol;

    /**
     * The currency position.
     * Values can be "left" of "right".
     *
     * @var string
     */
    protected $symbolPosition;

    /**
     * Creates an instance of the currency, localized according to the locale
     * code specified.
     *
     * @param string $locale The ISO locale code to initialize the instance.
     *     Example locale codes: en_US, es_AR, ru_RU.
     */
    public function __construct($locale) {
        $currencyFilepath = $this->documentRoot() . "locale/$locale/currency.php";

        if (file_exists($currencyFilepath)) {
            include $currencyFilepath;
            $symbol         = $currency['symbol'];
            $symbolPosition = $currency['symbolPosition'];
        } else {
            $symbol = "¤";
            $symbolPosition = "left";
        };

        $this->symbol = $symbol;
        $this->symbolPosition = $symbolPosition;
        unset($currency);
    }

    /**
     * Gets the currency symbol.
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Get the currency position, that can be "left" or "right";
     *
     * @return string
     */
    public function getSymbolPosition()
    {
        return $this->symbolPosition;
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