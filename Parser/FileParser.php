<?php
namespace Parser;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

use Parser\Model\Context;
use Parser\Visitor\ClassVisitor;
use Parser\Visitor\MethodVisitor;

class FileParser{
    public $parser;
    public $traverser;
    public $prettyPrinter;

    public function __construct()
    {
        $this->parser        = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $this->traverser     = new NodeTraverser;
        $this->prettyPrinter = new PrettyPrinter\Standard;

        // 添加遍历者
        $this->traverser->addVisitor(new ClassVisitor());
        $this->traverser->addVisitor(new MethodVisitor());
    }

    public function run($fileName){
        Context::Init($fileName);
        try {
            $code = file_get_contents($fileName);
            // parse
            $stmts = $this->parser->parse($code);
            // traverse
            $stmts = $this->traverser->traverse($stmts);
            // pretty print
            //$code = $this->prettyPrinter->prettyPrintFile($stmts);
            //echo json_encode(Context::$classInfo);
            //echo json_encode( Context::$functionInfo);
            //echo $code;
        } catch (PhpParser\Error $e) {
            echo 'Parse Error: ', $e->getMessage();
        }
        return [Context::$classInfo,Context::$functionInfo];
    }
}




