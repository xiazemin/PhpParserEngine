<?php
namespace Render;
use Parser\Utils\Utils;

class ClassRender
{
    public static function RendLinkedClass($aClass){
        $sClass="";
      foreach ($aClass as $class){
          $class=Utils::replaceDotSlash($class);
          //   father[label="爸爸", shape="box"]
          //   sister[label="姐姐", shape="circle"]
          $sClass.="\n".$class."[label=\"".$class."\", shape=\"circle\"]\n";
      }
      return $sClass;
    }
    public static function RendAllClass($aClassMap){
        foreach ($aClassMap as $className => $aClassInfo){

        }
    }

}