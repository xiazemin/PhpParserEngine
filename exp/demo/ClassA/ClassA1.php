<?php
namespace Demo\ClassA;
use Demo\ClassB\ClassB1;
use Demo\ClassB\ClassB2;
use Demo\ClassC\ClassC2;

class ClassA1
{
    public static function CallA11(){
        ClassB1::CallB11();
        ClassB1::CallB12();
        $b1=new ClassB1();
        $b1->CallB13();
        $c2=new ClassC2();
        $c2->CallC21();
    }
    public static function CallA12(){
        ClassB1::CallB11();
        ClassB2::CallB22();
    }
}