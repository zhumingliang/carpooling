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

class OrderService
{
    public function save($params)
    {
        $res = OrderT::create($params);
        if (!$res) {
            throw new OperationException();
        }
        $this->pushWithUser($res->id,$params['count'],$params['female'],
            $params['current_latitude'],$params['current_longitude'],$params['dis_latitude'],$params['dis_longitude']);


    }

    /**
     *向用户推荐数据
     * @param $o_id
     * @param $count
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
    public function pushWithUser($o_id, $count, $female, $current_latitude, $current_longitude,
                                 $dis_latitude, $dis_longitude)
    {
        $u_id = Token::getCurrentUid();
        $gender = Token::getCurrentTokenVar('gender');
        $refuse_ids = MatchingT::getRefuse($o_id);
        $all = OrderV::getReadyList($u_id, $count, $female, $gender, $refuse_ids);
        $pre_order = $this->prefixInfoForDistance($current_latitude, $current_longitude,
            $dis_latitude, $dis_longitude, $all);

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
            if ($des < $this->getDistance($lat2, $lng2, $dis_latitude, $dis_longitude)) {
                continue;
            }

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