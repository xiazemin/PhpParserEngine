<?php
namespace Render;
use Parser\Utils\Utils;

class EdageRender
{
    public static function RendLinkedEdage($aEdages){
       $sEdage="";
        foreach ($aEdages as $aEdage){
            if ($aEdage->method=="method"){
                $sEdage.="edge[color=\"#FF6347\";style=\"solid\"];\n";

                $sEdage.=Utils::replaceDotSlash($aEdage->callerClass)."->".
                    Utils::replaceDotSlash($aEdage->calleeClass).Utils::replaceDotSlash($aEdage->calleeMethod)."[label=\"".
                    Utils::replaceDotSlash($aEdage->method)."\"]\n";
            }else{
                //father->我[label="父子"]
                if($aEdage->method=="staticCall"){
                    $sEdage.="edge[color=\"#0032FF\"];\n";
                }elseif($aEdage->method=="call"){
                    $sEdage.="edge[color=\"#00FF27\";style=\"dashed\"];\n";
                }
                $sEdage.=Utils::replaceDotSlash($aEdage->callerClass).Utils::replaceDotSlash($aEdage->callerMethod)."->".
                    Utils::replaceDotSlash($aEdage->calleeClass).Utils::replaceDotSlash($aEdage->calleeMethod)."[label=\"".
                    Utils::replaceDotSlash($aEdage->method)."\"]\n";
                $sEdage.="edge[color=\"#FF6347\";style=\"solid\"];\n";
            }
        }
        //$method=Utils::replaceDotSlash($method);
        return $sEdage;
    }

    public static function renderMethod($aEdages){
        $sEdage="";
        $aMethod=[];
        foreach ($aEdages as $aEdage){
            if ($aEdage->method=="method"){
                //.Utils::replaceDotSlash($aEdage->callerMethod) nil
                $aMethod[Utils::replaceDotSlash($aEdage->callerClass)][]=$aEdage;
            }
        }

        foreach ($aMethod as $caller => $aEdages){
            $sEdage.="edge[color=\"#002327\";style=\"dashed\"];\n";
            // struct1 [shape=record,label="<f0> left|<f1> middle|<f2> right"];
            //_Demo_ClassC_ClassC1 [shape=record, label="<CallC22> CallC22|<CallC22> CallC22"];
            // struct3 [shape=record,label="hello\nworld |{ b |{c|<here> d|e}| f}| g | h"];
            $aLables=[];
            foreach ($aEdages as $edage){
                $aLables[]="<".Utils::replaceDotSlash($edage->calleeClass).Utils::replaceDotSlash($edage->calleeMethod)."> ". Utils::replaceDotSlash($edage->calleeMethod);
            }
            $sLable=implode("|",$aLables);

            $sEdage.=Utils::replaceDotSlash($caller)." [shape=record, label=\"".Utils::replaceDotSlash($caller)." | { ".$sLable." }\"];\n";
        }
        $sEdage.="edge[color=\"#FF6347\";style=\"solid\"];\n";

        //$sEdage.=Utils::replaceDotSlash($aEdage->callerClass)."->".
        //    Utils::replaceDotSlash($aEdage->calleeClass)."[label=\"".
        //    Utils::replaceDotSlash($aEdage->method)."\"]\n";
       return $sEdage;
    }
}