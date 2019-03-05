<?php
namespace App\Curl\Amazon;

use App\Curl\BaseCurl;
use App\Curl\bin\Curl;
use App\Curl\bin\JsonHttpCurlDriver;
use App\Curl\bin\StringCurlDriver;

class AmazonCurl extends BaseCurl
{
   // private $curl = null;

    public function __construct()
    {
        $this->curl = new Curl(new StringCurlDriver());//假设亚马逊返回的是 json 数据
    }

    public function getProductList()
    {
        $data = [];
        $tkey             = date('YmdHis',time());
        $data['username'] = config('sms.smsusername');
        $data['tkey']     = $tkey;
        $data['password'] = strtolower(md5(md5(config('sms.smspass')).$tkey));
        $data['content']  = trim('抠抠集团测试用短信').'退订回T【抠抠集团】';
        $data['mobile']   = '17320606631';
        return $this->curl->get('http://api.zthysms.com/sendSms.do',$data);
    }
}