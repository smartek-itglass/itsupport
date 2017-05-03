<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 include (APPPATH . 'libraries/REST_Controller.php');

class UserSettings extends REST_Controller 
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('User_model');
	}
	
	public function forgotPasswordView_get()
	{
		//This function is used to forgot the password
		$this->load->view('webservices/user_forgot_password');
	}
	public function forgotPassword_post()
	{
		//This function is for forgot the password
		$email=$this->input->post('email');
		//now check the email_id from login
		$result=$this->User_model->getRecord('user_info',array('email'=>$email));
		//print_r($result);
		if($result==0)
		{
			//This email_id does not exist in the database	
			$post['message']="Email does not exist";
		}
		else 
		{
			//This email_id exist in the database
			$user_id = $result[0]['user_id'];
			$pass = $this->User_model->genRandomPassword(6);
			$this->User_model->updateRecord('user_info',array('password'=>$pass) ,array('user_id'=>$user_id));
			
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
		$this->load->view('webservices/user_change_password');
	}
	public function changePassword_post()
	{
		 $user_id = $this->input->post('user_id');
		 $old_password = $this->input->post('old_password');
		 $new_password = $this->input->post('new_password');
		 
		 $result=$this->User_model->getRecord('user_info',array('user_id'=>$user_id,'password'=>$old_password));
		 
		 if(!empty($result)){
		 	  $updat = $this->User_model->updateRecord('user_info',array('password'=>$new_password),array('user_id'=>$user_id));
			  $post['message']="success";
		 }else{
		 	  $post['message']="Old password not match";
		 }
		 echo json_encode($post);
	}
	
	/* Contact us */
    public function userContactUsView_get()
	{
		//This function is used to change password
		$this->load->view('webservices/user_contact_us');
	}
	public function userContactUs_post()
	{
		 $user_id = $this->input->post('user_id');
		 $subject = $this->input->post('subject');
		 $message = $this->input->post('message');
		 
		 $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
		 $userName = $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'];
		 
		 $email = 'parkhya.developer@gmail.com';
		 $sub='Fooder Customer Contact Us';
		 $msg = '<html>
	                <head><meta charset="utf-8"><title>Fooder App</title></head>
					<body style="">
					    <table>
					         <tr>
					             <td>Customer Name :- </td>
					             <td>'.$userName.'</td>
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
	public function userDeleteAccountView_get()
	{
		//This function is used to change password
		$this->load->view('webservices/user_delete_account');
	}
	public function userDeleteAccount_post()
	{
		 $user_id = $this->input->post('user_id');
		 
		 $sql = "SELECT * FROM `order_info` WHERE `user_id` = ".$user_id." AND `is_canceled` = 0 AND 
		        (`order_status_id` is null OR `order_status_id` < 5) ";
		 
		 $orderList = $this->User_model->getRecordSql($sql);	
		 
		 if($orderList == 0){
		 	 $this->User_model->updateRecord('user_info',array('is_delete'=>1) ,array('user_id'=>$user_id));
		 	 $post['message']="success";
		 }else{
		 	 $post['message']="You can't delete your account, until previous orders are being processed.";
		 }	
		 echo json_encode($post);	
	}
	/* End delete account */
}	

?>