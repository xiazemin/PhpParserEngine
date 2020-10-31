<?php
namespace Parser\Visitor;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

use Parser\Model\Context;
use Parser\Model\ClassData;
use Parser\Model\MethodData;
use Parser\Utils\Utils;
use Parser\Utils\OutPut;
use Hook\Add\ClassProperty;

class ClassVisitor extends NodeVisitorAbstract
{
    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Stmt\Namespace_){
            OutPut::echo("class namespace declare");
            //{"nodeType":"Stmt_Namespace","name":{"nodeType":"Name","parts":["Test"],
            Context::$namespace=Utils::buildParts($node->name->parts);
            OutPut::echo($node->name->parts);
        }elseif ($node instanceof Node\Stmt\Use_) {
            OutPut::echo("class use declare");
            /*
             * {"nodeType":"Stmt_Use","type":1,"uses":
             * [{"nodeType":"Stmt_UseUse","type":0,"name":
             * {"nodeType":"Name","parts":["PhpParser","Node"],
             * "attributes":{"startLine":3,"endLine":3}},"alias":null,
             * "attributes":{"startLine":3,"endLine":3}}],
             * "attributes":{"startLine":3,"endLine":3}}
             */
            foreach ($node->uses as $use) {
                if ($use instanceof Node\Stmt\UseUse) {
                    $as=null;
                    if(!empty($use->alias)){
                       $as=$use->alias->name;
                    }

                    Context::$uses[]=[
                        'use'=>Utils::buildParts($use->name->parts),
                        'as'=>$as,
                    ];
                    OutPut::echo($use->name->parts);
                    OutPut::echo($use->alias);
                }
            }
        }elseif($node instanceof Node\Stmt\Class_){
            OutPut::echo("class declare");
            Context::$class=Context::$namespace."\\".$node->name->name;
            Context::$classInfo[Context::$class]=new ClassData(
                Context::$fileName,
                Context::$namespace,
                Context::$class,
                Context::$uses
            );
            OutPut::echo($node->name->name);
        }else if ($node instanceof Node\Stmt\ClassMethod ) {
            //静态后动态方法都走这里
            OutPut::echo("class method declare");
            OutPut::echo($node->name->name);
            Context::$method=$node->name->name;
            if(empty(Context::$classInfo[Context::$class])){
                OutPut::error(Context::$class);
            }else{
                Context::$classInfo[Context::$class]->setMethod($node->name->name);
            }
            if(empty( Context::$functionInfo[Context::$class][Context::$method])) {
                OutPut::echo($node);
                Context::$functionInfo[Context::$class][Context::$method] =
                    new methodData(Context::$method,$node->getStartLine(),
                        Utils::getCommentText($node->getComments()));
            }
        }elseif($node instanceof Node\Stmt\StaticVar){
            //echo "\nclass Property declare:\n";
            //echo json_encode($node);
        }elseif($node instanceof Node\Stmt\Property){
            //echo "\nclass Property declare:\n";
            //{"nodeType":"Stmt_Property","flags":1,"props":
            //[{"nodeType":"Stmt_PropertyProperty","name":
            //{"nodeType":"VarLikeIdentifier","name":"property","attributes":{"startLine":8,"endLine":8}},
            //"default":null,"attributes":{"startLine":8,"endLine":8}}],"attributes":{"startLine":8,"endLine":8}}
            //echo json_encode($node);
        }elseif($node instanceof Node\Stmt\PropertyProperty){
            OutPut::echo("class PropertyProperty declare");
            OutPut::echo($node->name->name);
            Context::$classInfo[Context::$class]->setProperty($node->name->name);
            ClassProperty::addProperty($node);
        }else{
            //echo "\n not recognize \n";
            // echo json_encode($node);
        }
    }
}