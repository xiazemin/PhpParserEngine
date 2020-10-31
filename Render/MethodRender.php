<?php
namespace Render;
use Parser\Utils\Utils;

class MethodRender
{
    public static function RendLinkedMethod($aMethod){
       $sMethod="";
        foreach ($aMethod as $method){
            $method=Utils::replaceDotSlash($method);
            //   father[label="爸爸", shape="box"]
            $sMethod.="\n".$method."[label=\"".$method."\", shape=\"box\"]\n";
        }
        return $sMethod;
    }

    public static function RendAllMethod($aMethodMap){
      foreach ($aMethodMap as $className => $aMethodInfo){
          foreach ($aMethodInfo as $method => $aMethodInfo){

          }
      }
    }
}