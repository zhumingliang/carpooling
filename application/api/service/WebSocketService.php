<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019/1/8
 * Time: 7:17 PM
 */

namespace app\api\service;


use app\api\model\UserT;
use GatewayClient\Gateway;

class WebSocketService
{
    /**
     * 获取用户client_id
     * @return int
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     */
    public static function getClientId()
    {
        $id = 1;//Token::getCurrentUid();
        $user = UserT::where('id', $id)->find();
        if (strlen($user->client_id)) {
            return self::checkClientIdOnline($user->client_id);
        }
        return 0;

    }

    private static function checkClientIdOnline($client_id)
    {
        $online = Gateway::isOnline($client_id);
        if ($online) {
            return $client_id;
        }
        return 0;


    }

}