<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

use GettextDb\Translator;

/**
 * @param string $original
 * @param array $parse
 * @return mixed
 */
function __db(string $original, array $parse = [])
{
    $text = $original;

    /**
     * Base carragada no Translator
     */
    $db = Translator::$i18n;

    /**
     * @var TYPE_NAME $i18n
     */
    if(isset($db[$original]) and $db[$original] != '')
    {
        $text = $db[$original];
    }

    if($parse)
    {
        foreach ($parse as $procura => $troca)
        {
            $search[] = $procura;
            $replace[] = $troca;
        }

        $text = str_replace($search, $replace, $text);
    }

    return $text;
}