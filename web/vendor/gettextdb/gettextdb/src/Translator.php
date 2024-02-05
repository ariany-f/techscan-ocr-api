<?php

namespace GettextDb;

use Tecno\Lib\Utils;

/**
 * Class to manage a translation string.
 */
class Translator
{
    public static $i18n;

    /**
     * Translator constructor.
     * @param $translation_source
     */
    public function __construct($translation_source)
    {
        /**
         * @var TYPE_NAME $i18n
         */
        if(file_exists($translation_source))
        {
            $db = require $translation_source;
            self::setDbArray($db);
        }
        $this->register();
    }

    public function setDbArray(array $db)
    {
        self::$i18n = $db;
    }

    public function register()
    {
        require_once 'translator_functions.php';
    }
}