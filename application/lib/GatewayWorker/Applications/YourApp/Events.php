<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */

//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;

require_once "mysql/src/Connection.php";

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        // $port = $_SERVER['GATEWAY_PORT'];
        // Gateway::bindUid($client_id, $port);
        Gateway::sendToClient($client_id, json_encode(array(
            'type' => 'init',
            //'port' => $port,
            'client_id' => $client_id
        )));
    }

    /**
     * 当客户端发来消息时触发
     * @param $client_id
     * @param $message
     * @throws Exception
     */
    public static function onMessage($client_id, $message)
    {
        $info = json_decode($message);
        $type = $info['type'];
        if ($type == "bind") {
            $u_id = $info['u_id'];
            self::saveBind($client_id, $u_id);
        }


    }


    /**
     * 将用户信息和websocket绑定
     * @param $client_id
     * @param $u_id
     * @throws Exception
     */
    private static function saveBind($client_id, $u_id)
    {
        $db = new \Workerman\MySQL\Connection2('55a32a9887e03.gz.cdb.myqcloud.com',
            '16273', 'cdb_outerroot', 'Libo1234', 'carpooling');

        //修改状态
        $res = $db->update('car_user_t')
            ->cols(array(
                'client_id' => $client_id
            ))
            ->where('id=' . $u_id)
            ->query();

       // Gateway::sendToAll($res);
    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
        // 向所有人发送
        // GateWay::sendToAll("$client_id logout\r\n");
    }
}
