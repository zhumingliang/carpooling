<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019/1/4
 * Time: 9:49 AM
 */

namespace app\api\service;


use app\api\model\MatchingT;
use app\api\model\OrderT;
use app\api\model\OrderV;
use app\lib\exception\OperationException;
use app\lib\exception\OrderException;
use GatewayClient\Gateway;
use think\Db;
use think\Exception;

class OrderService
{
    /**
     * 保存拼车申请
     * @param $params
     * @throws OperationException
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function save($params)
    {
        $res = OrderT::create($params);
        if (!$res) {
            throw new OperationException();
        }
        $client_id = "";
        $this->pushWithUser($res->id, $params['count'], $client_id, $params['female'],
            $params['current_latitude'], $params['current_longitude'],
            $params['dis_latitude'], $params['dis_longitude']);


    }

    /**
     * 用户选择了一个用户
     * @param $params
     * @throws OperationException
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     */
    public function selectUser($params)
    {
        $this->checkUserSelected($params['select_o_id']);
        $res = MatchingT::create($params);
        if (!$res) {
            throw new OperationException();
        }
        $info = [
            'nickName' => Token::getCurrentTokenVar('nickName'),
            'avatarUrl' => Token::getCurrentTokenVar('avatarUrl'),
            'id' => $res->id
        ];
        $client_id = "";
        $this->pushToSelecter($client_id, $info);

    }

    public function receiveSelect($id, $type)
    {
        Db::startTrans();
        try {
           $res= MatchingT::update(['state' => $type], ['id' => $id]);
            if (!$res) {
                Db::rollback();
                throw new OperationException(
                    [
                        'code' => 401,
                        'msg' => '修改状态失败',
                        'errorCode' => 50003
                    ]
                );

            }
            if ($type==2){
                $order_res= OrderT::update(['state' => $type], ['id' => $res->o_id]);
                if (!$order_res) {
                    Db::rollback();
                    throw new OperationException(
                        [
                            'code' => 401,
                            'msg' => '修改状态失败',
                            'errorCode' => 50004
                        ]
                    );

                }
            }
            Db::commit();
        } catch (Exception $e) {
            Db::rollback();
            throw $e;
        }


    }


    /**
     * 检测被选择用户是否可以被匹配
     * @param $select_o_id
     * @throws OrderException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function checkUserSelected($select_o_id)
    {
        //1.等待匹配
        //2.取消匹配
        //3.匹配中
        //4.已经匹配
        $order = OrderT::where('id', $select_o_id)->field('state')->find();
        if ($order->state == 2) {
            throw new OrderException(
                [
                    'code' => 401,
                    'msg' => '匹配失败，该用户已取消拼车请求',
                    'errorCode' => 50002
                ]
            );
        }
        if ($order->state == 3 || MatchingT::getEffect($select_o_id)) {
            throw new OrderException();
        }

    }

    /**
     * 推送给被选择用户
     * @param $info
     * @param $client_id
     */
    private function pushToSelecter($info, $client_id)
    {
        Gateway::sendToClient($client_id, json_encode($info));

    }

    /**
     *向用户推荐数据
     * @param $o_id
     * @param $count
     * @param $client_id
     * @param $female
     * @param $current_latitude
     * @param $current_longitude
     * @param $dis_latitude
     * @param $dis_longitude
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function pushWithUser($o_id, $count, $client_id, $female, $current_latitude, $current_longitude,
                                 $dis_latitude, $dis_longitude)
    {
        $u_id = Token::getCurrentUid();
        $gender = Token::getCurrentTokenVar('gender');
        $refuse_ids = MatchingT::getRefuse($o_id);
        $all = OrderV::getReadyList($u_id, $count, $female, $gender, $refuse_ids);
        $pre_order = $this->prefixInfoForDistance($current_latitude, $current_longitude,
            $dis_latitude, $dis_longitude, $all);
        $return_info = [
            'type' => 'push',
            'o_id' => $o_id,
            'recommend' => $pre_order
        ];
        if (count($pre_order)) {
            Gateway::sendToClient($client_id, json_encode($return_info));
        }

    }

    /**
     * 匹配起始距离获取推送数据
     * @param $current_latitude
     * @param $current_longitude
     * @param $dis_latitude
     * @param $dis_longitude
     * @param $all
     * @return array
     */
    private function prefixInfoForDistance($current_latitude, $current_longitude,
                                           $dis_latitude, $dis_longitude, $all)
    {
        $arr = array();
        $ori = config('setting.des_distance');
        $des = config('setting.des_distance');
        $push_count = config('setting.push_count');
        foreach ($all as $k => $v) {
            $lat1 = $v['current_latitude'];
            $lng1 = $v['current_longitude'];
            $lat2 = $v['dis_latitude'];
            $lng2 = $v['dis_longitude'];
            if ($ori < $this->getDistance($lat1, $lng1, $current_latitude, $current_longitude)) {
                continue;
            }
            $dis = $this->getDistance($lat2, $lng2, $dis_latitude, $dis_longitude);
            if ($des < $dis) {
                continue;
            }
            $all[$k]['distance'] = $dis;
            array_push($arr, $all[$k]);
            if (count($arr) == $push_count) {
                break;
            }
        }
        return $arr;


    }

    /**
     * 获取两点之间的距离
     * @param $lat1
     * @param $lng1
     * @param $lat2
     * @param $lng2
     * @return float
     */
    private function getDistance($lat1, $lng1, $lat2, $lng2)
    {
        //将角度转为狐度
        $radLat1 = deg2rad($lat1);//deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6371;
        return round($s, 1);


    }
}