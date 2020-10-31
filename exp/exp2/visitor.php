<?php
/**
 * Created by PhpStorm.
 * Date: 20/10/16
 * Time: 19:40
 * @category Category
 * @package FileDirFileName
 * @author xiazemin <xiazemin@didichuxing.com>
 * @link ${link}
 */
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class MyNodeVisitor extends NodeVisitorAbstract
{
    public function leaveNode(Node $node) {
        if ($node instanceof Node\Scalar\String_) {
            $node->value = 'foo';
        }
    }
}