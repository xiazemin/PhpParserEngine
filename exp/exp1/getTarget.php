<?php
/**
 * Created by PhpStorm.
 * Date: 20/10/16
 * Time: 19:37
 * @category Category
 * @package FileDirFileName
 * @author xiazemin <xiazemin@didichuxing.com>
 * @link ${link}
 */

require __DIR__ . '/../../vendor/autoload.php';

use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

$code = "<?php echo 'Hi ', hi\\getTarget();";

$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
$prettyPrinter = new PrettyPrinter\Standard;

try {
    // 解析成AST
    $stmts = $parser->parse($code);

    // 重构
    $stmts[0]         // echo 语句
    ->exprs     // 子表达式
    [0]         // 第一个元素，即字符串
    ->value     // 字符串的值，也就是 'Hi '
        = 'Hello '; // 修改它

    // 生成重构后的代码
    $code = $prettyPrinter->prettyPrint($stmts);

    echo $code;
} catch (Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}