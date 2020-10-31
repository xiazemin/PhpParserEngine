<?php

namespace Linker;
class Edage
{
    public $callerClass;
    public $callerMethod;
    public $calleeClass;
    public $calleeMethod;

    public $method;

    public function __construct($callerClass,$callerMethod,$calleeClass,$calleeMethod,$method)
    {
         $this->callerClass=$callerClass;
         $this->callerMethod=$callerMethod;
         $this->calleeClass=$calleeClass;
         $this->calleeMethod=$calleeMethod;
         $this->method=$method;
    }

    public static function arrayUnique($aEdages){
        $aAll=[];
        foreach ($aEdages as $edage){
            $aAll[$edage->callerClass.
            $edage->callerMethod.
            $edage->calleeClass.
            $edage->calleeMethod.
            $edage->method]=$edage;
        }
        return array_values($aAll);
    }
}