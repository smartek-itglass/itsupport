<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include (APPPATH . 'libraries/REST_Controller.php');

/**
 * 
 */
class User extends REST_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->model('User_model');
	}
	public function userRegisterView_get() 
	{
		 $this->load->view('webservices/user_registration_form');
	}
	public function userRegister_post(){
		
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$mobile = $this->input->post('mobile');
		$address = $this->input->post('address');
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$device_id = $this->input->post('device_id');
		$device_type = $this->input->post('device_type');
		$refference_code = $this->input->post('refference_code');
		$dvc_date = date('Y-m-d , H:i:s');
		$dvcTimeZone = $this->input->post('timezone');
		$device_time_zone = date_default_timezone_get();
		$cur_date = $this->User_model->convertTime($dvc_date,$device_time_zone);
		$checkForCode = 1;
		$already = $this->User_model->getRecord('user_info',array('email'=>$email,'is_delete'=>0));
		if($already == 0){
			 // if email is not in database 
			 $code = $this->User_model->genRandomPassword(6); 
			 
			 $data = array(
			     'first_name'  => $first_name,
			     'last_name'   => $last_name,
			     'email'       => $email,
				 'password'    => $password,
				 'mobile'      => $mobile,
				 'address'     => $address,
				 'device_id'   => $device_id,
				 'device_type' => $device_type,
				 'latitude'    => $latitude,
				 'longitude'   => $longitude,
				 'refference_code' => $code,
				 'is_verify'   => 1,
				 'login_status' => 1,
				 'created'     => $cur_date
			 );
			 if(!empty($refference_code)){
			 	$checkForCode = 2;
			 	$rfrInfo = $this->User_model->getRecord('user_info',array('refference_code'=>$refference_code,'is_delete'=>0));
				if(!empty($rfrInfo)){
					$rfr_id = $rfrInfo[0]['user_id'];
					$data['reffer_by'] = $rfr_id;
					
					$reffer_count = $rfrInfo[0]['reffer_count'] + 1;
					$total_reffer_count = $rfrInfo[0]['total_reffer_count'] + 1;
					
					$updtRefr = array(
					     'reffer_count' => $reffer_count,
					     'total_reffer_count' => $total_reffer_count
					);
					$checkForCode = 1;
					$this->User_model->updateRecord('user_info',$updtRefr,array('user_id'=>$rfr_id));
				}else{
					$post['message']="Invalid code";
				} 
			 }
			 if($checkForCode == 1){
				 $logId = $this->User_model->saveRecord('user_info',$data);
				 if($logId != 0){
					 $post['message']="success";
					 $enc_logId = $this->User_model->encrypt_decrypt('encrypt', $logId);
					 $subject='Verify Email For Customer';
					 $text = base_url().'index.php/User/verifyEmail/'.$enc_logId;
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
																										Hello Customer,
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
				 }else{
					 $post['message']="Error";
				 }
			 }else{
			 	 //// check for code 
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
		$result = $this->User_model->getRecord('user_info',array('user_id'=>$login_id));
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
			$this->User_model->updateRecord('user_info',array('is_verify'=>0),array('user_id'=>$login_id));
			
			echo   '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
	public function userSocialLoginView_get() 
	{
		 $this->load->view('webservices/user_social_form');
	}
	public function userSocialLogin_post() {
		// work of this function is to register user by social media and login
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');

		$social_id = $this->input->post('social_id');
		$social = $this->input->post('social_type');
		$social_type = strtolower($social);
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$device_id = $this->input->post('device_id');
		$device_type = $this->input->post('device_type');
		$dvcTimeZone = $this->input->post('timezone');
	    //$cur_date = date('Y-m-d , H:i:s');
		$dvc_date = date('Y-m-d , H:i:s');
		$device_time_zone = date_default_timezone_get();
		$cur_date = $this->User_model->convertTime($dvc_date,$device_time_zone);
		
			$already = $this->User_model->getRecord('user_info',array('social_id'=>$social_id,'is_delete'=>0));
			if($already == 0){
				//// social id doesn't exists in table so here we register the user
				//Get the file
				 $code = $this->User_model->genRandomPassword(6); 
				 $data = array(
				      'first_name'   => $first_name,
			          'last_name'    => $last_name,
				      'email'        => $email,
					  'social_id'    => $social_id,
					  'social_type'  => $social_type,
					  'device_id'    => $device_id,
					  'device_type'  => $device_type,
					  'latitude'     => $latitude,
					  'longitude'    => $longitude,
					  'refference_code' => $code,
					  'login_status' => 1,
					  'created'      => $cur_date
				 );
				 $logId = $this->User_model->saveRecord('user_info',$data);
				 if($logId != 0){
					 
					 $post = $this->User_model->getUserInfo($logId);
					 $post['message']="success";
					 $post['is_array']=0;
					 $post['is_registered']="no";
				 }else{
					 $post['message']="Error";
				 }
			}else{
				 $loginId = $already[0]['user_id'];
				 $this->User_model->updateRecord('user_info',array('device_id'=>$device_id,'device_type'=>$device_type),array('user_id'=>$loginId));
				 
				 $post = $this->User_model->getUserInfo($loginId);
				 $post['message']="success";
				 $post['is_array']=0;
				 $post['is_registered']="yes";
		   }
		echo json_encode($post); 
	}
	public function userLoginView_get() 
	{
		 $this->load->view('webservices/user_login_form');
	}
	public function userLogin_post() 
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
		
			$exists = $this->User_model->getRecord('user_info',array('email'=>$email,'is_delete'=>0));
			if($exists != 0){
				 //// user email register so here we send user's all info in response
				 if($exists[0]['is_verify'] == 0){
				 	 if($exists[0]['password'] == $password){
						 $exists[0]['user_id'];
						 $loginId = $exists[0]['user_id'];
						 $updateArr = array(
						      'device_id'=>$device_id,
							  'device_type'=>$device_type,
							  //'latitude' => $latitude,
							  //'longitude' => $longitude,
							  'login_status' => 0
						 );
						 $this->User_model->updateRecord('user_info',$updateArr ,array('user_id'=>$loginId));
						 $post['message']="success";
						 $post['is_array']=0;
						 $post = $this->User_model->getUserInfo($loginId);
					 }else{
						$post['message']="Sorry, Your email and password do not match.";
					 }
				 }else{
				 	$post['message']="Please verify your email";
				 }
			}else{
				$post['message']="Account does not exist";
			}
		echo json_encode($post); 
	}
	
	/* Country State Start */
	public function countryStateList_post()
	{
		//This function is for getting the country , state
		$catSql = "SELECT * FROM `country` ORDER BY `country_name` ASC ";
		$result = $this->User_model->getRecordSql($catSql);
		if($result==0)
		{
			//there is no category	
			$post['message']='No record found';
		}
		else 
		{
			$catArr = array();
			$post['message']='success';
			$post['is_array']=1;
			foreach ($result as $cat) 
			{
				  $stateArr = array();
				  $country_id = $cat['country_id'];
				  $stateSql = "SELECT * FROM `state` WHERE `country_id` = ".$country_id." ORDER BY `state_name` ASC ";
		          $stateList = $this->User_model->getRecordSql($stateSql);
				  if(!empty($stateList)){
					  foreach($stateList as $sub){
					  	  
						  $stateArr[] = array(
							 'state_id' => $sub['state_id'],
							 'state_name' => $sub['state_name'],
							 'country_id' => $sub['country_id']
						  );
					  }
				  }
				  $catArr[] = array(
					 'country_id' => $cat['country_id'],
					 'country_name' => $cat['country_name'],
					 'state_list' => $stateArr,
				 );
			}
			$post['result'] = $catArr;	
		}
		echo json_encode($post);
	}
    /* End Country State */
    
    /* Country State Start */
    public function cityAreaListView_get() 
	{
		 $this->load->view('webservices/city_area');
	}
	public function cityAreaList_post()
	{
		$state_id = $this->input->post('state_id');
		
		//This function is for getting the country , state
		$catSql = "SELECT * FROM `city` WHERE `state_id` = ".$state_id."  ORDER BY `city_name` ASC ";
		$result = $this->User_model->getRecordSql($catSql);
		if($result==0)
		{
			//there is no category	
			$post['message']='No record found';
		}
		else 
		{
			$catArr = array();
			$post['message']='success';
			$post['is_array']=1;
			$imgPath = base_url().'admin_images/';
			foreach ($result as $cat) 
			{
				  $stateArr = array();
				  $city_id = $cat['city_id'];
				  $stateSql = "SELECT * FROM `area` WHERE `city_id` = ".$city_id." ORDER BY `area_name` ASC ";
		          $stateList = $this->User_model->getRecordSql($stateSql);
				  if(!empty($stateList)){
					  foreach($stateList as $sub){
					  	  
						  $stateArr[] = array(
							 'area_id' => $sub['area_id'],
							 'area_name' => $sub['area_name'],
							 'city_id' => $sub['city_id']
						  );
					  }
				  }
				  $catArr[] = array(
					 'city_id' => $cat['city_id'],
					 'city_name' => $cat['city_name'],
					 'area_list' => $stateArr,
				 );
			}
			$post['result'] = $catArr;	
		}
		echo json_encode($post);
	}
    /* End Country State City Area */
    
    /* Start Get Filter Option */
    public function filterOptionView_get() 
	{
		 $this->load->view('webservices/filter_option');
	}
	public function filterOption_post()
	{
		$user_id = $this->input->post('user_id');
		$dvcTimeZone = $this->input->post('timezone');
		$foodArr = array();$max_price = $min_price = 0;
		//This function is for getting the country , state
		$foodSql = "SELECT * FROM `food_category` ORDER BY `food_cat_name` ASC;";
		$result = $this->User_model->getRecordSql($foodSql);
		
		if($result != 0){
			foreach($result as $data){
				$foodArr[] = array(
				     'food_cat_id' => $data['food_cat_id'],
				     'food_cat_name' => $data['food_cat_name']
				);
			}
            $post['is_array']=1;
		}else{
			$post['is_array']=0;
		}
		$priceSql = "SELECT MAX(`item_price`) as max_price,MIN(`item_price`) as min_price FROM `restaurant_food_items` ";
		$priceInfo = $this->User_model->getRecordSql($priceSql);
		
		if(!empty($priceInfo)){
			$max_price = $priceInfo[0]['max_price'];
			$min_price = $priceInfo[0]['min_price'];
		}
		$post['message']='success';
	    $post['food_cat_list']=$foodArr;
		$post['max_price']=$max_price;
		$post['min_price']=$min_price;
		
		echo json_encode($post);
	}
    /* End Filter Option */
    
    /* Start Get Restaurant List */
    public function restaurantListView_get() 
	{
		 $this->load->view('webservices/restaurant_list');
	}
	public function restaurantList_post()
	{
		$user_id = $this->input->post('user_id');
		$city_id = $this->input->post('city_id');
		$area_id = $this->input->post('area_id');
		$text = $this->input->post('text');
		$sort_by = $this->input->post('sort_by');
		$max_price = $this->input->post('max_price');
		$min_price = $this->input->post('min_price');
		$food_category = $this->input->post('food_category');
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$page_no = $this->input->post('page_no');
		$limit = $this->input->post('limit');
		$dvcTimeZone = $this->input->post('timezone');
		$start = $limit * ($page_no - 1);
		$quryLimit = "LIMIT ".$start.','.$limit;
		$dataArr = $sortIds = $filterIds = array();
		$locationSql = $radiusSql = $filterSql='';
		$disSql = " ORDER BY RI.restaurant_id DESC ";
		$restInfo = 0;
		
		if($area_id != '' && $city_id != ''){
			$locationSql = " RI.city_id = ".$city_id." AND RI.area_id = ".$area_id." AND ";
		}
		
		$distanceSql =" ((6371 * ACOS( COS( RADIANS(".$latitude.") ) * COS( RADIANS(RI.latitude) ) * 
		        COS( RADIANS( RI.longitude ) - RADIANS(".$longitude.") ) + SIN( RADIANS(".$latitude.") ) * 
		        SIN( RADIANS( RI.latitude) ) ) )) AS distance , ";
		$availSql = " RI.is_available = 0 AND RI.is_delete = 0 ";
		$radiusSql = " HAVING distance <= 25 ";
		$restAreaSql = "SELECT RA.restaurant_id FROM restaurant_delivery_area RA 
		        LEFT JOIN area AR ON RA.area_id = AR.area_id
                WHERE ((6371 * ACOS( COS( RADIANS(".$latitude.") ) * COS( RADIANS(AR.latitude) ) * 
		        COS( RADIANS( AR.longitude ) - RADIANS(".$longitude.") ) + SIN( RADIANS(".$latitude.") ) * 
		        SIN( RADIANS( AR.latitude) ) ) )) <= 5";
		
		//// Start Sort By Search ///
		if($sort_by != ''){
			if($sort_by == 'nearest'){
				$disSql = " ORDER BY distance ASC ";
			}elseif($sort_by == 'farthest'){
				$disSql = " ORDER BY distance DESC ";
			}elseif($sort_by == 'low' || $sort_by == 'high'){
				
				$srtBySql = ($sort_by == 'low')? ' ASC ': ' DESC';
				
				$sortByQuery = "SELECT ".$distanceSql." FI.food_item_id,FI.item_price, RI.* FROM restaurant_food_items FI 
						  LEFT JOIN restaurant_info RI ON RI.restaurant_id = FI.restaurant_id
						  WHERE RI.restaurant_id IN (".$restAreaSql.") AND ".$locationSql." ".$availSql."  
						  GROUP BY FI.restaurant_id ".$radiusSql." ORDER BY FI.item_price ".$srtBySql." 
						  ".$quryLimit." ";
			    $restInfo = $this->User_model->getRecordSql($sortByQuery);		
			    
			    if(!empty($restInfo)){
			    	foreach($restInfo as $value){
			    		$sortIds[] = $value['restaurant_id'];
			    	}
			    }	  
			}
		}
		//// End Sort By Search ///
		//echo "<pre/>";
	    //print_r($restInfo);
	    //echo "sort";
		//print_r($sortIds);
		//// Start Filter Search ///
	    if(($max_price != '' && $min_price != '') || $food_category != ''){
	   	   	
	   	   $priceRangeSql = $foodCatSql = '';	
	   	   if($max_price != '' && $min_price != ''){
	   	   	     $priceRangeSql = " FI.item_price between '".$min_price."' and '".$max_price."' ";
	   	   }		
	   	   if($food_category != ''){
			   
			   $andSql = ($priceRangeSql != '') ? 'AND':'';
			   $foodCatSql = $andSql." FI.restaurant_id IN (SELECT RF.restaurant_id FROM restaurant_food_cat RF 
			                       WHERE RF.food_cat_id IN (".$food_category.") GROUP BY RF.restaurant_id)";
		   }		
	   	   $filterSql = "SELECT ".$distanceSql." FI.food_item_id,FI.item_price, RI.* FROM restaurant_food_items FI 
						 LEFT JOIN restaurant_info RI ON RI.restaurant_id = FI.restaurant_id
						 WHERE RI.restaurant_id IN (".$restAreaSql.") AND ".$priceRangeSql." ".$foodCatSql." AND
						 ".$locationSql." ".$availSql." GROUP BY FI.restaurant_id ".$radiusSql." 
						 ".$disSql." ".$quryLimit." ";
							 
		   $restInfo = $this->User_model->getRecordSql($filterSql);	
		   if(!empty($restInfo)){
		    	foreach($restInfo as $value){
		    		$filterIds[] = $value['restaurant_id'];
		    	}
		    }
	   }
	   //// End Filter Search ///
	   //echo "<pre/>";
	   //echo "filter";
	   //print_r($restInfo);
	   //print_r($filterIds);
	   //// if user set filter and search sort by ///
	   if(!empty($sortIds) && !empty($filterIds)){
	   	    $restInfo = array();
            $AllIds=array_intersect($sortIds,$filterIds);
		    foreach($AllIds as $id){
		    	$restInfo[] = array(
				    'restaurant_id' => $id
				);
		    }
		    //echo "<pre/>";
	   	    //print_r($restInfo);
	   }elseif( $filterSql != ''){
	   	   if( empty($filterIds)){
	   	      $restInfo = array();
	       } 
	   } 
	   ///// end merge result of sort and filter///
	   
	   /// Start without Search Qurery For Home Page ///
	   if($restInfo == 0){
	   	    $sql = "SELECT ".$distanceSql." RI.* FROM restaurant_info RI 
			        WHERE RI.restaurant_id IN (".$restAreaSql.") AND ".$locationSql." ".$availSql." ".$radiusSql."
			        ".$disSql." ".$quryLimit." ";
	        $restInfo = $this->User_model->getRecordSql($sql);
	   }	
	   /// End without Search Qurery For Home Page ///
	   
	   /// start text search ///
	   if($text != ''){
	   	   $sql = "SELECT ".$distanceSql." RI.restaurant_id FROM restaurant_info RI 
	   	            WHERE RI.restaurant_id IN (".$restAreaSql.") AND RI.restaurant_name LIKE '%".$text."%' AND ".$availSql."  UNION
					SELECT ".$distanceSql." RI.restaurant_id FROM restaurant_menu RM 
					LEFT JOIN restaurant_info RI ON RI.restaurant_id = RM.restaurant_id
					WHERE RI.restaurant_id IN (".$restAreaSql.") AND RM.menu_title LIKE '%".$text."%' AND ".$availSql."   
					GROUP BY RM.restaurant_id  UNION
					SELECT ".$distanceSql." RI.restaurant_id FROM restaurant_food_items IT 
					LEFT JOIN restaurant_info RI ON RI.restaurant_id = IT.restaurant_id
					WHERE RI.restaurant_id IN (".$restAreaSql.") AND IT.item_name LIKE '%".$text."%' AND ".$availSql."  
					GROUP BY IT.restaurant_id ".$radiusSql." ".$quryLimit." ";
	   	    $restInfo = $this->User_model->getRecordSql($sql);
	   }
	   /// end text search ///
	   //echo "<pre/>";
	   //print_r($restInfo);
	   $moreData = (count($restInfo) < $limit )?'no':'yes';
	   
	   if(!empty($restInfo)){
	   	    foreach($restInfo as $rest){
				  $menuArr = array();	
				  $restaurant_id = $rest['restaurant_id'];
				  $dataArr[] = $this->User_model->restaurantCardView($restaurant_id,$latitude,$longitude); 
	   	    }
	   }
	   if(!empty($dataArr)){
	   	    $post['message']="success";
	   	    $post['is_array']=1;
		    $post['result']=$dataArr;
			$post['is_more_data'] = $moreData;
	   }else{
	   	    $post['message']='No record found';
	   }			
	   //print_r($dataArr);
	   echo json_encode($post);
	}
    /* End Get Restaurant List */
    
    /* Start Get Restaurant Info */
    public function restaurantInfoView_get() 
	{
		 $this->load->view('webservices/restaurant_info');
	}
	public function restaurantInfo_post()
	{
		$user_id = $this->input->post('user_id');
		$restaurant_id = $this->input->post('restaurant_id');
		$dvcTimeZone = $this->input->post('timezone');
		
		$sql = "SELECT RI.*,AI.area_name,CT.city_name,ST.state_name,
				CO.country_name FROM restaurant_info RI 
				LEFT JOIN area AI ON AI.area_id = RI.area_id
				LEFT JOIN city CT ON CT.city_id = RI.city_id
				LEFT JOIN state ST ON ST.state_id = CT.state_id
				LEFT JOIN country CO ON CO.country_id = ST.country_id
				WHERE RI.restaurant_id = ".$restaurant_id." ";
		$info = $this->User_model->getRecordSql($sql);
		
		if(!empty($info)){
			
			/// code for getting rating and total count ///
			$ratingSql = "SELECT AVG(RW.rating) as total_rating,COUNT(RW.review_id) as total_count FROM review RW WHERE RW.restaurant_id = ".$restaurant_id." ";
			$ratingInfo = $this->User_model->getRecordSql($ratingSql);
			
			$total_rating = $total_count = 0;
			if(!empty($ratingInfo)){
				$total_rating = ($ratingInfo[0]['total_rating'] != '')?$ratingInfo[0]['total_rating']:0;
				$total_count = ($ratingInfo[0]['total_count'] != '')?$ratingInfo[0]['total_count']:0;
			}
			
			///// code for getting review list ////
			$rewSql = "SELECT RW.*,UI.first_name,UI.last_name FROM review RW 
						LEFT JOIN user_info UI ON UI.user_id = RW.user_id
						WHERE RW.restaurant_id = ".$restaurant_id." ";
		    $reviewList = $this->User_model->getRecordSql($rewSql);
		    $reviewArr = array();
		    				
			if(!empty($reviewList)){
				foreach($reviewList as $rew){
					$reviewArr[] = array(
					     'review_id' => $rew['review_id'],
					     'order_id' => $rew['order_id'],
					     'user_id' => $rew['user_id'],
					     'restaurant_id' => $rew['restaurant_id'],
					     'deliverer_id' => $rew['deliverer_id'],
					     'name' => $rew['first_name'].' '.$rew['last_name'],
					     'title' => $rew['title'],
					     'comment' => $rew['comment'],
					     'rating' => $rew['rating'],
					     'created' => $rew['created'],
					     'updated' => ($rew['updated'] != '')?$rew['updated']:''
					);
				}
			}
			$restArr = array(
			     'restaurant_id'   => $info[0]['restaurant_id'],
			     'user_name'       => $info[0]['user_name'],
			     'email'           => $info[0]['email'],
			     'paypal_email'    => $info[0]['paypal_email'],
			     'contact'         => $info[0]['contact'],
			     'restaurant_name' => $info[0]['restaurant_name'],
			     'restaurant_img'  => $info[0]['restaurant_img'],
			     'start_day'       => $info[0]['start_day'],
			     'close_day'       => $info[0]['close_day'],
			     'open_time'       => $info[0]['open_time'],
			     'close_time'      => $info[0]['close_time'],
			     'min_amount'      => $info[0]['min_amount'],
			     'tax'             => $info[0]['tax'],
			     'description'     => $info[0]['description'],
			     'avail_distance'  => $info[0]['avail_distance'],
			     'delivery_time'   => $info[0]['delivery_time'],
			     'retry_time_limit'=> $info[0]['retry_time_limit'],
			     'area_id'         => $info[0]['area_id'],
			     'city_id'         => $info[0]['city_id'],
			     'area_name'       => $info[0]['area_name'],
			     'city_name'       => $info[0]['city_name'],
			     'state_name'      => $info[0]['state_name'],
			     'country_name'    => $info[0]['country_name'],
			     'address'         => $info[0]['address'],
			     'latitude'        => $info[0]['latitude'],
			     'longitude'       => $info[0]['longitude'],
			     'luxury_status'   => ($info[0]['luxury_status'] != '')?$info[0]['luxury_status']:'',
			     'is_available'    => $info[0]['is_available'],
			     'is_delete'       => $info[0]['is_delete'],
			     'created'         => $info[0]['created'],
			     'total_rating'    => ($total_rating > 0 )?$total_rating:'0.0',
			     'total_count'     => $total_count,
			     'review_list'     => $reviewArr
			);
		}
        if(!empty($restArr)){
	   	    $post['message']="success";
	   	    $post['is_array']=0;
		    $post['result']=$restArr;
	    }else{
	   	    $post['message']='No record found';
	    }			
	    //print_r($dataArr);
	    echo json_encode($post);
		
	}
    //// End Restaurant Info ////
	
	/* Start Get order address */
    public function orderAddressView_get() 
	{
		 $this->load->view('webservices/order_address');
	}
	public function orderAddress_post()
	{
		$user_id = $this->input->post('user_id');
		$dvcTimeZone = $this->input->post('timezone');
		$addressArr = array();
		//This function is for getting the country , stateused for getting user's previous order adresses
		$addressSql = "SELECT * FROM `order_info` WHERE `user_id` = ".$user_id." ORDER BY `id` DESC ";
		$result = $this->User_model->getRecordSql($addressSql);
		
		if($result != 0){
			foreach($result as $data){
				$addressArr[] = array(
				     'flat_no' => $data['flat_no'],
				     'street' => $data['street'],
				     'address' => $data['address'],
				     'landmark' => $data['landmark'],
				     'zipcode' => $data['zipcode'],
				     'latitude' => $data['latitude'],
				     'longitude' => $data['longitude']
				);
			}
            $post['is_array']=1;
		}else{
			$post['is_array']=0;
		}
		$post['message']='success';
	    $post['address_list']=$addressArr;
		
		echo json_encode($post);
	}
    /* End order address */
    
    /* End order request Response */
	public function testNotification_get() 
	{
		$device_id = 'e204a90fd1300313b3fbf41f0817d63eb132742081addb7a55988c8dd26efbd0';
		$msg = 'test';
		$dataArray = array();
		$totalCount = 2;
		$result = $this->User_model->customer_iphone_notification($device_id,$msg,1,$dataArray,$totalCount);
		print_r($result);
	}
    /* end test notification */
    
    /* user update profile */
    public function updateUserProfileView_get() 
	{
		 $this->load->view('webservices/update_user_profile');
	}
	public function updateUserProfile_post()
	{
		 $user_id = $this->input->post('user_id');
		 $first_name = $this->input->post('first_name');
		 $last_name = $this->input->post('last_name');
		 //$email = $this->input->post('email');
		 //$password = $this->input->post('password');
		 $mobile = $this->input->post('mobile');
		 $gender = $this->input->post('gender');
		 $flat_no = $this->input->post('flat_no');
		 $street = $this->input->post('street');
		 $address = $this->input->post('address');
		 $landmark = $this->input->post('landmark');
		 $zip_code = $this->input->post('zip_code');
		 $latitude = $this->input->post('latitude');
		 $longitude = $this->input->post('longitude');
		 $device_id = $this->input->post('device_id');
		 $device_type = $this->input->post('device_type');
		 $refference_code = $this->input->post('refference_code');
		 $dvcTimeZone = $this->input->post('timezone');
		 $dvc_date = date('Y-m-d , H:i:s');
		 $checkForCode = 1;
		 
		 $dataArr = array(
		      'first_name' => $first_name,
		      'last_name'  => $last_name,
		      'mobile'     => $mobile,
		      'gender'     => $gender,
		      'flat_no'    => $flat_no,
		      'street'     => $street,
		      'address'    => $address,
		      'landmark'   => $landmark,
		      'zip_code'   => $zip_code,
		      'latitude'   => $latitude,
		      'longitude'  => $longitude,
		      'device_id'  => $device_id,
		      'device_type'=> $device_type,
		      'updated'    => $dvc_date
		 );
		 if(!empty($refference_code)){
		 	$checkForCode = 2;
		 	$rfrInfo = $this->User_model->getRecord('user_info',array('refference_code'=>$refference_code,'is_delete'=>0));
			if(!empty($rfrInfo)){
				$rfr_id = $rfrInfo[0]['user_id'];
				$dataArr['reffer_by'] = $rfr_id;
				
				$reffer_count = $rfrInfo[0]['reffer_count'] + 1;
				$total_reffer_count = $rfrInfo[0]['total_reffer_count'] + 1;
				
				$updtRefr = array(
				     'reffer_count' => $reffer_count,
				     'total_reffer_count' => $total_reffer_count
				);
				$checkForCode = 1;
				$this->User_model->updateRecord('user_info',$updtRefr,array('user_id'=>$rfr_id));
			}else{
				$post['message']="Invalid code.";
			} 
		 }
		 if($checkForCode == 1){
		 	 $updt = $this->User_model->updateRecord('user_info',$dataArr,array('user_id'=>$user_id));
		 
		     $post['message']="success";
			 $post['is_array']=0;
			 $post = $this->User_model->getUserInfo($user_id);
		 }
		 
		 
		 echo json_encode($post);
	}	
    /* end update profile */
    
    /* Start get all notification */
    public function allNotificationView_get() 
	{
		 $this->load->view('webservices/all_user_notification');
	}
	public function allNotification_post()
	{
		 $user_id = $this->input->post('user_id');
		 $dvcTimeZone = $this->input->post('timezone');
		 
		 $sql = "SELECT * FROM `notification_user` WHERE `receiver_id` = ".$user_id."
		        ORDER BY `notification_id` DESC";
	     $notifInfo = $this->User_model->getRecordSql($sql);
	     if(!empty($notifInfo)){

			 foreach($notifInfo as $ntf){
			 	  $share_status = $split_status = '';
			 	  if($ntf['notification_type'] == 2){
			 	 	    //// get order contact share request ////
			 	 	    $order_id = $ntf['order_id'];
						$shareInfo = $this->User_model->getRecord('order_contact_share',array('order_id' =>$order_id));
						if(!empty($shareInfo)){
							$share_status = $shareInfo[0]['status'];
						}
			 	  }
				  if($ntf['notification_type'] == 3){
			 	 	    //// get order contact share request ////
			 	 	    $order_id = $ntf['order_id'];
						$splitInfo = $this->User_model->getRecord('order_payment',array('user_id'=>$user_id,'order_id' =>$order_id));
						if(!empty($splitInfo)){
							$split_status = $splitInfo[0]['request_status'];
						}
                        if($ntf['sub_type'] == 3){
                        	$split_status = '';
                        }
			 	  }
			 	  $notificationArr[] = array(
				        'notification_id'   => $ntf['notification_id'],
				        'restaurant_id'     => $ntf['restaurant_id'],
				        'deliverer_id'      => $ntf['deliverer_id'],
				        'receiver_id'       => $ntf['receiver_id'],
				        'order_id'          => $ntf['order_id'],
				        'notification'      => $ntf['notification'],
				        'notification_type' => $ntf['notification_type'],
				        'sub_type'          => $ntf['sub_type'],
				        'is_read'           => $ntf['is_read'],
				        'is_deleted'        => $ntf['is_deleted'],
				        'created'           => $ntf['created'],
				        'contact_share_status' => $share_status,
				        'split_request_status' => $split_status 
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
    
    /* start user Logout */
    public function userLogoutView_get() 
	{
		 $this->load->view('webservices/user_logout');
	}
	public function userLogout_post()
	{
		 $user_id = $this->input->post('user_id');
		 
		 $updateArr = array(
		      'device_id'=> '',
			  'device_type'=> '',
			  //'latitude' => $latitude,
			  //'longitude' => $longitude,
			  'login_status' => 1
		 );
		 $this->User_model->updateRecord('user_info',$updateArr ,array('user_id'=>$user_id));
		 $post['message']="success";
		 $post['is_array']=0;
		 
		 echo json_encode($post);
	}
    /* end user Logout */
}
?>