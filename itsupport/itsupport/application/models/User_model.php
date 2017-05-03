<?php 
 class User_model extends CI_Model {
     
		function __construct() 
		{
			parent::__construct();
			$this->load->database();	
		}
		public function saveRecord($table,$data)
		{
			$this -> db -> insert($table,$data);
			$id = $this -> db -> insert_id();
			if ($id == 0) 
			{
				return 0; //if not inserted 
			} 
			else 
			{
				return $id; //if inserted
			}
		}
		public function getRecord($table,$where)
		{
			$query=$this->db->get_where($table,$where);
			$row=$query->result_array();
			if(!$row)
			{
				return 0;	
			}
			else 
			{
				return $row;
			}
		}
		public function getRecordSql($sql)
		{
			$query = $this->db->query($sql);
			$rows = $query->result_array();
			if(!$rows)
			{
				return 0;	
			}
			else 
			{
				return $rows;
			}
		}
		public function deleteRecord($table,$where) 
		{
			$this -> db -> delete($table, $where);
			if ($this -> db -> affected_rows() > 0) 
			{
				return 1;
			} 
			else 
			{
				return 0;
			}
		}
		public function updateRecord($table,$data,$where)
		{
			$this -> db -> where($where);
			$this -> db -> update($table, $data);
			//echo $this->db->last_query();die;
			return $afftectedRows = $this -> db -> affected_rows();
		}
		public function recordOrder($table,$data,$column,$order)
		{
			$this ->db-> order_by($column,$order);
			$query = $this -> db -> get_where($table,$data);
			$rows = $query -> result_array();
			if(!$rows)
			{
				return 0;
			}
			else 
			{
				return $rows;	
			}
	   }
	   public function genRandomPassword($length) 
	   {
		
		 $characters = '12346789abcdefghjkmnpqrstuvwxyABCDEFGHJKLMNPQRSTUVWXYZ';
		 $string = '';
		 for ($p = 0; $p < $length; $p++) {
			 $string .= @$characters[@mt_rand(0, @strlen($characters))];
		 }
		 return $string;
	  }
	  function encrypt_decrypt($action, $string) 
	  {
			$output = false;
			$encrypt_method = "AES-256-CBC";
			$secret_key = 'This is my secret key';
			$secret_iv = 'This is my secret iv';
		
			// hash
			$key = hash('sha256', $secret_key);
			
			// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
		
			if( $action == 'encrypt' ) {
				$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
				$output = base64_encode($output);
			}
			else if( $action == 'decrypt' ){
				$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
			}
		
			return $output;
	 }
	 public function sendEmail($email_id,$subject,$message) 
	 {
		
		$to = $email_id;
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <parkhya.developer@gmail.com>' . "\r\n";
		
		mail($to,$subject,$message,$headers);	
			
	 }
     function send_android_notification($registatoin_ids,$message,$notificationType,$dataArray,$totalCount) 
     {
		  // Set POST variables
		  $url = 'https://android.googleapis.com/gcm/send';
		  /*$fields = array(
			   'registration_ids' => array($registatoin_ids),
			  'data' =>  array('message' => $message,'badge_count'=>$badge_count),
		  );*/
		  $fields = array(
			  'registration_ids' => array($registatoin_ids),
			  'data' =>  array('message'=>$message,'notification_type'=>$notificationType,'data_array'=>$dataArray,'total_count'=>$totalCount),
		  );
		  //AIzaSyArUgBagMcpaZ4RRokzMuE6T4rqqWPlvsA
		  $headers = array(
			   'Authorization: key=AIzaSyAym4sOdFXX1kG5HcaSZuB8KZd3GH6m9eU',
			   'Content-Type: application/json'
		   );
		   // Open connection
		   $ch = curl_init();
	       
		   // Set the url, number of POST vars, POST data
		   curl_setopt($ch, CURLOPT_URL, $url);
	       
		   curl_setopt($ch, CURLOPT_POST, true);
		   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
		   // Disabling SSL Certificate support temporarly
		   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
		   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	       
		   // Execute post
		   $result = curl_exec($ch);
		   /*echo "<pre>";
		   print_r($result);*/
		   if ($result === FALSE) 
		   {
			  // die('Curl failed: ' . curl_error($ch));
			  return 0;
		   }
		   else 
		   {
			  return 1;	
		   }
		   // Close connection
		   curl_close($ch);
		//   echo $result;
	}
	public function customer_iphone_notification($deviceToken,$message,$notificationType,$sub_type,$dataArray,$totalCount)
	{
		
		$passphrase = 'abc123';
		////////////////////////////////////////////////////////////////////////////////
		// $pemfile = base_url()."APNS/SelfieezAPNS-ClientA-C.pem";
		
		$pemfile = $_SERVER['DOCUMENT_ROOT'] . "/fooder_app/assets/ios/fooderCustomer.pem";
		
		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', $pemfile);
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
		
		// Open a connection to the APNS server
		//$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (!$fp)
		exit("Failed to connect: $err $errstr" . PHP_EOL);
		// Create the payload body
		$body['aps'] = array(
			 'alert' => $message,
			 'notification_type' => $notificationType,
			 'sub_type'  => $sub_type,
			 'data_array' => $dataArray,
			 'total_count'=> $totalCount,
			 'sound' => 'default',
		);
		// Encode the payload as JSON
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		return $result = fwrite($fp, $msg, strlen($msg));
		/*if (!$result)
		return  0;
		else
		return  1;*/
		// Close the connection to the server
		fclose($fp);
	}
    public function delivery_iphone_notification($deviceToken,$message,$notificationType,$sub_type,$dataArray,$totalCount)
	{
		
		$passphrase = '123';
		////////////////////////////////////////////////////////////////////////////////
		// $pemfile = base_url()."APNS/SelfieezAPNS-ClientA-C.pem";
		
		$pemfile = $_SERVER['DOCUMENT_ROOT'] . "/fooder_app/assets/ios/fooderDelivery.pem";
		
		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', $pemfile);
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
		
		// Open a connection to the APNS server
		//$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (!$fp)
		exit("Failed to connect: $err $errstr" . PHP_EOL);
		// Create the payload body
		$body['aps'] = array(
			 'alert' => $message,
			 'notification_type' => $notificationType,
			 'sub_type'   => $sub_type,
			 'data_array' => $dataArray,
			 'total_count'=> $totalCount,
			 'sound' => 'default',
		);
		// Encode the payload as JSON
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		if (!$result)
		return  0;
		else
		return  1;
		// Close the connection to the server
		fclose($fp);
	 }
	 
	 public function serverTimeZone()
	 {
		 echo date_default_timezone_get();
	 }
	 
	 public function serverTime($device_date,$device_time_zone)
	 {
		$server_timezone= date_default_timezone_get();
		
		date_default_timezone_set($device_time_zone);

		$datetime = new DateTime($device_date);
		$datetime->format('Y-m-d H:i:s') . "\n";
		$la_time = new DateTimeZone($server_timezone);
		$datetime->setTimezone($la_time);
		date_default_timezone_set($server_timezone);
		return $datetime->format('Y-m-d H:i:s');
		
	 }
	 public function convertTime($device_date,$device_time_zone)
	 {
		/*
		$dt = new DateTime($device_date, new DateTimeZone($device_time_zone));
		$dt->format('r') . PHP_EOL;
		$dt->setTimezone(new DateTimeZone($server_timezone));
		$time_zone=$dt->format('Y-m-d H:i:s');
		$to_time = strtotime($device_date);
		$from_time = strtotime($time_zone);
		$difference= round(($to_time - $from_time) / 60,2). " minutes";
		$endTime = strtotime($difference, strtotime($time_zone));
		return date('Y-m-d H:i:s', $endTime);
		*/
		$server_timezone= date_default_timezone_get();
		
		date_default_timezone_set($server_timezone);

		$datetime = new DateTime($device_date);
		$datetime->format('Y-m-d H:i:s') . "\n";
		$la_time = new DateTimeZone($device_time_zone);
		$datetime->setTimezone($la_time);
		date_default_timezone_set($server_timezone);
		return $datetime->format('Y-m-d H:i:s');
		
	 }
	 
	 public function getUserInfo($logId) 
	 {
		 $imagePath = base_url().'profile_images/';
		 $post['message']="success";
	     
		 $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$logId));
		 
		 $post['user_id']= $userInfo[0]['user_id'];
		 $post['first_name']= $userInfo[0]['first_name'];
		 $post['last_name']= $userInfo[0]['last_name'];
		 $post['email'] = $userInfo[0]['email'];
		 $post['password'] = $userInfo[0]['password'];
		 $post['mobile'] = ($userInfo[0]['mobile'] != '')?$userInfo[0]['mobile']:'';
		 $post['gender'] = $userInfo[0]['gender'];
		 $post['flat_no'] = ($userInfo[0]['flat_no'] != '')?$userInfo[0]['flat_no']:'';
		 $post['street'] = ($userInfo[0]['street'] != '')?$userInfo[0]['street']:'';
		 $post['address'] = ($userInfo[0]['address'] != '')?$userInfo[0]['address']:'';
		 $post['landmark'] = ($userInfo[0]['landmark'] != '')?$userInfo[0]['landmark']:'';
		 $post['area_id'] = ($userInfo[0]['area_id'] != '')?$userInfo[0]['area_id']:'';
		 $post['city_id'] = ($userInfo[0]['city_id'] != '')?$userInfo[0]['city_id']:'';
		 $post['zipcode'] = ($userInfo[0]['zip_code'] != '')?$userInfo[0]['zip_code']:'';
		 $post['latitude'] = $userInfo[0]['latitude'];
		 $post['longitude'] = $userInfo[0]['longitude'];
		 $post['social_id'] = ($userInfo[0]['social_id'] != '' )?$userInfo[0]['social_id']:'';
		 $post['social_type'] = ($userInfo[0]['social_type'] != '')?$userInfo[0]['social_type']:'';
		 $post['device_type'] = $userInfo[0]['device_type'];
		 $post['device_id'] = $userInfo[0]['device_id'];
		 $post['notification_status'] = $userInfo[0]['notification_status'];
		 $post['notification_count'] = $userInfo[0]['notification_count'];
		 $post['refference_code'] = ($userInfo[0]['refference_code'] != '')?$userInfo[0]['refference_code']:'';
		 $post['reffer_by'] = ($userInfo[0]['reffer_by'] != '')?$userInfo[0]['reffer_by']:'';
		 $post['reffer_count'] = $userInfo[0]['reffer_count'];
		 $post['total_reffer_count']= $userInfo[0]['total_reffer_count'];
		 $post['reject_order_count']= $userInfo[0]['reject_order_count'];
		 $post['total_reject_count']=$userInfo[0]['total_reject_count'];
		 
		 $post['is_delete'] = $userInfo[0]['is_delete'];
		 $post['is_verify'] = $userInfo[0]['is_verify'];
		 $post['created'] = ($userInfo[0]['created'] != '')?$userInfo[0]['created']:'';
		 
		 return $post;
	 }

     public function getDelivererInfo($logId) 
	 {
		 $post['message']="success";
	     
		 $delivererInfo = $this->User_model->getRecord('deliverer_info',array('deliverer_id'=>$logId));
		 
		 /// code for getting rating and total count ///
		  $ratingSql = "SELECT AVG(RW.rating) as total_rating,COUNT(RW.review_id) as total_count FROM review RW WHERE RW.deliverer_id = ".$logId." ";
		  $ratingInfo = $this->User_model->getRecordSql($ratingSql);
			
		  $total_rating = $total_count = 0;
			if(!empty($ratingInfo)){
				$total_rating = ($ratingInfo[0]['total_rating'] != '')?$ratingInfo[0]['total_rating']:0;
				$total_count = ($ratingInfo[0]['total_count'] != '')?$ratingInfo[0]['total_count']:0;
		  }
		 
		 $post['deliverer_id']= $delivererInfo[0]['deliverer_id'];
		 $post['first_name']= $delivererInfo[0]['first_name'];
		 $post['last_name']= $delivererInfo[0]['last_name'];
		 $post['email'] = $delivererInfo[0]['email'];
		 $post['password'] = $delivererInfo[0]['password'];
		 $post['contact'] = ($delivererInfo[0]['contact'] != '')?$delivererInfo[0]['contact']:'';
		 $post['alt_contact'] = ($delivererInfo[0]['alt_contact'] != '')?$delivererInfo[0]['alt_contact']:'';
		 $post['gender'] = $delivererInfo[0]['gender'];
		 $post['flat_no'] = ($delivererInfo[0]['flat_no'] != '')?$delivererInfo[0]['flat_no']:'';
		 $post['street'] = ($delivererInfo[0]['street'] != '')?$delivererInfo[0]['street']:'';
		 $post['address'] = ($delivererInfo[0]['address'] != '')?$delivererInfo[0]['address']:'';
		 $post['landmark'] = ($delivererInfo[0]['landmark'] != '')?$delivererInfo[0]['landmark']:'';
		 $post['area_id'] = ($delivererInfo[0]['area_id'] != '')?$delivererInfo[0]['area_id']:'';
		 $post['city_id'] = ($delivererInfo[0]['city_id'] != '')?$delivererInfo[0]['city_id']:'';
		 $post['zipcode'] = ($delivererInfo[0]['zip_code'] != '')?$delivererInfo[0]['zip_code']:'';
		 $post['latitude'] = $delivererInfo[0]['latitude'];
		 $post['longitude'] = $delivererInfo[0]['longitude'];
		 $post['duty_status'] = $delivererInfo[0]['duty_status'];
		 $post['balance'] = $delivererInfo[0]['balance'];
		 $post['device_type'] = $delivererInfo[0]['device_type'];
		 $post['device_id'] = $delivererInfo[0]['device_id'];
		 $post['notification_status'] = $delivererInfo[0]['notification_status'];
		 $post['notification_count'] = $delivererInfo[0]['notification_count'];
		 $post['is_delete'] = $delivererInfo[0]['is_delete'];
		 $post['is_verify'] = $delivererInfo[0]['is_verify'];
		 $post['created'] = ($delivererInfo[0]['created'] != '')?$delivererInfo[0]['created']:'';
		 $post['total_rating'] = ($total_rating > 0 )?$total_rating: '0.0';
		 $post['total_count'] = $total_count;
		 
		 return $post;
	 }
	 
	 public function restaurantCardView($restaurant_id,$latitude,$longitude) 
	 {
		   $restImgPath = base_url().'images/restaurant_images/';
		   $itemImgPath = base_url().'images/item_images/';
		   $menuImgPath = base_url().'images/menu_images/';
		   
	 	   $dataArr = array();
		   $sql = "SELECT ((6371 * ACOS( COS( RADIANS(".$latitude.") ) * COS( RADIANS(RI.latitude) ) * 
			        COS( RADIANS( RI.longitude ) - RADIANS(".$longitude.") ) + SIN( RADIANS(".$latitude.") ) * 
			        SIN( RADIANS( RI.latitude) ) ) )) AS distance , RI.* FROM restaurant_info RI WHERE 
			        RI.restaurant_id = ".$restaurant_id." AND RI.is_available = 0 AND RI.is_delete = 0 ";
		   
		   $restInfo = $this->User_model->getRecordSql($sql);
		   
		   if(!empty($restInfo)){
		   	    //foreach($restInfo as $rest){
					  $menuArr = array();	
					  $restaurant_id = $restInfo[0]['restaurant_id'];
					  
					  /// get restaurant menu list ///
					  $menuList = $this->User_model->getRecord('restaurant_menu',array('restaurant_id'=>$restaurant_id));
					  if(!empty($menuList)){
					  	  foreach($menuList as $menu){
					  	  	   $foodArr = array();
					  	  	   $rest_menu_id =  $menu['rest_menu_id'];
							   
							   //// get food list ////
							   $foodList = $this->User_model->getRecord('restaurant_food_items',array('rest_menu_id'=>$rest_menu_id));
							   if(!empty($foodList)){
							   	   foreach($foodList as $food){
							   	   	    $foodArr[] = array(
							   	   	        'food_item_id' => $food['food_item_id'],
							   	   	        'rest_menu_id' => $food['rest_menu_id'],
							   	   	        'restaurant_id' => $food['restaurant_id'],
							   	   	        'item_name' => $food['item_name'],
							   	   	        'item_description' => $food['item_description'],
							   	   	        'item_price' => $food['item_price'],
							   	   	        'item_img' => ($food['item_img'] != '')?$itemImgPath.$food['item_img']:'',
							   	   	        'item_type' => $food['item_type'],
							   	   	        'item_rating' => 2
							   	   	    );
							   	   }
							   }
					  	  	   $menuArr[] = array(
							       'rest_menu_id' => $menu['rest_menu_id'],
							       'restaurant_id' => $menu['restaurant_id'],
							       'menu_title' => $menu['menu_title'],
							       'menu_img' => ($menu['menu_img'] != '')?$menuImgPath.$menu['menu_img']:'',
							       'food_list' => $foodArr
							   );
					  	  }
					  }
					  //// get rstaurant type ///
					  $foodTypeArr = array();
					  $foodCatSql = "SELECT RF.rest_food_cat_id,FC.food_cat_id,FC.food_cat_name FROM restaurant_food_cat RF 
									 LEFT JOIN food_category FC ON FC.food_cat_id = RF.food_cat_id
									 WHERE RF.restaurant_id = ".$restaurant_id." ";
					  
					  $foodCatInfo = $this->User_model->getRecordSql($foodCatSql);
					  if(!empty($foodCatInfo)){
					  	  foreach($foodCatInfo as $type){
					  	  	   $foodTypeArr[] = array(
							        'rest_food_cat_id' => $type['rest_food_cat_id'],
							        'food_cat_id' => $type['food_cat_id'],
							        'food_cat_name' => $type['food_cat_name']
							   );
					  	  }
					  }
					  
					  /// code for getting rating and total count ///
					  $ratingSql = "SELECT AVG(RW.rating) as total_rating,COUNT(RW.review_id) as total_count FROM review RW WHERE RW.restaurant_id = ".$restaurant_id." ";
					  $ratingInfo = $this->User_model->getRecordSql($ratingSql);
						
					   $total_rating = $total_count = 0;
						if(!empty($ratingInfo)){
							$total_rating = ($ratingInfo[0]['total_rating'] != '')?$ratingInfo[0]['total_rating']:0;
							$total_count = ($ratingInfo[0]['total_count'] != '')?$ratingInfo[0]['total_count']:0;
					   }
					   
					  //// get rstaurant area list ///
					  $areaListArr = array();
					  $areaListSql = "SELECT DA.restaurant_id,DA.area_id,AR.area_name,AR.latitude,AR.longitude 
									  FROM restaurant_delivery_area DA LEFT JOIN area AR ON AR.area_id = DA.area_id
									  WHERE DA.restaurant_id = ".$restaurant_id." ";
					  
					  $areaListInfo = $this->User_model->getRecordSql($areaListSql);
					  if(!empty($areaListInfo)){
					  	  foreach($areaListInfo as $areaList){
					  	  	   $areaListArr[] = array(
							        'restaurant_id' => $areaList['restaurant_id'],
							        'area_id'      => $areaList['area_id'],
							        'area_name'      => $areaList['area_name'],
							        'latitude'      => $areaList['latitude'],
							        'longitude'      => $areaList['longitude']
							   );
					  	  }
					  } 
						
					  $dataArr = array(
					      'distance' => $restInfo[0]['distance'],
					      'restaurant_id' => $restInfo[0]['restaurant_id'],
					      'restaurant_name' => $restInfo[0]['restaurant_name'],
					      'restaurant_img' => ($restInfo[0]['restaurant_img'] != '')?$restImgPath.$restInfo[0]['restaurant_img']:'',
					      'paypal_email' => $restInfo[0]['paypal_email'],
					      'start_day' => $restInfo[0]['start_day'],
					      'close_day' => $restInfo[0]['close_day'],
					      'open_time' => $restInfo[0]['open_time'],
					      'close_time' => $restInfo[0]['close_time'],
					      'min_amount' => $restInfo[0]['min_amount'],
					      'tax'        => $restInfo[0]['tax'],
					      'avail_distance'  => ($restInfo[0]['avail_distance'] != '')?$restInfo[0]['avail_distance']:'',
			              'delivery_time'   => ($restInfo[0]['delivery_time'] != '')?$restInfo[0]['delivery_time']:'',
					      'latitude'        => $restInfo[0]['latitude'],
					      'longitude'       => $restInfo[0]['longitude'],
					      'total_rating' => ($total_rating > 0 )?$total_rating: '0.0',
					      'total_count' => $total_count,
					      'restaurant_type' => $foodTypeArr,
					      'menu_list' => $menuArr,
					      'area_list' => $areaListArr
					 );
		   	    }
		   //}  
           return $dataArr;
		///  
	 }
	 
	 public function getOrderDetail($order_id,$dvcTimeZone) 
	 {
	 	     //$dvcTimeZone = 'Asia/Kolkata';  
	 	     $orderDetailArr = array(); 	
	 	     $orderSql = "SELECT OI.*,UI.first_name,UI.last_name,OS.order_status FROM order_info OI 
						  LEFT JOIN order_status OS ON OS.order_status_id = OI.order_status_id
						  LEFT JOIN user_info UI ON UI.user_id = OI.user_id
						  WHERE OI.order_id = '".$order_id."' ";
			 $orderInfo = $this->User_model->getRecordSql($orderSql);
			 if(!empty($orderInfo)){
			 	
				$order_id = $orderInfo[0]['order_id'];
			
				//// get order item list ///
				$itemArr = array();
				$itemSql = "SELECT OI.*,RF.item_name FROM order_item OI 
							LEFT JOIN restaurant_food_items RF ON RF.food_item_id = OI.food_item_id
							WHERE OI.order_id = '".$order_id."' ";
			    $itemInfo = $this->User_model->getRecordSql($itemSql); 				
				if(!empty($itemInfo)){
					foreach($itemInfo as $item){
						$itemArr[] = array(
						     'order_item_id' => $item['order_item_id'],
						     'order_id'      => $item['order_id'],
						     'food_item_id'  => $item['food_item_id'],
						     'item_name'     => $item['item_name'],
						     'price'         => $item['price'],
						     'total_price'   => $item['total_price'],
						     'quantity'      => $item['quantity']
						);
					}
				}
				//// get payment detail ///
				$payArr = array();
				$paySql =  "SELECT OP.*,UI.first_name,UI.last_name FROM order_payment OP 
							LEFT JOIN user_info UI ON UI.user_id = OP.user_id
							WHERE OP.order_id = '".$order_id."' ";
				$payInfo = $this->User_model->getRecordSql($paySql);
				if(!empty($payInfo)){
					foreach($payInfo as $pay){
						 $payArr[] = array(
						      'order_payment_id' => $pay['order_payment_id'],
						      'order_id'         => $pay['order_id'],
						      'user_id'          => $pay['user_id'],
						      'user_name'        => $pay['first_name'].' '.$pay['last_name'],
						      'payment_type'     => $pay['payment_type'],
						      'amount'           => $pay['amount'],
						      'total_amount'     => ($pay['total_amount'] != '')?$pay['total_amount']:'',
						      'is_split'         => $pay['is_split'],
						      'paypal_id'        => $pay['paypal_id'],
						      'transaction_id'   => $pay['transaction_id'],
						      'request_status'   => $pay['request_status'],
						      'payment_status'   => $pay['payment_status'],
						      'create_time'      => $pay['create_time'],
						      'state'            => $pay['state']
						 );
					}
				}
				
				//// get restaurant detail ///
				$restTym = '';
				$restaurant_id = $orderInfo[0]['restaurant_id'];
				$restaurantArr = '';
				$restSql = "SELECT RI.restaurant_id,RI.restaurant_name,RI.email,RI.contact,RI.address,RI.latitude,
				            RI.longitude,RI.min_amount,RI.delivery_time,RI.paypal_email,CT.city_name,AI.area_name,RI.retry_time_limit FROM restaurant_info RI 
							LEFT JOIN city CT ON CT.city_id = RI.city_id
							LEFT JOIN area AI ON AI.area_id = RI.area_id
							WHERE RI.restaurant_id = ".$restaurant_id." ";
			    $restInfo = $this->User_model->getRecordSql($restSql); 				
				if(!empty($restInfo)){
					$restaurantArr = array(
					     'restaurant_id'   => $restInfo[0]['restaurant_id'],
					     'restaurant_name' => $restInfo[0]['restaurant_name'],
					     'email'           => $restInfo[0]['email'],
					     'paypal_email'    => $restInfo[0]['paypal_email'],
					     'contact'         => $restInfo[0]['contact'],
					     'min_amount'      => $restInfo[0]['min_amount'],
					     'retry_time_limit'=> $restInfo[0]['retry_time_limit'],
					     'delivery_time'   => $restInfo[0]['delivery_time'],
					     'address'         => $restInfo[0]['address'],
					     'latitude'        => $restInfo[0]['latitude'],
					     'longitude'       => $restInfo[0]['longitude'],
					     'city_name'       => ($restInfo[0]['city_name'] != '')?$restInfo[0]['city_name']:'',
					     'area_name'       => ($restInfo[0]['area_name'] != '')?$restInfo[0]['area_name']:''
					);
					$restTym = ($restInfo[0]['delivery_time'] != '')?$restInfo[0]['delivery_time']:'';
				}
				//// get deliverer detail ///
				$deliverer_id = $orderInfo[0]['deliverer_id'];
				$delivererArr = '';
				if($deliverer_id != ''){
					
					$delSql = "SELECT DI.*,CT.city_name,AI.area_name FROM deliverer_info DI 
								LEFT JOIN city CT ON CT.city_id = DI.city_id
								LEFT JOIN area AI ON AI.area_id = DI.area_id 
								WHERE DI.deliverer_id = ".$deliverer_id." ";
				    $delInfo = $this->User_model->getRecordSql($delSql); 				
					if(!empty($delInfo)){
						$delivererArr = array(
						     'deliverer_id' => $delInfo[0]['deliverer_id'],
						     'first_name'   => $delInfo[0]['first_name'],
						     'last_name'    => $delInfo[0]['last_name'],
						     'email'        => $delInfo[0]['email'],
						     'contact'      => ($delInfo[0]['contact'] != '')?$delInfo[0]['contact']:'',
						     'alt_contact'  => ($delInfo[0]['alt_contact'] != '')?$delInfo[0]['alt_contact']:'',
						     'address'      => ($delInfo[0]['address'] != '')?$delInfo[0]['address']:'',
						     'latitude'     => $delInfo[0]['latitude'],
						     'longitude'    => $delInfo[0]['longitude'],
						     'city_name'    => ($delInfo[0]['city_name'] != '')?$delInfo[0]['city_name']:'',
						     'area_name'    => ($delInfo[0]['area_name'] != '')?$delInfo[0]['area_name']:''
						);
					}
				}
				
				//// get customer detail ///
				$user_id = $orderInfo[0]['user_id'];
				$customerArr = '';
				$userSql = "SELECT UI.user_id,UI.first_name,UI.last_name,UI.email,UI.mobile 
				            FROM user_info UI WHERE UI.user_id = ".$user_id." ";
			    $userInfo = $this->User_model->getRecordSql($userSql); 				
				if(!empty($userInfo)){
					$customerArr = array(
					     'user_id'    => $userInfo[0]['user_id'],
					     'first_name' => $userInfo[0]['first_name'],
					     'last_name'  => $userInfo[0]['last_name'],
					     'email'      => $userInfo[0]['email'],
					     'mobile'     => ($userInfo[0]['mobile'] != '')?$userInfo[0]['mobile']:'',
					);
				}
                $resStatus = '';
				if($orderInfo[0]['is_canceled'] == 0){
					if($orderInfo[0]['restaurant_status'] == 0){
						 $resStatus = 'Pending';
					}elseif($orderInfo[0]['restaurant_status'] == 2){
						 $resStatus = 'Rejected by restaurant';
					}
                    if($resStatus == ''){
                    	if($orderInfo[0]['order_status'] != ''){
	                    	$resStatus = $orderInfo[0]['order_status'];
	                    }
                    }
				}else{
					$resStatus = 'Canceled';
				}
				
				//// get order contact share request ////
				$share_status = '';
				$shareInfo = $this->User_model->getRecord('order_contact_share',array('order_id' =>$order_id));
				if(!empty($shareInfo)){
					$share_status = $shareInfo[0]['status'];
				}
				
				$order_date_end_time = $this->User_model->convertTime($orderInfo[0]['retry_update_time'],$dvcTimeZone);
		        $order_end_server_time = date('H:i:s',strtotime($order_date_end_time));
				
				$orderDetailArr = array(
				     'id'                   => $orderInfo[0]['id'],
				     'order_id'             => $orderInfo[0]['order_id'],
				     'user_id'              => $orderInfo[0]['user_id'],
				     'user_name'            => $orderInfo[0]['first_name'].' '.$orderInfo[0]['last_name'],
				     'restaurant_id'        => $orderInfo[0]['restaurant_id'],
				     'order_date'           => $orderInfo[0]['order_date'],
				     'order_time'           => $order_end_server_time,//$orderInfo[0]['order_time'],
				     'flat_no'              => $orderInfo[0]['flat_no'],
				     'street'               => $orderInfo[0]['street'],
				     'address'              => $orderInfo[0]['address'],
				     'landmark'             => $orderInfo[0]['landmark'],
				     'zipcode'              => $orderInfo[0]['zipcode'],
				     'latitude'             => $orderInfo[0]['latitude'],
				     'longitude'            => $orderInfo[0]['longitude'],
				     'delivery_instruction' => $orderInfo[0]['delivery_instruction'],
				     'estm_time'            => ($orderInfo[0]['estm_time'] != '')?$orderInfo[0]['estm_time']:$restTym,
				     'delivery_date'        => ($orderInfo[0]['delivery_date'] != '')?$orderInfo[0]['delivery_date']:'',
				     'delivery_time'        => ($orderInfo[0]['delivery_time'] != '')?$orderInfo[0]['delivery_time']:'',
				     'coupon_code'          => $orderInfo[0]['coupon_code'],
				     'reffer_user_count'    => ($orderInfo[0]['reffer_user_count'] != '')?$orderInfo[0]['reffer_user_count']:'',
				     'coupon_discount'      => ($orderInfo[0]['coupon_discount'] != '')?$orderInfo[0]['coupon_discount']:'',
					 'discount_type'        => ($orderInfo[0]['discount_type'] != '')?$orderInfo[0]['discount_type']:'',
				     'discount_amount'      => ($orderInfo[0]['discount_amount'] != '')?$orderInfo[0]['discount_amount']:'',
				     'tax'                  => $orderInfo[0]['tax'],
				     'sub_total'            => $orderInfo[0]['sub_total'],
				     'total_amount'         => $orderInfo[0]['total_amount'],
				     'payment_type'         => $orderInfo[0]['payment_type'],
				     'order_status_id'      => ($orderInfo[0]['order_status_id'] != '')?$orderInfo[0]['order_status_id']:'',
				     'order_status'         => $resStatus,
				     'deliverer_id'         => ($orderInfo[0]['deliverer_id'] != '')?$orderInfo[0]['deliverer_id']:'',
				     'is_contact_share'     => $orderInfo[0]['is_contact_share'],
				     'signature_file'       => ($orderInfo[0]['signature_file'] != '')?$orderInfo[0]['signature_file']:'',
				     'retry_count'          => $orderInfo[0]['retry_count'],
				     'retry_update_time'    => ($order_end_server_time != '')?$order_end_server_time:'',
				     'is_canceled'          => $orderInfo[0]['is_canceled'],
				     'created'              => $orderInfo[0]['created'],
				     'item_list'            => $itemArr,
			         'payment_detail'       => $payArr,
			         'restaurant_detail'    => $restaurantArr,
			         'deliverer_detail'     => $delivererArr,
			         'customer_detail'      => $customerArr,   
			         'contact_share_status' => $share_status                
				);
				
			 }
             return $orderDetailArr;
	    }	
	    //// --- end --- ///
	    
 }
  
?>