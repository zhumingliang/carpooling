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
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $message)
    {
        try {

            Gateway::sendToAll("a");

            // 向所有人发送
            //接收客户端发送用户的u_id信息，并进行保存
            $u_id = $message;
            $res = self::saveBind($client_id, $u_id);
            Gateway::sendToAll($res);

        } catch (Exception $e) {
            $info = $e->getMessage();
            Gateway::sendToAll("$client_id said $info\r\n");

        }

    }


    private static function saveBind($client_id, $u_id)
    {
        $db = new \Workerman\MySQL\Connection('55a32a9887e03.gz.cdb.myqcloud.com',
            '16273', 'cdb_outerroot', 'Libo1234', 'carpooling');

        //修改状态
       $res= $db->update('car_user_t')
            ->cols(array(
                'client_id' => $client_id
            ))
            ->where('id=' . 1)
            ->query();
        return$res;
        /*   $db->insert('car_log_t')->cols(array(
               'create_time' => date("Y-m-d H:i:s", time()),
               'update_time' => date("Y-m-d H:i:s", time()),
               'msg' => "client_id" . $client_id . "   u_id:" . $u_id,
           ))->query();*/
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
