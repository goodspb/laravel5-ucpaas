<?php namespace Goodspb\Laravel5Ucpaas\Api;

/**
 * Created by PhpStorm.
 * User: UCPAAS JackZhao
 * Date: 2014/10/22
 * Time: 12:04
 * Dec : ucpass php sdk
 */
class UcpaasApi
{

    /**
     *  云之讯REST API版本号。当前版本号为：2014-06-30
     */
    const SoftVersion = "2014-06-30";
    /**
     * API请求地址
     */
    const BaseUrl = "https://api.ucpaas.com/";
    /**
     * @var string
     * 开发者账号ID。由32个英文字母和阿拉伯数字组成的开发者账号唯一标识符。
     */
    private $accountSid;
    /**
     * @var string
     * 开发者账号TOKEN
     */
    private $token;
    /**
     * @var string
     * 时间戳
     */
    private $timestamp;

    /**
     * 错误代码含义
     * @var array
     */
    static $error_info = array(
        '000000' => 'ok',
        //公共错误
        '100000' => '金额不为整数',
        '100001' => '余额不足',
        '100002' => '数字非法',
        '100003' => '不允许有空值',
        '100004' => '枚举类型取值错误',
        '100005' => '访问IP不合法',
        '100006' => '手机号不合法',
        '100015' => '号码不合法',
        '100500' => 'HTTP状态码不等于200',
        '100007' => '查无数据',
        '100008' => '手机号码为空',
        '100009' => '手机号为受保护的号码',
        '100010' => '登录邮箱或手机号为空',
        '100011' => '邮箱不合法',
        '100012' => '密码不能为空',
        '100013' => '没有测试子账号',
        '100014' => '金额过大,不要超过12位数字',
        '100016' => '余额被冻结',
        '100017' => '余额已注销',
        '100018' => '通话时长需大于60秒',
        '100699' => '系统内部错误',
        '100019' => '应用餘額不足',
        '100020' => '字符长度太长',
        '100104' => 'callId不能为空',
        '100105' => '日期格式错误',
        '100108' => '取消回拨失败',
        //开发者资源
        '101100' => '请求包头Authorization参数为空',
        '101101' => '请求包头Authorization参数Base64解码失败',
        '101102' => '请求包头Authorization参数解码后账户ID为空',
        '101103' => '请求包头Authorization参数解码后时间戳为空',
        '101104' => '请求包头Authorization参数解码后格式有误',
        '101105' => '主账户ID存在非法字符',
        '101106' => '请求包头Authorization参数解码后时间戳过期',
        '101107' => '请求地址SoftVersion参数有误',
        '101108' => '主账户已关闭',
        '101109' => '主账户未激活',
        '101110' => '主账户已锁定',
        '101111' => '主账户不存在',
        '101112' => '主账户ID为空',
        '101113' => '请求包头Authorization参数中账户ID跟请求地址中的账户ID不一致',
        '101114' => '请求地址Sig参数为空',
        '101115' => '请求token校验失败',
        '101116' => '主账号sig加密串不匹配',
        '101117' => '主账号token不存在',
        //应用资源
        '102100' => '应用ID为空',
        '102101' => '应用ID存在非法字符',
        '102102' => '应用不存在',
        '102103' => '应用未审核通过',
        '102104' => '测试应用不允许创建client',
        '102105' => '应用不属于该主账号',
        '102106' => '应用类型错误',
        '102107' => '应用类型为空',
        '102108' => '应用名为空',
        '102109' => '行业类型为空',
        '102110' => '行业信息错误',
        '102111' => '是否允许拨打国际填写错误',
        '102112' => '是否允许拨打国际不能为空',
        '102113' => '创建应用失败',
        '102114' => '应用名称已存在',
        '103100' => '子账户昵称为空',
        '103101' => '子账户名称存在非法字符',
        '103102' => '子账户昵称长度有误',
        '103103' => '子账户clientNumber为空',
        '103104' => '同一应用下，friendlyname重复',
        '103105' => '子账户friendlyname只能包含数字和字母和下划线',
        '103106' => 'client_number长度有误',
        '103107' => 'client_number不存在或不属于该主账号',
        '103108' => 'client已经关闭',
        '103109' => 'client充值失败',
        '103110' => 'client计费类型为空',
        '103111' => 'clientType只能取值0,1',
        '103112' => 'clientType为1时，charge不能为空',
        '103113' => 'clientNumber未绑定手机号',
        '103114' => '同一应用下同一手机号只能绑定一次',
        '103115' => '单次查询记录数不能超过100',
        '103116' => '绑定手机号失败',
        '103117' => '子账号是否显号(isplay)不能为空',
        '103118' => '子账号是否显号(display)取值只能是0(不显号)和1(显号)',
        '103119' => '应用下该子账号不存在',
        '103120' => 'friendlyname不能为空',
        '103121' => '查询client参数不能为空',
        '103122' => 'client不属于应用',
        '103123' => '未上线应用不能超过100个client',
        '103125' => '子账号余额不足',
        '103126' => '未上线应用或demo只能使用白名单中号码',
        '103127' => '测试demo不能创建子账号',
        '103128' => '校验码不能为空',
        '103129' => '校验码错误或失效',
        '103130' => '校验号码失败',
        '103131' => '解绑失败,信息错误或不存在绑定关系',
        //通话
        '104100' => '主叫clientNumber为空',
        '104101' => '主叫clientNumber未绑定手机号',
        '104102' => '验证码为空',
        '104103' => '显示号码不合法',
        '104104' => '语音验证码位4-8位',
        '104106' => '语音通知类型错误',
        '104107' => '语音通知内容为空',
        '104108' => '语音ID非法',
        '104109' => '文本内容存储失败',
        '104110' => '语音文件不存在或未审核',
        '104111' => '号码与绑定的号码不一致',
        '104112' => '开通或关闭呼转失败',
        '104113' => '不能同时呼叫同一被叫',
        '104114' => '内容包含敏感词',
        '104115' => '语音通知发送多语音ID不能超过5个',
        '104116' => '不在线呼转模式只能取1,2,3,4',
        '104117' => '呼转模式为2,4则必须填写forwardPhone',
        '104118' => '呼转模式为2,4则前转号码与绑定手机号码不能相等',
        '104119' => '群聊列表格式不合法',
        '104120' => '群聊呼叫模式只能是1免费,2直拨,3智能拨打',
        '104121' => '群聊ID不能为空',
        '104122' => '群聊超过最大方数',
        '104123' => '群聊ID发送错误',
        '104124' => '群聊操作失败服务出错',
        '104125' => '呼转号码不存在',
        '104126' => '订单号不能为空',
        '104127' => '订单号不存在',
        '104128' => '号码释放失败或号码已经自动释放',
        '104129' => '显手机号必须是呼叫列表中的号码',
        '104130' => '主被叫不能相同',
        '104131' => '开通国际漫游禁止回拨呼叫',
        '104132' => 'callid不能为空',
        '104133' => '发起者不能为空',
        //短信、语音验证码
        '105100' => '短信服务请求异常',
        '105101' => 'url关键参数为空',
        '105102' => '号码不合法',
        '105103' => '没有通道类别',
        '105104' => '该类别为冻结状态',
        '105105' => '没有足够金额',
        '105106' => '不是国内手机号码并且不是国际电话',
        '105107' => '黑名单',
        '105108' => '含非法关键字',
        '105109' => '该通道类型没有第三方通道',
        '105110' => '短信模板ID不存在',
        '105111' => '短信模板未审核通过',
        '105112' => '短信模板替换个数与实际参数个数不匹配',
        '105113' => '短信模板ID为空',
        '105114' => '短信内容为空',
        '105115' => '短信类型长度应为1',
        '105116' => '同一天同一用户不能发超过3条相同的短信',
        '105117' => '模板ID含非法字符',
        '105118' => '短信模板有替换内容，但参数为空',
        '105119' => '短信模板替换内容过长，不能超过70个字符',
        '105120' => '手机号码不能超过100个',
        '105121' => '短信模板已删除',
        '105122' => '同一天同一用户不能发超过N条验证码(n为用户自己配置)',
        '105123' => '短信模板名称为空',
        '105124' => '短信模板内容为空',
        '105125' => '创建短信模板失败',
        '105126' => '短信模板名称错误',
        '105127' => '短信模板内容错误',
        '105128' => '短信模板id为空',
        '105129' => '短信模板id不存在',
        '105130' => '30秒内不能连续发同样的内容',
        '105131' => '30秒内不能给同一号码发送相同模板消息',
        '105132' => '验证码短信参数长度不能超过10位',
    );

