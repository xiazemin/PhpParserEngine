<?php
namespace  context;
require __DIR__.'/classData.php';
require __DIR__.'/methodData.php';
class Context
{
    public static $namespace;
    public static $uses; //use=> as=>
    public static $class;
    public static $method;

    public static $classInfo;  //map[classname]classInfo
    public static $functionInfo; //map[className][functionName]functionInfo
}