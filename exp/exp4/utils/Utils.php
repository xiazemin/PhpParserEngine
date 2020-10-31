<?php
namespace Utils;
class Utils
{
    public static function buildParts($aParts){
        if(empty($aParts)){
            return '';
        }
        $s="";
        for($i=0;$i<count($aParts);$i++){
            $s=$s."\\".$aParts[$i];
        }
        return $s;
    }
}