<?php
/**
* YsServerSDK.php
* ���ӻ���ƽ̨REST API 
*/ 
class YsServerSDK{

/*�ṩ�Ľӿ�*/
private $addApi = "AddUser"; //����һ���û�
private $BatchAddUser = "BatchAddUser";//���������û�
private $sendMsgApi = "SendUserMsg";//��ָ���û������Զ�����Ϣ
private $serverKey;

private $YS_API_URL = "http://api.rongkecloud.com:8080/1.0/";
/**
* ���캯��
*/ 
public function __construct($serverKey){
	$this->serverKey = $serverKey;
}
 
/**
* ���һ���û� 
* return:
* 0��success
* 9999:��������
* 1007: key ��֤ʧ��
* 1002��username �Ѿ�����
* 1008: �û����������ʽ����
*/ 
public function addUser($username,$secret){ 
	$url = $YS_API_URL.$this->addApi; 
	$params = array("key"=>$this->serverKey,"username" => $username,"pwd"=>$secret); 
	$ret = $this->httpRequest($url, $params,"post");   
	return $ret; 
} 

/**
* �������һ���û� 
* return:
* 0��success
* 9999:��������
* 1007: key ��֤ʧ��
* 1002��username �Ѿ�����
* 1009: ��ǰ������������������
* 1008: �û����������ʽ����,��result�ֶλ�ó�����û���Ϣ:
	result=[{"nm":"����","pwd":"fasdiqw"},{"nm":"������","pwd":"fasdiqw"}]
*/ 
public function BatchAddUser($userinfo){ 
	$url = $YS_API_URL.$this->BatchAddUser; 
	$params = array("key"=>$this->serverKey,"userinfo" => $userinfo); 
	$ret = $this->httpRequest($url, $params,"post");   
	return $ret; 
} 


/**
 * �����Զ�����Ϣ
 * return :
 * 0:success
 * 9999:��������
 * 1007: key ��֤ʧ��
 */
public function sendUserMsg($username,$dst,$msg){
	$url = $YS_API_URL.$this->sendMsgApi;
	$params = array("key"=>$this->serverKey,"username" => $username,"dst" => $dst,"msg" => $msg);
	$ret = $this->httpRequest($url, $params,"post");
	return $ret;
}
/**
* �˺���ִ��һ��ģ���HTTP���󣬲�����HTTP����ķ���ֵ 
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