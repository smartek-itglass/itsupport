<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Admin extends CI_Controller 
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->no_cache();
		$this->load->library('form_validation');	
		$this -> load -> library('session');	
	}
	protected function no_cache() 
	{
		//This function is used for clearing the cache
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
	}
	public function index()
	{
		//this function is for admin login
		$session=$this->session->all_userdata();
		if(isset($session['admin_email_id']))
		{
			//the email is set in session
			if($session['admin_email_id']!='')
			{
				redirect('admin/home');	
			}
			
		}
		else 
		{
			
			//session is not in the session
			//now run the validation file
			if($this->form_validation->run('admin_login')==FALSE)
			{
				$this->load->view('admin/login');		
			}
			else 
			{
				if(isset($_POST['submit']))
				{
					//now getting the values from view
					$email=$this->input->post('email');
					$password=$this->input->post('password');
					//get the data from admin table
					$result=$this->admin_model->getRecord('admin',array('admin_email_id'=>$email,'password'=>$password));
					if($result==0)
					{
						//invalid credential
						$this -> session -> set_flashdata('message', 'Authentication Failed');
						redirect("admin/index");	
					}
					else 
					{
						//user validation successful
						$email_admin=$result[0]['admin_email_id'];
						$data=array('admin_email_id'=>$email_admin);
						$this -> session -> set_userdata($data);
						redirect('admin/home');
					}
				}
			}
		}
		
	}
	public function home()
	{
		$session=$this->session->all_userdata();
		$email = $this->session->userdata('admin_email_id');
		if($email =='')
		{
			redirect('admin/index');
		}
		$this->load->view('admin/home');
	}
	public function changePassword()
	{
		//This function is for change the password 
		$session=$this->session->all_userdata();
		$email = $this->session->userdata('admin_email_id');
		if($email =='')
		{
			redirect('admin/index');
		}
		$this->load->view('admin/change_password');
		if(isset($_POST['submit']))
		{
			//now getting the vlaues from view
			$password=$this->input->post('password');
			$newPassword=$this->input->post('newPassword');
			//check the credential is correct or not
			$check=$this->admin_model->getRecord('admin', array('admin_email_id'=>$email,'password'=>$password));
			if($check==0)
			{
				$this->session->set_flashdata('error_msg','Invalid old password');
				redirect('admin/changePassword');	
			}
			else 
			{
				//all the credentials are valid
				//now update the new password for login email id
				$result=$this->admin_model->updateRecord('admin',array('password'=>$newPassword),array('admin_email_id'=>$email));
				if($result==0)
				{
					$this->session->set_flashdata('error_msg','Unable to change password');
					redirect('admin/changePassword');
				}
				else 
				{
					$this->session->set_flashdata('success_msg','Password changed successfully');
					redirect('admin/changePassword');
				}
			}
		}
	}
	public function sendNotification()
	{
		//This function is for sending the notification to the user
		$session=$this->session->all_userdata();
		$email = $this->session->userdata('admin_email_id');
		if($email =='')
		{
			redirect('admin/index');
		}
		$this->load->view('admin/send_notification');
		if(isset($_POST['submit']))
		{
			//now getting the values from view
			$message=$this->input->post('message');
			/*
			$result=$this->admin_model->getRecord($table, $data);
			if($result!=0)
			{
					
			}*/
			$this->session->set_flashdata('success_msg','Notification send successfully');
		}
	}
	public function logout() 
	{
		//This function is used to logout the user and destroy the session
		$this -> session -> unset_userdata('admin_email_id');
		$this -> session -> sess_destroy();
		redirect(site_url('admin/index'));
		$this -> db -> cache_delete_all();

	}
}

?>