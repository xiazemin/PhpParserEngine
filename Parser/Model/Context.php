<?php
namespace Parser\Model;
class Context
{
    public static $fileName;
    public static $namespace;
    public static $uses; //use=> as=>
    public static $class;
    public static $method;

    public static $classInfo;  //map[classname]classInfo
    public static $functionInfo; //map[className][functionName]functionInfo

    public static function Init($fileName){
        self::$fileName=$fileName;
        self::$namespace=null;
        self::$uses=null;
        self::$class=null;
        self::$method=null;

        self::$classInfo=null;
        self::$functionInfo=null;
    }
}
