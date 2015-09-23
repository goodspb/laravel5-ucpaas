<?php
/**
 * 云之信短信平台配置
 * User: goodspb
 */

return [
//使用uspaas服务
    'appname'       =>  '',         //应用名称
    'appid'         =>  '',         //应用ID
    'accountsid'    =>  '',         //accountsid
    'token'         =>  '',         //token
    'codelen'       =>  5,          //短信验证码长度
    //文字短信
    'textTemplateId'        =>  '',          //模板ID
    'textTemplateContent'   =>  '{code}',    //模板替换内容，使用{code}替换验证码，其他内容请自行使用 , 隔开
];
