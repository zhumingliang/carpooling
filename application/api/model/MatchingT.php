<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019/1/4
 * Time: 11:24 PM
 */

namespace app\api\model;


use think\Model;

class MatchingT extends Model
{
    /**
     * 获取拒绝用户或者未处理用户请求的数据
     * @param $o_id
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getRefuse($o_id)
    {
        $limit_time = addTime(1, date("Y-m-d H:i:s"), "minute");
        $sql = "(state =3) OR (state = 1 AND create_time < " . $limit_time . ")";
        $list = self::where('o_id', $o_id)
            ->whereRaw($sql)
            ->field('select_o_id')
            ->select()->toArray();
        $ids = implode(',', $list);
        return $ids;

    }

}