    /**
     * @param $options 数组参数必填
     * $options = array(
     *
     * )
     * @throws Exception
     */
    public function  __construct($options)
    {
        if (is_array($options) && !empty($options)) {
            $this->accountSid = isset($options['accountsid']) ? $options['accountsid'] : '';
            $this->token = isset($options['token']) ? $options['token'] : '';
            $this->timestamp = date("YmdHis") + 7200;
        } else {
            throw new \Exception("非法参数");
        }
    }

    /**
     * @return string
     * 包头验证信息,使用Base64编码（账户Id:时间戳）
     */
    private function getAuthorization()
    {
        $data = $this->accountSid . ":" . $this->timestamp;
        return trim(base64_encode($data));
    }

    /**
     * @return string
     * 验证参数,URL后必须带有sig参数，sig= MD5（账户Id + 账户授权令牌 + 时间戳，共32位）(注:转成大写)
     */
    private function getSigParameter()
    {
        $sig = $this->accountSid . $this->token . $this->timestamp;
        return strtoupper(md5($sig));
    }

    /**
     * @param $url
     * @param string $type
     * @return mixed|string
     */
    private function getResult($url, $body = null, $type = 'json',$method)
    {
        $data = $this->connection($url,$body,$type,$method);
        if (isset($data) && !empty($data)) {
            $result = $data;
        } else {
            $result = '没有返回数据';
        }
        return $result;
    }

