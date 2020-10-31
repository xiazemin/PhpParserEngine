<?php
namespace File\Scan;
class Dir
{
    public static function getAllFiles($path,$sufix=".php"){
        $aFiles=[];
        if(is_dir($path)){
            $dir =  scandir($path);
            foreach ($dir as $value){
                if($value == '.' || $value == '..'){
                    continue;
                }

                $sub_path =$path .'/'.$value;
                if(is_dir($sub_path)){
                    // echo '目录名:'.$value .'<br/>';
                    $aSubFiles=self::getAllFiles($sub_path,$sufix);
                    $aFiles=array_merge($aFiles,$aSubFiles);
                }else{
                    //.$path 可以省略，直接输出文件名
                    //echo ' 最底层文件: '.$path. ':'.$value.' <hr/>';
                    if(substr($value,-strlen($sufix))!=$sufix){
                        //echo "\n$value\n";
                        continue;
                    }
                    $aFiles[]=$path."/".$value;
                }
            }
        }else{
            echo "error,please input a path";
            return [];
        }
        return $aFiles;
    }

    public static function getDirTree($path){
        if(!is_dir($path)){
            return [];
        }
        $aFiles=[];
        $dir=scandir($path);
        foreach ($dir as $value){
            if($value=='.' || $value=='..'){
                continue;
            }
            $sub_path =$path .'/'.$value;

            $sShortPath=trim(strrchr($path, '/'),'/');//substr($path,0,strpos($path, "/"));
            if(is_dir($sub_path)){
                $aFiles[$sShortPath][]=self::getDirTree($sub_path);
            }else{
                $aFiles[$sShortPath][]=$value;
            }
        }
        return  $aFiles;
    }

}