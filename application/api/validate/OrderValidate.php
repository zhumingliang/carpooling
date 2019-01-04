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
    ];

}