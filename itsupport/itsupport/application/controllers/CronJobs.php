<?php
/**
 * 
 */
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class CronJobs extends CI_Controller 
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('admin_model');
		
	}
	
	//// deliverer search /////
	public function delivererSearch()
	{
		$serverTmzn = date_default_timezone_get(); 
		date_default_timezone_set($serverTmzn);
		$date = date('Y-m-d'); 
		$time = date('H:i');
		$current_date = date('Y-m-d , H:i:s');
		
		$sql = "SELECT * FROM `delivery_request_history` WHERE `request_date` = '".$date."' AND `last_request_time` <= '".$time."' AND `request_count` < 13 AND `request_status` = 0 ";
	    $dataInfo = $this->admin_model->getRecordSql($sql);
		//echo "<pre/>";
		//print_r($dataInfo);
		if(!empty($dataInfo)){
			foreach($dataInfo as $data){
				if($data['request_count'] < 12){	
					 $req_history_id = $data['req_history_id'];
					 $order_id = $data['order_id'];
					 $orderInfo = $this->admin_model->getRecord('order_info', array('order_id'=>$order_id));
			
					 $order_date = $orderInfo[0]['order_date'];
					 $restrnt_id = $orderInfo[0]['restaurant_id'];
					 $user_id = $orderInfo[0]['user_id'];
					 
					 $request_count = $data['request_count'] + 1; 
					
					 $historyUpdate = array(
					     'last_request_time'=> $time,
					     'request_count'=> $request_count
					 ); 
					 /// update last update time in order request history ///
					 $this->admin_model->updateRecord('delivery_request_history',$historyUpdate ,array('req_history_id'=>$req_history_id));
					 
					 /// delete all delivery request for this order ///
					 $this->admin_model->deleteRecord('delivery_request',array('order_id'=>$order_id));
					 /// delete alll notification of this order //
					 $this->admin_model->deleteRecord('notification_deliverer',array('order_id'=>$order_id));
					 
					 //// send notification to user for  ///
					  $sender_id   = $restrnt_id;
					  $receiver_id = $user_id;
					  $sub_type = 6;
				      //// get delivererr details ///
					  $msg =  "Please wait your order ".$order_id." is in queue.";
					 
					  $notificationType = 1;
					 
					  $notificationArr = array(
					       'restaurant_id'     => '',
					       'deliverer_id'      => $sender_id,
					       'receiver_id'       => $receiver_id,
					       'order_id'          => $order_id,
					       'notification'      => $msg,
					       'notification_type' => 1,
					       'sub_type'          => $sub_type,
					       'is_read'           => 1,
					       'is_deleted'        => 0,
					       'created'           => date('Y-m-d , H:i:s')
					 );
					 $noticationId = $this->admin_model->saveRecord('notification_user', $notificationArr);
					 //// send  notification  /////
					 if($noticationId > 0){
					 	 
						 $deviceInfo = $this->admin_model->getRecord('user_info',array('user_id' =>$receiver_id));
						 $notfiCount = $deviceInfo[0]['notification_count']+1;
						 $totalCount = $deviceInfo[0]['total_count']+1;
						 $logUpdate = array(
							 'notification_count' => $notfiCount,
							 'total_count' => $totalCount
						 );
						 $update = $this->admin_model->updateRecord('user_info',$logUpdate ,array('user_id'=>$receiver_id));
						 /// for sending push notification
						 if($deviceInfo[0]['device_id'] != '' && $deviceInfo[0]['notification_status'] == 0){
							 $device_id = $deviceInfo[0]['device_id'];
							 ///device_type :- 0 for ios , 1for android
							 $dataArray = array();
							 $dataArray = array(
								 'notification_id' => $noticationId,
								 'sender_id' => $sender_id,
								 'order_id' => $order_id
							 );
							 if($deviceInfo[0]['device_type'] == 0){
								  $result = $this->admin_model->customer_iphone_notification($device_id,$msg,$notificationType,$sub_type,$dataArray,$totalCount);
							 }else if($deviceInfo[0]['device_type'] == 1){
							 	  
							 }
						 }
					  }
					 //// ---- user notification ---- ////
					 
					 /// search deliverer send request again ///
					 $dlvSql = "SELECT * FROM deliverer_info DI WHERE DI.duty_status = 0 AND DI.is_verify = 0 AND DI.is_approved = 0 AND 
					            DI.is_delete = 0 AND DI.deliverer_id NOT IN (SELECT OI.deliverer_id FROM order_info OI 
					            WHERE OI.order_date = '".$order_date."' AND (OI.order_status_id = 3 OR OI.order_status_id = 4) 
					            AND OI.is_canceled =  0) ";
					 
					 $dlvrerLIst = $this->admin_model->getRecordSql($dlvSql); 
					 
					 if(!empty($dlvrerLIst)){
					 	  foreach($dlvrerLIst as $dlvr){
					 	  	    $deliverer_id = $dlvr['deliverer_id'];
							    /// check that deliverer is take order on same day on same restaurant only 3 times ////
								$checkCountSql = "SELECT COUNT(OI.id) as total FROM order_info OI WHERE OI.order_date = '".$order_date."' 
								                  AND OI.restaurant_id = ".$restrnt_id." AND OI.deliverer_id = ".$deliverer_id." AND OI.is_canceled =  0 HAVING total < 3;";
								$checkCount = $this->admin_model->getRecordSql($checkCountSql); 
								 
								if(!empty($checkCount)){
									 	
									 $dlvryReqArr = array(
									      'order_id'     => $order_id,
									      'deliverer_id' => $deliverer_id,
									      'status'       => 0,
									      'created'      => date('Y-m-d , H:i:s')
									 );
									 $this->admin_model->saveRecord('delivery_request', $dlvryReqArr);
									 //// send notification to deliverer ///
									 $sub_type = 0;
									 $msg = "You have an order delivery request for ".$order_id.".";
									 $dlvrNotifArr = array(
									       'restaurant_id'     => $restrnt_id,
									       'user_id'           => '',
									       'receiver_id'       => $deliverer_id,
									       'order_id'          => $order_id,
									       'notification'      => $msg,
									       'notification_type' => 1,
									       'sub_type'          => $sub_type,
									       'is_read'           => 1,
									       'is_deleted'        => 0,
									       'created'           => date('Y-m-d , H:i:s')
									 );
									 $dlvrNotifiId = $this->admin_model->saveRecord('notification_deliverer', $dlvrNotifArr);
									 if($dlvrNotifiId > 0){
				 	 
										 $dlvrerInfo = $this->admin_model->getRecord('deliverer_info',array('deliverer_id' =>$deliverer_id));
										 $dlvrNotfiCount = $dlvrerInfo[0]['notification_count']+1;
										 $dlvrTotalCount = $dlvrerInfo[0]['total_count']+1;
										 $dlvrLogUpdate = array(
											 'notification_count' => $dlvrNotfiCount,
											 'total_count' => $dlvrTotalCount
										 );
										 $update = $this->admin_model->updateRecord('deliverer_info',$dlvrLogUpdate ,array('deliverer_id'=>$deliverer_id));
										 /// for sending push notification
										 if($dlvrerInfo[0]['device_id'] != '' && $dlvrerInfo[0]['notification_status'] == 0){
											 $dlvr_device_id = $dlvrerInfo[0]['device_id'];
											 ///device_type :- 0 for ios , 1for android
											 $dataArray = array();
											 $dataArray = array(
												 'notification_id' => $dlvrNotifiId,
												 'sender_id' => $restrnt_id,
												 'order_id' => $order_id
											 );
											 if($dlvrerInfo[0]['device_type'] == 0){
												 $result = $this->admin_model->delivery_iphone_notification($dlvr_device_id,$msg,1,$sub_type,$dataArray,$dlvrTotalCount);
											 }else if($dlvrerInfo[0]['device_type'] == 1){
											 	  
											 }
										 }
									 }
									 //// end notification //////
								} 
								//echo "hii"; 
					 	  }
					 }
					////  ---- search deliverer ---- ////
					
					
					
				}elseif($data['request_count'] == 12){
					 //// order cancle ////
					 $order_id = $data['order_id'];
					 // get order detail ///
		             $orderInfo = $this->admin_model->getRecord('order_info',array('order_id'=>$order_id));
		
					 /// update in order info table /////
					 $this->admin_model->updateRecord('order_info',array('is_canceled'=>1) ,array('order_id'=>$order_id));
					 /// update last update time in order request history ///
					 $this->admin_model->deleteRecord('delivery_request_history',array('order_id'=>$order_id));
					 /// delete all delivery request for this order ///
					 $this->admin_model->deleteRecord('delivery_request',array('order_id'=>$order_id));
					 /// delete alll notification of this order //
					 $this->admin_model->deleteRecord('notification_deliverer',array('order_id'=>$order_id));
					 
					 /// send notification to restaurant ///
					 $restaurant_id = $orderInfo[0]['restaurant_id'];
					 $msg = " Order id ".$order_id.". has been canceled. ";
					 $notificationArr = array(
					       'deliverer_id' => '',
					       'receiver_id' => $restaurant_id,
					       'order_id' => $order_id,
					       'notification' => $msg,
					       'notification_type' => 1,
					       'is_read' => 1,
					       'created' => $current_date
					 );
					 $notification_id = $this->admin_model->saveRecord('notification_restaurant',$notificationArr);
					 $restInfo = $this->admin_model->getRecord('restaurant_info',array('restaurant_id'=>$restaurant_id));
					 $not_count = $restInfo[0]['notification_count'] + 1;
					 $rest_update = $this->admin_model->updateRecord('restaurant_info',array('notification_count'=>$not_count),array('restaurant_id'=>$restaurant_id));
				     /// --- notification to restaurant --- ///
					 
					 //// notification send to user for order cancelation ///
					 $sender_id = $orderInfo[0]['restaurant_id'];
					 $receiver_id = $orderInfo[0]['user_id'];
					 
				     $senderInfo = $this->admin_model->getRecord('restaurant_info',array('restaurant_id' =>$sender_id));
				
					 $msg = "Your order ".$order_id." has been canceled.";
					 $notificationType = 1;$sub_type = 7;
					 
					 $notificationArr = array(
					       'restaurant_id'     => $sender_id,
					       'deliverer_id'      => '',
					       'receiver_id'       => $receiver_id,
					       'order_id'          => $order_id,
					       'notification'      => $msg,
					       'notification_type' => 1,
					       'sub_type'          => $sub_type,
					       'is_read'           => 1,
					       'is_deleted'        => 0,
					       'created'           => date('Y-m-d , H:i:s')
					 );
					 $noticationId = $this->admin_model->saveRecord('notification_user', $notificationArr);
					 ////  notification  /////
					 if($noticationId > 0){
					 	 
						 $deviceInfo = $this->admin_model->getRecord('user_info',array('user_id' =>$receiver_id));
						 $notfiCount = $deviceInfo[0]['notification_count']+1;
						 $totalCount = $deviceInfo[0]['total_count']+1;
						 $logUpdate = array(
							 'notification_count' => $notfiCount,
							 'total_count' => $totalCount
						 );
						 $update = $this->admin_model->updateRecord('user_info',$logUpdate ,array('user_id'=>$receiver_id));
						 /// for sending push notification
						 if($deviceInfo[0]['device_id'] != '' && $deviceInfo[0]['notification_status'] == 0){
							 $device_id = $deviceInfo[0]['device_id'];
							 ///device_type :- 0 for ios , 1for android
							 $dataArray = array();
							 $dataArray = array(
								 'notification_id' => $noticationId,
								 'sender_id' => $sender_id,
								 'order_id' => $order_id
							 );
							 if($deviceInfo[0]['device_type'] == 0){
								 $result = $this->admin_model->customer_iphone_notification($device_id,$msg,$notificationType,$sub_type,$dataArray,$totalCount);
							 }else if($deviceInfo[0]['device_type'] == 1){
							 	  
							 }
						 }
					 } 
					 //// -- user notification --- //// 
				}
			}/// foreach ///	
		}
				  	
	}
	/// ----- deliverer search ---- ///
	
	//// order timeout /////
	public function orderTimeOut()
	{
		//$this->cronTest();
		$serverTmzn = date_default_timezone_get(); 
		date_default_timezone_set($serverTmzn);
		$date = date('Y-m-d'); 
		$time = date('H:i');
		$current_date = date('Y-m-d , H:i:s');
		$cur_date = date('Y-m-d,H:i:s');
		
		$sql = "SELECT OI.order_id,OI.order_date,OI.order_time,OI.user_id,OI.restaurant_id,RI.restaurant_name,
		        RI.retry_time_limit FROM order_info OI
				LEFT JOIN restaurant_info RI ON RI.restaurant_id = OI.restaurant_id
				WHERE OI.order_date = '".$date."' AND OI.is_canceled = 0 AND OI.full_payment_status = 1 AND OI.restaurant_status = 0 ";
		$dataInfo = $this->admin_model->getRecordSql($sql);
		//echo "<pre/>";
		//print_r($dataInfo);
		if(!empty($dataInfo)){
			foreach($dataInfo as $data){
				$data['retry_time_limit'];
				$order_time = $data['order_time'];
				$retry_time_limit = 3 * $data['retry_time_limit'];
				$endtime = date("H:i", strtotime('+ '.$retry_time_limit.' minutes', strtotime($order_time)));
				$time = date('H:i');
				
				//echo $endtime = strtotime('+ '.$retry_time_limit.' minutes', strtotime( $order_time ) );
				if($time == $endtime || $time > $endtime){
					 $testArr = array(
					    'date_time' => $cur_date,
					    'order_time' => $order_time,
					    'retry_time_limit' => $data['retry_time_limit'],
					    'end_time_limit' => $retry_time_limit,
					    'time_time' => $time,
					    'endtime' => $endtime,
					    'cancle'  => $data['order_id'],
					    'order_id' => $data['order_id'],
					    
					 );
					 $result = $this->admin_model->saveRecord('cron_test',$testArr);
					 $endtime;
					 $order_id = $data['order_id'];
					 $orderInfo = $this->admin_model->getRecord('order_info',array('order_id'=>$order_id));
					 $restaurant_id = $orderInfo[0]['restaurant_id'];
					 $user_id = $orderInfo[0]['user_id'];
					 
					 /// canceled order ///
					 $update = $this->admin_model->updateRecord('order_info',array('is_canceled'=>1) ,array('order_id'=>$order_id));
					 
					  //// user notification ////
				 	  $sender_id   = $restaurant_id;
					  $receiver_id = $user_id;
					  $sub_type = 7;
				      //// get restaurant details ///
					  $senderInfo = $this->admin_model->getRecord('restaurant_info',array('restaurant_id' =>$sender_id));
					  $restName = $senderInfo[0]['restaurant_name'];
					 
					  $msg = $restName." not respond to your order request for ".$order_id." then your order is canceled.";
					  $notificationType = 1;$sub_type=7;
					 
					  $notificationArr = array(
					       'restaurant_id'     => '',
					       'deliverer_id'      => $sender_id,
					       'receiver_id'       => $receiver_id,
					       'order_id'          => $order_id,
					       'notification'      => $msg,
					       'notification_type' => 1,
					       'sub_type'          => $sub_type,
					       'is_read'           => 1,
					       'is_deleted'        => 0,
					       'created'           => date('Y-m-d , H:i:s')
					 );
					 $noticationId = $this->admin_model->saveRecord('notification_user', $notificationArr);
					 //// send  notification  /////
					 if($noticationId > 0){
					 	 
						 $deviceInfo = $this->admin_model->getRecord('user_info',array('user_id' =>$receiver_id));
						 $notfiCount = $deviceInfo[0]['notification_count']+1;
						 $totalCount = $deviceInfo[0]['total_count']+1;
						 $logUpdate = array(
							 'notification_count' => $notfiCount,
							 'total_count' => $totalCount
						 );
						 $update = $this->admin_model->updateRecord('user_info',$logUpdate ,array('user_id'=>$receiver_id));
						 /// for sending push notification
						 if($deviceInfo[0]['device_id'] != '' && $deviceInfo[0]['notification_status'] == 0){
							 $device_id = $deviceInfo[0]['device_id'];
							 ///device_type :- 0 for ios , 1for android
							 $dataArray = array();
							 $dataArray = array(
								 'notification_id' => $noticationId,
								 'sender_id' => $sender_id,
								 'order_id' => $order_id
							 );
							 if($deviceInfo[0]['device_type'] == 0){
								  $result = $this->admin_model->customer_iphone_notification($device_id,$msg,$notificationType,$sub_type,$dataArray,$totalCount);
							 }else if($deviceInfo[0]['device_type'] == 1){
							 	  
							 }
						 }
					  }
				 	  ///// ---- notification ---- ////
				 	  
				 	 ////  restaurant notification ////
				 	 //// get user details ///
					 $userInfo = $this->admin_model->getRecord('user_info',array('user_id'=>$user_id));
					 $userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
				 	 $msg= "You not respond to ".$userName."'s order request for ".$order_id." then this order is canceled.";
					 $notificationArr = array(
					       'user_id' => $user_id,
					       'receiver_id' => $restaurant_id,
					       'order_id' => $order_id,
					       'notification' => $msg,
					       'notification_type' => 1,
					       'sub_type'          => 7,
					       'is_read' => 1,
					       'created' => $cur_date
					 );
					 $notification_id = $this->admin_model->saveRecord('notification_restaurant',$notificationArr);
					 $restInfo = $this->admin_model->getRecord('restaurant_info',array('restaurant_id'=>$restaurant_id));
					 $not_count = $restInfo[0]['notification_count'] + 1;
					 $rest_update = $this->admin_model->updateRecord('restaurant_info',array('notification_count'=>$not_count),array('restaurant_id'=>$restaurant_id));
				 	 /// --- reataurant notification --- ///
					 
				}
			}
		}
		
	}
	//// ---- order timeout --- ///
	
	//// split order timeout /////
	public function splitOrderTimeOut()
	{
		//$this->cronTest();
		$serverTmzn = date_default_timezone_get(); 
		date_default_timezone_set($serverTmzn);
		$date = date('Y-m-d'); 
		$time = date('H:i');
		$current_date = date('Y-m-d , H:i:s');
		$cur_date = date('Y-m-d,H:i:s');
		
		$sql = "SELECT * FROM order_info OI WHERE OI.order_date = '".$date."' AND OI.is_canceled = 0 AND 
		        OI.full_payment_status = 0 AND OI.payment_type = 1 AND OI.restaurant_status = 0 ";
		$dataInfo = $this->admin_model->getRecordSql($sql);
		//echo "<pre/>";
		//print_r($dataInfo);
		if(!empty($dataInfo)){
			foreach($dataInfo as $data){
				$order_time = $data['order_time'];
				//$endtime = date("H:i", strtotime('+ 30 minutes', strtotime($order_time)));
				$endtime = date("H:i", strtotime('+ 15 minutes', strtotime($order_time)));
				$time = date('H:i');
				
				//echo $endtime = strtotime('+ '.$retry_time_limit.' minutes', strtotime( $order_time ) );
				if($time == $endtime || $time > $endtime){
					 
					 $endtime;
					echo $order_id = $data['order_id'];
					 $user_id = $data['user_id'];
					 
					 /// canceled order ///
					 $update = $this->admin_model->updateRecord('order_info',array('is_canceled'=>1) ,array('order_id'=>$order_id));
					 $updt = $this->admin_model->updateRecord('order_payment',array('request_status'=>3) ,array('order_id'=>$order_id,'request_status'=>0));
					 $paySql = "SELECT * FROM `order_payment` WHERE `order_id` = '".$order_id."' AND `request_status` < 2 ";
					 $orderInfo = $this->admin_model->getRecordSql($sql);
					 if(!empty($orderInfo)){
					 	 foreach($orderInfo as $info){
					 	 	  $other_user = $info['user_id'];
					 	 	  //// user notification ////
						 	  $sender_id   = '';
							  $receiver_id = $other_user;
							  $sub_type = 7;
							  
							  if( $other_user == $user_id){
							  	  $msg = "Your friends not respond to your order cost spit request for ".$order_id." then your order is canceled.";
							  }else{
							  	  $msg = "Your had order cost spit request for ".$order_id." this order is canceled.";
							  }
							  
							  $notificationType = 1;$sub_type=7;
							 
							  $notificationArr = array(
							       'restaurant_id'     => '',
							       'receiver_id'       => $receiver_id,
							       'order_id'          => $order_id,
							       'notification'      => $msg,
							       'notification_type' => 1,
							       'sub_type'          => $sub_type,
							       'is_read'           => 1,
							       'is_deleted'        => 0,
							       'created'           => date('Y-m-d , H:i:s')
							 );
							 $noticationId = $this->admin_model->saveRecord('notification_user', $notificationArr);
							 //// send  notification  /////
							 if($noticationId > 0){
							 	 
								 $deviceInfo = $this->admin_model->getRecord('user_info',array('user_id' =>$receiver_id));
								 $notfiCount = $deviceInfo[0]['notification_count']+1;
								 $totalCount = $deviceInfo[0]['total_count']+1;
								 $logUpdate = array(
									 'notification_count' => $notfiCount,
									 'total_count' => $totalCount
								 );
								 $update = $this->admin_model->updateRecord('user_info',$logUpdate ,array('user_id'=>$receiver_id));
								 /// for sending push notification
								 if($deviceInfo[0]['device_id'] != '' && $deviceInfo[0]['notification_status'] == 0){
									 $device_id = $deviceInfo[0]['device_id'];
									 ///device_type :- 0 for ios , 1for android
									 $dataArray = array();
									 $dataArray = array(
										 'notification_id' => $noticationId,
										 'sender_id' => $sender_id,
										 'order_id' => $order_id
									 );
									 if($deviceInfo[0]['device_type'] == 0){
										  $result = $this->admin_model->customer_iphone_notification($device_id,$msg,$notificationType,$sub_type,$dataArray,$totalCount);
									 }else if($deviceInfo[0]['device_type'] == 1){
									 	  
									 }
								 }
							  }
						 	  ///// ---- notification ---- ////
					 	 	   
					 	 }//// loop end
					 }/// payment 
					 
				}/// time check condition
			}/// loop end
		}
		
	}
	//// ---- split order timeout --- ///
	
	
	//// cron test ////
	public function cronTest()
	{
		$serverTmzn = date_default_timezone_get(); 
		date_default_timezone_set($serverTmzn);
		$date = date('Y-m-d'); 
		$time = date('H:s:i');
		$current_date = date('Y-m-d , H:i:s');
		$cur_date = date('Y-m-d,H:i:s');
		
		$result = $this->admin_model->saveRecord('cron_test',array('date_time' =>$cur_date ));
		$result;
	}
	/// ---- cron test ---////
	
}
?>