<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Restaurant extends CI_Controller 
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
		if(isset($session['email']) && ($session['user_type'] == 2))
		{
			//the email is set in session
			if($session['email']!='' )
			{
				redirect('restaurant/home');	
			}
			
		}
		else 
		{
			
			//session is not in the session
			//now run the validation file
			if($this->form_validation->run('admin_login')==FALSE)
			{
				$this->load->view('restaurant/login');		
			}
			else 
			{
				if(isset($_POST['submit']))
				{
					//now getting the values from view
					$email=$this->input->post('email');
					$password=$this->input->post('password');
					//get the data from admin table
					$result=$this->admin_model->getRecord('restaurant_info',array('email'=>$email,'password'=>$password));
					if($result==0)
					{
						//invalid credential
						$this -> session -> set_flashdata('message', 'Authentication Failed');
						redirect("restaurant/index");	
					}
					else 
					{
						//user validation successful
						$email = $result[0]['email'];
						$password = $result[0]['password'];
						$restaurant_id = $result[0]['restaurant_id'];
						$data=array('email'=>$email,'password'=>$password,'restaurant_id'=>$restaurant_id,'user_type'=>2);
						$this -> session -> set_userdata($data);
						redirect("restaurant/home");	
					}
				}
			}
		}
		
	}
	public function home()
	{
		$session=$this->session->all_userdata();
		$email = $this->session->userdata('email');
		if($email =='')
		{
			redirect('restaurant/index');
		}
		redirect("RestaurantHome/home");
		//$this->load->view('restaurant/home');
	}
	public function logout() 
	{
		//This function is used to logout the user and destroy the session
		$this -> session -> unset_userdata('email');
		$this -> session -> sess_destroy();
		redirect(site_url('restaurant/index'));
		$this -> db -> cache_delete_all();

	}
}

?>