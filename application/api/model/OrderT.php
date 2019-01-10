<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019/1/4
 * Time: 10:16 AM
 */

namespace app\api\model;


use app\lib\enum\CommonEnum;
use think\Model;

class OrderT extends Model
{
    public static function getEffective($u_id)
    {
        $order_effective_time = config('setting.order_effective_time');
        $time_now = date("Y-m-d H:i:s");
        $time_begin = reduceTime($order_effective_time, $time_now, "minute");
        $order = self::where('state', CommonEnum::READY)
            ->where('u_id', $u_id)
            ->where('create_time', '>', $time_begin)
            ->order('create_time desc')
            ->find()->toArray();

        return $order;
    }

}