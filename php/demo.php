<?php
	include(dirname(__FILE__) . "/YsServerSDK.php");
	/*��������Ҫ�����Լ���Ӧ�ã�����ö�Ӧ��server key���ڽӿ�����*/
	$server_key = "your-server-key";
	$obj = new YsServerSDK($server_key);
	/*���ӵ����û�*/
	$res = $obj->addUser("zhangsan","jnmk123");    
	if($res['ret_code'] == 0){
		echo "Add Success\r\n";
	}    
	
	/*���������û�*/
	$user_data = new UserData();
	$user_data->NewUser("gwd","adfasdf");
	$user_data->NewUser("gwd1","adfasdf");
	$user_data->NewUser("gwd2","adfasdf");
	$users_info = $user_data->getData();
	$res = $obj->BatchAddUser($users_info);
	if($ret['ret_code'] == 0)
		echo "Success\r\n";
	else if($ret['ret_code'] == 1008){
		$invalid_user = $ret['result'];//��ó�����û���Ϣ
		echo "Invalid User info is :$invalid_user";
	}
	else
		echo "failed,code:$ret\r\n";
		
	/*��ָ���û������û��Զ�����Ϣ*/
	$sender = "Jack"; //����������
	$recivers = "Tom,Jerry,LiLei"; //���������ƣ������������ ��Ƕ���','����
	$msg = "{type:"invite",content:"Play MangJiang Together?",date:"17:28 2015/5/27"}";
	$res = $obj->sendUserMsg($sender,$recivers,$msg);
	if($ret['ret_code'] == 0)
		echo "Success\r\n";
	else
		echo "failed,code:$ret\r\n";

?>