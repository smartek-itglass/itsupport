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