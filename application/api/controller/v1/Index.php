<?php

namespace app\api\controller\v1;

class Index
{
    public function index()
    {
        $db = new \Workerman\MySQL\Connection('55a32a9887e03.gz.cdb.myqcloud.com',
            '16273', 'cdb_outerroot', 'Libo1234', 'carpooling');

        //修改状态
        $res= $db->update('car_user_t')
            ->cols(array(
                'client_id' => 1
            ))
            ->where('id=' . 1)
            ->query();
        echo $res;
       /* //将角度转为狐度
        $radLat1 = deg2rad("34.575935");//deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad("34.5698");
        $radLng1 = deg2rad("117.72722");
        $radLng2 = deg2rad("117.74313");
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6371;
        echo round($s, 1);*/
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
