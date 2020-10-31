<?php


namespace Parser\Utils;
class OutPut
{
    private static $bNotice=false;
    private static $bFatal=true;
    public static function echo($o){
        if(!self::$bNotice){
            return ;
        }
        self::_echo($o);
    }

    private static function _echo($o){
        if(is_string($o)){
            echo "\n".$o."\n";
        }else{
            echo "\n".json_encode($o)."\n";
        }
    }

    public static function error($o){
        if(!self::$bFatal){
            return;
        }
        self::_echo($o);
    }

}