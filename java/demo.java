import java.io.IOException;
import java.util.HashMap;

import org.json.JSONException;

import com.yunshihudong.sdk.server.UserInfo;
import com.yunshihudong.sdk.server.YsServerSDK;


public class Main {
	public static void main(String[] args) {
		/*开发者需要申请自己的应用，并获得对应的server key，在接口中用*/
		String server_key = "3fc933aaa759b9ecfc2450f0ae6a1835833ab913";
		
		YsServerSDK client = new YsServerSDK(server_key);
		try {
			/*添加用户*/
			//addUser(String uname,String pwd)
			int ret = client.addUser("jack10001", "mypassw0rd");
			if(ret == 0){
				//添加成功
			}else if(ret == 1007){
				//key认证失败
			}else if(ret == 1008){
				//用户名密码格式错误
			}else if(ret == 1002){
				//用户名重复 
			}else if(ret == 9999){
				//参数出错
			}else{
				//-1异常
			}
			
			/*
			 * 添加多个用户信息
			 * 添加时要确保每一个用户名在系统内不能重复
			 * 接口一次最多允许添加100个用户,如果超过100个，则返回失败，建议循环批量添加用户
			*/
			UserInfo UserInfoData = new UserInfo();
			UserInfoData.NewUser("jerry1", "password");
			UserInfoData.NewUser("jerry2", "password");
			UserInfoData.NewUser("jerry3", "password");
			UserInfoData.NewUser("jerry4", "password");
			
			//HashMap<String,String> BatchAddUser(String user_info_json)
			HashMap<String,String> result = client.BatchAddUser(UserInfoData.GetData());
			int ret_muti = Integer.parseInt(result.get("ret_code"));
			if(ret_muti == 0){
				//添加成功
			}else if(ret_muti == 1007){
				//key认证失败
			}else if(ret_muti == 1008){
				//用户名密码格式错误
				//打印result返回的错误名字列表
				System.out.println("错误的用户信息："+result.get("result"));
			}else if(ret_muti == 1009){
				//添加人数超过最大允许上限 ：100
			}else if(ret_muti == 9999){
				//参数错误
			}else{
				//-1异常
			}
			
			/*给指定用户推送用户自定义消息*/
			String sender = "sun";//发送者名称
			String recivers = "jerry,tom,lucy";//接受者名称，多个接收者用 半角逗号','隔开
			String content = "北京今天的天气：多云转雷阵雨 30℃~20℃ ";
			int ret_send = client.SendMessage(sender, recivers, content);
			if(ret_send == 0){
				//发送成功
			}else if(ret_send == 1007){
				//key认证失败
			}else if(ret_send == 2002){
				//发送失败，可以尝试重发 
			}else if(ret_send == 9999){
				//参数错误
			}else{
				//-1异常
			}
			
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}

	/* (non-Java-doc)
	 * @see java.lang.Object#Object()
	 */
	public Main() {
		super();
	}

}