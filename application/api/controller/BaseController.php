<?php

namespace app\api\controller;


use app\lib\enum\CommonEnum;
use think\Controller;
use app\api\service\Token as TokenService;


class BaseController extends Controller
{

    public  function getParams()
    {
        $params = $this->request->param();
        $params['u_id'] = TokenService::getCurrentUid();
        $params['state'] = CommonEnum::READY;
    }


}