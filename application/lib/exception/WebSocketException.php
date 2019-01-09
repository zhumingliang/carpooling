<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019/1/9
 * Time: 12:43 AM
 */

namespace app\lib\exception;


class WebSocketException extends BaseException
{

    public $code = 401;
    public $msg = 'websocket连接已断开，请重新连接';
    public $errorCode = 10001;

}