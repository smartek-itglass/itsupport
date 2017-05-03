<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 include (APPPATH . 'libraries/REST_Controller.php');

/**
 * 
 */
class Order extends REST_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->model('User_model');
	}
    
    /* Start Place Order */
    public function placeOrderView_get() 
	{
		 $this->load->view('webservices/place_order');
	}
	public function placeOrder_post()
	{
		$time = date('H:s:i');
		$user_id = $this->input->post('user_id');
		$restaurant_id = $this->input->post('restaurant_id');
		$order_date = $this->input->post('order_date');
		$order_time = $this->input->post('order_time');
		$flat_no = $this->input->post('flat_no');
		$street = $this->input->post('street');
		$address = $this->input->post('address');
		$landmark = $this->input->post('landmark');
		$zipcode = $this->input->post('zipcode');
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$delivery_instruction = $this->input->post('delivery_instruction');
		$estm_time = $this->input->post('estm_time');
		$coupon_code = $this->input->post('coupon_code');
		$reffer_user_count = $this->input->post('reffer_user_count');
		$coupon_discount = $this->input->post('coupon_discount');
		$discount_type = $this->input->post('discount_type');
		$discount_amount = $this->input->post('discount_amount');
		$tax = $this->input->post('tax');
		$sub_total = $this->input->post('sub_total');
		$total_amount = $this->input->post('total_amount');
		$payment_type = $this->input->post('payment_type');
		
		$full_payment_status = $this->input->post('full_payment_status');
	
		$item_list = $this->input->post('item_list');
		$payment_detail = $this->input->post('payment_detail');
		$cur_date = date('Y-m-d,H:i:s');
		$dvcTimeZone = $this->input->post('timezone');
		
		//[{"amount":"100","is_split":"0","paypal_id":"2666","transaction_id":"2666","payment_status":"1"},{"amount":"200","is_split":"0","paypal_id":"1565","transaction_id":"2666","payment_status":"1"}]
		// [{"food_item_id":"1","price":"40","quantity":"2","total_price":"30"},{"food_item_id":"2","price":"90","quantity":"1","total_price":"30"}]
		
		$a = '';
        for ($i = 0; $i<5; $i++) 
        {
            $a .= mt_rand(0,9);
        }
		$order_id = "ORD".date("md").$a;
		//echo date_default_timezone_get();
		///// convert datetime ////
		$orderDateTime = $order_date." ".$order_time;
		$order_date_time = $this->User_model->serverTime($orderDateTime,$dvcTimeZone);
	    $order_server_date = date('Y-m-d',strtotime($order_date_time));
	    $order_server_time = date('H:i:s',strtotime($order_date_time));
		
		$dataArr = array(
		   'order_id' => $order_id,
		   'user_id' => $user_id,
		   'restaurant_id' => $restaurant_id,
		   'order_date'  => $order_server_date,
		   'order_time' => $order_server_time,
		   'flat_no' => $flat_no,
		   'street' => $street,
		   'address' => $address,
		   'landmark' => $landmark,
		   'zipcode' => $zipcode,
		   'latitude' => $latitude,
		   'longitude' => $longitude,
		   'delivery_instruction' => $delivery_instruction,
		   'estm_time' => $estm_time,
		   'coupon_code' => $coupon_code,
		   'reffer_user_count' => $reffer_user_count,
		   'coupon_discount' => $coupon_discount,
		   'discount_type' => $discount_type,
		   'discount_amount' => $discount_amount,
		   'sub_total' => $sub_total,
		   'tax' => $tax,
		   'total_amount' => $total_amount,
		   'payment_type' => $payment_type,
		   'full_payment_status' => $full_payment_status,
		   'retry_update_time' => $order_server_time,
		   'created' => $cur_date
		);
		//echo "<pre/>";
        //print_r($dataArr);
        
        /// save order info ///
	    $ordId = $this->User_model->saveRecord('order_info',$dataArr);
		if($ordId > 0){
			
			/// get and insert food item data ///
			//print_r($item_list);
			$item_idArr =  preg_replace('/\\\r\\\n|\\\r|\\\n\\\r|\\\n/m', '', $item_list);
			$item_idArr = stripslashes ( $item_idArr );
			$itemArr = json_decode($item_idArr);
			//print_r($itemArr);
		    if(!empty($itemArr)){
		   	    foreach($itemArr as $item){
					$itemData = array(
					     'order_id' => $order_id,
					     'food_item_id' => $item->food_item_id,
					     'price' => $item->price,
					     'quantity' => $item->quantity,
					     'total_price' => $item->total_price,
					     'created' => $cur_date    
					);	
					$itemId = $this->User_model->saveRecord('order_item',$itemData);
		   	    }
	        }
			//// get and insert payment data ////
			$pymnt_detailArr =  preg_replace('/\\\r\\\n|\\\r|\\\n\\\r|\\\n/m', '', $payment_detail);
			$pymnt_detailArr = stripslashes ($pymnt_detailArr );
			$paymentDetailArr = json_decode($pymnt_detailArr);
			if(!empty($paymentDetailArr)){
				foreach($paymentDetailArr as $pay){
					 $split_user = $pay->user_id;
					 $paymentArr = array(
					     'order_id' => $order_id,
					     //'user_id' => $user_id,
					     'user_id' => $pay->user_id,
					     'payment_type' => $payment_type,
					     'amount' => $pay->amount,
					     'total_amount' => $total_amount,
					     'is_split' => $pay->is_split,
					     'paypal_id' => $pay->paypal_id,
					     'transaction_id' => $pay->transaction_id,
					     'payment_status' => $pay->payment_status,
					     'create_time' => $pay->create_time,
					     'state' => $pay->state,
					     'created' => $cur_date
					);
					if($payment_type == 1){
						if($user_id != $split_user){
							 //// send notification request for split ////
							  $sender_id   = $user_id;
							  $receiver_id = $split_user;
							 
						      //// get user details ///
							  $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
							  $userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
							  
							  $msg = $userName." send you to split cost request for order ".$order_id." .";
							  $notificationType = 3;$sub_type=0;
							  
							  $notificationArr = array(
							       'restaurant_id'     => '',
							       'deliverer_id'      => $sender_id,
							       'receiver_id'       => $receiver_id,
							       'order_id'          => $order_id,
							       'notification'      => $msg,
							       'notification_type' => $notificationType,
							       'sub_type'          => $sub_type,
							       'is_read'           => 1,
							       'is_deleted'        => 0,
							       'created'           => date('Y-m-d , H:i:s')
							 );
							 $noticationId = $this->User_model->saveRecord('notification_user', $notificationArr);
							 ////  notification  /////
							 if($noticationId > 0){
							 	 
								 $deviceInfo = $this->User_model->getRecord('user_info',array('user_id' =>$receiver_id));
								 $notfiCount = $deviceInfo[0]['notification_count']+1;
								 $totalCount = $deviceInfo[0]['total_count']+1;
								 $logUpdate = array(
									 'notification_count' => $notfiCount,
									 'total_count' => $totalCount
								 );
								 $update = $this->User_model->updateRecord('user_info',$logUpdate ,array('user_id'=>$receiver_id));
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
										  $result = $this->User_model->customer_iphone_notification($device_id,$msg,$notificationType,$sub_type,$dataArray,$totalCount);
									 }else if($deviceInfo[0]['device_type'] == 1){
									 	  
									 }
								 }
							  }
							 //// ---- notification ---- ////
						}
					}
					$pymntId = $this->User_model->saveRecord('order_payment',$paymentArr);
				}
			}
            if($full_payment_status == 1 && $payment_type == 0){
				//// get user details ///
				$userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
				$userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
				//// now send notification to restaurant ////
				$msg="Your have an order from '".$userName."' and order ID is ".$order_id." please acknowlege this order.";
				$notificationArr = array(
				       'user_id' => $user_id,
				       'receiver_id' => $restaurant_id,
				       'order_id' => $order_id,
				       'notification' => $msg,
				       'notification_type' => 1,
				       'sub_type'          => 0,
				       'is_read' => 1,
				       'created' => $cur_date
				);
				$notification_id = $this->User_model->saveRecord('notification_restaurant',$notificationArr);
				$restInfo = $this->User_model->getRecord('restaurant_info',array('restaurant_id'=>$restaurant_id));
				$not_count = $restInfo[0]['notification_count'] + 1;
				$rest_update = $this->User_model->updateRecord('restaurant_info',array('notification_count'=>$not_count),array('restaurant_id'=>$restaurant_id));
				
			}
			$post['message'] = "success";
		}else{
			$post['message']='error';
		}
	    //print_r($dataArr);
	    echo json_encode($post);
	}
    /* End Order */
	
	/* Start Order History */
    public function orderHistoryView_get() 
	{
		 $this->load->view('webservices/user_order_history');
	}
	public function orderHistory_post()
	{
		 $user_id = $this->input->post('user_id');
		 $page_no = $this->input->post('page_no');
		 $limit = $this->input->post('limit');
		 $dvcTimeZone = $this->input->post('timezone');
		 $start = $limit * ($page_no - 1);
		 $quryLimit = "LIMIT ".$start.','.$limit;
		 
		 $orderArr = array();
		 $sql = "SELECT OI.*,RI.restaurant_name,RI.retry_time_limit,RI.area_id,RI.city_id,RI.address,
				CT.city_name,AI.area_name,DI.first_name,DI.last_name,DI.contact,DI.alt_contact,
				OS.order_status FROM order_info OI 
				LEFT JOIN restaurant_info RI ON OI.restaurant_id = RI.restaurant_id
				LEFT JOIN city CT ON CT.city_id = RI.city_id 
				LEFT JOIN area AI ON AI.area_id = RI.area_id
				LEFT JOIN deliverer_info DI ON DI.deliverer_id = OI.deliverer_id
				LEFT JOIN order_status OS ON OS.order_status_id = OI.order_status_id
				WHERE OI.user_id = ".$user_id." AND OI.payment_type = 0 ORDER BY OI.id DESC ".$quryLimit." ";
	    $orderInfo = $this->User_model->getRecordSql($sql);
		
		if(!empty($orderInfo)){
			foreach($orderInfo as $order){
				$order_id = $order['order_id'];
				$orderDetailArr = $this->User_model->getOrderDetail($order_id,$dvcTimeZone); 
				if(!empty($orderDetailArr)){
				 	 $orderArr[] = $orderDetailArr;
				}
			}
		}
        if(!empty($orderArr)){
        	$post['message']  = "success";
	   	    $post['is_array'] = 1;
		    $post['result']   = $orderArr;
        }else{
        	$post['message']='No record found';
        }	
        echo json_encode($post);		 
	}
	/* End Order History */
	
	/* Start Get order details */
    public function orderAllDetailView_get() 
	{
		 $this->load->view('webservices/order_all_detail');
	}
	public function orderAllDetail_post()
	{
		$order_id = $this->input->post('order_id');
		$dvcTimeZone = $this->input->post('timezone');
		$orderArr = array();
		
		$orderDetailArr = $this->User_model->getOrderDetail($order_id,$dvcTimeZone); 
		if(!empty($orderDetailArr)){
		 	 $orderArr = $orderDetailArr;
		}
		
		$post['message']='success';
		$post['is_array'] = 0;
	    $post['result']=$orderArr;
		
		echo json_encode($post);
	}
    /* End order detail */
	
	/* Start resend order notification */
	public function resendOrderView_get() 
	{
		 $this->load->view('webservices/resend_order');
	}
	public function resendOrder_post()
	{
		 $order_id = $this->input->post('order_id');
		 $user_id = $this->input->post('user_id');
		 $restaurant_id = $this->input->post('restaurant_id');
		 $dvcTimeZone = $this->input->post('timezone');
		 $cur_date = date('Y-m-d,H:i:s');
		 
		 $orderInfo = $this->User_model->getRecord('order_info',array('order_id'=>$order_id));
		 if(!empty($orderInfo)){
		 	 $retry_count = $orderInfo[0]['retry_count'];
			 $new_count = $retry_count + 1;
			 
			 if($new_count < 3){
			 	 
				 $updtArr = array(
				     'order_time'  => date('H:i:s'),
				     'retry_count' => $new_count,
				     'retry_update_time' => date('H:i:s'),
				 );
				 $this->User_model->updateRecord('order_info',$updtArr ,array('order_id'=>$order_id));
			 	 //// get user details ///
				 $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
				 $userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
				 //// now send notification to restaurant ////
				 $msg="Your have an order from '".$userName."' and order ID is ".$order_id." please acknowlege this order.";
				 $notificationArr = array(
				       'user_id' => $user_id,
				       'receiver_id' => $restaurant_id,
				       'order_id' => $order_id,
				       'notification' => $msg,
				       'notification_type' => 1,
				       'sub_type'          => 0,
				       'is_read' => 1,
				       'created' => $cur_date
				 );
				 $notification_id = $this->User_model->saveRecord('notification_restaurant',$notificationArr);
				 $restInfo = $this->User_model->getRecord('restaurant_info',array('restaurant_id'=>$restaurant_id));
				 $not_count = $restInfo[0]['notification_count'] + 1;
				 $rest_update = $this->User_model->updateRecord('restaurant_info',array('notification_count'=>$not_count),array('restaurant_id'=>$restaurant_id));
				 $post['message'] = "success";
			 }else{
			 	 $post['message']='error';
			 }
			 
		 }else{
		 	 $post['message']='error';
		 }
		 echo json_encode($post);
		 
	}
	/* End resed order notification */
	
	/* Start order review */
	public function orderReviewView_get() 
	{
		 $this->load->view('webservices/order_review');
	}
	public function orderReview_post()
	{
		 $order_id = $this->input->post('order_id');
		 $user_id = $this->input->post('user_id');
		 $restaurant_id = $this->input->post('restaurant_id');
		 $deliverer_id = $this->input->post('deliverer_id');
		 $title = $this->input->post('title');
		 $comment = $this->input->post('comment');
		 $rating = $this->input->post('rating');
		 $dvcTimeZone = $this->input->post('timezone');
		 $cur_date = date('Y-m-d,H:i:s');
		 
		 $dataArr = array(
		       'order_id' => $order_id,
		       'user_id' => $user_id,
		       'restaurant_id' => $restaurant_id,
		       'deliverer_id' => $deliverer_id,
		       'title' => $title,
		       'comment' => $comment,
		       'rating' => $rating
		 );
		 $reviewInfo = $this->User_model->getRecord('review',array('user_id'=>$user_id,'order_id'=>$order_id));
		 if(!empty($reviewInfo)){
		 	  //// update old review ///
		 	  $review_id = $reviewInfo[0]['review_id'];
		 	  $dataArr['updated'] = $cur_date;
			  $this->User_model->updateRecord('review',$dataArr,array('review_id'=>$review_id));
			  $post['message']='success';
		      $post['is_array'] = 0;
		 }else{
		 	  /// save review ////
		 	  $dataArr['created'] = $cur_date;
			  $review_id = $this->User_model->saveRecord('review',$dataArr);
			  if($review_id != 0){
			  	    $post['message']='success';
		            $post['is_array'] = 0;
			  }else{
			  	    $post['message']='error';
			  }
		 }
		 echo json_encode($post);
	}
	/* End order review */
	
	/* Send contact request to deliverer */
	public function contactRequestView_get() 
	{
		 $this->load->view('webservices/user_contact_request');
	}
	public function contactRequest_post()
	{
		 $order_id = $this->input->post('order_id');
		 $user_id = $this->input->post('user_id'); 
		 $deliverer_id = $this->input->post('deliverer_id');
		 $dvcTimeZone = $this->input->post('timezone');
		 $cur_date = date('Y-m-d,H:i:s');
		 
		 $dataArr = array(
		      'order_id'        => $order_id,
		      'send_by_cutomer' => $user_id,
		      'receiver_id'     => $deliverer_id,
		      'status'          => 0,
		      'created'         => $cur_date
		 );
		 
		 $shareInfo = $this->User_model->getRecord('order_contact_share',array('order_id'=>$order_id));
		 if(!empty($shareInfo)){
		 	$share_id = $shareInfo[0]['share_id'];
			$updt = $this->User_model->updateRecord('order_contact_share',$dataArr,array('share_id'=>$share_id));
		 }else{
		 	$share_id = $this->User_model->saveRecord('order_contact_share',$dataArr);
		 }
		 
		 $share_id = $this->User_model->saveRecord('order_contact_share',$dataArr);
		 if($share_id != 0){
		 	    $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
			    $userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
		 	    ///// notification //////
		 	    $sub_type = 0;
		 	    $msg = $userName." request you to share your contact number.";
				$dlvrNotifArr = array(
				       'restaurant_id'     => '',
				       'user_id'           => $user_id,
				       'receiver_id'       => $deliverer_id,
				       'order_id'          => $order_id,
				       'notification'      => $msg,
				       'notification_type' => 2,
				       'sub_type'          => $sub_type,
				       'is_read'           => 1,
				       'is_deleted'        => 0,
				       'created'           => date('Y-m-d , H:i:s')
				 );
				 $dlvrNotifiId = $this->User_model->saveRecord('notification_deliverer', $dlvrNotifArr);
			     if($dlvrNotifiId > 0){
	 
				     $dlvrerInfo = $this->User_model->getRecord('deliverer_info',array('deliverer_id' =>$deliverer_id));
					 $dlvrNotfiCount = $dlvrerInfo[0]['notification_count']+1;
					 $dlvrTotalCount = $dlvrerInfo[0]['total_count']+1;
					 $dlvrLogUpdate = array(
						 'notification_count' => $dlvrNotfiCount,
						 'total_count' => $dlvrTotalCount
					 );
					 $update = $this->User_model->updateRecord('deliverer_info',$dlvrLogUpdate ,array('deliverer_id'=>$deliverer_id));
					 /// for sending push notification
					 if($dlvrerInfo[0]['device_id'] != '' && $dlvrerInfo[0]['notification_status'] == 0){
						 $dlvr_device_id = $dlvrerInfo[0]['device_id'];
						 ///device_type :- 0 for ios , 1for android
						 $dataArray = array();
						 $dataArray = array(
							 'notification_id' => $dlvrNotifiId,
							 'sender_id' => $user_id,
							 'order_id' => $order_id
						 );
						 if($dlvrerInfo[0]['device_type'] == 0){
							  $result = $this->User_model->delivery_iphone_notification($dlvr_device_id,$msg,2,$sub_type,$dataArray,$dlvrTotalCount);
						 }else if($dlvrerInfo[0]['device_type'] == 1){
						 	    
						 }
					 }
				 }
		 	   //// ---- notification --- ///
		  	  $post['message']='success';
	          $post['is_array'] = 0;
		 }else{
		  	  $post['message']='error';
		 }
		 echo json_encode($post);
	}
	/* End contact request */
	
	/* Response contact request to deliverer */
	public function responseContactReqView_get() 
	{
		 $this->load->view('webservices/user_contact_response');
	}
	public function responseContactReq_post()
	{
		 $order_id = $this->input->post('order_id');
		 $user_id = $this->input->post('user_id'); 
		 $deliverer_id = $this->input->post('deliverer_id');
		 $status = $this->input->post('status');
		 $cur_date = date('Y-m-d,H:i:s');
		 $dvcTimeZone = $this->input->post('timezone');
		 $request_status = ($status == 1)?'Accept':'Reject';
		 
		 $dataArr = array(
		      'order_id'        => $order_id,
		      'send_by_deliverer' => $deliverer_id,
		      'receiver_id'       => $user_id,
		      'status'            => 0
		 );
		 
		 $shareInfo = $this->User_model->getRecord('order_contact_share',$dataArr);
		 //echo "<pre/>";
		 //print_r($shareInfo);
		 if(!empty($shareInfo)){
		 	    $share_id = $shareInfo[0]['share_id'];
			    if($status == 1){
			   	   $this->User_model->updateRecord('order_info',array('is_contact_share' => 1) ,array('order_id'=>$order_id));
			    }
			    //if($status == 1){
			   	    $updtArr = array('status'=>$status,'updated'=>$cur_date);
			   	    $this->User_model->updateRecord('order_contact_share',$updtArr ,array('share_id'=>$share_id));
			    //}elseif($status == 2){
			   	   // $this->User_model->deleteRecord('order_contact_share',array('share_id'=>$share_id));
			   // }
			   
			    ///// notification /////
			    $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
			    $userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
			    $sub_type = $status;
		 	    $msg = $userName." ".$request_status. " your request for share contact number.";
				$dlvrNotifArr = array(
				       'restaurant_id'     => '',
				       'user_id'           => $user_id,
				       'receiver_id'       => $deliverer_id,
				       'order_id'          => $order_id,
				       'notification'      => $msg,
				       'notification_type' => 2,
				       'sub_type'          => $sub_type,
				       'is_read'           => 1,
				       'is_deleted'        => 0,
				       'created'           => date('Y-m-d , H:i:s')
				 );
				 $dlvrNotifiId = $this->User_model->saveRecord('notification_deliverer', $dlvrNotifArr);
			     if($dlvrNotifiId > 0){
	 
				     $dlvrerInfo = $this->User_model->getRecord('deliverer_info',array('deliverer_id' =>$deliverer_id));
					 $dlvrNotfiCount = $dlvrerInfo[0]['notification_count']+1;
					 $dlvrTotalCount = $dlvrerInfo[0]['total_count']+1;
					 $dlvrLogUpdate = array(
						 'notification_count' => $dlvrNotfiCount,
						 'total_count' => $dlvrTotalCount
					 );
					 $update = $this->User_model->updateRecord('deliverer_info',$dlvrLogUpdate ,array('deliverer_id'=>$deliverer_id));
					 //// for sending push notification ////
					 if($dlvrerInfo[0]['device_id'] != '' && $dlvrerInfo[0]['notification_status'] == 0){
						 $dlvr_device_id = $dlvrerInfo[0]['device_id'];
						 ///device_type :- 0 for ios , 1for android
						 $dataArray = array();
						 $dataArray = array(
							 'notification_id' => $dlvrNotifiId,
							 'sender_id' => $user_id,
							 'order_id' => $order_id
						 );
						 if($dlvrerInfo[0]['device_type'] == 0){
							  $result = $this->User_model->delivery_iphone_notification($dlvr_device_id,$msg,2,$sub_type,$dataArray,$dlvrTotalCount);
						 }else if($dlvrerInfo[0]['device_type'] == 1){
						 	    
						 }
					 }
				 }
			    ///// --- notification ---- ////
			    $post['message']='success';
	            $post['is_array'] = 0;
		 }else{
		 	  $post['message']='error';
		 }
		 echo json_encode($post);
	}
	/* response to contact request */
	
	/* start cancle order */
	public function cancleOrderView_get() 
	{
		 $this->load->view('webservices/cancle_order');
	}
	public function cancleOrder_post()
	{
		 $order_id = $this->input->post('order_id');
		 $cur_date = date('Y-m-d,H:i:s');
		 $orderInfo = $this->User_model->getRecord('order_info',array('order_id'=>$order_id,'is_canceled'=>0));
		 if(!empty($orderInfo)){
		 	   $restaurant_id = $orderInfo[0]['restaurant_id'];
			   $user_id = $orderInfo[0]['user_id'];
			   $deliverer_id = $orderInfo[0]['deliverer_id'];	 
				 /// canceled order ///
		         $update = $this->User_model->updateRecord('order_info',array('is_canceled'=>1) ,array('order_id'=>$order_id));
		         
		         //// get user details ///
				 $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
				 $userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
				 
				 /// update cancel order count ///
					$reject_order_count = $userInfo[0]['reject_order_count'] + 1;
					$total_reject_count = $userInfo[0]['total_reject_count'] + 1;
					
					$updtRjct = array(
					     'reject_order_count' => $reject_order_count,
					     'total_reject_count' => $total_reject_count
					);
					$this->User_model->updateRecord('user_info',$updtRjct,array('user_id'=>$user_id));
				 /// ---- update acncel order count ---- ///
				 
				 if($restaurant_id != ''){
				     ////  restaurant notification ////
				 	 $msg = $userName." cancel order ".$order_id.".";
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
					 $notification_id = $this->User_model->saveRecord('notification_restaurant',$notificationArr);
					 $restInfo = $this->User_model->getRecord('restaurant_info',array('restaurant_id'=>$restaurant_id));
					 $not_count = $restInfo[0]['notification_count'] + 1;
					 $rest_update = $this->User_model->updateRecord('restaurant_info',array('notification_count'=>$not_count),array('restaurant_id'=>$restaurant_id));
			 	     /// --- reataurant notification --- ///
			 	 }
                 if($deliverer_id != ''){
                 	    ///// deliverer notification /////
					    $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
					    $userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
					    $sub_type = 7;
				 	    $msg = $userName." cancel order ".$order_id.".";
						$dlvrNotifArr = array(
						       'restaurant_id'     => '',
						       'user_id'           => $user_id,
						       'receiver_id'       => $deliverer_id,
						       'order_id'          => $order_id,
						       'notification'      => $msg,
						       'notification_type' => 7,
						       'sub_type'          => $sub_type,
						       'is_read'           => 1,
						       'is_deleted'        => 0,
						       'created'           => date('Y-m-d , H:i:s')
						 );
						 $dlvrNotifiId = $this->User_model->saveRecord('notification_deliverer', $dlvrNotifArr);
					     if($dlvrNotifiId > 0){
			 
						     $dlvrerInfo = $this->User_model->getRecord('deliverer_info',array('deliverer_id' =>$deliverer_id));
							 $dlvrNotfiCount = $dlvrerInfo[0]['notification_count']+1;
							 $dlvrTotalCount = $dlvrerInfo[0]['total_count']+1;
							 $dlvrLogUpdate = array(
								 'notification_count' => $dlvrNotfiCount,
								 'total_count' => $dlvrTotalCount
							 );
							 $update = $this->User_model->updateRecord('deliverer_info',$dlvrLogUpdate ,array('deliverer_id'=>$deliverer_id));
							 //// for sending push notification ////
							 if($dlvrerInfo[0]['device_id'] != '' && $dlvrerInfo[0]['notification_status'] == 0){
								 $dlvr_device_id = $dlvrerInfo[0]['device_id'];
								 ///device_type :- 0 for ios , 1for android
								 $dataArray = array();
								 $dataArray = array(
									 'notification_id' => $dlvrNotifiId,
									 'sender_id' => $user_id,
									 'order_id' => $order_id
								 );
								 if($dlvrerInfo[0]['device_type'] == 0){
									  $result = $this->User_model->delivery_iphone_notification($dlvr_device_id,$msg,7,$sub_type,$dataArray,$dlvrTotalCount);
								 }else if($dlvrerInfo[0]['device_type'] == 1){
								 	    
								 }
							 }
						 }
					  ///// --- deliverer  notification ---- ////
                 }
			     $post['message'] = "success";
		 }else{
		 	  $post['message']='error';
		 }
		 echo json_encode($post);
	}
	/* end cancle order */
	
	/* start response split request */
	public function responseSplitReqView_get() 
	{
		 $this->load->view('webservices/user_split_response');
	}
	public function responseSplitReq_post()
	{
		 $order_id = $this->input->post('order_id');
		 $user_id = $this->input->post('user_id'); 
		 $status = $this->input->post('status');
		 $dvcTimeZone = $this->input->post('timezone');
		 $cur_date = date('Y-m-d,H:i:s');
		 $request_status = ($status == 1)?'accept':'reject';
		 
		 $orderArr = array(
			  'order_id'=>$order_id,
			  'order_date'=>date('Y-m-d'),
			  'is_canceled'=>0
		 );
		 $orderInfo = $this->User_model->getRecord('order_info',$orderArr);
		 if(!empty($orderInfo)){
		 	 $order_user = $orderInfo[0]['user_id'];
			 $dataArr = array(
			      'order_id'  => $order_id,
			      'user_id'   => $user_id,
			      'request_status' => 0
			 );
		 	 $splitInfo = $this->User_model->getRecord('order_payment',$dataArr);
			 if(!empty($splitInfo)){
			 	 
				 $order_payment_id = $splitInfo[0]['order_payment_id'];
				 $this->User_model->updateRecord('order_payment',array('request_status' => $status) ,array('order_payment_id'=>$order_payment_id));
				 
				  //// notification ///
				  $sender_id   = $user_id;
				  $receiver_id = $order_user;
				 
			      //// get user details ///
				  $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
				  $userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
				 
				  $msg = $userName." ".$request_status." your split cost request for order ".$order_id." .";
				  $notificationType = 3;$sub_type=3;
				 
				  $notificationArr = array(
				       'restaurant_id'     => '',
				       'deliverer_id'      => $sender_id,
				       'receiver_id'       => $receiver_id,
				       'order_id'          => $order_id,
				       'notification'      => $msg,
				       'notification_type' => $notificationType,
				       'sub_type'          => $sub_type,
				       'is_read'           => 1,
				       'is_deleted'        => 0,
				       'created'           => date('Y-m-d , H:i:s')
				 );
				 $noticationId = $this->User_model->saveRecord('notification_user', $notificationArr);
				 ////  notification  /////
				 if($noticationId > 0){
				 	 
					 $deviceInfo = $this->User_model->getRecord('user_info',array('user_id' =>$receiver_id));
					 $notfiCount = $deviceInfo[0]['notification_count']+1;
					 $totalCount = $deviceInfo[0]['total_count']+1;
					 $logUpdate = array(
						 'notification_count' => $notfiCount,
						 'total_count' => $totalCount
					 );
					 $update = $this->User_model->updateRecord('user_info',$logUpdate ,array('user_id'=>$receiver_id));
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
							  $result = $this->User_model->customer_iphone_notification($device_id,$msg,$notificationType,$sub_type,$dataArray,$totalCount);
						 }else if($deviceInfo[0]['device_type'] == 1){
						 	  
						 }
					 }
				  }
                  /// check is other split user is remaining for payment ///
				  $checkSql = "SELECT * FROM `order_payment` WHERE `order_id` = '".$order_id."' AND 
				               `user_id` != '".$order_user."' AND `request_status` < 2 AND `payment_status` = 0 ";
				  $avilbUser = $this->User_model->getRecordSql($checkSql);
				  
				  if($avilbUser == 0){
				  	   $updateOwner = array(
					       'order_id' => $order_id,
		                   'user_id'  => $order_user
					   );
				  	   $updt = $this->User_model->updateRecord('order_payment',array('request_status' =>1),$updateOwner); 
				  }			   
				 /// --- motification --- ///
				 $post['message'] = "success";
			 }else{
			 	 $post['message']='error';
			 }	
		 }else{
		 	 $post['message']='Order not available';
		 }
		 echo json_encode($post);
	}
	/* end split request */
	
	/* start split payment */
	public function orderSplitPaymentView_get() 
	{
		 $this->load->view('webservices/order_split_payment');
	}
	public function orderSplitPayment_post()
	{
		 $order_id = $this->input->post('order_id');
		 $user_id = $this->input->post('user_id'); 
		 $amount = $this->input->post('amount'); 
		 $paypal_id = $this->input->post('paypal_id'); 
		 $transaction_id = $this->input->post('transaction_id'); 
		 $payment_status = $this->input->post('payment_status'); 
		 $create_time = $this->input->post('create_time'); 
		 $state = $this->input->post('state'); 
		 $dvcTimeZone = $this->input->post('timezone');
		 $cur_date = date('Y-m-d,H:i:s');
		 
		 $orderArr = array(
			  'order_id'    => $order_id,
			  'order_date'  => date('Y-m-d'),
			  'is_canceled' => 0
		 );
		 $orderInfo = $this->User_model->getRecord('order_info',$orderArr);
		 if(!empty($orderInfo)){
		      $order_user = $orderInfo[0]['user_id'];
			  $dataArr = array(
			      'order_id' => $order_id,
			      'user_id'  => $user_id,
			      'request_status' => 1
			  );
		 	  $splitInfo = $this->User_model->getRecord('order_payment',$dataArr);
			  if(!empty($splitInfo)){
			  	   $order_payment_id = $splitInfo[0]['order_payment_id'];
			       $updtArr = array(
				        'amount' => $amount,
				        'paypal_id' => $paypal_id,
				        'transaction_id' => $transaction_id,
				        'payment_status' => $payment_status,
				        'create_time' => $create_time,
				        'state' => $state,
				        'payment_status' => 1
				   ); 
				   //print_r($updtArr);
			      $updt_id = $this->User_model->updateRecord('order_payment',$updtArr,array('order_payment_id'=>$order_payment_id)); 
				  if($updt_id != 0){
				  	  if($user_id != $order_user)	{
					  	  //// send notification to owner of order that other user done paymnet ///
					  	  $sender_id   = $user_id;
						  $receiver_id = $order_user;
						 
					      //// get user details ///
						  $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
						  $userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
						 
						  $msg = $userName." done split cost payment for your order ".$order_id." .";
						  $notificationType = 3;$sub_type=3;
						 
						  $notificationArr = array(
						       'restaurant_id'     => '',
						       'deliverer_id'      => $sender_id,
						       'receiver_id'       => $receiver_id,
						       'order_id'          => $order_id,
						       'notification'      => $msg,
						       'notification_type' => $notificationType,
						       'sub_type'          => $sub_type,
						       'is_read'           => 1,
						       'is_deleted'        => 0,
						       'created'           => date('Y-m-d , H:i:s')
						 );
						 $noticationId = $this->User_model->saveRecord('notification_user', $notificationArr);
						 ////  notification  /////
						 if($noticationId > 0){
						 	 
							 $deviceInfo = $this->User_model->getRecord('user_info',array('user_id' =>$receiver_id));
							 $notfiCount = $deviceInfo[0]['notification_count']+1;
							 $totalCount = $deviceInfo[0]['total_count']+1;
							 $logUpdate = array(
								 'notification_count' => $notfiCount,
								 'total_count' => $totalCount
							 );
							 $update = $this->User_model->updateRecord('user_info',$logUpdate ,array('user_id'=>$receiver_id));
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
									  $result = $this->User_model->customer_iphone_notification($device_id,$msg,$notificationType,$sub_type,$dataArray,$totalCount);
								 }else if($deviceInfo[0]['device_type'] == 1){
								 	  
								 }
							 }
						  }
					  	  //// --- notification ---- /////
					  }elseif($order_user == $user_id){
					  	    $restaurant_id = $orderInfo[0]['restaurant_id'];
							$orderUpdtArr = array(
							    'order_time' => date('H:i:s'),
							    'full_payment_status' => 1
							);
							$order_update = $this->User_model->updateRecord('order_info',$orderUpdtArr,array('order_id'=>$order_id));
					  	    
					  	    //// get user details ///
							$userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
							$userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
							//// now send notification to restaurant ////
							$msg="Your have an order from '".$userName."' and order ID is ".$order_id." please acknowlege this order.";
							$notificationArr = array(
							       'user_id' => $user_id,
							       'receiver_id' => $restaurant_id,
							       'order_id' => $order_id,
							       'notification' => $msg,
							       'notification_type' => 1,
							       'sub_type'          => 0,
							       'is_read' => 1,
							       'created' => $cur_date
							);
							$notification_id = $this->User_model->saveRecord('notification_restaurant',$notificationArr);
							$restInfo = $this->User_model->getRecord('restaurant_info',array('restaurant_id'=>$restaurant_id));
							$not_count = $restInfo[0]['notification_count'] + 1;
							$rest_update = $this->User_model->updateRecord('restaurant_info',array('notification_count'=>$not_count),array('restaurant_id'=>$restaurant_id));
				            
					  }
					  /// check is other split user is remaining for payment ///
					  $checkSql = "SELECT * FROM `order_payment` WHERE `order_id` = '".$order_id."' AND 
					               `user_id` != '".$order_user."' AND `request_status` < 2 AND `payment_status` = 0 ";
					  $avilbUser = $this->User_model->getRecordSql($checkSql);
					  
					  if($avilbUser == 0){
					  	   $updateOwner = array(
						       'order_id' => $order_id,
			                   'user_id'  => $order_user
						   );
					  	   $updt = $this->User_model->updateRecord('order_payment',array('request_status' =>1),$updateOwner); 
					  }			   
					  $post['message'] = "success";
				  }else{
				  	  $post['message'] = 'error';
				  }
			  }else{
			 	   $post['message']='Order not available for payment';
			  }
		 }else{
		 	 $post['message']='Order not available';
		 }
		 echo json_encode($post);
	}
	/* end split payment */
	
	/* user list for split */
	public function allUserListView_get() 
	{
		 $this->load->view('webservices/all_user_list');
	}
	public function allUserList_post()
	{
		 $user_id = $this->input->post('user_id'); 
		 $userArr = array();
		 
		 $sql = "SELECT * FROM `user_info` WHERE `user_id` != ".$user_id." AND `is_delete` = 0 ";
	     $userInfo = $this->User_model->getRecordSql($sql);
		 
		 if(!empty($userInfo)){
		 	foreach($userInfo as $user){
		 		 $userArr[] = array(
				     'user_id' => $user['user_id'],
				     'user_name' => $user['first_name'].' '.$user['last_name']
				 );
		 	 }
		 }
		 if(!empty($userArr)){
		  	 $post['message']  = "success";
	   	     $post['is_array'] = 1;
		     $post['result']   = $userArr;
		 }else{
		 	 $post['message']='No record found';
		 }
		 echo json_encode($post);
	}
	/* end user list for split */
	
	/* Start Order History */
    public function splitOrderHistoryView_get() 
	{
		 $this->load->view('webservices/split_order_history');
	}
	public function splitOrderHistory_post()
	{
		 $user_id = $this->input->post('user_id');
		 $page_no = $this->input->post('page_no');
		 $limit = $this->input->post('limit');
		 $dvcTimeZone = $this->input->post('timezone');
		 $start = $limit * ($page_no - 1);
		 $quryLimit = "LIMIT ".$start.','.$limit;
		 
		 $orderArr = array();
		 $sql = "SELECT * FROM `order_payment` WHERE `user_id` = ".$user_id." AND `is_split` = 1 
		         ORDER BY `order_payment_id` DESC ".$quryLimit." ";
	     $orderInfo = $this->User_model->getRecordSql($sql);
		
		 if(!empty($orderInfo)){
			foreach($orderInfo as $order){
				$order_id = $order['order_id'];
				$orderDetailArr = $this->User_model->getOrderDetail($order_id,$dvcTimeZone); 
				if(!empty($orderDetailArr)){
				 	 $orderArr[] = $orderDetailArr;
				}
			}
		 }
        if(!empty($orderArr)){
        	$post['message']  = "success";
	   	    $post['is_array'] = 1;
		    $post['result']   = $orderArr;
        }else{
        	$post['message']='No record found';
        }	
        echo json_encode($post);		 
	}
	/* End Order History */
}
?>