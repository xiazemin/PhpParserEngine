<?php
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use context\Context;
use context\methodData;
use Utils\Utils;

class methodVisitor extends NodeVisitorAbstract
{
    public function enterNode(Node $node)
    {
        if($node instanceof Node\Expr\Assign){
            if($node->var instanceof Node\Expr\StaticPropertyFetch){
                echo "\nfunction StaticPropertyFetch Call\n";
                echo $node->var->name->name;

            }
        }

        if ($node instanceof Node\Expr\StaticCall){
            echo "\nfunction StaticCall Call\n";
            echo json_encode($node->class->parts);
            echo json_encode($node->name->name);
            Context::$functionInfo[Context::$class][Context::$method]->methodCalls[Utils::buildParts($node->class->parts)]=$node->name->name;
        }elseif($node instanceof Node\Expr\FuncCall){
            echo "\nfunction FuncCall Call\n";
            //{"nodeType":"Expr_FuncCall","name":{"nodeType":"Name","parts":["array_keys"],
            //"attributes":{"startLine":24,"endLine":24}},"args":[{"nodeType":"Arg","value":
            //{"nodeType":"Expr_Array","items":[{"nodeType":"Expr_ArrayItem","key":
            //{"nodeType":"Scalar_String","value":"a","attributes":{"startLine":24,"endLine":24,"kind":2}},
            //"value":{"nodeType":"Scalar_String","value":"test class","attributes":
            //{"startLine":24,"endLine":24,"kind":2}},"byRef":false,"attributes":{"startLine":24,"endLine":24}}],
            //"attributes":{"startLine":24,"endLine":24,"kind":2}},"byRef":false,"unpack":false,"attributes":
            //{"startLine":24,"endLine":24}}],"attributes":{"startLine":24,"endLine":24}}
            echo json_encode($node->name->parts);
            Context::$functionInfo[Context::$class][Context::$method]->functions[]=Utils::buildParts($node->name->parts);
        }elseif($node instanceof Node\Expr\MethodCall) {
            echo "\nfunction methodCall\n";
            echo json_encode($node->var->name);
            echo json_encode($node->name->name);
            Context::$functionInfo[Context::$class][Context::$method]->methodCalls[$node->var->name]=$node->name->name;
        }else if($node instanceof Node\Expr\Assign ){
            if($node->expr instanceof Node\Expr\New_) {
                //{"nodeType":"Expr_Assign","var":{"nodeType":"Expr_Variable","name":"o","attributes":
                //{"startLine":14,"endLine":14}},"expr":{"nodeType":"Expr_New","class":
                //{"nodeType":"Name","parts":["CalledClass"],"attributes":{"startLine":14,"endLine":14}},
                //"args":[],"attributes":{"startLine":14,"endLine":14}},"attributes":{"startLine":14,"endLine":14}}
                //echo json_encode($node->expr);
                Context::$functionInfo[Context::$class][Context::$method]->vars[$node->var->name] = Utils::buildParts($node->expr->class->parts);
            }else{
                //echo json_encode($node);
            }
        }
    }
}