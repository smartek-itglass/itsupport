<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 include (APPPATH . 'libraries/REST_Controller.php');

/**
 * 
 */
class PromoCode extends REST_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->model('User_model');
	}
    
	/* Start Get promo code */
    public function promoCodeListView_get() 
	{
		 $this->load->view('webservices/promo_code_list');
	}
	public function promoCodeList_post()
	{
		 $user_id = $this->input->post('user_id');
		 $page_no = $this->input->post('page_no');
		 $limit = $this->input->post('limit');
		 $dvcTimeZone = $this->input->post('timezone');
		 $start = $limit * ($page_no - 1);
		 $quryLimit = "LIMIT ".$start.','.$limit;
		 $cur_date = date('Y-m-d');
		 
		 $codeArr = array();
		 $sql = "SELECT * FROM `coupon_master` WHERE `validity_start_date` >= '".$cur_date."' OR `validity_end_date` >= '".$cur_date."'  
		         ORDER BY `coupon_id` DESC ".$quryLimit." ";
	     $codeInfo = $this->User_model->getRecordSql($sql);
		
		 if(!empty($codeInfo)){
			foreach($codeInfo as $list){
				 $validDate = date("d-m-Y", strtotime($list['validity_end_date'])); 
				 $msg="Book your order and get ".$list['discount']." ".$list['discount_type']." discount on promo code ".$list['coupon_code']." valid upto ".$validDate.". "; 
				 
				 if($list['reffer_user_count'] != '' && $list['reffer_user_count'] > 0){
				 	  
				 	  $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
					  $reffer_count = $userInfo[0]['reffer_count'];
					  $msg = '';
					  $msg .= "Reffer this App ".$list['reffer_user_count']." user and get ".$list['discount']." ".$list['discount_type']." discount on promo code ".$list['coupon_code']." valid upto ".$validDate.". ";
					  if($reffer_count > 0){
					  	 $msg .= "You reffered 2 user.";
					  }
					  
				 }
				 
				 $codeArr[] = array(
				      'coupon_id'           => $list['coupon_id'],
				      'coupon_code'         => $list['coupon_code'],
				      'reffer_user_count'   => ($list['reffer_user_count'] != '')?$list['reffer_user_count']:'',
				      'discount'            => $list['discount'],
				      'discount_type'       => $list['discount_type'],
				      'validity_start_date' => $list['validity_start_date'],
				      'validity_end_date'   => $list['validity_end_date'],
				      'created'             => $list['created'],
				      'msg'                 => $msg,
				 );
			 }
		 }
         if(!empty($codeArr)){
        	$post['message']  = "success";
	   	    $post['is_array'] = 1;
		    $post['result']   = $codeArr;
         }else{
        	$post['message']='No record found';
         }	
         echo json_encode($post);	
	}
    /* End promo code */
    
    /* Start redeem promo code */
    public function redeemCodeView_get() 
	{
		 $this->load->view('webservices/redeem_promo_code');
	}
	public function redeemCode_post()
	{
		 $user_id = $this->input->post('user_id');
		 $restaurant_id = $this->input->post('restaurant_id');
		 $coupon_code = $this->input->post('coupon_code');
		 $dvcTimeZone = $this->input->post('timezone');
		 $cur_date = date('Y-m-d');
		 
		 $codeArr = array();
		 
		 $dataArr = array(
		      'coupon_code'   => $coupon_code,
		      'restaurant_id' => $restaurant_id,
		      'is_active' => 0
		 );
		 $couponInfo = $this->User_model->getRecord('restaurant_coupon',$dataArr);
		 
		 if(!empty($couponInfo)){
		 	  $sql = "SELECT * FROM `coupon_master` WHERE `coupon_code` = '".$coupon_code."' AND (`validity_start_date` >= '".$cur_date."' OR `validity_end_date` >= '".$cur_date."') ";
	          $codeInfo = $this->User_model->getRecordSql($sql);
			  if(!empty($codeInfo)){
			  	    $checkSql = "SELECT * FROM `order_info` WHERE `coupon_code` = '".$coupon_code."' AND 
			  	                `restaurant_id` = ".$restaurant_id." AND `user_id` = ".$user_id." 
			  	                 AND (`order_status_id` <= 5 OR `order_status_id` > 0) AND `full_payment_status` = 1
			  	                 AND `is_canceled` = 0 ";
				    $alreadyUse = $this->User_model->getRecordSql($checkSql);
					
					if(!empty($alreadyUse)){
						 $post['message']='Already used this promo code.';
					}else{
						 
						 $codeArr = array(
						      'coupon_id'           => $codeInfo[0]['coupon_id'],
						      'coupon_code'         => $codeInfo[0]['coupon_code'],
						      'reffer_user_count'   => ($codeInfo[0]['reffer_user_count'] != '')?$codeInfo[0]['reffer_user_count']:'',
						      'discount'            => $codeInfo[0]['discount'],
						      'discount_type'       => $codeInfo[0]['discount_type'],
						      'validity_start_date' => $codeInfo[0]['validity_start_date'],
						      'validity_end_date'   => $codeInfo[0]['validity_end_date'],
						      'created'             => $codeInfo[0]['created']
						 );
						 $reffer_user_count = $codeInfo[0]['reffer_user_count'];
						 
						 if($reffer_user_count != '' && $reffer_user_count > 0){
						 	  $userInfo = $this->User_model->getRecord('user_info',array('user_id'=>$user_id));
							  $reffer_count = $userInfo[0]['reffer_count'];
							  
							  if($reffer_count >= $reffer_user_count){
								  $newCount = $reffer_count - $reffer_user_count;
								  $updtRefr = array(
									     'reffer_count' => $newCount
								  );
								  $this->User_model->updateRecord('user_info',$updtRefr,array('user_id'=>$user_id)); 
							  	  $post['message']  = "success";
							   	  $post['is_array'] = 0;
								  $post['result']   = $codeArr;
								  
							  }else{
							  	  $post['message']='You need to reffer '.$reffer_user_count.' user to redeem this code.';
							  }
						 }else{
						 	  $post['message']  = "success";
						   	  $post['is_array'] = 0;
							  $post['result']   = $codeArr;
						 }
						 
					}
			  }else{
			  	   $post['message']='Invalid promo code.';
			  }
		 }else{
		 	  $post['message']='Promo code note available for this restaurant.';
		 }
		
         echo json_encode($post);	
	}
    /* End redeem promo code */
    
    
	
	
}
?>