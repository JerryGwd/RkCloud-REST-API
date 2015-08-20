<?php
/**
* YsServerSDK.php
* 云视互动平台REST API 
*/ 
class YsServerSDK{

/*提供的接口*/
private $addApi = "AddUser"; //增加一个用户
private $BatchAddUser = "BatchAddUser";//批量增加用户
private $sendMsgApi = "SendUserMsg";//给指定用户发送自定义消息
private $serverKey;

private $YS_API_URL = "http://api.rongkecloud.com:8080/1.0/";
/**
* 构造函数
*/ 
public function __construct($serverKey){
	$this->serverKey = $serverKey;
}
 
/**
* 添加一个用户 
* return:
* 0：success
* 9999:参数错误
* 1007: key 认证失败
* 1002：username 已经存在
* 1008: 用户名和密码格式有误
*/ 
public function addUser($username,$secret){ 
	$url = $YS_API_URL.$this->addApi; 
	$params = array("key"=>$this->serverKey,"username" => $username,"pwd"=>$secret); 
	$ret = $this->httpRequest($url, $params,"post");   
	return $ret; 
} 

/**
* 批量添加一个用户 
* return:
* 0：success
* 9999:参数错误
* 1007: key 认证失败
* 1002：username 已经存在
* 1009: 当前添加人数超过最大人数
* 1008: 用户名和密码格式有误,从result字段获得出错的用户信息:
	result=[{"nm":"张三","pwd":"fasdiqw"},{"nm":"ｊａｓｏｎ","pwd":"fasdiqw"}]
*/ 
public function BatchAddUser($userinfo){ 
	$url = $YS_API_URL.$this->BatchAddUser; 
	$params = array("key"=>$this->serverKey,"userinfo" => $userinfo); 
	$ret = $this->httpRequest($url, $params,"post");   
	return $ret; 
} 


/**
 * 发送自定义消息
 * return :
 * 0:success
 * 9999:参数错误
 * 1007: key 认证失败
 */
public function sendUserMsg($username,$dst,$msg){
	$url = $YS_API_URL.$this->sendMsgApi;
	$params = array("key"=>$this->serverKey,"username" => $username,"dst" => $dst,"msg" => $msg);
	$ret = $this->httpRequest($url, $params,"post");
	return $ret;
}
/**
* 此函数执行一个模拟的HTTP请求，并返回HTTP请求的返回值 
* @param String $url 
* @param Array $params
* @param String $method
* @return Mixed 
*/ 
function httpRequest($url,$params = array(),$method = "get"){
	$ch = curl_init($url);
	if($params){
		$paramsArray = array();
		foreach ($params as $key=>$value){
			$paramsArray[] = $key . "=" . urlencode($value);
		}
		if($method){
			if(strtolower($method) == "post"){
				curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&",$paramsArray));
			} else {
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, implode("&",$paramsArray));
			}
		}
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);	
	$result = curl_exec($ch);
	$errMessage = curl_error($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	curl_close($ch);
	if($errMessage != "" || $http_code >= 400){
		return false;
	} else {
	    return $result;
	}
}

class UserData{
        private $userData=array();
        function NewUser($name,$pwd){
                $user=array();
                $user['nm'] = $name;
                $user['pwd'] = $pwd;
                array_push($this->userData,$user);
        }
        function GetData(){
                return json_encode($this->userData);
        }

}

?>