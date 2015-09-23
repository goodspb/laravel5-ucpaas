<?php namespace Goodspb\Laravel5Ucpaas;
/**
 * 云之讯API
 * User: goodspb
 */

use Config;
use Goodspb\Laravel5Ucpaas\Api\UcpaasApi;

class ucpaas{

    //Laravel DI
    public $app;
    //Api对象
    public $ucpass = null;

    //配置项
    public $appname;
    public $appid;
    public $accountsid;
    public $token;
    public $codelen;
    public $textTemplateId;
    public $textTemplateContent;

    public static $error;

    function __construct($app){
        $this->app = $app;

        $config = Config::get('ucpaas');
        extract($config);
        $this->appname = $appname;
        $this->appid = $appid;
        $this->accountsid = $accountsid;
        $this->token = $token;
        $this->codelen = $codelen;
        $this->textTemplateId = $textTemplateId;
        $this->textTemplateContent = $textTemplateContent;

        //初始化配置项
        $options['accountsid']=$accountsid;
        $options['token']=$token;

        //初始化 $options必填
        $this->ucpass = new UcpaasApi($options);
    }

    /**
     * 验证手机号码的合法性
     * @param $phone
     * @return bool
     */
    function checkPhone($phone){
        if(preg_match("/^1[3-8]\d{9}$/",$phone)){
            return true;
        }
        return false;
    }

    /**
     * 生成随机码
     * @param int $long 位数
     * @return int
     */
    function createCode($long = null){
        $long = $long==null ? $this->codelen : $long;
        return mt_rand(pow(10,$long-1),pow(10,$long)-1);
    }


    /**
     * 发送文字验证码
     * @param string $phone 手机号码
     * @param int $code 短信验证码，可由 createCode() 生成
     * @return bool
     * @throws Api\Exception
     */
    function sendTextSms($phone, $code){
        $param = str_replace('{code}',$code,$this->textTemplateContent);
        $response = $this->ucpass->templateSMS($this->appid,$phone,$this->textTemplateId,$param);
        $response = json_decode($response,true);
        $response = $response['resp'];
        if($response['respCode'] != '000000'){
            self::$error = $this->ucpass->getErrorMsg($response['respCode']);
            return false;
        }
        return true;
    }

    /**
     * 发送语音验证码
     * @param string $phone 手机号码
     * @param int $code 短信验证码，可由 createCode() 生成
     * @return bool 是否成功
     * @throws Api\Exception
     */
    function sendVioceSms($phone,$code){
        $response = $this->ucpass->voiceCode($this->appid,$code,$phone);
        $response = json_decode($response,true);
        $response = $response['resp'];
        if($response['respCode'] != '000000'){
            self::$error = $this->ucpass->getErrorMsg($response['respCode']);
            return false;
        }
        return true;
    }

    function getError(){
        return self::$error;
    }
}
