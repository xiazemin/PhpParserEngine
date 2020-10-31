<?php
namespace Parser\Visitor;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

use Parser\Model\Context;
use Parser\Utils\Utils;
use Parser\Utils\OutPut;
use Hook\Add\LocalVariable;
class MethodVisitor extends NodeVisitorAbstract
{
    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Expr\Assign) {
            if ($node->var instanceof Node\Expr\StaticPropertyFetch) {
                OutPut::echo("function StaticPropertyFetch Call");
                OutPut::echo($node->var->name->name);

            }
        }

        if ($node instanceof Node\Expr\StaticCall) {
            OutPut::echo("function StaticCall Call");
            OutPut::echo($node->class->parts);
            OutPut::echo($node->name->name);
            Context::$functionInfo[Context::$class][Context::$method]->staticCalls
            [Utils::buildParts($node->class->parts)][]= $node->name->name;
        } elseif ($node instanceof Node\Expr\FuncCall) {
            OutPut::echo("function FuncCall Call");
            //{"nodeType":"Expr_FuncCall","name":{"nodeType":"Name","parts":["array_keys"],
            //"attributes":{"startLine":24,"endLine":24}},"args":[{"nodeType":"Arg","value":
            //{"nodeType":"Expr_Array","items":[{"nodeType":"Expr_ArrayItem","key":
            //{"nodeType":"Scalar_String","value":"a","attributes":{"startLine":24,"endLine":24,"kind":2}},
            //"value":{"nodeType":"Scalar_String","value":"test class","attributes":
            //{"startLine":24,"endLine":24,"kind":2}},"byRef":false,"attributes":{"startLine":24,"endLine":24}}],
            //"attributes":{"startLine":24,"endLine":24,"kind":2}},"byRef":false,"unpack":false,"attributes":
            //{"startLine":24,"endLine":24}}],"attributes":{"startLine":24,"endLine":24}}
            OutPut::echo($node->name->parts);
            Context::$functionInfo[Context::$class][Context::$method]->functions[] = Utils::buildParts($node->name->parts);
        } elseif ($node instanceof Node\Expr\MethodCall) {
            OutPut::echo("function methodCall");
            //OutPut::echo($node->var->name);
            OutPut::echo($node->name->name);
            if(empty(Context::$method)||empty(Context::$class)){
                OutPut::error([Context::$class,Context::$method,$node]);
            }else {
                Context::$functionInfo[Context::$class]
                [Context::$method]->methodCalls
                [Utils::buildCallList($node->var)][]
                    = $node->name->name;
            }
        } else if ($node instanceof Node\Expr\Assign) {
            if ($node->expr instanceof Node\Expr\New_) {
                //{"nodeType":"Expr_Assign","var":{"nodeType":"Expr_Variable","name":"o","attributes":
                //{"startLine":14,"endLine":14}},"expr":{"nodeType":"Expr_New","class":
                //{"nodeType":"Name","parts":["CalledClass"],"attributes":{"startLine":14,"endLine":14}},
                //"args":[],"attributes":{"startLine":14,"endLine":14}},"attributes":{"startLine":14,"endLine":14}}
                //echo json_encode($node->expr);
                if(empty($node->expr->class->parts)){
                    OutPut::echo($node->expr);
                    Context::$functionInfo[Context::$class][Context::$method]->vars[Utils::buildCallList($node->var)] =
                        $node->expr->class->name;
                }else {
                    OutPut::echo($node->var);
                    Context::$functionInfo[Context::$class][Context::$method]->vars[Utils::buildCallList($node->var)] =
                        Utils::buildParts($node->expr->class->parts);
                }
            } else {
                //echo json_encode($node);
            }
        }
        LocalVariable::addLocalVariable($node);
    }
}