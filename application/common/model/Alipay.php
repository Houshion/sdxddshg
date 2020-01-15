<?php
namespace app\common\model;

use think\Model;

class Alipay extends Model
{
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = 'timestamp';
    // 定义时间戳字段名
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    
    public function getJsSign($url = '')
    {
        vendor("dodgepudding.wechat-php-sdk.JSSDK#class");
        $wxConfig = $this->find();
        $jssdk = new \JSSDK($wxConfig["appid"], $wxConfig["appsecret"],$url);

        $result = $jssdk->getSignPackage();

        return $result;
    }
    /**
     * getWeObj
     * @param  integer $type     用户名类型 （1-公众号，2-小程序）
     * @return integer           登录成功-用户ID，登录失败-错误编号
     */
    public function getWeObj() 
    {
        header("Content-type:text/html;charset=UTF-8");
        vendor("alilogin.AopSdk");
        vendor("alilogin.aop.AopClient");
        $aop = new \AopClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = '2018050302627629';
        $aop->rsaPrivateKey = 'MIIEogIBAAKCAQEAvUUsnWj/sLuMA8g/7PCBlaGHgYxkYHZ2dJmCF1QKsYgIVw6V0K6ICDWRaX8Ii9uO3+yiGNudgAdqur7lvfjlLYW6cVkpW0k+P7mgc2JdoFIYvhz4g4SSElTydY2URp1PrzU3DKB7L2BnvWuOeMVsDkwIT4xwdI73S64HQAcIQYjdK9MYS9l+qbkMkjAncNnO38Ksp1ggT6WR4hnglE21/JAPP20Sr/Xtdy01ihIy78ojtrDaizYf4A1wztCrRyDxabPIuApSxPfVItFciUmDFyQ8Betct1jWih0wXMPdXqcu4v4biJgcBR8eokzjnYe/2qq3UK7XD5QMlrolyMG9KQIDAQABAoIBACF4yEkWNpHEuSA6G8QFTIVvyY0JjP7aNFyugSkq/bEjw4XR2IDNPNVm0856XsKNE5laOdh3jkUECsX32J1eFPmV+sDs6blxHIcchtmg/bnKiwGkEfcATOzdBPvxC9XpIBx2JsQe5WodfHstOEb3cwKcQ6P9zC1w0x8ZKcMS+0zLXyA2d8nBeYunhDzMdGbWYYdKkKOoM2AkswpsRJhxQTbDLRe/1cz6ilmWa2TAGnYgHry5nbG81PrqLq0DF3thUF0Ys7+vVOzBz3DBXcYRQbPRbXBy6kO5pAvIJ/NZ5UekvVAi/c/NkJAo9ghz2xiWSKIrs6pNfkr+9dta5xWziQECgYEA9zR4+ZJTIqOq6Xl4Lhj6RfWxOMVa8WrHeXMWLjQfEIwjblqKr9AK1Cv4QwzjTGRNVxH4WpPwVitKzGsKx4WuPthRwGI9N735Gowtt7mvn9mJetn6BBn6T5Q8AyJtiMURsFL9cbFM+3QUh0z6xmPuZaaWMZG7EULcMh2nyBZs5xECgYEAxAEJGeeSkUZlbmjiAMfMRBhoIKZ3IV5Zld5lvrqzwZQywthRXcbGUKS8D1qxXqeGw5zkzJTWOkWtF+I1u4A6Bn5GfgLyglpiE4vi+wLHQvJCa0CFXT0zPWBAP9Y83wN5M1sHYRwW2+ECreuQ2qRXjBy/cWzCXucm5KBfIlrZZJkCgYBgGVjyBE0nSSLW8m6i1PjuG24SmL4a3Zy//NphiceNwjy/2JjTcffTtWgkgK0X9GIQeB7o71vd06SXRQGCwNgU/DkDpe0Qb1yYUmgvZRL9/C4ywOwtjf+90e1mdorIQXv35Ls76GX51o1ob6eJWi3B/HmkuXdUZX5+SQMBiJ47UQKBgCogptoggcojvU1b0aelSewg6tCJtvU/GDY0FN5HtrcWqUpjwClNvfY7Ughiz9iuXTLSGAM4wkrICwolHrNsPgyDO5d9/q2xy360BFc7I6Tp+QigV4nQy6CXfXe7Dl5ImtZE7HMc3HTqCe9jwECeLgr5atRwMd7ABAYDyi7SJAORAoGAagCg2+V/agzh0WUw5x3Z8N+fsNjr+QApiDroO/TqNTv+ZMMXQGHkd3ZXHF0u2gp88XWM7QdDD477wpo1mMp57vYAhwyCWLCWuQlJHkil5hAHptqm5bgxK8r+hZGYLX5aNcxkYflePaYolIFAW3na2YDCbTFj37uvmA5xD1wT2/c=';
        $aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAotpp9P6wa0hAjZAFUDlRteiJr0em5jsl5ag3bW3Qa+LvoGnEfNiZS+YQBz25yKa05S1hRttCyLJ1XSkrB7dn/oVKl6qkxGAuq5OYJOa7WPsika2KZ2NU0LxibY8y3dmXvk+1w+KxMNwTtrxcWljgHW68TP0jmRwpurUHfRQiRq10pHCIKjtzGNySyj0QYvGGtCjp7inKfuU6kWnJJ+4Fcp9ZEmj5LOJ50mdcdtPHYsWTjUw3O9RtAuFyIDMuYdnFQgITtPWQ3IvtyRf0vjgMsRtjZm2SoY+BBBe5F6KUyOgkzocRPACYwUVT0BVvhtzG4ncdHE3jElJuH5n6N2cLkQIDAQAB';
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='UTF-8';
        $aop->format='json';
        return $aop;
    }
	
