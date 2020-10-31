<?php
namespace Linker;
use Parser\Utils\OutPut;

class Linker
{
    public static function linkMethodToClassMethod($aAllClass,$aAllMethod,$sClass,$sMethod){
       $aEdages=[];
       $aClass=[];
       $aMethod=[];
       if(empty($aAllMethod[$sClass])||empty($aAllMethod[$sClass][$sMethod])){
           return [$aEdages,$aClass,$aMethod];
       }

       $aMethodInfo=$aAllMethod[$sClass][$sMethod];
       if(!empty($aMethodInfo->methodCalls)){
               foreach ($aMethodInfo->methodCalls as $obj =>$function){
                   $Callee=Relation::getCallee($aAllClass,$aAllMethod,$sClass,$aMethodInfo,$obj,$function);
                   foreach ($function as $f) {
                       $aEdages[] = new Edage(
                           $sMethod,
                           $f,//$Callee,
                           "call"
                       );
                   }
                   $aClass[]=$Callee;
                   list($aSubEdages,$aSubClass,$aSubMethod)=self::linkClassToMethod($aAllClass,$aAllMethod,$Callee);
                   $aEdages=array_merge($aEdages,$aSubEdages);
                   $aClass=array_merge($aClass,$aSubClass);
                   $aMethod=array_merge($aMethod,$aSubMethod);
               }
       }

       if(!empty($aMethodInfo->staticCalls)){
           foreach ($aMethodInfo->staticCalls as $calleeClass =>$function){
               $Callee=Relation::getStaticCallee($aAllClass,$aAllMethod,$sClass,$calleeClass,$function);
               foreach ($function as $f) {
                   $aEdages[] = new Edage(
                       $sMethod,
                       $f,// $Callee,
                       "staticCall"
                   );
               }
               $aClass[]=$Callee;
               list($aSubEdages,$aSubClass,$aSubMethod)=self::linkClassToMethod($aAllClass,$aAllMethod,$Callee);
               $aEdages=array_merge($aEdages,$aSubEdages);
               $aClass=array_merge($aClass,$aSubClass);
               $aMethod=array_merge($aMethod,$aSubMethod);
           }
       }
        return [$aEdages,$aClass,$aMethod];
    }

    public static function linkClassToMethod($aAllClass,$aAllMethod,$sEntranceClass){
        $aEdages=[];
        $aClass=[];
        $aMethod=[];
        if(empty($aAllMethod[$sEntranceClass])){
            return [$aEdages,$aClass,$aMethod];
        }
        foreach ($aAllMethod[$sEntranceClass] as $sMethodName => $aMethodInfo){
            $aEdages[]=new Edage(
                $sEntranceClass,
                $sMethodName,
                "method"
            );
            list($aSubEdages,$aSubClass,$aSubMethod)=self::linkMethodToClassMethod($aAllClass,$aAllMethod,$sEntranceClass,$sMethodName);
            $aMethod[]=$sMethodName;//$sEntranceClass."::".$sMethodName;
            $aEdages=array_merge($aEdages,$aSubEdages);
            $aClass=array_merge($aClass,$aSubClass);
            $aMethod=array_merge($aMethod,$aSubMethod);
        }
        return [$aEdages,$aClass,$aMethod];
    }

}