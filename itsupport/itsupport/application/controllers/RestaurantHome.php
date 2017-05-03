<?php
/**
 * 
 */
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class RestaurantHome extends CI_Controller 
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
			redirect('restaurant/index');
		}
	}
    
	/* Start Country */
	public function Menu()
	{
		$restaurant_id = $_SESSION['restaurant_id'];
		$sql = "SELECT * FROM `restaurant_menu` WHERE `restaurant_id` = ".$restaurant_id." ORDER BY `rest_menu_id` DESC";
		$result['data']=$this->admin_model->getRecordSql($sql);
		$date = date('Y-m-d H:i:s');
		//print_r($_POST);
		
		if(isset($_POST['submit']))
		{
			
			$name = ($_POST['menu_title'] != '')?$_POST['menu_title'] : '';
			$update_id = ($_POST['update_id'] != '')?$_POST['update_id'] : '';
			
			if($this->form_validation->run('menu_val')==FALSE)
			{
				$this->load->view('restaurant/menu_view',$result);
			}
			else 
			{
				$dataArr['menu_title'] = $name;
				
				$dataArr['restaurant_id'] = $restaurant_id;
				
				if(!empty($update_id))
				{
					
					$dataArr['updated'] = $date;
					//// code for update ///
					$sql = "SELECT * FROM `restaurant_menu` WHERE `menu_title` = '".$name."' AND `restaurant_id` = '".$restaurant_id."' AND `rest_menu_id` != '".$update_id."' ";
					$already = $this->admin_model->getRecordSql($sql);
					if($already == 0)
					{
						$dataInfo = $this->admin_model->getRecord('restaurant_menu', array('rest_menu_id' => $update_id));
						$oldImg = $dataInfo[0]['menu_img'];
						
						if($_FILES['menu_img1']['name']!='')
						{
							$imanename = $_FILES['menu_img1']['name'];
							$temp = explode(".", $_FILES["menu_img1"]["name"]);
							$newfilename = rand(1, 99999) . '.' . end($temp);
							//This is for upload the image
							$path= './images/menu_images/'.$newfilename;
							$upload = copy($_FILES['menu_img1']['tmp_name'], $path);
							
							$dataArr['menu_img'] = $newfilename;
							
							/// start delete old image from folder ///
							if($oldImg != '' ){
								 $imgpath = base_url().'images/menu_images/';
								 $oldPath = base_url().'images/menu_images/'.$oldImg; 
								 if(file_exists('images/menu_images/'.$oldImg)){
									 //$oldImgPAth = $imagePath.$oldImg;
									 //unlink($oldImgPAth);
									 unlink('images/menu_images/'.$oldImg);
								 }
							 } 
							//// end delete old image //
						}
						$update = $this->admin_model->updateRecord('restaurant_menu',$dataArr,array('rest_menu_id'=>$update_id));
						if($update == 0){
							$this -> session -> set_flashdata('error_msg', 'Failed');
						}else{
							$this -> session -> set_flashdata('success_msg', 'Update successfully');
						}
					    redirect('restaurantHome/Menu');
					}
				}
				else
				{
					$dataArr['created'] = $date;
					//// code for save ///
					$aleady = $this->admin_model->getRecord('restaurant_menu',array('menu_title'=>$name,'restaurant_id'=>$restaurant_id));
					if($aleady == 0)
					{
						if($_FILES['menu_img']['name']!='')
						{
							$imanename = $_FILES['menu_img']['name'];
							$temp = explode(".", $_FILES["menu_img"]["name"]);
							$newfilename = rand(1, 99999) . '.' . end($temp);
							//This is for upload the image
							$path= './images/menu_images/'.$newfilename;
							$upload = copy($_FILES['menu_img']['tmp_name'], $path);
							
							$dataArr['menu_img'] = $newfilename;
						}
						$save = $this->admin_model->saveRecord('restaurant_menu',$dataArr);
						//print_r($save);
						if($save == 0)
						{
							$this -> session -> set_flashdata('error_msg', 'Failed');
						}
						else
						{
							$this -> session -> set_flashdata('success_msg', 'Save successfully');
						}
						//redirect('adminhome/Country');
					}
					else
					{
					     $this -> session -> set_flashdata('error_msg', 'Already exists');
					}
					redirect('restaurantHome/Menu');
				}
			}
		}else{
		    $this->load->view('restaurant/menu_view',$result);
		}
	}
	public function editMenu()
	{
		$restaurant_id = $_SESSION['restaurant_id'];
		$id = $this->uri->segment(3); 
		//$catInfo = $this->admin_model->getRecord('country',array('country_id'=>$id));
		$resultList=$this->admin_model->getRecord('restaurant_menu',array('restaurant_id' => $restaurant_id));
		foreach($resultList as $list){
			$edit = ($list['rest_menu_id'] == $id)? 1 : 0 ;
		      $result['data'][] = array(
			          'rest_menu_id' => $list['rest_menu_id'],
					  'menu_title' => $list['menu_title'],
					  'menu_img' => $list['menu_img'],
					  'restaurant_id' => $list['restaurant_id'],
					  'created' => $list['created'],
					  'is_edit' => $edit
			  );
		}
	    $this->load->view('restaurant/menu_view',$result);		  	
	}
	public function deleteMenu()
	{
		$id = $this->uri->segment(3); 
		
		$aleady = $this->admin_model->getRecord('restaurant_food_items',array('rest_menu_id'=>$id));
		if($aleady == 0)
		{ 
			$dataInfo = $this->admin_model->getRecord('restaurant_menu', array('rest_menu_id' => $id));
			$oldImg = $dataInfo[0]['menu_img'];
			$imgpath = base_url().'images/menu_images/';
			$delete = $this->admin_model->deleteRecord('restaurant_menu',array('rest_menu_id'=>$id));
			if($delete > 0){
				/// start delete old image from folder ///
				if($oldImg != '' ){
					 $oldPath = base_url().'images/menu_images/'.$oldImg; 
					 if(file_exists('images/menu_images/'.$oldImg)){
						 //$oldImgPAth = $imgpath.$oldImg;
						 //unlink($oldImgPAth);
						 unlink('images/menu_images/'.$oldImg);
					 }
				 } 
				//// end delete old image //
			    $this -> session -> set_flashdata('success_msg', 'Delete successfully');
			}else{
			    $this -> session -> set_flashdata('error_msg', 'Failed');
			}
		}else{
			$this -> session -> set_flashdata('error_msg', 'You cant delete this data');
		}
	    redirect('restaurantHome/Menu');	  	
	}
    /* End Country */	
    
    /* Start Food Item */
	public function FoodItem()
	{
		$restaurant_id = $_SESSION['restaurant_id'];
		$sql = "SELECT FI.*,RM.menu_title FROM restaurant_food_items FI
				LEFT JOIN restaurant_menu RM ON RM.rest_menu_id = FI.rest_menu_id
				WHERE FI.restaurant_id = ".$restaurant_id."
				ORDER BY FI.food_item_id DESC ";
		$result['data']=$this->admin_model->getRecordSql($sql);
		$date = date('Y-m-d H:i:s');
		//print_r($_POST);
		
		if(isset($_POST['submit']))
		{
			$item_name = ($_POST['item_name'] != '')?$_POST['item_name'] : '';
			$name = $item_name;
			$rest_menu_id = ($_POST['rest_menu_id'] != '')?$_POST['rest_menu_id'] : '';
			
			$update_id = ($_POST['update_id'] != '')?$_POST['update_id'] : '';
			
			if($this->form_validation->run('food_item_val')==FALSE)
			{
				$this->load->view('restaurant/food_item',$result);
			}
			else 
			{
				$dataArr['item_name'] = $name;  
				$dataArr['rest_menu_id'] = $rest_menu_id; 
				$dataArr['restaurant_id'] = $restaurant_id; 
				$dataArr['item_description'] = ($_POST['item_description'] != '')?$_POST['item_description'] : '';
				$dataArr['item_price'] = ($_POST['item_price'] != '')?$_POST['item_price'] : '';
				$dataArr['item_type'] = ($_POST['item_type'] != '')?$_POST['item_type'] : '';
				
				if(!empty($update_id))
				{
					//// code for update ///
					$dataArr['updated'] = $date;
					$sql = "SELECT * FROM `restaurant_food_items` WHERE `item_name` = '".$name."' AND `rest_menu_id` = '".$rest_menu_id."' AND `food_item_id` != '".$update_id."' ";
					$already = $this->admin_model->getRecordSql($sql);
					if($already == 0)
					{
						$dataInfo = $this->admin_model->getRecord('restaurant_food_items', array('food_item_id' => $update_id));
						$oldImg = $dataInfo[0]['item_img'];
						if($_FILES['item_img1']['name']!='')
						{
							$imanename = $_FILES['item_img1']['name'];
							$temp = explode(".", $_FILES["item_img1"]["name"]);
							$newfilename = rand(1, 99999) . '.' . end($temp);
							//This is for upload the image
							$path= './images/item_images/'.$newfilename;
							$upload = copy($_FILES['item_img1']['tmp_name'], $path);
							
							$dataArr['item_img'] = $newfilename;
							/// start delete old image from folder ///
							if($oldImg != '' ){
								 $imgpath = base_url().'images/item_images/';
								 $oldPath = base_url().'images/item_images/'.$oldImg; 
								 if(file_exists('images/item_images/'.$oldImg)){
									 //$oldImgPAth = $imagePath.$oldImg;
									 //unlink($oldImgPAth);
									 unlink('images/item_images/'.$oldImg);
								 }
							 } 
							//// end delete old image //
						}
						$update = $this->admin_model->updateRecord('restaurant_food_items', $dataArr,array('food_item_id'=>$update_id));
						if($update == 0){
							$this -> session -> set_flashdata('error_msg', 'Failed');
						}else{
							$this -> session -> set_flashdata('success_msg', 'Update successfully');
						}
					    redirect('restaurantHome/FoodItem');
					}
				}
				else
				{
					//// code for save ///
					$aleady = $this->admin_model->getRecord('restaurant_food_items',$dataArr);
					if($aleady == 0)
					{
						$dataArr['created'] = $date; 
						if($_FILES['item_img']['name']!='')
						{
							$imanename = $_FILES['item_img']['name'];
							$temp = explode(".", $_FILES["item_img"]["name"]);
							$newfilename = rand(1, 99999) . '.' . end($temp);
							//This is for upload the image
							$path= './images/item_images/'.$newfilename;
							$upload = copy($_FILES['item_img']['tmp_name'], $path);
							
							$dataArr['item_img'] = $newfilename;
						}
						$save = $this->admin_model->saveRecord('restaurant_food_items',$dataArr);
						//print_r($save);
						if($save == 0)
						{
							$this -> session -> set_flashdata('error_msg', 'Failed');
						}
						else
						{
							$this -> session -> set_flashdata('success_msg', 'Save successfully');
						}
						//redirect('adminhome/State');
					}
					else
					{
					     $this -> session -> set_flashdata('error_msg', 'Already exists');
					}
					redirect('restaurantHome/FoodItem');
				}
			}
		}else{
		    $this->load->view('restaurant/food_item',$result);
		}
	}
	public function editFoodItem()
	{
		/// code edit view ///
		$restaurant_id = $_SESSION['restaurant_id'];
		$id = $this->uri->segment(3);
		$sql = "SELECT FI.*,RM.menu_title FROM restaurant_food_items FI
				LEFT JOIN restaurant_menu RM ON RM.rest_menu_id = FI.rest_menu_id
				WHERE RM.restaurant_id = ".$restaurant_id."
				ORDER BY FI.food_item_id DESC ";
		$resultList = $this->admin_model->getRecordSql($sql); 
		foreach($resultList as $list){
			$edit = ($list['food_item_id'] == $id)? 1 : 0 ;
		      $result['data'][] = array(
				      'food_item_id' => $list['food_item_id'],
				      'item_name' => $list['item_name'],
			          'rest_menu_id' => $list['rest_menu_id'],
			          'menu_title' => $list['menu_title'],
			          'restaurant_id' => $list['restaurant_id'],
			          'item_description' => $list['item_description'],
			          'item_price' => $list['item_price'],
			          'item_img' => $list['item_img'],
			          'item_type' => $list['item_type'],
					  'created' => $list['created'],
					  'is_edit' => $edit
			  );
		}
	    $this->load->view('restaurant/food_item',$result);		  	
	}
	public function deleteFoodItem()
	{
		/// code for delete ///
		$id = $this->uri->segment(3); 
		$aleady = $this->admin_model->getRecord('order_item',array('food_item_id'=>$id));
		if($aleady == 0)
		{ 
			$dataInfo = $this->admin_model->getRecord('restaurant_food_items', array('food_item_id' => $id));
			$oldImg = $dataInfo[0]['item_img'];
			$imgpath = base_url().'images/item_images/';
			$delete = $this->admin_model->deleteRecord('restaurant_food_items',array('food_item_id'=>$id));
			if($delete > 0){
				/// start delete old image from folder ///
				if($oldImg != '' ){
					 $oldPath = base_url().'images/item_images/'.$oldImg; 
					 if(file_exists('images/item_images/'.$oldImg)){
						 //$oldImgPAth = $imgpath.$oldImg;
						 //unlink($oldImgPAth);
						 unlink('images/item_images/'.$oldImg);
					 }
				 } 
				//// end delete old image //
			    $this -> session -> set_flashdata('success_msg', 'Delete successfully');
			}else{
			    $this -> session -> set_flashdata('error_msg', 'Failed');
			}
		}else{
			$this -> session -> set_flashdata('error_msg', 'You cant delete this data');
		}
	    redirect('restaurantHome/FoodItem');	  	
	}
    /* End Food Item */	
    
	/* Start Get All Order */ 
	public function home()
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
		
		$restaurant_id = $_SESSION['restaurant_id'];
		$sql = "SELECT OI.id,OI.order_id,OI.order_date,OI.total_amount,UI.first_name,UI.last_name,
		        RI.restaurant_name,OI.order_status_id,OI.is_canceled,OS.order_status,OI.restaurant_status FROM order_info OI 
				LEFT JOIN user_info UI ON UI.user_id = OI.user_id
				LEFT JOIN restaurant_info RI ON RI.restaurant_id = OI.restaurant_id
				LEFT JOIN order_status OS ON OS.order_status_id = OI.order_status_id
				WHERE OI.restaurant_id = ".$restaurant_id." AND ".$statusSql." ORDER BY OI.id DESC ";
		$resultList['data'] = $this->admin_model->getRecordSql($sql); 
		
		$this->load->view('restaurant/home',$resultList);
	}
	/* End All Order */
	
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
		
		$this->load->view('restaurant/order_detail',$result);
	}	
	/* End Oeder Setail */
	
	/* Start Get All Order */ 
	public function OrderExport()
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
		
		$restaurant_id = $_SESSION['restaurant_id'];
		$sql = "SELECT OI.id,OI.order_id,OI.order_date,OI.total_amount,UI.first_name,UI.last_name,
		        RI.restaurant_name,OI.order_status_id,OI.is_canceled,OS.order_status,OI.restaurant_status FROM order_info OI 
				LEFT JOIN user_info UI ON UI.user_id = OI.user_id
				LEFT JOIN restaurant_info RI ON RI.restaurant_id = OI.restaurant_id
				LEFT JOIN order_status OS ON OS.order_status_id = OI.order_status_id
				WHERE OI.restaurant_id = ".$restaurant_id." AND ".$statusSql." ORDER BY OI.id DESC ";
		$resultList['data'] = $this->admin_model->getRecordSql($sql); 
		
		$this->load->view('export_excel/export_order_detail.php',$resultList);	
	}
	/* End All Order */
	
	/* Start Order Response */
	public function orderResponse()
	{
		$status = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$order_id = $this->admin_model->encrypt_decrypt('decrypt', $id);
		$request_status = ($status == 1)?' accept' :' reject';
		
		/// get order info ////
		$orderInfo = $this->admin_model->getRecord('order_info', array('order_id'=>$order_id));
		
		$order_date = $orderInfo[0]['order_date'];
		$restrnt_id = $orderInfo[0]['restaurant_id'];
		
		if(!empty($orderInfo)){
			
			//// update order status ///
			$dataArr = array(
			    'restaurant_status' => $status,
			    'order_status_id' => ($status == 1)?1:'',
			);
			$update = $this->admin_model->updateRecord('order_info', $dataArr,array('order_id'=>$order_id));
			
			if($status == 1){
				 $est_time = $_POST['est_time'];
				 if($this->form_validation->run('estTime')==FALSE)
				 {
				 	//print_r($_POST);
					//$this->load->view('restaurant/food_item',$result);
				 }
				 else 
				 {
					 $orderHistoryArr = array(
					     'current_order_status_id'=>1,
					     'order_id' =>$order_id,
					     'created'  => date('Y-m-d , H:i:s')
					 );
				     $save = $this->admin_model->saveRecord('order_status_history',$orderHistoryArr);
					 
					 ///// if restaurant accept order request then notification send to deliverer ///
					 
					 $dlvSql = "SELECT * FROM deliverer_info DI WHERE DI.duty_status = 0 AND DI.is_verify = 0 AND DI.is_approved = 0 AND 
					            DI.is_delete = 0 AND DI.deliverer_id NOT IN (SELECT OI.deliverer_id FROM order_info OI 
					            WHERE OI.order_date = '".$order_date."' AND (OI.order_status_id = 3 OR OI.order_status_id = 4) 
					            AND OI.is_canceled =  0) ";
					 
					 $dlvrerLIst = $this->admin_model->getRecordSql($dlvSql); 
					 //print_r($dlvrerLIst);
					 if(!empty($dlvrerLIst)){
					 	  foreach($dlvrerLIst as $dlvr){
					 	  	    $deliverer_id = $dlvr['deliverer_id'];
							    /// check that deliverer is take order on same day on same restaurant only 3 times ////
								$checkCountSql = "SELECT COUNT(OI.id) as total FROM order_info OI WHERE OI.order_date = '".$order_date."' 
								                  AND OI.restaurant_id = ".$restrnt_id." AND OI.deliverer_id = ".$deliverer_id." AND OI.is_canceled =  0 HAVING total < 3;";
								$checkCount = $this->admin_model->getRecordSql($checkCountSql); 
								$totalCount = $checkCount[0]['total']; 
								if($totalCount < 3){
									 //echo $deliverer_id;	
									 $dlvryReqArr = array(
									      'order_id'     => $order_id,
									      'deliverer_id' => $deliverer_id,
									      'status'       => 0,
									      'created'      => date('Y-m-d , H:i:s')
									 );
									 $this->admin_model->saveRecord('delivery_request', $dlvryReqArr);
									 //// send notification to deliverer ///
									 $sub_type = 0;
									 $msg = "You have an order delivery request and restaurant can prepare ordered food at ".$est_time.".";
									 $dlvrNotifArr = array(
									       'restaurant_id'     => $restrnt_id,
									       'user_id'           => '',
									       'receiver_id'       => $deliverer_id,
									       'order_id'          => $order_id,
									       'notification'      => $msg,
									       'notification_type' => 1,
									       'sub_type'          => $sub_type,
									       'is_read'           => 1,
									       'is_deleted'        => 0,
									       'created'           => date('Y-m-d , H:i:s')
									 );
									 $dlvrNotifiId = $this->admin_model->saveRecord('notification_deliverer', $dlvrNotifArr);
									 if($dlvrNotifiId > 0){
				 	 
										 $dlvrerInfo = $this->admin_model->getRecord('deliverer_info',array('deliverer_id' =>$deliverer_id));
										 $dlvrNotfiCount = $dlvrerInfo[0]['notification_count']+1;
										 $dlvrTotalCount = $dlvrerInfo[0]['total_count']+1;
										 $dlvrLogUpdate = array(
											 'notification_count' => $dlvrNotfiCount,
											 'total_count' => $dlvrTotalCount
										 );
										 $update = $this->admin_model->updateRecord('deliverer_info',$dlvrLogUpdate ,array('deliverer_id'=>$deliverer_id));
										 /// for sending push notification
										 if($dlvrerInfo[0]['device_id'] != '' && $dlvrerInfo[0]['notification_status'] == 0){
											 $dlvr_device_id = $dlvrerInfo[0]['device_id'];
											 ///device_type :- 0 for ios , 1for android
											 $dataArray = array();
											 $dataArray = array(
												 'notification_id' => $dlvrNotifiId,
												 'sender_id' => $restrnt_id,
												 'order_id' => $order_id
											 );
											 if($dlvrerInfo[0]['device_type'] == 0){
												   $result = $this->admin_model->delivery_iphone_notification($dlvr_device_id,$msg,1,$sub_type,$dataArray,$dlvrTotalCount);
											 }else if($dlvrerInfo[0]['device_type'] == 1){
											 	  
											 }
										 }
									 }
									 //// end notification //////
								} 
					 	  }
	                      ///// request history ///
	                      $reqHistoryArr = array(
						        'order_id'           => $order_id,
						        'request_date'       => date('Y-m-d') ,
						        'first_request_time' => date('H:i'),
						        'last_request_time'  => date('H:i'),
						        'request_count'      => 1,
						        'request_status'     => 0,
						        'created'            => date('Y-m-d , H:i:s')
						  );
						  $this->admin_model->saveRecord('delivery_request_history', $reqHistoryArr);
					 }
					////  ---- search deliverer ---- ////
				}//validation
				
			} /// end status 1 check ///          
			///// start notification /////
			 $sender_id = $orderInfo[0]['restaurant_id'];
			 $receiver_id = $orderInfo[0]['user_id'];
			 
		     $senderInfo = $this->admin_model->getRecord('restaurant_info',array('restaurant_id' =>$sender_id));
		
			 $msg = $senderInfo[0]['restaurant_name'].$request_status." your order request";
			 $notificationType = 1;$sub_type = $status;
			 
			 $notificationArr = array(
			       'restaurant_id'     => $sender_id,
			       'deliverer_id'      => '',
			       'receiver_id'       => $receiver_id,
			       'order_id'          => $order_id,
			       'notification'      => $msg,
			       'notification_type' => 1,
			       'sub_type'          => $status,
			       'is_read'           => 1,
			       'is_deleted'        => 0,
			       'created'           => date('Y-m-d , H:i:s')
			 );
			 $noticationId = $this->admin_model->saveRecord('notification_user', $notificationArr);
			 ////  notification  /////
			 if($noticationId > 0){
			 	 
				 $deviceInfo = $this->admin_model->getRecord('user_info',array('user_id' =>$receiver_id));
				 $notfiCount = $deviceInfo[0]['notification_count']+1;
				 $totalCount = $deviceInfo[0]['total_count']+1;
				 $logUpdate = array(
					 'notification_count' => $notfiCount,
					 'total_count' => $totalCount
				 );
				 $update = $this->admin_model->updateRecord('user_info',$logUpdate ,array('user_id'=>$receiver_id));
				 /// for sending push notification
				 if($deviceInfo[0]['device_id'] != '' && $deviceInfo[0]['notification_status'] == 0){
					 $device_id = $deviceInfo[0]['device_id'];
					 ///device_type :- 0 for ios , 1for android
					 $dataArray = array();
					 $dataArray = array(
						 'notification_id' => $noticationId,
						 'sender_id' => $sender_id,
						 'order_id' => $order_id
					 );
					 if($deviceInfo[0]['device_type'] == 0){
						  $result = $this->admin_model->customer_iphone_notification($device_id,$msg,$notificationType,$sub_type,$dataArray,$totalCount);
					 }else if($deviceInfo[0]['device_type'] == 1){
					 	  
					 }
				 }
			 }
			//// ---- notification ---- /////
		}
		redirect(base_url().'index.php/RestaurantHome/orderDetail/'.$id);
	}	
	/* End Oeder Response */
	
	/* Start Order Detail */
	public function clearCount()
	{
		$restaurant_id = $_SESSION['restaurant_id'];
		$dataArr = array('notification_count' => 0);
		$update = $this->admin_model->updateRecord('restaurant_info', $dataArr,array('restaurant_id'=>$restaurant_id));
		
		redirect('restaurantHome/home');
	}	
	/* End Oeder Detail */
	
	/* get notification  */
	public function getNotification()
	{
		$restaurant_id = $_SESSION['restaurant_id'];
		$result = '';
		
	    //$notificationArr = $this->admin_model->getRecord('notification_restaurant',array('receiver_id'=>$restaurant_id));  
	    $sql = "SELECT * FROM `notification_restaurant` WHERE `receiver_id` = ".$restaurant_id."
		        ORDER BY `notification_id` DESC";
	    $notificationArr = $this->admin_model->getRecordSql($sql);
	    if(!empty($notificationArr)){
        $result .= '<ul  class="dropdown-menu-list scroller" style="height:250px; overflow:scroll;">';
		foreach($notificationArr as $ntf){
		
			$clr = '';		
			if($ntf['is_read'] == 1){
				$clr = 'style="background-color:#d9d9d9;"';
			}	
			$order_id = $ntf['order_id'];
	        $orderId = $this->admin_model->encrypt_decrypt('encrypt', $order_id);	
			$id = $ntf['notification_id'];	
			$rderDetail = base_url().'index.php/RestaurantHome/readNotification/'.$id.'/'.$orderId;
			
			$result .=	'
			             <li>
							<a '.$clr.' href="'.$rderDetail.'">
								<span class="task">
									<span class="desc">
										 '.$ntf['notification'].'
									</span>
								</span>
							</a>
						</li>';
					 } 
	    $result .=	'</ul><li class="external">
						<a href="'.base_url().'index.php/RestaurantHome/allNotification">
							 See all tasks <i class="m-icon-swapright"></i>
						</a>
					</li> ';
	    }
		//$result .=	'';
		/*$result = '<li>
						<a href="#">
							<span class="task">
								<span class="desc">
									 Test notification
								</span>
							</span>
						</a>
					</li>';*/
		echo $result;
    }
	/* End get notification */
	
	/* Start get notification count */
	public function notificationCount()
	{
		$restaurant_id = $_SESSION['restaurant_id'];
        $restInfo = $this->admin_model->getRecord('restaurant_info',array('restaurant_id'=>$restaurant_id));
		
        $total_count = $restInfo[0]['notification_count'];   
		//$total_count = 2;
		echo $total_count;
    }
	/* End get notification count */
	/* Start get notification count */
	public function pushNotification()
	{
	    //$curernt_time = $_POST['curernt_time'];
		$restaurant_id = $_SESSION['restaurant_id'];
		
		$dateTime = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -10 seconds"));
		$sql = "SELECT * FROM `notification_restaurant` WHERE `receiver_id` = ".$restaurant_id." AND `created` >= '".$dateTime."' 
		        ORDER BY `notification_id` DESC LIMIT 1";
		$checkNew = $this->admin_model->getRecordSql($sql); 
		if(!empty($checkNew)){
			echo $notification = $checkNew[0]['notification'];
		}else{
			echo '';
		}
		//echo $notification = $checkNew[0]['notification'];
		//echo 'Your have an order from Fooder App and order ID is ORD030833439 please acknowlege this order';
    }
	/* End get notification count */
	/* Start read notification */
	public function readNotification()
	{
		$notiId = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$order_id = $this->admin_model->encrypt_decrypt('decrypt', $id);
		
		$restaurant_id = $_SESSION['restaurant_id'];
		
		$notiInfo = $this->admin_model->getRecord('notification_restaurant',array('notification_id'=>$notiId));
		
		if($notiInfo[0]['is_read'] == 1){
			
			$this->admin_model->updateRecord('notification_restaurant',array('is_read' =>0) ,array('notification_id'=>$notiId));
			
			$restInfo = $this->admin_model->getRecord('restaurant_info',array('restaurant_id'=>$restaurant_id));
            $total_count = ($restInfo[0]['notification_count'] > 0)?$restInfo[0]['notification_count']-1:0;
			
			$this->admin_model->updateRecord('restaurant_info',array('notification_count'=>$total_count) ,array('restaurant_id'=>$restaurant_id));
		}
		
		redirect(base_url().'index.php/RestaurantHome/orderDetail/'.$id);
    }
	/* End read notification */
	
	/* Start get all notification  */
	public function allNotification()
	{
		$restaurant_id = $_SESSION['restaurant_id'];
		
	    $sql = "SELECT * FROM `notification_restaurant` WHERE `receiver_id` = ".$restaurant_id."
		        ORDER BY `notification_id` DESC";
	    $notificationArr = $this->admin_model->getRecordSql($sql);
	    $result['data']= $notificationArr;
		
		$this->load->view('restaurant/all_notification',$result);
		
    }
	/* End get all notification */
	
	/* Start restaurant profile */
	public function restaurantProfile()
	{
		$restaurant_id = $_SESSION['restaurant_id'];
		
	    $sql = "SELECT RI.*,ST.state_name,CN.country_name,CT.city_name FROM restaurant_info RI 
				LEFT JOIN city CT ON CT.city_id = RI.city_id
				LEFT JOIN state ST ON ST.state_id = CT.state_id
				LEFT JOIN country CN ON CN.country_id = ST.state_id
				WHERE RI.restaurant_id = ".$restaurant_id." ";
	    $restInfo = $this->admin_model->getRecordSql($sql);
	    $result['data']= $restInfo;
		
		$this->load->view('restaurant/rest_profile',$result);
		
    }
	/* End get all notification */
	
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
				$restaurant_id = $_SESSION['restaurant_id'];
				//// code for update ///
				$already = $this->admin_model->getRecord('restaurant_info',array('password'=>$password,'restaurant_id'=>$restaurant_id));
				if($already != 0)
				{
					$update = $this->admin_model->updateRecord('restaurant_info',array('password'=>$newPassword),array('restaurant_id'=>$restaurant_id));
					if($update == 0){
						$this -> session -> set_flashdata('error_msg', 'Failed');
					}else{
						$this -> session -> set_flashdata('success_msg', 'Update successfully');
					}
				}else{
					$this -> session -> set_flashdata('error_msg', 'Current password not match');
				}
				$this->load->view('restaurant/change_password');	
			}
		}else{
		    $this->load->view('restaurant/change_password');	
		}
	}
    /* End change password */
    
    /* Start restaurant coupon list */
    public function restaurantCouponList()
	{
		$restaurant_id = $_SESSION['restaurant_id'];
		
		$sql = "SELECT RC.restaurant_id,RC.is_active,RC.rest_coupon_id,CM.* FROM restaurant_coupon RC 
				LEFT JOIN coupon_master CM ON CM.coupon_code = RC.coupon_code
				WHERE RC.restaurant_id = ".$restaurant_id." ";
		$couponList = $this->admin_model->getRecordSql($sql);
		
		$result['data'] = $couponList;
		
		$this->load->view('restaurant/restaurant_coupon_list',$result);
	}
    /* End restaurant coupon */
    
    /* Start Coupon enable/disable for restaurant */
    public function activeCoupon()
	{
		$id = $this->uri->segment(3); 
		$couponInfo = $this->admin_model->getRecord('restaurant_coupon', array('rest_coupon_id'=>$id));
		$coupon_code = $couponInfo[0]['coupon_code'];
		
		$is_active = $couponInfo[0]['is_active'];
		$set_active = ($is_active == 1)?0:1;
		
		$update = $this->admin_model->updateRecord('restaurant_coupon',array('is_active'=>$set_active),array('rest_coupon_id'=>$id));
		
		redirect('RestaurantHome/restaurantCouponList/');
	}
    /* End Coupon enable/disable for restaurant */
    
    /* Start charges set */
	public function restaurantCharges()
	{
		$restaurant_id = $_SESSION['restaurant_id'];
		$data = $minCheck = $maxCheck = array();
		$sql = "SELECT * FROM `restaurant_charges` WHERE `restaurant_id` = ".$restaurant_id." ORDER BY `rest_charges_id` DESC ";
		$data['data'] = $result = $this->admin_model->getRecordSql($sql);
		
		if(isset($_POST['submit']))
		{
			$update_id = ($_POST['update_id'] != '')?$_POST['update_id'] : '';
			if($this->form_validation->run('charges_val')==FALSE)
			{
				$this->load->view('restaurant/restaurant_charges',$data);
			}
			else 
			{
				$saveData = array(
				    'restaurant_id'      => $restaurant_id,
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

					$minSql = "SELECT * FROM `restaurant_charges` WHERE (`min_price` = '".$min."' OR `max_price` = '".$min."') AND `rest_charges_id` != ".$update_id." ";
					$minCheck = $result = $this->admin_model->getRecordSql($minSql);
					//print_r($minCheck);
					if(empty($minCheck)){
						//echo 'hii';
						$maxSql = "SELECT * FROM `restaurant_charges` WHERE (`min_price` = '".$max."' OR `max_price` = '".$max."') AND `rest_charges_id` != ".$update_id." ";
						$maxCheck = $result = $this->admin_model->getRecordSql($maxSql);	
						
						if(empty($maxCheck)){
							$update = $this->admin_model->updateRecord('restaurant_charges',$saveData,array('rest_charges_id'=>$update_id));
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
					
					$minSql = "SELECT * FROM `restaurant_charges` WHERE (`min_price` = '".$min."' OR `max_price` = '".$min."') AND `restaurant_id` = ".$restaurant_id." ";
					$minCheck = $result = $this->admin_model->getRecordSql($minSql);
					
					if(empty($minCheck)){
						
						$maxSql = "SELECT * FROM `restaurant_charges` WHERE (`min_price` = '".$max."' OR `max_price` = '".$max."') AND `restaurant_id` = ".$restaurant_id." ";
						$maxCheck = $result = $this->admin_model->getRecordSql($maxSql);	
						
						if(empty($maxCheck)){
							$save = $this->admin_model->saveRecord('restaurant_charges',$saveData);
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
				redirect('RestaurantHome/restaurantCharges');	
			}
		}else{
			$this->load->view('restaurant/restaurant_charges',$data);
		}
	}
     
	public function editRestCharges()
	{
		$id = $this->uri->segment(3); 
		$sql = "SELECT * FROM `restaurant_charges` ORDER BY `rest_charges_id` DESC ";
		$resultList = $result = $this->admin_model->getRecordSql($sql);
		foreach($resultList as $list){
			  $edit = ($list['rest_charges_id'] == $id)? 1 : 0 ;
		      $result['data'][] = array(
			          'rest_charges_id'    => $list['rest_charges_id'],
			          'restaurant_id'      => $list['restaurant_id'],
					  'min_price'          => $list['min_price'],
					  'max_price'          => $list['max_price'],
					  'restaurant_per'     => $list['restaurant_per'],
					  'restaurant_amount'  => $list['restaurant_amount'],
					  'del_weekday_per'    => $list['del_weekday_per'],
					  'del_weekday_amount' => $list['del_weekday_amount'],
					  'del_weekend_per'    => $list['del_weekend_per'],
					  'del_weekend_amount' => $list['del_weekend_amount'],
					  'created'            => $list['created'],
					  'is_edit'            => $edit
			  );
		}
	    $this->load->view('restaurant/restaurant_charges',$result);		  	
	} 
    public function deleteRestCharges()
	{
		$id = $this->uri->segment(3); 
		$dataInfo = $this->admin_model->getRecord('restaurant_charges', array('rest_charges_id'=>$id));
		
		//$aleady = $this->admin_model->getRecord('charges_master',array('rest_charges_id'=>$coupon_code));
		//if($aleady == 0)
		//{ 
			$delete = $this->admin_model->deleteRecord('restaurant_charges',array('rest_charges_id'=>$id));
			if($delete > 0){
			    $this -> session -> set_flashdata('success_msg', 'Delete successfully');
			}else{
			    $this -> session -> set_flashdata('error_msg', 'Failed');
			}
		//}else{
			//$this -> session -> set_flashdata('error_msg', 'You cant delete this data');
		//}
	    redirect('RestaurantHome/restaurantCharges');	
	}
	/* End charges set */
}
?>