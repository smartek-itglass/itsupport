<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 include (APPPATH . 'libraries/REST_Controller.php');

/**
 * 
 */
class Deliverer extends REST_Controller 
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('User_model');
	}
	public function delivererRegisterView_get() 
	{
		 $this->load->view('webservices/deliverer_registration');
	}
	public function delivererRegister_post() {
		
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$contact = $this->input->post('contact');
		$city_id = $this->input->post('city_id');
		$area_id = $this->input->post('area_id');
		$address = $this->input->post('address');
		$password = $this->input->post('password');
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$device_id = $this->input->post('device_id');
		$device_type = $this->input->post('device_type');
		$dvc_date = date('Y-m-d , H:i:s');
		$dvcTimeZone = $this->input->post('timezone');
		$device_time_zone = date_default_timezone_get();
		$cur_date = $this->User_model->convertTime($dvc_date,$device_time_zone);
		
		$already = $this->User_model->getRecord('deliverer_info',array('email'=>$email,'is_delete'=>0));
		if($already == 0){
			// if email is not in database 
			 $data = array(
			     'first_name' => $first_name,
			     'last_name' => $last_name,
			     'contact'   => $contact,
			     'email'=> $email,
			     'city_id' => $city_id,
			     'area_id' => $area_id,
			     'address' => $address,
				 'password'=> $password,
				 'device_id'=> $device_id,
				 'device_type'=> $device_type,
				 'latitude' => $latitude,
				 'longitude' => $longitude,
				 'is_verify' => 1,
				 'is_approved' => 1,
				 'duty_status' => 1,
				 'login_status' => 1,
				 'created' => $cur_date,
			 );
			 $logId = $this->User_model->saveRecord('deliverer_info',$data);
			 if($logId != 0){
				 $post['message']="success";
				 
				 $enc_logId = $this->User_model->encrypt_decrypt('encrypt', $logId);
				 $subject='Verify Email For Deliverer';
				 $text = base_url().'index.php/Deliverer/verifyEmail/'.$enc_logId;
				 /*$message = '<html>
                    <head><meta charset="utf-8"><title>Fooder App</title></head>
					<body style=""><div style=" overflow:hidden; max-width:540px; width:100%; padding:10px; box-sizing:border-box; margin:0 auto;">
 						<div style=" text-align:center;margin-bottom: 2px; overflow:hidden; background:#fff; padding-left:10px;">
				            <div style="width:100%; margin:0 auto; background:#fff; padding:5px; box-sizing:border-box;">
								<h1 style=" font-size:16px;font-family:Arial, Helvetica, sans-serif;">Verify Email</h1>
								<div style="background:#CCCFFF; color:#000; padding:10px; font-family:Arial, Helvetica, sans-serif;">
								<label style="color:#D85555; font-size:14px;"><b>Email Id:</b></label>'.$email.'<br style="margin-top:10px;"><br>
								<label style="color:#D85555;font-size:14px;"><b> To verify your email  </b></label>
								<a href="'.$text.'"/>click here</a><br style="margin-top:10px;"><br></div>
				            </div>
			            </div>
		            </body>
	            </html>';	*/
	            $imageUrl = base_url().'images/'; 
	            $message = '<!DOCTYPE html>
							<html xmlns="http://www.w3.org/1999/xhtml">
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<title>Untitled Document</title>
							</head>
							<body>
							<table data-thumb="#" data-module="Menu" data-bgcolor="Main BG" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" align="center" style="    border: 1px solid #efefef;">
										<tbody><tr>
											<td align="center">
							                  <table data-thumb="#" data-module="Menu" data-bgcolor="Main BG" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" align="center" class="">
												<tbody><tr>
													<td align="center">
														<!--TABLE SECTION-800 START-->
														<table class="display-width" data-bgcolor="Menu BG" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="" align="center" style="padding-bottom: 20px;    border-top: 4px solid #238ac7;">
															<tbody><tr>
																<td align="center">
																	<table class="display-width" width="100%" cellspacing="0" cellpadding="0" border="0" align=	                                 "center">
																		<tbody>
																		<tr>
																			<td class="padding" align="center" >
																	
																				<!--TABLE SECTION-600 START-->
																				<table class="display-width" width="95%" cellspacing="0" cellpadding="0" border="0"                                              align="center">
																					<tbody><tr>
																						<td align="center">
																							<table class="display-width-4" width="100%" cellspacing="0" cellpadding                                                          ="0" border="0" align="center">
																								<tbody><tr>
																									<td height="15"></td>
																								</tr>
																								<tr>
																									<td style="border-bottom: 1px solid #eee">
																										<table class="menu-width" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; " width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
																											<tbody><tr>
																												<td align="left">
																													<table class="display-width" style="" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
																														<tbody>
																														<tr>
																															<td align="center">
																																<a href="#" style="text-decoration:none; color:#ffffff;" data-color="Menu">
																																	<img src="logo1.png" alt="150x50" style="margin:0; border:0; padding:0;" width="">
																																</a>
																															</td>
																														</tr>
																														<tr>
																															<td height="15"></td>
																														</tr>
																														<tr>
																															
																														</tr>
																													</tbody></table>
																												</td>
																												
																											</tr>
																										</tbody></table>
																									</td>
																								</tr>
																								<tr>
																							<td height="10"></td>
																						</tr>
																								<tr>
																									<td style="text-align: left;font-size:24px;font-weight: 700; font-family: Segoe UI, Helvetica Neue, Arial, Verdana, Trebuchet MS, sans-serif;">
																									<br>
																									Hello Deliverer,
																									</td>
																								</tr>		
																								<tr>
																									<td height="5"></td>
																								</tr>
																								
																							</tbody></table>
																						</td>
																					</tr>
																				</tbody></table>
																				<!--TABLE SECTION-600 END-->
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														<!--TABLE SECTION-800 END-->
													</td>
												</tr>
											</tbody></table>
									<table class="display-width" style=" background-position:center; background-repeat:no-repeat;" data-bg="Header BG Image" width="100%" height="" cellspacing="0" cellpadding="0" border="0" background="banner.jpg" align="center">
										<tbody><tr>
											<td align="center">
												<!--TABLE SECTION-600 START-->
												<table class="display-width" width="95%" cellspacing="0" cellpadding="0" border="0" align="left">
													<tbody><tr>
															<td align="center">
																<table class="display-width-4" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
																	<tbody>
																		
																		<tr>
																			<td>
																				<!--TABLE LEFT-->
																				<table class="display-width-1" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
																				<tbody>
																						
																						
																						</tr>
																						
																						
																						
																						<tr>	
																							<td class="MsoNormal" style="color:#000000; font-family:Segoe UI, Helvetica Neue, Arial, Verdana, Trebuchet MS, sans-serif; font-size:20px; line-height:50px;letter-spacing:1px;font-weight: 300;padding-left: 6%;line-height: 30px;" data-color="Header SubHeading" data-size="Header SubHeading" data-min="12" data-max="38" align="left">
																							<b>Thank you for register in Fooder App</b><br/>
							<b>To verify you email please <a href="'.$text.'"/>click here</a> !</b> 
																							</td>
																						</tr>
																						
																						<tr>
																							<td style="text-align: center;font-size: 20px;font-weight: 600; font-family: Segoe UI, Helvetica Neue, Arial, Verdana, Trebuchet MS, sans-serif;color: #00a1b1;">
																							<p style="margin-top:0;margin-bottom: 5px;margin-top:4%;">We hope you are getting good service from Fooder App !</p>
																							<!--a href="https://www.aquariumgalleryperth.com.au" style="color: #00a1b1;font-size: 26px;">https://www.aquariumgalleryperth.com.au/</a--> <br></td>
																						</tr>
																									</tbody></table>
																									</td>
																									</tr>
																									<tr>
																										<td height="60">
																										</td>
																									</tr>
																								</tbody></table>
																							</td>
																						</tr>
																					</tbody></table>
																					<!--TABLE SECTION-600 END-->
																				
																				</td>
																			</tr>
																		
									</tbody></table>
									
									</td>
								</tr>
							</tbody></table>
							</td>
								</tr>
							</tbody></table>
							</body>
							</html>';
				 $mail_result=$this->User_model->sendEmail($email,$subject,$message);
				 //$post = $this->User_model->getDelivererInfo($logId);
			 }else{
				 $post['message']="Error";
			 }
		}else{
			 $post['message']="Email already exists";
		}
		echo json_encode($post); 
	}
	public function verifyEmail_get()
	{
		//This function is for verify email
		//now getting the vaues from url
		$id=$this->uri->segment(3);
		$login_id=$this->User_model->encrypt_decrypt('decrypt', $id);
		//echo $login_id;
		$result = $this->User_model->getRecord('deliverer_info',array('deliverer_id'=>$login_id));
		$result[0]['email'];
		//$post['message']="success";
		//echo json_encode($post); 
		if($result==0)
		{
			//credential not found in the database	
			echo "invalid credential";
		}
		else 
		{
			//creadential found in the database
			//now update the verification status for this user
			$this->User_model->updateRecord('deliverer_info',array('is_verify'=>0),array('deliverer_id'=>$login_id));
			
		    echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					   <title>Fooder App</title>
					</head>
					<body>
						<div style="overflow:hidden;max-width:640px;width:100%;color:#000;margin-top:500px;
									 font-family:Arial, Helvetica, sans-serif; box-sizing:border-box; margin:0 auto;
									 background-color: #f5f5f5;border-color: #ddd; padding:22px;">
							  <span style="text-align:center"><b>Your email  "'.$result[0]['email'].'"  successfully verified !</b></span>
						</div>
					</body>
				</html>';
		}
	}
    /* Start Deliver login */
	public function delivererLoginView_get() 
	{
		 $this->load->view('webservices/deliverer_login');
	}
	public function delivererLogin_post() 
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$device_id = $this->input->post('device_id');
		$device_type = $this->input->post('device_type');
		$dvcTimeZone = $this->input->post('timezone');
		//$cur_date = date('Y-m-d , H:i:s');
		$dvc_date = date('Y-m-d , H:i:s');
		$device_time_zone = date_default_timezone_get();
		$cur_date = $this->User_model->convertTime($dvc_date,$device_time_zone);
		$imagePath = base_url().'profile_images/';
		
			$exists = $this->User_model->getRecord('deliverer_info',array('email'=>$email,'is_delete'=>0));
			if($exists != 0){
				if($exists[0]['is_verify'] == 0){
					if($exists[0]['is_approved'] == 0){
						 //// user email register so here we send user's all info in response
						 if($exists[0]['password'] == $password){
							 $exists[0]['deliverer_id'];
							 $loginId = $exists[0]['deliverer_id'];
							 $updateArr = array(
							      'device_id'=>$device_id,
								  'device_type'=>$device_type,
								  'latitude' => $latitude,
								  'longitude' => $longitude,
								  'login_status' => 0
							 );
							 $this->User_model->updateRecord('deliverer_info',$updateArr ,array('deliverer_id'=>$loginId));
							 $post['message']="success";
							 $post = $this->User_model->getDelivererInfo($loginId);
						 }else{
							$post['message']="Sorry, Your email and password do not match.";
						 }
					}else{
						$post['message']="You are not verify by administration";
					}	 
			    }else{
				 	$post['message']="Please verify your email";
				}
			}else{
				$post['message']="Account does not exist";
			}
		echo json_encode($post); 
	}
    /* End login */
    
    /* Start Update Deliver Status */
	public function updateStatusView_get() 
	{
		 $this->load->view('webservices/update_duty_status');
	}
	public function updateStatus_post() 
	{
		$deliverer_id = $this->input->post('deliverer_id');
		$duty_status = $this->input->post('duty_status');
		$dvcTimeZone = $this->input->post('timezone');
		
		$this->User_model->updateRecord('deliverer_info',array('duty_status'=>$duty_status) ,array('deliverer_id'=>$deliverer_id));
		$post['message']="success";
		$post['duty_status']=$duty_status;
		
		echo json_encode($post); 
	}
	/* End update delivery status */
	
	/* Start getting Order Request */
	public function orderRequestListView_get() 
	{
		 $this->load->view('webservices/order_request_list');
	}
	public function orderRequestList_post() 
	{
		$deliverer_id = $this->input->post('deliverer_id');
		$dvcTimeZone = $this->input->post('timezone');
        
		$date = date('Y-m-d'); 
		$time = date('H:s:i');
		$curr_date = date('Y-m-d , H:i:s');
		
		$requestSql = "SELECT DR.*,RI.restaurant_name FROM delivery_request DR 
						LEFT JOIN order_info OI ON DR.order_id = OI.order_id
						LEFT JOIN restaurant_info RI ON RI.restaurant_id = OI.restaurant_id
						WHERE DR.deliverer_id = ".$deliverer_id." AND DR.status = 0 
						AND OI.order_date = '".$date."' AND OI.is_canceled =  0 ";
		$requestList = $this->User_model->getRecordSql($requestSql);					
		//print_r($requestList);
		if(!empty($requestList)){
			foreach($requestList as $req){
				
				 $order_id = $req['order_id'];
				 $orderDetailArr = $this->User_model->getOrderDetail($order_id,$dvcTimeZone); 
				 
				 $requestArr[] = array(
				       'dlv_request_id'  => $req['dlv_request_id'],
				       'order_id'        => $req['order_id'],
				       'deliverer_id'    => $req['deliverer_id'],
				       'status'          => $req['status'],
				       'restaurant_name' => $req['restaurant_name'],
				       'distance'        => 5,
				       'order_info'      => $orderDetailArr
				 );
			}
			$post['message']="success";
	   	    $post['is_array']=1;
		    $post['result']=$requestArr;
		}else{
			$post['message']='No record found';
		}
		
		echo json_encode($post); 
	}
	/* End order request */
	
	/* Start Order Request Response */
	public function orderRequestResponseView_get() 
	{
		 $this->load->view('webservices/order_request_response');
	}
	public function orderRequestResponse_post() 
	{
		//$dlv_request_id = $this->input->post('dlv_request_id');
		$deliverer_id   = $this->input->post('deliverer_id');
		$order_id   = $this->input->post('order_id');
		$status = $this->input->post('status');
		$dvcTimeZone = $this->input->post('timezone');
		
		$date = date('Y-m-d'); 
		$time = date('H:s:i');
		$cur_date = date('Y-m-d , H:i:s');
		
		// get order detail ///
		$orderInfo = $this->User_model->getRecord('order_info',array('order_id'=>$order_id));
		
		/// update status in deliverer request ///
		$this->User_model->updateRecord('delivery_request',array('status'=> $status) ,array('deliverer_id'=>$deliverer_id,'order_id'=>$order_id));
		if($status == 1){
			/// update request status in request history ///
			$this->User_model->updateRecord('delivery_request_history',array('request_status'=>$status) ,array('order_id'=>$order_id));
			
			//// delete other deliverer request ///
			$this->User_model->deleteRecord('delivery_request',array('order_id'=>$order_id,'status'=> 0));		 
			
			//// update deliverer id in order table ///
			$orderUpdt = array('deliverer_id'=>$deliverer_id,'order_status_id' => 2);
			$this->User_model->updateRecord('order_info',$orderUpdt ,array('order_id'=>$order_id));
			
			 /// update order status history ///
			 $orderHistoryArr = array(
			     'current_order_status_id'=>2,
			     'order_id' =>$order_id,
			     'created'  => date('Y-m-d , H:i:s')
			 );
		     $save = $this->User_model->saveRecord('order_status_history',$orderHistoryArr);
			 
			 //// get delivererr details ///
			 $delInfo = $this->User_model->getRecord('deliverer_info',array('deliverer_id'=>$deliverer_id));
			 $delName = $delInfo[0]['first_name'].' '.$delInfo[0]['last_name'];
			 
			 //// send notification to  restaurant ////
			 $restaurant_id = $orderInfo[0]['restaurant_id'];
			 $msg=  "Deliverer '".$delName."' accept order delivery request for order id ".$order_id.". ";
			 $notificationArr = array(
			       'deliverer_id'      => $deliverer_id,
			       'receiver_id'       => $restaurant_id,
			       'order_id'          => $order_id,
			       'notification'      => $msg,
			       'notification_type' => 1,
			       'sub_type'          => $status,
			       'is_read'           => 1,
			       'created'           => $cur_date
			 );
			 $notification_id = $this->User_model->saveRecord('notification_restaurant',$notificationArr);
			 $restInfo = $this->User_model->getRecord('restaurant_info',array('restaurant_id'=>$restaurant_id));
			 $not_count = $restInfo[0]['notification_count'] + 1;
			 $rest_update = $this->User_model->updateRecord('restaurant_info',array('notification_count'=>$not_count),array('restaurant_id'=>$restaurant_id));
		     /// --- notification to restaurant --- ///
		     
		     //// send notification to user ////
		     $sender_id = $restaurant_id;
			 $receiver_id = $orderInfo[0]['user_id'];
			 
		     $senderInfo = $this->User_model->getRecord('restaurant_info',array('restaurant_id' =>$sender_id));
		
			 $msg = "Your order has been preparing.";
			 $notificationType = 1;$sub_type = 3;
			 
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
		     //// ---- user notification --- ////
		}
        $post['message']="success";
	   	    $post['is_array']=0;
		echo json_encode($post); 
	}
	/* End order request Response */
	public function testNotification_get() 
	{
		$dlvr_device_id = '459989fe33a7a44855a50539d7581e03f13f5b5a52ad97cbc8b27708ec8d102b';
		$msg = 'test';
		$dataArray = array();
		$dlvrTotalCount = 2;
		$this->User_model->delivery_iphone_notification($dlvr_device_id,$msg,1,0,$dataArray,$dlvrTotalCount);
	}
    /* end test notification */
    
    /* Start getting Order History */
	public function delOrderHistoryView_get() 
	{
		 $this->load->view('webservices/del_order_history');
	}
	public function delOrderHistory_post() 
	{
		$deliverer_id = $this->input->post('deliverer_id');
		$dvcTimeZone = $this->input->post('timezone');
        
		$date = date('Y-m-d'); 
		$time = date('H:s:i');
		$curr_date = date('Y-m-d , H:i:s');
		
		$orderSql = "SELECT * FROM order_info OI WHERE OI.deliverer_id = ".$deliverer_id." 
		             AND OI.order_status_id = 5 AND OI.is_canceled = 0 ORDER BY OI.id DESC ";
		$orderList = $this->User_model->getRecordSql($orderSql);					
		//print_r($requestList);
		if(!empty($orderList)){
			foreach($orderList as $data){
				 $order_id = $data['order_id'];
				 $orderDetailArr = $this->User_model->getOrderDetail($order_id,$dvcTimeZone); 
				 if(!empty($orderDetailArr)){
				 	   $orderArr[] = $orderDetailArr;
				 }
			}
			$post['message']="success";
	   	    $post['is_array']=1;
		    $post['result']=$orderArr;
		}else{
			$post['message']='No record found';
		}
		
		echo json_encode($post); 
	}
	/* End order history */
	
	/* Start getting Order History */
	public function delAssignOrderView_get() 
	{
		 $this->load->view('webservices/del_assign_order');
	}
	public function delAssignOrder_post() 
	{
		$deliverer_id = $this->input->post('deliverer_id');
		$dvcTimeZone = $this->input->post('timezone');
        
		$date = date('Y-m-d'); 
		$time = date('H:s:i');
		$curr_date = date('Y-m-d , H:i:s');
		
		$orderSql = "SELECT * FROM order_info OI WHERE OI.deliverer_id = ".$deliverer_id." 
		             AND OI.order_status_id < 5 AND OI.is_canceled = 0 ORDER BY OI.id DESC ";
		$orderList = $this->User_model->getRecordSql($orderSql);					
		//print_r($requestList);
		if(!empty($orderList)){
			foreach($orderList as $data){
				 $order_id = $data['order_id'];
				 $orderDetailArr = $this->User_model->getOrderDetail($order_id,$dvcTimeZone); 
				 if(!empty($orderDetailArr)){
				 	   $orderArr[] = $orderDetailArr;
				 }
			}
			$post['message']="success";
	   	    $post['is_array']=1;
		    $post['result']=$orderArr;
		}else{
			$post['message']='No record found';
		}
		echo json_encode($post); 
	}
	/* End order history */
	
	/* Start contact send request */
	public function delContactRequestView_get() 
	{
		 $this->load->view('webservices/del_contact_request');
	}
	public function delContactRequest_post()
	{
		 $order_id = $this->input->post('order_id');
		 $user_id = $this->input->post('user_id'); 
		 $deliverer_id = $this->input->post('deliverer_id');
		 $dvcTimeZone = $this->input->post('timezone');
		 $cur_date = date('Y-m-d,H:i:s');
		 
		 $dataArr = array(
		      'order_id'          => $order_id,
		      'send_by_deliverer' => $deliverer_id,
		      'receiver_id'       => $user_id,
		      'status'            => 0,
		      'created'           => $cur_date
		 );
		 $shareInfo = $this->User_model->getRecord('order_contact_share',array('order_id'=>$order_id));
		 if(!empty($shareInfo)){
		 	$share_id = $shareInfo[0]['share_id'];
			$updt = $this->User_model->updateRecord('order_contact_share',$dataArr,array('share_id'=>$share_id));
		 }else{
		 	$share_id = $this->User_model->saveRecord('order_contact_share',$dataArr);
		 }
		 
		 if($share_id != 0){
		 	  //// notification ////
		 	  $sender_id   = $deliverer_id;
			  $receiver_id = $user_id;
			 
		      //// get delivererr details ///
			  $delInfo = $this->User_model->getRecord('deliverer_info',array('deliverer_id'=>$deliverer_id));
			  $delName = $delInfo[0]['first_name'].' '.$delInfo[0]['last_name'];
			 
			  $msg = $delName." request you to share your contact number.";
			  $notificationType = 2;$sub_type=0;
			 
			  $notificationArr = array(
			       'restaurant_id'     => '',
			       'deliverer_id'      => $sender_id,
			       'receiver_id'       => $receiver_id,
			       'order_id'          => $order_id,
			       'notification'      => $msg,
			       'notification_type' => 2,
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
		 	  ///// ---- notification ---- ////
		 	  $post['message']='success';
	          $post['is_array'] = 0;
		 }else{
		  	  $post['message']='error';
		 }
		 echo json_encode($post);
	}
	/* End contact send request */
	
	/* Start get all notification */
    public function delAllNotificationView_get() 
	{
		 $this->load->view('webservices/all_del_notification');
	}
	public function delAllNotification_post()
	{
		 $deliverer_id = $this->input->post('deliverer_id');
		 $dvcTimeZone = $this->input->post('timezone');
		 
		 $sql = "SELECT * FROM `notification_deliverer` WHERE `receiver_id` = ".$deliverer_id."
		         ORDER BY `notification_id` DESC";
	     $notifInfo = $this->User_model->getRecordSql($sql);
	     if(!empty($notifInfo)){

			 foreach($notifInfo as $ntf){
			 	  $share_status = '';
			 	  if($ntf['notification_type'] == 2){
			 	 	    //// get order contact share request ////
			 	 	    $order_id = $ntf['order_id'];
						$shareInfo = $this->User_model->getRecord('order_contact_share',array('order_id' =>$order_id));
						if(!empty($shareInfo)){
							$share_status = $shareInfo[0]['status'];
						}
			 	  }
			 	  $notificationArr[] = array(
				        'notification_id'   => $ntf['notification_id'],
				        'restaurant_id'     => $ntf['restaurant_id'],
				        'user_id'           => $ntf['user_id'],
				        'receiver_id'       => $ntf['receiver_id'],
				        'order_id'          => $ntf['order_id'],
				        'notification'      => $ntf['notification'],
				        'notification_type' => $ntf['notification_type'],
				        'sub_type'          => $ntf['sub_type'],
				        'is_read'           => $ntf['is_read'],
				        'is_deleted'        => $ntf['is_deleted'],
				        'created'           => $ntf['created'],
				        'contact_share_status' => $share_status 
				  );
			 }
			 $post['message']  = "success";
	   	     $post['is_array'] = 0;
		     $post['result']   = $notificationArr;
		 }else{
		 	 $post['message']='No record found';
		 }
		 echo json_encode($post);
	}
    /* End notification */
    
    /* Start response to contact share request */
    public function delResContactReqView_get() 
	{
		 $this->load->view('webservices/del_contact_response');
	}
	public function delResContactReq_post()
	{
		 $order_id = $this->input->post('order_id');
		 $user_id = $this->input->post('user_id'); 
		 $deliverer_id = $this->input->post('deliverer_id');
		 $status = $this->input->post('status');
		 $dvcTimeZone = $this->input->post('timezone');
		 $cur_date = date('Y-m-d,H:i:s');
		 $request_status = ($status == 1)?'Accept':'Reject';
		 
		 $dataArr = array(
		      'order_id'          => $order_id,
		      'send_by_cutomer'   => $user_id,
		      'receiver_id'       => $deliverer_id,
		      'status'            => 0
		 );
		 
		 $shareInfo = $this->User_model->getRecord('order_contact_share',$dataArr);
		 
		 if(!empty($shareInfo)){
		 	   $share_id = $shareInfo[0]['share_id'];
			   if($status == 1){
			   	   $this->User_model->updateRecord('order_info',array('is_contact_share' => 1) ,array('order_id'=>$order_id));
			   }
			   //if($status == 1){
			   	    $updtArr = array('status'=>$status,'updated'=>$cur_date);
			   	    $this->User_model->updateRecord('order_contact_share',$updtArr ,array('share_id'=>$share_id));
			   //}elseif($status == 2){
			   	    //$this->User_model->deleteRecord('order_contact_share',array('share_id'=>$share_id));
			   //}
			   
			  //// notification ////
		 	  $sender_id   = $deliverer_id;
			  $receiver_id = $user_id;
			  $sub_type = $status;
		      //// get delivererr details ///
			  $delInfo = $this->User_model->getRecord('deliverer_info',array('deliverer_id'=>$deliverer_id));
			  $delName = $delInfo[0]['first_name'].' '.$delInfo[0]['last_name'];
			 
			  $msg = $delName." ".$request_status. " your request for share contact number.";
			  $notificationType = 2;
			 
			  $notificationArr = array(
			       'restaurant_id'     => '',
			       'deliverer_id'      => $sender_id,
			       'receiver_id'       => $receiver_id,
			       'order_id'          => $order_id,
			       'notification'      => $msg,
			       'notification_type' => 2,
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
		 	  ///// ---- notification ---- ////
		      $post['message']='success';
	          $post['is_array'] = 0;
		 }else{
		 	  $post['message']='error';
		 }
		 echo json_encode($post);	   
	}
    /* End response to sontact share request */
    
    /* start Picked up  */
    public function delStatusUpdateView_get() 
	{
		 $this->load->view('webservices/del_status_update');
	}
	public function delStatusUpdate_post()
	{
		 $order_id = $this->input->post('order_id');
		 $deliverer_id = $this->input->post('deliverer_id');
		 $status = $this->input->post('status');
		 $estm_time = $this->input->post('estm_time');
		 $dvcTimeZone = $this->input->post('timezone');
		 $cur_date = date('Y-m-d,H:i:s');
		 
		 $orderInfo = $this->User_model->getRecord('order_info',array('order_id'=>$order_id,'is_canceled'=>0));
		 if(!empty($orderInfo)){
		 	   $restaurant_id = $orderInfo[0]['restaurant_id'];
			   $user_id = $orderInfo[0]['user_id'];
				 
				//// update order status ///
				$dataArr = array(
				    'order_status_id' => $status,
				);
				if($status == 3 || $status == 4){
					$dataArr['estm_time'] = $estm_time;
				}
				if($status == 5){
					$dataArr['order_date'] = date('Y-m-d');
					$dataArr['order_time'] = date('H:i:s');
				}
				$update = $this->User_model->updateRecord('order_info', $dataArr,array('order_id'=>$order_id));
				
				///// save order history ////
				$orderHistoryArr = array(
				     'current_order_status_id'=>$status,
				     'order_id' =>$order_id,
				     'created'  => date('Y-m-d , H:i:s')
				);
			    $save = $this->User_model->saveRecord('order_status_history',$orderHistoryArr); 
				
				//// user notification ////
			 	  $sender_id   = $deliverer_id;
				  $receiver_id = $user_id;
				  $sub_type = $status + 1;
			      //// get delivererr details ///
				  $delInfo = $this->User_model->getRecord('deliverer_info',array('deliverer_id'=>$deliverer_id));
				  $delName = $delInfo[0]['first_name'].' '.$delInfo[0]['last_name'];
				  if($status == 3){
				  	   $msg = $delName." picked up everything from restaurant . Order will take ".$estm_time." min for delivery.";
				  }elseif($status == 4){
				  	   $msg = $delName." is on the way to deliver your order. Order will take ".$estm_time." min for delivery.";
				  }elseif($status == 5){
				 	 $msg=  $delName." at the door to deliver your order.";
				  }
				  
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
				 $noticationId = $this->User_model->saveRecord('notification_user', $notificationArr);
				 //// send  notification  /////
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
			 	  ///// ---- notification ---- ////
			     
			     ////  restaurant notification ////
			 	 //// get user details ///
				 $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
				 $userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
				 if($status == 3){
				 	 $msg=  $delName." picked up everything from your restaurant.";
				 }elseif($status == 4){
				 	 $msg=  $delName." is on the way for deliver order.";
				 }elseif($status == 5){
				 	 $msg=  $delName." at the door for deliver order.";
				 }
			 	 
				 $notificationArr = array(
				       'user_id' => $user_id,
				       'receiver_id' => $restaurant_id,
				       'order_id' => $order_id,
				       'notification' => $msg,
				       'notification_type' => 1,
				       'sub_type'   => $status,
				       'is_read' => 1,
				       'created' => $cur_date
				 );
				 $notification_id = $this->User_model->saveRecord('notification_restaurant',$notificationArr);
				 $restInfo = $this->User_model->getRecord('restaurant_info',array('restaurant_id'=>$restaurant_id));
				 $not_count = $restInfo[0]['notification_count'] + 1;
				 $rest_update = $this->User_model->updateRecord('restaurant_info',array('notification_count'=>$not_count),array('restaurant_id'=>$restaurant_id));
			 	 /// --- reataurant notification --- ///
			    $post['message'] = "success";
		 }else{
		 	  $post['message']='error';
		 }
		 echo json_encode($post);		 
	}
	/* End picked up */
	
}
?>