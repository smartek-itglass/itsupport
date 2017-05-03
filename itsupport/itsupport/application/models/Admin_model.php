<?php
/**
 * 
 */
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Admin_model extends CI_Model 
{
	
	function __construct() 
	{
		parent::__construct();
		$this -> load -> database();
	}
	public function record_count($query) 
	{
		$query=$this->db->query($query);
		 $rows= $query->num_rows();
		if (!$rows) 
		{
			return 0; 
		} 
		else 
		{
			return $rows;
		}
	}
	public function getRecordLimit($table, $data,$limit,$start)
	{
		$this -> db ->where($data);
		$this->db->limit($limit,$start);
		$query = $this->db->get($table);
		$rows=$query->result_array();
		if (!$rows) 
		{
			return 0;
		} else {
			return $rows;
		}
	 }
	public function saveRecord($table, $data)
	{
		$this -> db -> insert($table, $data);
		$id = $this -> db -> insert_id();
		//echo $this->db->last_query();die; 
		if($id==0)
		{
			return 0;
		}
		else 
		{
			return $id;	
		}
	}
	public function getRecordQuery($query)
	{
		$query=$this->db->query($query);
		$rows=$query->result_array();
		if (!$rows) 
		{
			return 0; 
		} 
		else 
		{
			return $rows;
		}
	}
	public function updateRecord($table,$data,$where)
	{
		$this -> db -> where($where);
		$this -> db -> update($table, $data);
		//echo $this->db->last_query();die;
		return $afftectedRows = $this -> db -> affected_rows();
	}
	public function deleteRecord($where,$table) 
	{
		$this -> db -> delete($table, $where);
		//echo $this->db->last_query();
		if ($this -> db -> affected_rows() > 0) 
		{
			return 1;
		} 
		else 
		{
			return 0;
		}
	}
	public function get_user_img_url($dir, $str)
	 {
		//return $str= 'http://192.168.1.44'.$str;
		return $str = 'http://' . $_SERVER["HTTP_HOST"] . '/itsupport/images/' . $dir . '/' . $str;
	 }
	
	
	public function getRecord($table, $data)
	 {
		$query = $this -> db -> get_where($table, $data);
		$rows = $query -> result_array();
		if (!$rows) 
		{
			return 0;
		} else {
			return $rows;
		}
	 }	
	public function getRecordOrder($table, $data,$column,$order)
	 {
		$this -> db ->where($data);
		//$rows = $query -> result_array();
		//$this->db->order_by($column, 'RANDOM');
		$this->db->order_by($column, $order);
	    //$this->db->limit(1);
	    $query = $this->db->get($table);
	    $rows=$query->result_array();
		if (!$rows) 
		{
			return 0;
		} else {
			return $rows;
		}
	 }		 
	public function getLatLong($address)
	{

	    $address = str_replace(" ", "+", $address);
	
	    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
	    $json = json_decode($json);
		$status = $json->status;
		if($status=="OK")
		{
		    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
		    return $lat.','.$long;
		}
		else
		{
			return " ".','." ";	
		} 
	
	}

	public function getAddress($lat,$lng)
	{
		$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
		$json = @file_get_contents($url);
		$data=json_decode($json);
		$status = $data->status;
		if($status=="OK")
		return $data->results[0]->formatted_address;
		else
		return false;
	}	
	public function genRandomPassword($length)
	 {
		$characters = '12346789abcdefghjkmnpqrstuvwxyABCDEFGHJKLMNPQRSTUVWXYZ123456789000';
		$string = '';
		for ($p = 0; $p < $length; $p++)
		 {
			$string .= @$characters[@mt_rand(0, @strlen($characters))];
		 }
		return $string;
    }
	public function encrypt_decrypt($action, $string) 
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
	public function dateDiff($date)
	{
		$date1=date('Y-m-d H:i:s');
		//$diff = abs( strtotime( $date1 ) - strtotime( $date ) );
		$diff = ( strtotime( $date1 ) - strtotime( $date ) );
		if((intval( $diff / 86400 ))==0)
		{
			//days is 0
			if(intval( ( $diff % 86400 ) / 3600)==0)
			{
				//hour is 0	
				if(intval( ( $diff / 60 ) % 60 )==0)
				{
					//minut is 0
					echo intval( $diff % 60 )." sec ago";	
				}
				else 
				{
					echo intval( ( $diff / 60 ) % 60 )." mins ago";
				}
			}
			else 
			{
				echo intval( ( $diff % 86400 ) / 3600)." hrs ago";
			}
		}
		else 
		{
			echo intval( $diff / 86400 )." days ago";
		}
	}	
	public function sendMail($email_id,$subject,$message) 
	{
		$base_url=base_url();
		$str="&lsquo;";
		
		$this->load->library('Email'); 
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		$from='parkhya.developer@gmail.com';
		
		
		$to = $email_id;
		$subject = $subject;
		$message =$message;		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "Content-Type: image/jpg;\n" ;
		$headers .= "From:" . $from;	 
		
		
		$this->email->reply_to($from); 
		$this -> email -> from($from,'Classified');
		
		
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);  
		
		//$mail = $this->email->send();
		if($mail = $this->email->send())
		{
			return 1;
		}
		else 
		{
			return 0;
		}
	}
}

?>