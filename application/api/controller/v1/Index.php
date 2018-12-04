<?php

namespace app\api\controller\v1;

class Index
{
    public function index()
    {
       echo phpinfo();
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
