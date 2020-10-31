<?php
namespace Parser\Utils;
class Utils
{

    /*
     *   "comments": [
            {
                "nodeType": "Comment_Doc",
                "text": "/**
                      @Desc:
                      @param mixed[]
     */
    public static function getCommentText($comments){
        if(empty($comments)){
            return "empty comments";
        }

        $sComments="";
        foreach ($comments as $comment){
            $sComments.=$comment->getText();
            OutPut::echo([is_array($comment),is_object($comment),$comment->getText()]);
        }
        return $sComments;
    }

    public static function buildParts($aParts){
        if(empty($aParts)){
            return '';
        }
        $s="";
        for($i=0;$i<count($aParts);$i++){
            $s=$s."\\".$aParts[$i];
        }
        return $s;
    }

    /**
    {
    "nodeType": "Expr_MethodCall",
    "var": {
    "nodeType": "Expr_MethodCall",
    "var": {
    "nodeType": "Expr_Variable",
    "name": "oStepRuntime",
    "attributes": {
    "startLine": 39,
    "endLine": 39
    }
    },
    "name": {
    "nodeType": "Identifier",
    "name": "getInputSource",
    "attributes": {
    "startLine": 39,
    "endLine": 39
    }
    },
    "args": [],
    "attributes": {
    "startLine": 39,
    "endLine": 39
    }
    },
    "name": {
    "nodeType": "Identifier",
    "name": "getRawRequest",
    "attributes": {
    "startLine": 39,
    "endLine": 39
    }
    },
    "args": [],
    "attributes": {
    "startLine": 39,
    "endLine": 39
    }
    }
     */
    public static function buildCallList($var){
        if(empty($var)){
            return "null";
        }
        if(empty($var->var)){
            if(empty($var->name->name)){
                return $var->name;
            }
            //{"nodeType":"Expr_StaticPropertyFetch","class":{"nodeType":"Name","parts":["self"],
            //"attributes":{"startLine":29,"endLine":29}},"name":{"nodeType":"VarLikeIdentifier",
            //"name":"_oOrderSystemRpc","attributes":{"startLine":29,"endLine":29}},"attributes":
            //{"startLine":29,"endLine":29}}
            return $var->name->name;
        }
        OutPut::echo($var);
        if(!empty($var->name->name)){
            return self::buildCallList($var->var)."->".$var->name->name;
        }
        if(!empty($var->dim->name->name)){
            return self::buildCallList($var->var)."->".$var->dim->name->name;
        }
        return self::buildCallList($var->var)."->".$var->name;
    }

    public static function replaceDotSlash($s){
        if(empty($s)){
            return  "nil";
        }
        //replace .
        $s=str_replace(".","_",$s);
        return str_replace("\\","_",$s);
    }

}