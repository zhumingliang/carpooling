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
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function save()
    {
        (new OrderValidate())->scene('save')->goCheck();
        $params = $this->getParams();
        (new OrderService())->save($params);
        return json(new SuccessMessage());

    }

    /**
     * 发起拼车请求用户选择一个推送用户并推送至被选择用户
     * @throws \app\lib\exception\OperationException
     * @throws \app\lib\exception\ParameterException
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     */
    public function selectUser()
    {
        (new OrderValidate())->scene('select')->goCheck();
        $params = $this->getParams();
        (new OrderService())->selectUser($params);

    }

    /**
     * 接受被选择用户对于匹配请求的操作
     * @param $id
     * @param int $type
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function receiveSelect($id, $type = 1)
    {
        (new OrderService())->receiveSelect($id, $type);
        return json(new SuccessMessage());
    }


}