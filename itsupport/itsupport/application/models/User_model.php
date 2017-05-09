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
	  function get_user_img_url($dir, $str)
	 {
		//return $str= 'http://192.168.1.44'.$str;
		return $str = 'http://' . $_SERVER["HTTP_HOST"] . '/itsupport/images/' . $dir . '/' . $str;
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
}
  
?>