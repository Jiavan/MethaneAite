<?php
/**
 * Created by PhpStorm.
 * User: jiavan
 * Date: 15-7-22
 * Time: 下午10:59
 */

class test {

    public $b;
    /*function __construct(){
        $this->b = 2;
    }*/

    function test($b, $c){
        $this->b = 1;
        $b = 2;
        $c = 3;
        echo $this->b, $b, $c;
    }
}

$a = new test;
?>