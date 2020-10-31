<?php
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use context\Context;
use context\classData;
use context\methodData;
use Utils\Utils;
class classVisitor extends NodeVisitorAbstract
{
    public function enterNode(Node $node)
    {
      if ($node instanceof Node\Stmt\Namespace_){
            echo "\nclass namespace declare:\n";
            //{"nodeType":"Stmt_Namespace","name":{"nodeType":"Name","parts":["Test"],
            Context::$namespace=Utils::buildParts($node->name->parts);
            echo json_encode($node->name->parts);
        }elseif ($node instanceof Node\Stmt\Use_) {
            echo "\nclass use declare:\n";
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
                    Context::$uses[]=[
                        'use'=>Utils::buildParts($use->name->parts),
                        'as'=>$use->alias,
                    ];
                    echo json_encode($use->name->parts);
                    echo json_encode($use->alias);
                }
            }
        }elseif($node instanceof Node\Stmt\Class_){
           echo "\nclass declare:\n";
           Context::$class=Context::$namespace."\\".$node->name->name;
           Context::$classInfo[Context::$class]=new classData(
               "file",
               Context::$namespace,
               Context::$class,
               Context::$uses
           );

           echo json_encode($node->name->name);
        }else if ($node instanceof Node\Stmt\ClassMethod ) {
            //静态后动态方法都走这里
            echo "\nclass method declare:\n";
            echo json_encode($node->name->name);
          Context::$method=$node->name->name;
          Context::$classInfo[Context::$class]->setMethod($node->name->name);
          if(empty( Context::$functionInfo[Context::$class][Context::$method])) {
              Context::$functionInfo[Context::$class][Context::$method] = new methodData(Context::$method);
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
          echo "\nclass PropertyProperty declare:\n";
          echo json_encode($node->name->name);
          Context::$classInfo[Context::$class]->setProperty($node->name->name);
      }else{
            //echo "\n not recognize \n";
           // echo json_encode($node);
        }
    }
}