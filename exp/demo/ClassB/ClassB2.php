<?php
namespace Demo\ClassB;
use Demo\ClassC\ClassC1;
use Demo\ClassC\ClassC2;

class ClassB2
{
    public static function CallB21(){
        ClassC1::CallC12();
        ClassC2::CallC21();
        ClassC2::CallC22();
    }
    public static function CallB22(){
        ClassC2::CallC21();
        ClassC2::CallC22();
    }
}