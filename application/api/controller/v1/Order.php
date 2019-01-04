<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2018/12/5
 * Time: 1:15 AM
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\OrderService;
use app\api\validate\OrderValidate;
use app\lib\exception\SuccessMessage;

class Order extends BaseController
{
    /**
     * 用户发送拼车申请
     * @return \think\response\Json
     * @throws \app\lib\exception\OperationException
     * @throws \app\lib\exception\ParameterException
     */
    public function save()
    {
        (new OrderValidate())->goCheck();
        $params = $this->getParams();
        (new OrderService())->save($params);
        return json(new SuccessMessage());

    }




}