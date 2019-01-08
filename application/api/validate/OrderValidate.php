<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2019/1/4
 * Time: 9:50 AM
 */

namespace app\api\validate;


class OrderValidate extends BaseValidate
{
    protected $rule = [
        'current_location' => 'require|isNotEmpty',
        'destination' => 'require|isNotEmpty',
        'current_longitude' => 'require|isNotEmpty',
        'current_latitude' => 'require|isNotEmpty',
        'dis_longitude' => 'require|isNotEmpty',
        'dis_latitude' => 'require|isNotEmpty',
        'count' => 'require|in:1,2',
        'female' => 'require|in:1,2',
        'o_id' => 'require',
        'select_o_id' => 'require',
        'select_u_id' => 'require',
    ];
    protected $scene = [
        'save' => ['current_location', 'destination', 'current_longitude',
            'current_latitude', 'dis_longitude', 'dis_latitude', 'count', 'female'],
        'circle_list_mini' => ['province', 'city', 'area', 'page', 'size', 'c_id'],
        'select' => ['o_id', 'select_o_id', 'select_u_id'],
    ];

}