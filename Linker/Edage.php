<?php

namespace Linker;
class Edage
{
    public $callerClass;
    public $calleeClass;
    public $method;

    public function __construct($callerClass,$calleeClass,$method)
    {
         $this->callerClass=$callerClass;
         $this->calleeClass=$calleeClass;
         $this->method=$method;
    }

    public static function arrayUnique($aEdages){
        $aAll=[];
        foreach ($aEdages as $edage){
            $aAll[$edage->callerClass.$edage->calleeClass.$edage->method]=$edage;
        }
        return array_values($aAll);
    }
}