    public function getToken($aop,$code)
    {
        vendor("alilogin.aop.request.AlipaySystemOauthTokenRequest");
        $request = new \AlipaySystemOauthTokenRequest ();
        $request->setGrantType("authorization_code");
        $request->setCode($code);//这里传入 code
        $result = $aop->execute($request);
		write_log("login",json_encode($result));
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $access_token = $result->$responseNode->access_token;
		write_log("login","access_token： ".$access_token);
        return $access_token;
    }
	
    public function getInfo($aop,$access_token)
    {
        vendor("alilogin.aop.request.AlipayUserUserinfoShareRequest");
        $request_a = new \AlipayUserUserinfoShareRequest ();
        $result_a = $aop->execute ($request_a,$access_token); //这里传入获取的access_token
        $responseNode_a = str_replace(".", "_", $request_a->getApiMethodName()) . "_response";
        return $result_a->$responseNode_a;
    }

    /**
     * @param $aop 支付宝类
     * @param  $user_id  支付宝获取的唯一标示
     * @return mixed
     */
    public function is_subscribe($aop, $user_id)
    {
        vendor("alilogin.aop.request.AlipayOpenPublicUserFollowQueryRequest");
        $request = new \AlipayOpenPublicUserFollowQueryRequest ();
        $request->setBizContent("{" .
            "\"user_id\":\"$user_id\"" .
            "}");
        $result = $aop->execute ( $request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        $is_follow = $result->$responseNode->is_follow;
        if(!empty($resultCode)&&$resultCode == 10000&&$is_follow=='T'){
            return true;
        } else {
            return false;
        }
    }

    /**
     * 发送支付报消息
     * @param $aop
     * @param $data
     * @return mixed
     */
    public function message($aop, $data){
        vendor("alilogin.aop.request.AlipayOpenPublicMessageSingleSendRequest");
        $request = new \AlipayOpenPublicMessageSingleSendRequest ();
        $request->setBizContent($data);
        $result = $aop->execute ( $request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
       return $resultCode;
    }
    public function alipay($data)
    {
        header("Content-type: text/html; charset=utf-8");

        vendor("alilogin.wappay.service.AlipayTradeService");
        vendor("alilogin.wappay.buildermodel.AlipayTradeWapPayContentBuilder");
        vendor("alilogin.wappay.service.AlipayTradeService");
        if (!empty($data['out_trade_no']) && trim($data['out_trade_no']) != "") {
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $data['out_trade_no'];

            //订单名称，必填
            $subject = $data['subject'];

            //付款金额，必填
            $total_amount = $data['total_amount'];

            //商品描述，可空
            $body = $data['body'];

            //超时时间
            $timeout_express = "1m";

            $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setOutTradeNo($out_trade_no);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setTimeExpress($timeout_express);
            $config = config('alipay');
            $config['notify_url'] = $data['notify_url'];
            $payResponse = new \AlipayTradeService($config);

            $result = $payResponse->wapPay($payRequestBuilder, $config['return_url'], $data['notify_url']);
             // var_dump($result);die;
            return $result;
        }
    }
	
	
}