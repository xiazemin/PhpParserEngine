<?php
namespace Test;
require __DIR__."/CalledClass.php";
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use Called\CalledClass;

class Test{
    private $_property;
    public $property;
    public static $count;
    public static function getStaticResult(){
        self::$count=3;
        $o=new CalledClass();
        $o->get();
        return self::$count+1;
    }

    public function getResult(){
        CalledClass::getName();
        $a=$this->property;
        $b=$a+$this->property;
        $this->getStaticResult();
        array_keys(["a"=>"test class"]);
        return $b+self::getStaticResult();
    }
}