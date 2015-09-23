## Ucpaas SMS Client Provider For Laravel5

Ucpaas SMS Client Provider For Laravel5 <br>
云之讯开放平台 短信发送平台


### 安装

- [Packagist](https://packagist.org/packages/goodspb/laravel5-ucpaas)
- [GitHub](https://github.com/goodspb/laravel5-ucpaas)

只要在你的 `composer.json` 文件require中加入下面内容，就能获得最新版.

~~~
"goodspb/laravel5-ucpaas": "~1.0"
~~~

然后需要运行 "composer update" 来更新你的项目

安装完后，在 `app/config/app.php` 文件中找到 `providers` 键，

~~~

    Goodspb\Laravel5Ucpaas\Laravel5UcpaasServiceProvider::class

~~~

找到 `aliases` 键，

~~~
'aliases' => array(

    'Ucpaas' => Goodspb\Laravel5Ucpaas\Facades\Ucpaas::class

)
~~~

## 配置
运行以下命令发布配置文件
~~~
php artisan vendor:publish
~~~
然后到config目录下修改ucpaas.php
~~~
'appname'       =>  '我的应用名称',                             //应用名称
'appid'         =>  'xxx9d010a04a4baxxxxxxxxxxxxxxxxx',         //应用ID
'accountsid'    =>  'xxxa5fc150a72e5xxxxxxxxxxxxxxxxx',         //accountsid
'token'         =>  'xxx549fe7e962f3xxxxxxxxxxxxxxxxx',         //token
'codelen'       =>  5,                                          //短信验证码长度
//文字短信
'textTemplateId'        =>  '12037',                            //模板ID
'textTemplateContent'   =>  '{code}',                           //模板替换内容，使用{code}替换验证码，其他内容请自行使用 , 隔开
~~~

## 使用
1、发送文字短信
~~~
if(!Ucpaas::checkPhone($cellphone)){
    //不是正常的手机号码
    throw new \Exception("手机号码不正确");
}

//生成验证码
$code = Ucpaas::CreateCode();

if(!Ucpaas::sendTextSms($cellphone,$code)){
    //发送失败
    throw new Exception($Ucpaas::getError());
}
~~~

2、发送语音短信
~~~
//验证手机和生成验证码

if(!Ucpaas::sendVioceSms($cellphone,$code)){
    //发送失败
    throw new Exception($Ucpaas::getError());
}
~~~


## BUG
有问题请 [issues](https://github.com/goodspb/laravel5-ucpaas/issues)

