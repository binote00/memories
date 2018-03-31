<?php
/**
 * Created by PhpStorm.
 * User: jfvanass
 * Date: 27.03.18
 * Time: 14:00
 */

class Exception
{
    private $codes = [
        'GENERIC_ERROR' => 'Erreur.',
        'SQL_ERROR' => 'Erreur SQL.',
        'PARAM_MISSING' => 'Le paramètre est manquant',
        'PARAM_NOT_VALID' => 'Le paramètre est invalide',
    ];

    public $code;
    public $usermessage;
    public $developpermessage;

    public function __construct($code, $developpermessage = '')
    {
        $code_raw = $this->getRawCode($code);
        $this->usermessage = isset($this->codes[$code_raw]) ? $this->codes[$code_raw] : 'Description manquante pour : ' . $code_raw;
        $this->usermessage .= $this->formatDynamicMessage($code);
        $this->code = $code_raw;

        if (DEBUG_MODE) {
            echo '['.$this->code.'] ';
        }
        echo $this->usermessage;
    }

    /**
     * If you want to call a dynamic message then you must use | at the end of the code
     * example : PARAM_MISSING => PARAM_MISSING|site
     *
     * @param $msg
     * @return string
     */
    private function formatDynamicMessage($msg)
    {
        if (strpos($msg, '|')) {
            $dynamic_part = substr($msg, strpos($msg, '|') + 1, strlen($msg));
            return ' (' . strtolower($dynamic_part) . ')';
        } else {
            return false;
        }
    }

    /**
     * @param string $code
     * @return bool|string
     */
    private function getRawCode($code)
    {
        if (strpos($code, '|')) {
            return substr($code, 0, strpos($code, '|'));
        } else {
            return $code;
        }
    }
}