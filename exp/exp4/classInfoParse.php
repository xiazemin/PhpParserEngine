<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/visitor/classVisitor.php';
require __DIR__ . '/visitor/methodVisitor.php';

require __DIR__.'/context/Context.php';

require __DIR__."/utils/Utils.php";

$fileName= __DIR__ . '/test/test_class.php';

use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;
use context\Context;

$parser        = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
$traverser     = new NodeTraverser;
$prettyPrinter = new PrettyPrinter\Standard;

// 添加遍历者
$traverser->addVisitor(new classVisitor);
$traverser->addVisitor(new methodVisitor);

try {
    $code = file_get_contents($fileName);

    // parse
    $stmts = $parser->parse($code);

    // traverse
    $stmts = $traverser->traverse($stmts);

    // pretty print
    $code = $prettyPrinter->prettyPrintFile($stmts);
   echo json_encode(Context::$classInfo);
   echo json_encode( Context::$functionInfo);
    //echo $code;
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}
