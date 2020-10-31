<?php
/*
   digraph demo {
   label="示例"
   bgcolor="beige"

   node[color="grey"]

   father[label="爸爸", shape="box"]
   mother[label="妈妈", shape="box"]
   brother[label="哥哥", shape="circle"]
   sister[label="姐姐", shape="circle"]
   node[color="#FF6347"]
   strangers[label="路人"]

   edge[color="#FF6347"]

   father->mother[label="夫妻", dir="both"]
   father->brother[label="父子"]
   father->sister[label="父子"]
   father->我[label="父子"]

   mother->{brother,sister,我}[label="母子"]

   {rank=same; father, mother}
   {rank=same; brother,sister,我}
}
    */
namespace Render;
use Utils\Utils;
class Render
{
    public static function Rend($aEdages,$aClass,$aMethod)
    {
        $sGraph = "digraph demo {\n rankdir = LR;\n edge[color=\"#FF6347\"];\n%s \n}";
        $sClass=ClassRender::RendLinkedClass($aClass);
        $sMethod=MethodRender::RendLinkedMethod($aMethod);
        $sEdage=EdageRender::RendLinkedEdage($aEdages);
        $sMethod=EdageRender::renderMethod($aEdages);
        return sprintf($sGraph,$sClass.$sMethod.$sEdage.$sMethod);
    }
}