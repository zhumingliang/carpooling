<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019/1/5
 * Time: 11:41 PM
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 401;
    public $msg = '该用户已经匹配车友';
    public $errorCode = 50001;

}