<?php
namespace Linker;
use Parser\Utils\OutPut;
use Utils\Utils;

class Relation
{
    public static function getCallee($aAllClass,$aAllMethod,$sCallerClass,$aMethodInfo,$obj,$function){
        $obj=trim($obj,"\\");
        if($obj=="this"||$obj=="self"||$obj=="static"){
            return $aAllClass[$sCallerClass]->nameSpace.
                $aAllClass[$sCallerClass]->class;
        }else{
            /**
             * {
            "methodName": "getStaticResult",
            "vars": {
            "o": "\\CalledClass"
            },
            "functions": null,
            "methodCalls": {
            "o": ["get"]
            }
             */
            if(empty($aMethodInfo->vars)){
                OutPut::error($obj);
                return $obj;
            }
            foreach ($aMethodInfo->vars as $var=>$class){
                if($var==$obj){
                    return self::findUsedClass($aAllClass,$sCallerClass,$class);
                }
            }
            OutPut::error($obj);
            return $obj;
        }
    }

    public static function getStaticCallee($aAllClass,$aAllMethod,$sCallerClass,$sCalleeClass,$function){
        $short=substr($sCalleeClass,1+strrpos($sCalleeClass,"\\"));
        if($short=="self" ||$short=="static"){
            OutPut::echo($aAllClass[$sCallerClass]->nameSpace);
            return $aAllClass[$sCallerClass]->nameSpace.
                $aAllClass[$sCallerClass]->class;
        }
        return self::findUsedClass($aAllClass,$sCallerClass,$sCalleeClass);
    }

    public static function findUsedClass($aAllClass,$sCallerClass,$sCalleeClass){
        $short=substr($sCalleeClass,1+strrpos($sCalleeClass,"\\"));
        if(empty($aAllClass[$sCallerClass])||empty($aAllClass[$sCallerClass]->uses)){
            return  $sCalleeClass;
        }

        foreach ($aAllClass[$sCallerClass]->uses as $aUse){
            if(!empty($aUse["as"]) && $aUse["as"]==$short){
                return $aUse["use"];
            }
        }

        foreach ($aAllClass[$sCallerClass]->uses as $aUse){
            if(!empty($aUse["use"]) && substr($aUse["use"],1+strrpos($aUse["use"],"\\"))==$short){
                return $aUse["use"];
            }
        }
        return $sCalleeClass;
    }
}