<?php
	include(dirname(__FILE__) . "/YsServerSDK.php");
	/*开发者需要申请自己的应用，并获得对应的server key，在接口中用*/
	$server_key = "your-server-key";
	$obj = new YsServerSDK($server_key);
	/*增加单个用户*/
	$res = $obj->addUser("zhangsan","jnmk123");    
	if($res['ret_code'] == 0){
		echo "Add Success\r\n";
	}    
	
	/*批量增加用户*/
	$user_data = new UserData();
	$user_data->NewUser("gwd","adfasdf");
	$user_data->NewUser("gwd1","adfasdf");
	$user_data->NewUser("gwd2","adfasdf");
	$users_info = $user_data->getData();
	$res = $obj->BatchAddUser($users_info);
	if($ret['ret_code'] == 0)
		echo "Success\r\n";
	else if($ret['ret_code'] == 1008){
		$invalid_user = $ret['result'];//获得出错的用户信息
		echo "Invalid User info is :$invalid_user";
	}
	else
		echo "failed,code:$ret\r\n";
		
	/*给指定用户推送用户自定义消息*/
	$sender = "Jack"; //发送者名称
	$recivers = "Tom,Jerry,LiLei"; //接受者名称，多个接收者用 半角逗号','隔开
	$msg = "{type:"invite",content:"Play MangJiang Together?",date:"17:28 2015/5/27"}";
	$res = $obj->sendUserMsg($sender,$recivers,$msg);
	if($ret['ret_code'] == 0)
		echo "Success\r\n";
	else
		echo "failed,code:$ret\r\n";

?>