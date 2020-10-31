<?php
namespace Execute;
use File\Scan\Dir;
use Parser\FileParser;
use Linker\Linker;
use Render\Render;
use Linker\Edage;
use Hook\Filter\FunctionName;
use Hook\Filter\VariableName;

class Application
{
    public static function Parse($sDir,$sEntranceClass){
        $oParser=new FileParser();
        $aFiles=Dir::getAllFiles($sDir);

        //echo __DIR__;
        //die();
        //echo json_encode($aFiles);

        $aAllClass=[];
        $aAllMethod=[];
        foreach($aFiles as $f) {
            list($aClassInfo, $aMethodInfo) = $oParser->run($f);
            !empty($aClassInfo)&&$aAllClass+=$aClassInfo;
            !empty($aMethodInfo)&&$aAllMethod+=$aMethodInfo;
        }
       //echo json_encode([$aAllClass, $aAllMethod]);

        list($aEdages,$aClass,$aMethod)=Linker::linkClassToMethod($aAllClass,$aAllMethod,$sEntranceClass);
        //echo json_encode([$aEdages,$aClass,$aMethod]);
        echo json_encode([FunctionName::filter($aAllClass),VariableName::filter($aAllMethod)]);
        $sResult=Render::Rend(
            Edage::arrayUnique($aEdages),
            array_unique($aClass),
            array_unique($aMethod));

        $f=fopen(__DIR__."/render.dot","w");
        fwrite( $f,$sResult);
        fclose($f);
        shell_exec("dot -Tpng ".__DIR__."/render.dot"." -o ".__DIR__."/test.png");
        shell_exec("open ".__DIR__);
    }
}