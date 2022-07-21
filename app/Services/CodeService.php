<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * Class CodeService
 * @package App\Services
 */
class CodeService
{
    public function generateCode($prefix = ""){
        $today = Carbon::now()->isoFormat("YMDhms");
        $rand = rand(100,999);
        $code = $today . $rand;
        return $prefix.$code;
    }
    
    public function generateCodeFromDate($prefix = ""){
        $today = Carbon::now()->isoFormat("YMDhms");
        $rand = rand(100,999);
        $code = $today . $rand;
        return $prefix.$code;
    }

    public function generateCodeFromName($name, $prefix = "", $length = 12){
        $acronym = str($this->getInitial($name))->upper();
        $code = $prefix.$acronym;

        for ($i= strlen($code); $i < $length; $i++) { 
            $code .= rand(0,9);
        }

        return $code;
    }

    public function getInitial($text){
        $words = explode(" ", $text);
        $acronym = "";

        foreach ($words as $w) {
            $acronym .= mb_substr($w, 0, 1);
        }

        return $acronym;
    }
}
