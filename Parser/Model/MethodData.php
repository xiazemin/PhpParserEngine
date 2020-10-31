<?php
namespace Parser\Model;
class MethodData
{
    public $methodName;
    public $startLine;
    public $comment;

    public $vars; //map[var]class

    public $functions;  //list
    public $methodCalls; //map[var]callee list
    public $staticCalls;//map[class]callee list

    public function __construct($methodName,$startLine,$comment)
    {
        $this->methodName = $methodName;
        $this->startLine=$startLine;
        $this->comment=$comment;
    }
}
