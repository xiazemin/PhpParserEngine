<?php
namespace Hook\Add;
use Parser\Model\Context;
use Parser\Utils\Utils;

class LocalVariable
{
    public static function addLocalVariable($node){
       // Context::$functionInfo[Context::$class][Context::$method]->vars[Utils::buildCallList($node->var)] =
       //     Utils::buildParts($node->expr->class->parts);
    }

}