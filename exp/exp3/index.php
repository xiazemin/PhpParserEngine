<?php
/**
 * Created by PhpStorm.
 * Date: 20/10/16
 * Time: 19:54
 * @category Category
 * @package FileDirFileName
 * @author xiazemin <xiazemin@didichuxing.com>
 * @link ${link}
 */
require __DIR__ . '/../../vendor/autoload.php';

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

class MyMethodVisitor extends NodeVisitorAbstract {
    public $foundMethods;

    public function leaveNode(Node $node) {
        if ($node instanceof Node\Expr\MethodCall) {
            $this->foundMethods[] = $node->name;
        }
    }
}

class MyCaseMethodVisitor extends NodeVisitorAbstract {
    protected $caseValue;
    protected $methodVisitor;
    protected $traverser;

    public function __construct($caseValue, $methodVisitor) {
        $this->caseValue = $caseValue;
        $this->methodVisitor = $methodVisitor;
        $this->traverser = new NodeTraverser;
        $this->traverser->addVisitor($this->methodVisitor);
    }

    public function leaveNode(Node $node) {
        if ($node instanceof Node\Stmt\Case_
            && $node->cond instanceof Node\Scalar\String_
            && $node->cond->value === $this->caseValue
        ) {
            $this->traverser->traverse($node->stmts);
        }
    }

    public function getFoundMethods() {
        return $this->methodVisitor->foundMethods;
    }
}

$code = <<<EOF
<?php
class Demo {
    public function index(){
        switch (\$type) {
            case 'simple':
                \$this->_indexSimple();
                break;

            case 'verbose':
                \$this->_indexVerbose();
                break;

            case 'default':
                throw new Exception("unknown type.");
        }
    }
}
EOF;

$parser = (new ParserFactory)->create(ParserFactory::ONLY_PHP5);
$traverser = new NodeTraverser;
$visitor = new MyCaseMethodVisitor('verbose', new MyMethodVisitor); // 遍历出 case 是 'verbose' 的时候对应调用的私有方法
$traverser->addVisitor($visitor);

try {
    $nodes = $parser->parse($code);
    $traverser->traverse($nodes);
    var_dump($visitor->getFoundMethods());
} catch (Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}