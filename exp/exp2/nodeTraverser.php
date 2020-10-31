<?php
/**
 * Created by PhpStorm.
 * Date: 20/10/16
 * Time: 19:39
 * @category Category
 * @package FileDirFileName
 * @author xiazemin <xiazemin@didichuxing.com>
 * @link ${link}
 */
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/visitor.php';
$fileName=__FILE__;

use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

$parser        = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
$traverser     = new NodeTraverser;
$prettyPrinter = new PrettyPrinter\Standard;

// 添加遍历者
$traverser->addVisitor(new MyNodeVisitor);

try {
    $code = file_get_contents($fileName);

    // parse
    $stmts = $parser->parse($code);

    // traverse
    $stmts = $traverser->traverse($stmts);

    // pretty print
    $code = $prettyPrinter->prettyPrintFile($stmts);

    echo $code;
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}