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
     * @api {POST} /api/v1/order/save  4—用户发起拼车请求
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  用户发起拼车请求
     * @apiExample {post}  请求样例:
     *    {
     *       "current_location": "广州白云机场",
     *       "destination": "嘉禾小区",
     *       "current_longitude": 1212.323,
     *       "current_latitude": "31312.212",
     *       "dis_longitude": "213121",
     *       "dis_latitude": "2112",
     *       "count": 1,
     *       "female": 1
     *     }
     * @apiParam (请求参数说明) {String} current_location 当前位置
     * @apiParam (请求参数说明) {String} destination  目的地
     * @apiParam (请求参数说明) {String} current_longitude  当前经度
     * @apiParam (请求参数说明) {String} current_latitude   当前维度
     * @apiParam (请求参数说明) {String} dis_longitude   目的地经度
     * @apiParam (请求参数说明) {String} dis_latitude   目的地纬度
     * @apiParam (请求参数说明) {int} count   拼车人数 :1 | 2
     * @apiParam (请求参数说明) {int} female   是否要求女性拼车：1 | 是；2 | 否
     * @apiSuccessExample {json} 返回样例:
     * {"msg":"ok","errorCode":0}
     * @apiSuccess (返回参数说明) {int} error_code 错误代码 0 表示没有错误
     * @apiSuccess (返回参数说明) {String} msg 操作结果描述
     *
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
     * @api {POST} /api/v1/select/user  5-选择一个用户并推送拼车消息
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  发起拼车请求用户选择一个推送用户并推送至被选择用户
     * @apiExample {post}  请求样例:
     *    {
     *       "o_id": 1,
     *       "select_o_id": 2,
     *       "select_u_id": 2
     *     }
     * @apiParam (请求参数说明) {int} o_id 发起者订单id
     * @apiParam (请求参数说明) {int} select_o_id  被选择者订单id
     * @apiParam (请求参数说明) {int} select_u_id   被选择者id
     *
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
     * @api {POST} /api/v1/select/receive  6—用户接受拼车请求并处理
     * @apiGroup  CMS
     * @apiVersion 1.0.1
     * @apiDescription  用户发起拼车请求
     * @apiExample {post}  请求样例:
     *    {
     *       "m_id": "",
     *       "type": 2
     *     }
     * @apiParam (请求参数说明) {int} m_id 拼车匹配id:由webSocket推送返回
     * @apiParam (请求参数说明) {int} type 操作类别： 2 | 匹配成功；3 |  拒绝
     * @apiSuccessExample {json} 返回样例:
     * {"msg":"ok","errorCode":0}
     * @apiSuccess (返回参数说明) {int} error_code 错误代码 0 表示没有错误
     * @apiSuccess (返回参数说明) {String} msg 操作结果描述
     *
     * 接受被选择用户对于匹配请求的操作
     * @param $m_id
     * @param int $type
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function receiveSelect($m_id, $type = 2)
    {
        (new OrderService())->receiveSelect($m_id, $type);
        return json(new SuccessMessage());
    }

    public function matchingOrder()
    {
        (new OrderService())->matchingOrder();

    }


}