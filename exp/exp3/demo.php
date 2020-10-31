<?php
/**
 * Created by PhpStorm.
 * Date: 20/10/16
 * Time: 19:53
 * @category Category
 * @package FileDirFileName
 * @author xiazemin <xiazemin@didichuxing.com>
 * @link ${link}
 */
class Demo {
    public function index(){
        // ...
        switch ($type) {
            case 'simple':
                $this->_indexSimple();
                break;

            case 'verbose':
                $this->_indexVerbose();
                break;

            default:
                throw new Exception("unknown type.");
        }
    }
}