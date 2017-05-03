<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 include (APPPATH . 'libraries/REST_Controller.php');

class DelivererSettings extends REST_Controller 
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('User_model');
	}
	
    public function forgotPasswordView_get()
	{
		//This function is used to forgot the password
		$this->load->view('webservices/deliverer_forgot_password');
	}
	public function forgotPassword_post()
	{
		//This function is for forgot the password
		$email=$this->input->post('email');
		//now check the email_id from login
		$result=$this->User_model->getRecord('deliverer_info',array('email'=>$email));
		//print_r($result);
		if($result==0)
		{
			//This email_id does not exist in the database	
			$post['message']="Email does not exist";
		}
		else 
		{
			//This email_id exist in the database
			$deliverer_id = $result[0]['deliverer_id'];
			$pass = $this->User_model->genRandomPassword(6);
			$this->User_model->updateRecord('deliverer_info',array('password'=>$pass) ,array('deliverer_id'=>$deliverer_id));
			
			$subject='Forgot Password';
			$text = $pass;
			$message = '<html>
                    <head><meta charset="utf-8"><title>Fooder App</title></head>
					<body style=""><div style=" overflow:hidden; max-width:540px; width:100%; padding:10px; box-sizing:border-box; margin:0 auto;">
 						<div style=" text-align:center;margin-bottom: 2px; overflow:hidden; background:#fff; padding-left:10px;">
				            <div style="width:100%; margin:0 auto; background:#fff; padding:5px; box-sizing:border-box;">
								<h1 style=" font-size:16px;font-family:Arial, Helvetica, sans-serif;">Forgot Password</h1>
								<div style="background:#CCCFFF; color:#000; padding:10px; font-family:Arial, Helvetica, sans-serif;">
								<label style="color:#D85555; font-size:14px;"><b>Email Id:</b></label>'.$email.'<br style="margin-top:10px;"><br>
								<label style="color:#D85555;font-size:14px;"><b> Your new password :- </b></label>
								'.$text.'<br style="margin-top:10px;"><br></div>
				            </div>
			            </div>
		            </body>
	            </html>';	
			$mail_result=$this->User_model->sendEmail($email,$subject,$message);
			$post['message']="success";
		}
		echo json_encode($post);
	}
	
	public function changePasswordView_get()
	{
		//This function is used to change password
		$this->load->view('webservices/deliverer_change_password');
	}
	public function changePassword_post()
	{
		 $id = $this->input->post('deliverer_id');
		 $old_password = $this->input->post('old_password');
		 $new_password = $this->input->post('new_password');
		 
		 $result=$this->User_model->getRecord('deliverer_info',array('deliverer_id'=>$id,'password'=>$old_password));
		 
		 if(!empty($result)){
		 	  $updat = $this->User_model->updateRecord('deliverer_info',array('password'=>$new_password),array('deliverer_id'=>$id));
			  $post['message']="success";
		 }else{
		 	  $post['message']="Old password not match";
		 }
		 echo json_encode($post);
	}
	/* end */
	
	/* Contact us */
    public function delContactUsView_get()
	{
		//This function is used to change password
		$this->load->view('webservices/del_contact_us');
	}
	public function delContactUs_post()
	{
		 $deliverer_id = $this->input->post('deliverer_id');
		 $subject = $this->input->post('subject');
		 $message = $this->input->post('message');
		 
		 $delInfo = $this->User_model->getRecord('deliverer_info',array('deliverer_id'=>$deliverer_id));
	     $delName = $delInfo[0]['first_name'].' '.$delInfo[0]['last_name'];
		 
		 $email = 'parkhya.developer@gmail.com';
		 $sub = 'Fooder Deliverer Contact Us';
		 $msg = '<html>
	                <head><meta charset="utf-8"><title>Fooder App</title></head>
					<body style="">
					    <table>
					         <tr>
					             <td>Customer Name :- </td>
					             <td>'.$delName.'</td>
					         </tr>
					         <tr>
					             <td>Subject :- </td>
					             <td>'.$subject.'</td>
					         </tr>
					         <tr>
					             <td>Message :- </td>
					             <td>'.$message.'</td>
					         </tr>
					    </table>   
		            </body>
	            </html>';	
		$mail_result=$this->User_model->sendEmail($email,$sub,$msg);
		$post['message']="success";
		echo json_encode($post);	
	}
    /* End Contact us */
	
	/* Start delete account */
	public function delDeleteAccountView_get()
	{
		//This function is used to change password
		$this->load->view('webservices/del_delete_account');
	}
	public function delDeleteAccount_post()
	{
		 $deliverer_id = $this->input->post('deliverer_id');
		 
		 $sql = "SELECT * FROM `order_info` WHERE `deliverer_id` = ".$deliverer_id." 
		         AND `is_canceled` = 0 AND (`order_status_id` is null OR `order_status_id` < 5) ";
		 
		 $orderList = $this->User_model->getRecordSql($sql);	
		 
		 if($orderList == 0){
		 	 $this->User_model->updateRecord('deliverer_info',array('is_delete'=>1) ,array('deliverer_id'=>$deliverer_id));
		 	 $post['message']="success";
		 }else{
		 	 $post['message']="You can't delete your account, until previous orders are being processed.";
		 }	
		 echo json_encode($post);	
	}
	/* End delete account */
}	

?>