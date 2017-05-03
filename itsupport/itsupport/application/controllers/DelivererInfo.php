<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 include (APPPATH . 'libraries/REST_Controller.php');

/**
 * 
 */
class DelivererInfo extends REST_Controller 
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('User_model');
	}
	
	/* signature */
	public function delSignatureView_get() 
	{
		 $this->load->view('webservices/del_signature');
	}
	public function delSignature_post()
	{
		 $order_id = $this->input->post('order_id');
		 $signature_file = $this->input->post('signature_file');
		 $dvcTimeZone = $this->input->post('timezone');
		 
		 $orderInfo = $this->User_model->getRecord('order_info',array('order_id'=>$order_id,'is_canceled'=>0));
		 if(!empty($orderInfo)){
			 	
			 $oldImg = $orderInfo[0]['signature_file'];
			 //echo "<pre/>";
			 //print_r($_FILES);
			 if($_FILES['signature_file']['name']!='')
			 {
					$imanename = $_FILES['signature_file']['name'];
					$temp = explode(".", $_FILES["signature_file"]["name"]);
					$newfilename = rand(1, 99999) . '.' . end($temp);
					//This is for upload the image
					$path= './images/signature_images/'.$newfilename;
					$upload = copy($_FILES['signature_file']['tmp_name'], $path);
					
					/// start delete old image from folder ///
					if($oldImg != '' ){
						 $imgpath = base_url().'images/signature_images/';
						 $oldPath = base_url().'images/signature_images/'.$oldImg; 
						 if(file_exists('images/signature_images/'.$oldImg)){
							 
							 //unlink($oldImgPAth);
							 unlink('images/signature_images/'.$oldImg);
						 }
					 } 
					//// end delete old image //
					$updtArr = array(
					     'signature_file' => $newfilename
					);
					$this->User_model->updateRecord('order_info',$updtArr ,array('order_id'=>$order_id));
					$post['message'] = "success";
			 }else{
			 	$post['message']='error';
			 }
			 
		 }else{
		 	  $post['message']='error';
		 }
		 echo json_encode($post);	
	}
	/* end signature */
	
	/* start update deliverer profile */
	public function delUpdateProfileView_get() 
	{
		 $this->load->view('webservices/del_update_profile');
	}
	public function delUpdateProfile_post()
	{
		$deliverer_id = $this->input->post('deliverer_id');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$contact = $this->input->post('contact');
		$alt_contact = $this->input->post('alt_contact');
		$gender = $this->input->post('gender');
		
		$flat_no = $this->input->post('flat_no');
		$street = $this->input->post('street');
		$address = $this->input->post('address');
		$landmark = $this->input->post('landmark');
		$zip_code = $this->input->post('zip_code');
		$city_id = $this->input->post('city_id');
		$area_id = $this->input->post('area_id');
		
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$device_id = $this->input->post('device_id');
		$device_type = $this->input->post('device_type');
		$dvc_date = date('Y-m-d , H:i:s');
		$dvcTimeZone = $this->input->post('timezone');
		$cur_date = $this->User_model->convertTime($dvc_date,$dvcTimeZone);
		
		$dataArr = array(
			     'first_name'   => $first_name,
			     'last_name'    => $last_name,
			     'contact'      => $contact,
			     'alt_contact'  => $alt_contact,
			     'gender'       => $gender,
			     'flat_no'      => $flat_no,
			     'street'       => $street,
			     'address'      => $address,
			     'landmark'     => $landmark,
			     'zip_code'     => $zip_code,
			     'city_id'      => $city_id,
			     'area_id'      => $area_id,
				 'device_id'    => $device_id,
				 'device_type'  => $device_type,
				 'latitude'     => $latitude,
				 'longitude'    => $longitude,
				 'updated'      => $cur_date,
	    );
		$updt = $this->User_model->updateRecord('deliverer_info',$dataArr,array('deliverer_id'=>$deliverer_id));
		 
	    $post['message']="success";
		$post['is_array']=0;
		$post = $this->User_model->getDelivererInfo($deliverer_id);
		echo json_encode($post);
	}
	/* end update deliverer profile */
	
	/* start user logout */
	public function delivererLogoutView_get() 
	{
		 $this->load->view('webservices/deliverer_logout');
	}
	public function delivererLogout_post() 
	{
		$deliverer_id = $this->input->post('deliverer_id');
		
		$updateArr = array(
		      'device_id'=> '',
			  'device_type'=> '',
			  //'latitude' => $latitude,
			  //'longitude' => $longitude,
			  'login_status' => 1
		 );
		 $this->User_model->updateRecord('deliverer_info',$updateArr ,array('deliverer_id'=>$deliverer_id));
		 $post['message']="success";
		 echo json_encode($post);
	}
	/* end user logout */
}
?>