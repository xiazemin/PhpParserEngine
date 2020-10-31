<?php
namespace Demo\ClassB;
use Demo\ClassC\ClassC1;
use Demo\ClassC\ClassC2;
class ClassB1
{
    public static function CallB11(){
        ClassC1::CallC11();
    }
    public static function CallB12(){
        ClassC1::CallC12();
        ClassC2::CallC21();
        ClassC2::CallC22();
    }
    public function CallB13(){
        ClassC1::CallC12();
        ClassC2::CallC21();
    }

}