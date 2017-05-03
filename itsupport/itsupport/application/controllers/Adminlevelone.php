<?php
/**
 * 
 */
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class Adminlevelone extends CI_Controller 
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this -> load -> library('session');
		$this->no_cache();
		$this->redirect();
		$this->load->library('form_validation');
	}
	protected function no_cache() 
	{
		//This function is used for clearing the cache
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
	}
	public function redirect()
	{
		//This function is used for redirecting a function
		$email = $this->session->userdata('email');
		if($email =='')
		{
			redirect('admin/index');
		}
	}
	/// Start User ///
	public function userList()
	{
		//This function is used for showing list of all registered user in app
		$sql = "SELECT UI.*,CT.city_name FROM `user_info` UI 
				LEFT JOIN city CT ON CT.city_id = UI.city_id
				ORDER BY UI.`user_id` DESC ";
		$data = array();
		$data['data'] = $result = $this->admin_model->getRecordSql($sql);
		$this->load->view('admin/user_list',$data);
	}

	public function editUser()
	{
		/// code edit view ///
		$id = $this->uri->segment(3);
		$sql = "SELECT UI.*,ST.state_id,ST.state_name,CN.country_id,CN.country_name,CT.city_name, 
		        AI.area_name FROM user_info UI 
		        LEFT JOIN area AI ON AI.area_id = UI.area_id
				LEFT JOIN city CT ON CT.city_id = UI.city_id
				LEFT JOIN state ST ON ST.state_id = CT.state_id
				LEFT JOIN country CN ON CN.country_id = ST.state_id
				WHERE UI.user_id = ".$id." ";
		$result['data'] =  $this->admin_model->getRecordSql($sql);
	    $this->load->view('admin/user_detail',$result);		  	
	}
	//// End user ///
	
	/// Start Deliverer ///
	public function delivererList()
	{
		//This function is used for showing list of all registered deliverer in app
		$sql = "SELECT DI.*,CT.city_name FROM `deliverer_info` DI 
				LEFT JOIN city CT ON CT.city_id = DI.city_id
				ORDER BY DI.`deliverer_id` DESC ";
		$data = array();
		$data['data'] = $result = $this->admin_model->getRecordSql($sql);
		$this->load->view('admin/deliverer_list',$data);
	}
	public function approveDeliverer()
	{
		/// code edit view ///
		$id = $this->uri->segment(3);
		$delInfo = $this->admin_model->getRecord('deliverer_info', array('deliverer_id'=>$id));
		$is_approved = $delInfo[0]['is_approved'];
		
		$status = ($is_approved == 0)?1:0;
		$update = $this->admin_model->updateRecord('deliverer_info',array('is_approved'=>$status),array('deliverer_id'=>$id));
		
		redirect('adminlevelone/delivererList');			  	
	}
	public function editDeliverer()
	{
		/// code edit view ///
		$id = $this->uri->segment(3);
		$sql = "SELECT DI.*,ST.state_id,ST.state_name,CN.country_id,CN.country_name,CT.city_name, 
		        AI.area_name FROM deliverer_info DI 
		        LEFT JOIN area AI ON AI.area_id = DI.area_id
				LEFT JOIN city CT ON CT.city_id = DI.city_id
				LEFT JOIN state ST ON ST.state_id = CT.state_id
				LEFT JOIN country CN ON CN.country_id = ST.state_id
				WHERE DI.deliverer_id = ".$id." ";
		$result['data'] =  $this->admin_model->getRecordSql($sql);
	    $this->load->view('admin/deliverer_detail',$result);		  	
	}
	//// End Deliverer ///
	
	////// coupon code ///
	public function couponCode()
	{
	    $a = '';
	    for ($i = 0; $i<5; $i++) 
	    {
	        $a .= mt_rand(0,9);
	    }
	    echo $code = "CPN".$a;		
	}
	public function couponList()
	{
		//This function is used for showing list of all registered deliverer in app
		$data = array();
		$sql = "SELECT * FROM `coupon_master` ORDER BY `coupon_id` DESC; ";
		$data['data'] = $result = $this->admin_model->getRecordSql($sql);
		
		if(isset($_POST['submit']))
		{
			$update_id = ($_POST['update_id'] != '')?$_POST['update_id'] : '';
			if($this->form_validation->run('coupon_val')==FALSE)
			{
				$this->load->view('admin/coupon_master',$data);
			}
			else 
			{
				$saveData = array(
				    'coupon_code' => $_POST['coupon_code'],
				    'reffer_user_count' => $_POST['reffer_user_count'],
				    'discount' => $_POST['discount'],
				    'discount_type' => $_POST['discount_type'],
				    'validity_start_date' => date("Y-m-d", strtotime($_POST['validity_start_date'])),
				    'validity_end_date' => date("Y-m-d", strtotime($_POST['validity_end_date']))
				);
				if(!empty($update_id))
			    {
			    	$saveData['updated'] = date('Y-m-d H:i:s');
					$update = $this->admin_model->updateRecord('coupon_master',$saveData,array('coupon_id'=>$update_id));
					if($update == 0){
						$this -> session -> set_flashdata('error_msg', 'Failed');
					}else{
						$this -> session -> set_flashdata('success_msg', 'Update successfully');
					}
				    	
				}else{
					/// code for save ///
					$saveData['created'] = date('Y-m-d H:i:s');
					$save = $this->admin_model->saveRecord('coupon_master',$saveData);
					//print_r($save);
					if($save == 0)
					{
						$this -> session -> set_flashdata('error_msg', 'Failed');
					}
					else
					{
						$this -> session -> set_flashdata('success_msg', 'Save successfully');
					}
				}
				redirect('adminlevelone/couponList');	
			}
		}else{
			$this->load->view('admin/coupon_master',$data);
		}
	}
	public function editCoupon()
	{
		$id = $this->uri->segment(3); 
		$sql = "SELECT * FROM `coupon_master` ORDER BY `coupon_id` DESC; ";
		$resultList = $result = $this->admin_model->getRecordSql($sql);
		foreach($resultList as $list){
			  $edit = ($list['coupon_id'] == $id)? 1 : 0 ;
		      $result['data'][] = array(
			          'coupon_id' => $list['coupon_id'],
					  'coupon_code' => $list['coupon_code'],
					  'reffer_user_count' => $list['reffer_user_count'],
					  'discount' => $list['discount'],
					  'discount_type' => $list['discount_type'],
					  'validity_start_date' => $list['validity_start_date'],
					  'validity_end_date' => $list['validity_end_date'],
					  'created' => $list['created'],
					  'is_edit' => $edit
			  );
		}
	    $this->load->view('admin/coupon_master',$result);		  	
	}
	public function deleteCoupon()
	{
		$id = $this->uri->segment(3); 
		$couponInfo = $this->admin_model->getRecord('coupon_master', array('coupon_id'=>$id));
		$coupon_code = $couponInfo[0]['coupon_code'];
		
		$aleady = $this->admin_model->getRecord('restaurant_coupon',array('coupon_code'=>$coupon_code));
		if($aleady == 0)
		{ 
			$delete = $this->admin_model->deleteRecord('coupon_master',array('coupon_id'=>$id));
			if($delete > 0){
			    $this -> session -> set_flashdata('success_msg', 'Delete successfully');
			}else{
			    $this -> session -> set_flashdata('error_msg', 'Failed');
			}
		}else{
			$this -> session -> set_flashdata('error_msg', 'You cant delete this data');
		}
	    redirect('adminlevelone/couponList');	
	}
    /* End Coupon */	
    
    /* Start Coupon to add in restaurant */
    public function restaurantCoupon()
	{
		$id = $this->uri->segment(3); 
		$couponInfo = $this->admin_model->getRecord('coupon_master', array('coupon_id'=>$id));
		
		$coupon_code = $couponInfo[0]['coupon_code'];
		$sql = "SELECT RC.*,RI.restaurant_name FROM restaurant_coupon RC 
				LEFT JOIN restaurant_info RI ON RI.restaurant_id = RC.restaurant_id
				WHERE RC.coupon_code = '".$coupon_code."' ";
		$restList = $this->admin_model->getRecordSql($sql);
		
		$result['data'] = $couponInfo;
		$result['data']['restaurant_list'] = $restList;
		//print_r($_POST);
		if(isset($_POST['submit']))
		{
			 //print_r($_POST);
			 $restaurant_list = $_POST['restaurant_list'];
			 if(!empty($restaurant_list)){
			 	  foreach($restaurant_list as $list){
			 	  	  //echo $list;
					  $arr = array(
					      'coupon_code' => $coupon_code,
					      'restaurant_id' => $list
					  );
					  //print_r($arr);
					  //$restCoupon = $this->admin_model->getRecord('restaurant_coupon', $arr);
					  if(empty($restCoupon)){
					  	   $arr['created'] = date('Y-m-d H:i:s');
					  	   $rest_coupon_id = $this->admin_model->saveRecord('restaurant_coupon',$arr); 
					  }
			 	  }
                  //$this -> session -> set_flashdata('success_msg', 'Save successfully');
			 }else{
			 	
			 }
			 redirect('adminlevelone/restaurantCoupon/'.$id);
		}else{
			 $this->load->view('admin/coupon_restaurant',$result);	
		}
	    	  	
	}
    /* End coupon in restaurant */
    
    /* Start Coupon enable/disable for restaurant */
    public function activeRestaurantCoupon()
	{
		$id = $this->uri->segment(3); 
		$couponInfo = $this->admin_model->getRecord('restaurant_coupon', array('rest_coupon_id'=>$id));
		$coupon_code = $couponInfo[0]['coupon_code'];
		
		$codeInfo = $this->admin_model->getRecord('coupon_master',array('coupon_code'=>$coupon_code));
		$coupon_id = $codeInfo[0]['coupon_id'];
		
		$is_active = $couponInfo[0]['is_active'];
		$set_active = ($is_active == 1)?0:1;
		
		$update = $this->admin_model->updateRecord('restaurant_coupon',array('is_active'=>$set_active),array('rest_coupon_id'=>$id));
		
		redirect('adminlevelone/restaurantCoupon/'.$coupon_id);
	}
    /* End Coupon enable/disable for restaurant */
    
    /* Start change password */
    public function changePassword()
	{
		if(isset($_POST['submit']))
		{
			$password = ($_POST['password'] != '')?$_POST['password'] : '';
			$newPassword = ($_POST['newPassword'] != '')?$_POST['newPassword'] : '';
			if($this->form_validation->run('change_password')==FALSE)
			{
				//print_r($_POST);
				$this->load->view('admin/change_password');	
			}
			else 
			{
				//echo "<script>alert($_POST);</script>";   
				$email = $_SESSION['email'];
				//// code for update ///
				$sql = "SELECT * FROM `login` WHERE `email` = '".$email."' AND `password` = '".$password."' ";
				$already = $this->admin_model->getRecordSql($sql);
				if($already != 0)
				{
					$update = $this->admin_model->updateRecord('login',array('password'=>$newPassword),array('email'=>$email));
					if($update == 0){
						$this -> session -> set_flashdata('error_msg', 'Failed');
					}else{
						$this -> session -> set_flashdata('success_msg', 'Update successfully');
					}
				}else{
					$this -> session -> set_flashdata('error_msg', 'Current password not match');
				}
				$this->load->view('admin/change_password');	
			}
		}else{
		    $this->load->view('admin/change_password');	
		}
	}
    /* End change password */
    
	/* Start order list */
    public function orderList()
	{
		
		$statusSql = '';
		$id = $this->uri->segment(3); 
		if($id != ''){
			if($id == 0){
				$statusSql = ' OI.full_payment_status = 1 AND (OI.order_status_id = 0 OR OI.order_status_id IS NULL) AND OI.is_canceled = 0 ';
			}elseif($id > 0 && $id < 6){
				$statusSql = ' OI.full_payment_status = 1 AND OI.order_status_id = '.$id.' AND OI.is_canceled = 0 ';
			}elseif($id == 6){
				$statusSql = ' OI.is_canceled = 1 ';
			}
		}else{
			$statusSql = ' OI.full_payment_status = 1 ';
		}
		
		$sql = "SELECT OI.id,OI.order_id,OI.order_date,OI.total_amount,UI.first_name,UI.last_name,
		        RI.restaurant_name,OI.order_status_id,OI.is_canceled,OS.order_status,OI.restaurant_status FROM order_info OI 
				LEFT JOIN user_info UI ON UI.user_id = OI.user_id
				LEFT JOIN restaurant_info RI ON RI.restaurant_id = OI.restaurant_id
				LEFT JOIN order_status OS ON OS.order_status_id = OI.order_status_id
				WHERE  ".$statusSql." ORDER BY OI.id DESC ";
		$orderList['data'] = $this->admin_model->getRecordSql($sql); 
		
		$this->load->view('admin/order_list',$orderList);	
	}
	/* order list */
	
	/* Start Order Detail */
	public function orderDetail()
	{
		$id = $this->uri->segment(3);
		$orderId = $this->uri->segment(4); 
		
		if($orderId == ''){
			$orderId = $id;
		}
		$order_id = $this->admin_model->encrypt_decrypt('decrypt', $orderId);
		
		$orderArr = $this->admin_model->getOrderInfo($order_id);
		$result['data'] = $orderArr; 
        //echo "<pre/>";
		//print_r($orderArr);		
		//$result['data'] = $orderArr; 
		
		$this->load->view('admin/order_detail',$result);
	}	
	/* End Oeder Setail */
	
	/* Start Order Export */
	public function orderExport()
	{
		$statusSql = '';
		$id = $this->uri->segment(3); 
		if($id != ''){
			if($id == 0){
				$statusSql = ' OI.full_payment_status = 1 AND (OI.order_status_id = 0 OR OI.order_status_id IS NULL) AND OI.is_canceled = 0 ';
			}elseif($id > 0 && $id < 6){
				$statusSql = ' OI.full_payment_status = 1 AND OI.order_status_id = '.$id.' AND OI.is_canceled = 0 ';
			}elseif($id == 6){
				$statusSql = ' OI.is_canceled = 1 ';
			}
		}else{
			$statusSql = ' OI.full_payment_status = 1 ';
		}
		
		$sql = "SELECT OI.id,OI.order_id,OI.order_date,OI.total_amount,UI.first_name,UI.last_name,
		        RI.restaurant_name,OI.order_status_id,OI.is_canceled,OS.order_status,OI.restaurant_status FROM order_info OI 
				LEFT JOIN user_info UI ON UI.user_id = OI.user_id
				LEFT JOIN restaurant_info RI ON RI.restaurant_id = OI.restaurant_id
				LEFT JOIN order_status OS ON OS.order_status_id = OI.order_status_id
				WHERE  ".$statusSql." ORDER BY OI.id DESC ";
		$orderList['data'] = $this->admin_model->getRecordSql($sql); 
		
		$this->load->view('export_excel/export_order_detail.php',$orderList);	
	}	
	/* End Oeder Export */
	
	/* Start charges set */
	public function chargesMaster()
	{
		$data = array();
		$sql = "SELECT * FROM `charges_master` ORDER BY `charge_id` DESC ";
		$data['data'] = $result = $this->admin_model->getRecordSql($sql);
		
		if(isset($_POST['submit']))
		{
			$update_id = ($_POST['update_id'] != '')?$_POST['update_id'] : '';
			if($this->form_validation->run('charges_val')==FALSE)
			{
				$this->load->view('admin/charges_master',$data);
			}
			else 
			{
				$saveData = array(
				    'min_price'          => $_POST['min_price'],
				    'max_price'          => $_POST['max_price'],
				    'restaurant_per'     => $_POST['restaurant_per'],
				    'restaurant_amount'  => $_POST['restaurant_amount'],
				    'del_weekday_per'    => $_POST['del_weekday_per'],
				    'del_weekday_amount' => $_POST['del_weekday_amount'],
				    'del_weekend_per'    => $_POST['del_weekend_per'],
				    'del_weekend_amount' => $_POST['del_weekend_amount']
				);
				$min = $_POST['min_price'];
				$max = $_POST['max_price'];
				
				if(!empty($update_id))
			    {
			    	$saveData['updated'] = date('Y-m-d H:i:s');
					
                    $minSql = "SELECT * FROM `charges_master` WHERE `min_price` = '".$min."' OR `max_price` = '".$min."' ";
					$minCheck = $result = $this->admin_model->getRecordSql($sql);
					
					if($minCheck == 0){
						
						$maxSql = "SELECT * FROM `charges_master` WHERE `max_price` = '".$max."' OR `max_price` = '".$max."' ";
						$maxCheck = $result = $this->admin_model->getRecordSql($sql);	
						
						if($maxCheck == 0){
							$update = $this->admin_model->updateRecord('charges_master',$saveData,array('charge_id'=>$update_id));
							if($update == 0){
								$this -> session -> set_flashdata('error_msg', 'Failed');
							}else{
								$this -> session -> set_flashdata('success_msg', 'Update successfully');
							}
						}else{
							$this -> session -> set_flashdata('error_msg', 'Max price already exists');
						}
					}else{
						$this -> session -> set_flashdata('error_msg', 'Min price already exists');
					}
				    	
				}else{
					/// code for save ///
					$saveData['created'] = date('Y-m-d H:i:s');
					
					$minSql = "SELECT * FROM `charges_master` WHERE `min_price` = '".$min."' OR `max_price` = '".$min."' ";
					$minCheck = $result = $this->admin_model->getRecordSql($sql);
					
					if($minCheck == 0){
						
						$maxSql = "SELECT * FROM `charges_master` WHERE `max_price` = '".$max."' OR `max_price` = '".$max."' ";
						$maxCheck = $result = $this->admin_model->getRecordSql($sql);	
						
						if($maxCheck == 0){
							$save = $this->admin_model->saveRecord('charges_master',$saveData);
							//print_r($save);
							if($save == 0)
							{
								$this -> session -> set_flashdata('error_msg', 'Failed');
							}
							else
							{
								$this -> session -> set_flashdata('success_msg', 'Save successfully');
							}
						}else{
							$this -> session -> set_flashdata('error_msg', 'Max price already exists');
						}
					}else{
						$this -> session -> set_flashdata('error_msg', 'Min price already exists');
					}
					
				}
				redirect('adminlevelone/chargesMaster');	
			}
		}else{
			$this->load->view('admin/charges_master',$data);
		}
	}
     
	public function editCharges()
	{
		$id = $this->uri->segment(3); 
		$sql = "SELECT * FROM `charges_master` ORDER BY `charge_id` DESC ";
		$resultList = $result = $this->admin_model->getRecordSql($sql);
		foreach($resultList as $list){
			  $edit = ($list['charge_id'] == $id)? 1 : 0 ;
		      $result['data'][] = array(
			          'charge_id' => $list['charge_id'],
					  'min_price' => $list['min_price'],
					  'max_price' => $list['max_price'],
					  'restaurant_per' => $list['restaurant_per'],
					  'restaurant_amount' => $list['restaurant_amount'],
					  'del_weekday_per' => $list['del_weekday_per'],
					  'del_weekday_amount' => $list['del_weekday_amount'],
					  'del_weekend_per' => $list['del_weekend_per'],
					  'del_weekend_amount' => $list['del_weekend_amount'],
					  'created' => $list['created'],
					  'is_edit' => $edit
			  );
		}
	    $this->load->view('admin/charges_master',$result);		  	
	} 
    public function deleteCharges()
	{
		$id = $this->uri->segment(3); 
		$dataInfo = $this->admin_model->getRecord('charges_master', array('charge_id'=>$id));
		
		//$aleady = $this->admin_model->getRecord('charges_master',array('charge_id'=>$coupon_code));
		//if($aleady == 0)
		//{ 
			$delete = $this->admin_model->deleteRecord('charges_master',array('charge_id'=>$id));
			if($delete > 0){
			    $this -> session -> set_flashdata('success_msg', 'Delete successfully');
			}else{
			    $this -> session -> set_flashdata('error_msg', 'Failed');
			}
		//}else{
			//$this -> session -> set_flashdata('error_msg', 'You cant delete this data');
		//}
	    redirect('adminlevelone/chargesMaster');	
	}
	/* End charges set */
	
}
?>