<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019/1/4
 * Time: 6:54 PM
 */

namespace app\api\model;


use app\lib\enum\CommonEnum;
use think\Model;

class OrderV extends Model
{
    /**
     * 获取待匹配当前用户可以匹配用户
     * @param $u_id
     * @param $count
     * @param $female
     * @param $gender
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getReadyList($u_id, $count, $female, $gender, $refuse_ids)
    {
        $order_effective_time = config('setting.select_effective_time');
        $time_now = date("Y-m-d H:i:s");
        //$time_end = addTime($order_effective_time, $time_now, "minute");
        $time_begin = reduceTime($order_effective_time, $time_now, "minute");
        $list = self::where('state', CommonEnum::READY)
            ->where('u_id', '<>', $u_id)
            ->where(function ($query) use ($refuse_ids) {
                if (strlen($refuse_ids)) {
                    $query->where('id', 'not in', $refuse_ids);
                }
            })
            ->where(function ($query) use ($count) {
                if ($count == 2) {
                    $query->where('count', '=', 1);
                }
            })
            ->where(function ($query) use ($female, $gender) {
                if ($female == 1) {
                    $query->where('gender', '=', 2);
                } else {
                    if ($gender == 1) {
                        $query->where('female', '<>', 1);

                    }

                }
            })
            ->where('create_time', '>', $time_begin)
            ->select();
        return $list;

    }

    /**
     * 获取有效的订单进行匹配
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getEffectiveOrder()
    {
        $order_effective_time = config('setting.order_effective_time');
        $time_end = date("Y-m-d H:i:s");
        $time_begin = addTime($order_effective_time, $time_end, "minute");
        $list = self::where('state', CommonEnum::READY)
            ->whereBetweenTime('create_time', $time_begin, $time_end)
            ->select();
        return $list;

    }


}