<?php
namespace  context;
class methodData
{
    public $methodName;

    public $vars; //map[var]class

    public $functions;  //list
    public $methodCalls; //map[var]callee

    public function __construct($methodName)
    {
        $this->methodName=$methodName;
    }
}