    /**
     * @param $url
     * @param $type
     * @param $body  post数据
     * @param $method post或get
     * @return mixed|string
     */
    private function connection($url, $body, $type,$method)
    {
        if ($type == 'json') {
            $mine = 'application/json';
        } else {
            $mine = 'application/xml';
        }
        if (function_exists("curl_init")) {
            $header = array(
                'Accept:' . $mine,
                'Content-Type:' . $mine . ';charset=utf-8',
                'Authorization:' . $this->getAuthorization(),
            );
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            if($method == 'post'){
                curl_setopt($ch,CURLOPT_POST,1);
                curl_setopt($ch,CURLOPT_POSTFIELDS,$body);
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $result = curl_exec($ch);
            curl_close($ch);
        } else {
            $opts = array();
            $opts['http'] = array();
            $headers = array(
                "method" => strtoupper($method),
            );
            $headers[]= 'Accept:'.$mine;
            $headers['header'] = array();
            $headers['header'][] = "Authorization: ".$this->getAuthorization();
            $headers['header'][]= 'Content-Type:'.$mine.';charset=utf-8';

            if(!empty($body)) {
                $headers['header'][]= 'Content-Length:'.strlen($body);
                $headers['content']= $body;
            }

            $opts['http'] = $headers;
            $result = file_get_contents($url, false, stream_context_create($opts));
        }
        return $result;
    }

    /**
     * @param string $type 默认json,也可指定xml,否则抛出异常
     * @return mixed|string 返回指定$type格式的数据
     * @throws Exception
     */
    public function getDevinfo($type = 'json')
    {
        if ($type == 'json') {
            $type = 'json';
        } elseif ($type == 'xml') {
            $type = 'xml';
        } else {
            throw new \Exception("只能json或xml，默认为json");
        }
        $url = self::BaseUrl . self::SoftVersion . '/Accounts/' . $this->accountSid . '?sig=' . $this->getSigParameter();
        $data = $this->getResult($url,null,$type,'get');
        return $data;
    }


    /**
     * @param $appId 应用ID
     * @param $clientType 计费方式。0  开发者计费；1 云平台计费。默认为0.
     * @param $charge 充值的金额
     * @param $friendlyName 昵称
     * @param $mobile 手机号码
     * @return json/xml
     */
    public function applyClient($appId, $clientType, $charge, $friendlyName, $mobile, $type = 'json')
    {
        $url = self::BaseUrl . self::SoftVersion . '/Accounts/' . $this->accountSid . '/Clients?sig=' . $this->getSigParameter();
        if ($type == 'json') {
            $body_json = array();
            $body_json['client'] = array();
            $body_json['client']['appId'] = $appId;
            $body_json['client']['clientType'] = $clientType;
            $body_json['client']['charge'] = $charge;
            $body_json['client']['friendlyName'] = $friendlyName;
            $body_json['client']['mobile'] = $mobile;
            $body = json_encode($body_json);
        } elseif ($type == 'xml') {
            $body_xml = '<?xml version="1.0" encoding="utf-8"?>
                        <client><appId>'.$appId.'</appId>
                        <clientType>'.$clientType.'</clientType>
                        <charge>'.$charge.'</charge>
                        <friendlyName>'.$friendlyName.'</friendlyName>
                        <mobile>'.$mobile.'</mobile>
                        </client>';
            $body = trim($body_xml);
        } else {
            throw new \Exception("只能json或xml，默认为json");
        }
        $data = $this->getResult($url, $body, $type,'post');
        return $data;
    }

    /**
     * @param $clientNumber
     * @param $appId
     * @param string $type
     * @return mixed|string
     * @throws Exception
     */
    public function releaseClient($clientNumber,$appId,$type = 'json'){
        $url = self::BaseUrl . self::SoftVersion . '/Accounts/' . $this->accountSid . '/dropClient?sig=' . $this->getSigParameter();
        if($type == 'json'){
            $body_json = array();
            $body_json['client'] = array();
            $body_json['client']['clientNumber'] = $clientNumber;
            $body_json['client']['appId'] = $appId;
            $body = json_encode($body_json);
        }elseif($type == 'xml'){
            $body_xml = '<?xml version="1.0" encoding="utf-8"?>
                        <client>
                        <clientNumber>'.$clientNumber.'</clientNumber>
                        <appId>'.$appId.'</appId >
                        </client>';
            $body = trim($body_xml);
        }else {
            throw new \Exception("只能json或xml，默认为json");
        }
        $data = $this->getResult($url, $body, $type,'post');
        return $data;
    }

    /**
     * @param $appId
     * @param $start
     * @param $limit
     * @param string $type
     * @return mixed|string
     * @throws Exception
     */
    public function getClientList($appId,$start,$limit,$type = 'json'){
        $url = self::BaseUrl . self::SoftVersion . '/Accounts/' . $this->accountSid . '/clientList?sig=' . $this->getSigParameter();
        if($type == 'json'){
            $body_json = array('client'=>array(
                'appId'=>$appId,
                'start'=>$start,
                'limit'=>$limit
            ));
            $body = json_encode($body_json);
        }elseif($type == 'xml'){
            $body_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                        <client>
                            <appId>'.$appId.'</appId>
                            <start>'.$start.'</start>
                            <limit>'.$limit.'</limit>
                        </client>';
            $body = trim($body_xml);
        }else {
            throw new \Exception("只能json或xml，默认为json");
        }
        $data = $this->getResult($url, $body, $type,'post');
        return $data;
    }

    /**
     * @param $appId
     * @param $clientNumber
     * @param string $type
     * @return mixed|string
     * @throws Exception
     */
    public function getClientInfo($appId,$clientNumber,$type = 'json'){
        if ($type == 'json') {
            $type = 'json';
        } elseif ($type == 'xml') {
            $type = 'xml';
        } else {
            throw new \Exception("只能json或xml，默认为json");
        }
        $url = self::BaseUrl . self::SoftVersion . '/Accounts/' . $this->accountSid . '?sig=' . $this->getSigParameter(). '&clientNumber='.$clientNumber.'&appId='.$appId;
        $data = $this->getResult($url,null,$type,'get');
        return $data;
    }

    /**
     * @param $appId
     * @param $mobile
     * @param string $type
     * @return mixed|string
     * @throws \Exception
     */
    public function getClientInfoByMobile($appId,$mobile,$type = 'json'){
        if ($type == 'json') {
            $type = 'json';
        } elseif ($type == 'xml') {
            $type = 'xml';
        } else {
            throw new \Exception("只能json或xml，默认为json");
        }
        $url = self::BaseUrl . self::SoftVersion . '/Accounts/' . $this->accountSid . '/ClientsByMobile?sig=' . $this->getSigParameter(). '&mobile='.$mobile.'&appId='.$appId;
        $data = $this->getResult($url,null,$type,'get');
        return $data;
    }

    /**
     * @param $appId
     * @param $date
     * @param string $type
     * @return mixed|string
     * @throws \Exception
     */
    public function getBillList($appId,$date,$type = 'json'){
        $url = self::BaseUrl . self::SoftVersion . '/Accounts/' . $this->accountSid . '/billList?sig=' . $this->getSigParameter();
        if($type == 'json'){
            $body_json = array('appBill'=>array(
                'appId'=>$appId,
                'date'=>$date,
            ));
            $body = json_encode($body_json);
        }elseif($type == 'xml'){
            $body_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                        <appBill>
                            <appId>'.$appId.'</appId>
                            <date>'.$date.'</date>
                        </appBill>';
            $body = trim($body_xml);
        }else {
            throw new \Exception("只能json或xml，默认为json");
        }
        $data = $this->getResult($url, $body, $type,'post');
        return $data;
    }

    /**
     * @param $appId
     * @param $clientNumber
     * @param $chargeType
     * @param $charge
     * @param string $type
     * @return mixed|string
     * @throws Exception
     */
    public function chargeClient($appId,$clientNumber,$chargeType,$charge,$type = 'json'){
        $url = self::BaseUrl . self::SoftVersion . '/Accounts/' . $this->accountSid . '/chargeClient?sig=' . $this->getSigParameter();
        if($type == 'json'){
            $body_json = array('client'=>array(
                'appId'=>$appId,
                'clientNumber'=>$clientNumber,
                'chargeType'=>$chargeType,
                'charge'=>$charge
            ));
            $body = json_encode($body_json);
        }elseif($type == 'xml'){
            $body_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                        <client>
                            <clientNumber>'.$clientNumber.'</clientNumber>
                            <chargeType>'.$chargeType.'</chargeType>
                            <charge>'.$charge.'</charge>
                            <appId>'.$appId.'</appId>
                        </client>';
            $body = trim($body_xml);
        }else {
            throw new \Exception("只能json或xml，默认为json");
        }
        $data = $this->getResult($url, $body, $type,'post');
        return $data;

    }

    /**
     * @param $appId
     * @param $fromClient
     * @param $to
     * @param null $fromSerNum
     * @param null $toSerNum
     * @param string $type
     * @return mixed|string
     * @throws Exception
     */
    public function callBack($appId,$fromClient,$to,$fromSerNum=null,$toSerNum=null,$type = 'json'){
        $url = self::BaseUrl . self::SoftVersion . '/Accounts/' . $this->accountSid . '/Calls/callBack?sig=' . $this->getSigParameter();
        if($type == 'json'){
            $body_json = array('callback'=>array(
                'appId'=>$appId,
                'fromClient'=>$fromClient,
                'fromSerNum'=>$fromSerNum,
                'to'=>$to,
                'toSerNum'=>$toSerNum
            ));
            $body = json_encode($body_json);
        }elseif($type == 'xml'){
            $body_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                        <callback>
                            <fromClient>'.$fromClient.'</clientNumber>
                            <fromSerNum>'.$fromSerNum.'</chargeType>
                            <to>'.$to.'</charge>
                            <toSerNum>'.$toSerNum.'</toSerNum>
                            <appId>'.$appId.'</appId>
                        </callback>';
            $body = trim($body_xml);
        }else {
            throw new \Exception("只能json或xml，默认为json");
        }
        $data = $this->getResult($url, $body, $type,'post');
        return $data;
    }

    /**
     * @param $appId
     * @param $verifyCode
     * @param $to
     * @param string $type
     * @return mixed|string
     * @throws Exception
     */
    public function voiceCode($appId,$verifyCode,$to,$type = 'json'){
        $url = self::BaseUrl . self::SoftVersion . '/Accounts/' . $this->accountSid . '/Calls/voiceCode?sig=' . $this->getSigParameter();
        if($type == 'json'){
            $body_json = array('voiceCode'=>array(
                'appId'=>$appId,
                'verifyCode'=>$verifyCode,
                'to'=>$to
            ));
            $body = json_encode($body_json);
        }elseif($type == 'xml'){
            $body_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                        <voiceCode>
                            <verifyCode>'.$verifyCode.'</clientNumber>
                            <to>'.$to.'</charge>
                            <appId>'.$appId.'</appId>
                        </voiceCode>';
            $body = trim($body_xml);
        }else {
            throw new \Exception("只能json或xml，默认为json");
        }
        $data = $this->getResult($url, $body, $type,'post');
        return $data;
    }

    /**
     * @param $appId
     * @param $to
     * @param $templateId
     * @param null $param
     * @param string $type
     * @return mixed|string
     * @throws Exception
     */
    public function templateSMS($appId,$to,$templateId,$param=null,$type = 'json'){
        $url = self::BaseUrl . self::SoftVersion . '/Accounts/' . $this->accountSid . '/Messages/templateSMS?sig=' . $this->getSigParameter();
        if($type == 'json'){
            $body_json = array('templateSMS'=>array(
                'appId'=>$appId,
                'templateId'=>$templateId,
                'to'=>$to,
                'param'=>$param
            ));
            $body = json_encode($body_json);
        }elseif($type == 'xml'){
            $body_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                        <templateSMS>
                            <templateId>'.$templateId.'</templateId>
                            <to>'.$to.'</to>
                            <param>'.$param.'</param>
                            <appId>'.$appId.'</appId>
                        </templateSMS>';
            $body = trim($body_xml);
        }else {
            throw new \Exception("只能json或xml，默认为json");
        }
        $data = $this->getResult($url, $body, $type,'post');
        return $data;
    }

    function getErrorMsg($respCode){
        return self::$error_info[$respCode] ?: '未知错误！';
    }
}
