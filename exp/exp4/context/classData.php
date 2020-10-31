<?php
namespace  context;
class classData
{
    public $file;
    public $nameSpace;
    public $class;

    public $uses;
    public $propertys;
    public $methods;

    public function __construct($file,$nameSpace,$class,$uses){
        $this->file=$file;
        $this->nameSpace=$nameSpace;
        $this->class=$class;
        $this->uses=$uses;
    }

    public function setProperty($property){
        $this->propertys[]=$property;
    }

    public function setMethod($method){
        $this->methods[]=$method;
    }
}