<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 include (APPPATH . 'libraries/REST_Controller.php');

/**
 * 
 */
class delivererInfo extends REST_Controller 
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
}
?>