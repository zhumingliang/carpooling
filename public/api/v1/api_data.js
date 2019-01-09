define({ "api": [  {    "type": "POST",    "url": "/api/v1/order/save",    "title": "4—用户发起拼车请求",    "group": "CMS",    "version": "1.0.1",    "description": "<p>用户发起拼车请求</p>",    "examples": [      {        "title": "请求样例:",        "content": "{\n   \"current_location\": \"广州白云机场\",\n   \"destination\": \"嘉禾小区\",\n   \"current_longitude\": 1212.323,\n   \"current_latitude\": \"31312.212\",\n   \"dis_longitude\": \"213121\",\n   \"dis_latitude\": \"2112\",\n   \"count\": 1,\n   \"female\": 1\n }",        "type": "post"      }    ],    "parameter": {      "fields": {        "请求参数说明": [          {            "group": "请求参数说明",            "type": "String",            "optional": false,            "field": "current_location",            "description": "<p>当前位置</p>"          },          {            "group": "请求参数说明",            "type": "String",            "optional": false,            "field": "destination",            "description": "<p>目的地</p>"          },          {            "group": "请求参数说明",            "type": "String",            "optional": false,            "field": "current_longitude",            "description": "<p>当前经度</p>"          },          {            "group": "请求参数说明",            "type": "String",            "optional": false,            "field": "current_latitude",            "description": "<p>当前维度</p>"          },          {            "group": "请求参数说明",            "type": "String",            "optional": false,            "field": "dis_longitude",            "description": "<p>目的地经度</p>"          },          {            "group": "请求参数说明",            "type": "String",            "optional": false,            "field": "dis_latitude",            "description": "<p>目的地纬度</p>"          },          {            "group": "请求参数说明",            "type": "int",            "optional": false,            "field": "count",            "description": "<p>拼车人数 :1 | 2</p>"          },          {            "group": "请求参数说明",            "type": "int",            "optional": false,            "field": "female",            "description": "<p>是否要求女性拼车：1 | 是；2 | 否</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "返回样例:",          "content": "{\"msg\":\"ok\",\"errorCode\":0}",          "type": "json"        }      ],      "fields": {        "返回参数说明": [          {            "group": "返回参数说明",            "type": "int",            "optional": false,            "field": "error_code",            "description": "<p>错误代码 0 表示没有错误</p>"          },          {            "group": "返回参数说明",            "type": "String",            "optional": false,            "field": "msg",            "description": "<p>操作结果描述</p> <p>用户发送拼车申请</p>"          }        ]      }    },    "filename": "application/api/controller/v1/Order.php",    "groupTitle": "CMS",    "name": "PostApiV1OrderSave"  },  {    "type": "POST",    "url": "/api/v1/select/receive",    "title": "6—用户接受拼车请求并处理",    "group": "CMS",    "version": "1.0.1",    "description": "<p>用户发起拼车请求</p>",    "examples": [      {        "title": "请求样例:",        "content": "{\n   \"m_id\": \"\",\n   \"type\": 2\n }",        "type": "post"      }    ],    "parameter": {      "fields": {        "请求参数说明": [          {            "group": "请求参数说明",            "type": "int",            "optional": false,            "field": "m_id",            "description": "<p>拼车匹配id:由webSocket推送返回</p>"          },          {            "group": "请求参数说明",            "type": "int",            "optional": false,            "field": "type",            "description": "<p>操作类别： 2 | 匹配成功；3 |  拒绝</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "返回样例:",          "content": "{\"msg\":\"ok\",\"errorCode\":0}",          "type": "json"        }      ],      "fields": {        "返回参数说明": [          {            "group": "返回参数说明",            "type": "int",            "optional": false,            "field": "error_code",            "description": "<p>错误代码 0 表示没有错误</p>"          },          {            "group": "返回参数说明",            "type": "String",            "optional": false,            "field": "msg",            "description": "<p>操作结果描述</p> <p>接受被选择用户对于匹配请求的操作</p>"          }        ]      }    },    "filename": "application/api/controller/v1/Order.php",    "groupTitle": "CMS",    "name": "PostApiV1SelectReceive"  },  {    "type": "POST",    "url": "/api/v1/select/user",    "title": "5-选择一个用户并推送拼车消息",    "group": "CMS",    "version": "1.0.1",    "description": "<p>发起拼车请求用户选择一个推送用户并推送至被选择用户</p>",    "examples": [      {        "title": "请求样例:",        "content": "{\n   \"o_id\": 1,\n   \"select_o_id\": 2,\n   \"select_u_id\": 2\n }",        "type": "post"      }    ],    "parameter": {      "fields": {        "请求参数说明": [          {            "group": "请求参数说明",            "type": "int",            "optional": false,            "field": "o_id",            "description": "<p>发起者订单id</p>"          },          {            "group": "请求参数说明",            "type": "int",            "optional": false,            "field": "select_o_id",            "description": "<p>被选择者订单id</p>"          },          {            "group": "请求参数说明",            "type": "int",            "optional": false,            "field": "select_u_id",            "description": "<p>被选择者id</p>"          }        ]      }    },    "filename": "application/api/controller/v1/Order.php",    "groupTitle": "CMS",    "name": "PostApiV1SelectUser"  },  {    "type": "GET",    "url": "/api/v1/token/user",    "title": "3-小程序端获取登录token",    "group": "MINI",    "version": "1.0.1",    "description": "<p>微信用户登录获取token。</p>",    "examples": [      {        "title": "请求样例:",        "content": "http://mengant.cn/api/v1/token/user?code=mdksk",        "type": "get"      }    ],    "parameter": {      "fields": {        "请求参数说明": [          {            "group": "请求参数说明",            "type": "String",            "optional": false,            "field": "code",            "description": "<p>小程序code</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "返回样例:",          "content": "{\"token\":\"f4ad56e55cad93833180186f22586a08\",\"type\":1,\"u_id\":1}",          "type": "json"        }      ],      "fields": {        "返回参数说明": [          {            "group": "返回参数说明",            "type": "Sting",            "optional": false,            "field": "token",            "description": "<p>口令令牌，每次请求接口需要传入，有效期 2 hours</p>"          },          {            "group": "返回参数说明",            "type": "int",            "optional": false,            "field": "type",            "description": "<p>数据库是否缓存小程序用户信息</p>"          },          {            "group": "返回参数说明",            "type": "int",            "optional": false,            "field": "u_id",            "description": "<p>用户id</p>"          }        ]      }    },    "filename": "application/api/controller/v1/Token.php",    "groupTitle": "MINI",    "name": "GetApiV1TokenUser"  },  {    "type": "GET",    "url": "/api/v1/token/admin",    "title": "1-CMS获取登陆token",    "group": "PC",    "version": "1.0.1",    "description": "<p>后台用户登录</p>",    "examples": [      {        "title": "请求样例:",        "content": "{\n   \"phone\": \"18956225230\",\n   \"pwd\": \"a123456\"\n }",        "type": "post"      }    ],    "parameter": {      "fields": {        "请求参数说明": [          {            "group": "请求参数说明",            "type": "String",            "optional": false,            "field": "phone",            "description": "<p>用户手机号</p>"          },          {            "group": "请求参数说明",            "type": "String",            "optional": false,            "field": "pwd",            "description": "<p>用户密码</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "返回样例:",          "content": "{\"u_id\":1,\"username\":\"管理员\",\"token\":\"bde274895aa23cff9462d5db49690452\"}",          "type": "json"        }      ],      "fields": {        "返回参数说明": [          {            "group": "返回参数说明",            "type": "int",            "optional": false,            "field": "u_id",            "description": "<p>用户id</p>"          },          {            "group": "返回参数说明",            "type": "int",            "optional": false,            "field": "username",            "description": "<p>管理员名称</p>"          },          {            "group": "返回参数说明",            "type": "String",            "optional": false,            "field": "token",            "description": "<p>口令令牌，每次请求接口需要传入，有效期 2 hours</p>"          }        ]      }    },    "filename": "application/api/controller/v1/Token.php",    "groupTitle": "PC",    "name": "GetApiV1TokenAdmin"  },  {    "type": "GET",    "url": "/api/v1/token/loginOut",    "title": "2-CMS退出登陆",    "group": "PC",    "version": "1.0.1",    "description": "<p>CMS退出当前账号登陆。</p>",    "examples": [      {        "title": "请求样例:",        "content": "http://test.mengant.cn/api/v1/token/loginOut",        "type": "get"      }    ],    "success": {      "examples": [        {          "title": "返回样例:",          "content": "{\"msg\":\"ok\",\"errorCode\":0}",          "type": "json"        }      ],      "fields": {        "返回参数说明": [          {            "group": "返回参数说明",            "type": "int",            "optional": false,            "field": "error_code",            "description": "<p>错误码： 0表示操作成功无错误</p>"          },          {            "group": "返回参数说明",            "type": "String",            "optional": false,            "field": "msg",            "description": "<p>信息描述</p>"          }        ]      }    },    "filename": "application/api/controller/v1/Token.php",    "groupTitle": "PC",    "name": "GetApiV1TokenLoginout"  }] });
