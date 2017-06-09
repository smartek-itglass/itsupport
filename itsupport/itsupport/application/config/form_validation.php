<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 $config = array(
 				'admin_login'=>array(
 								array(
										'field'=>'email',
										'label'=>'Email',
										'rules'=>'trim|required|valid_email',
									),
								array(
										'field'=>'password',
										'label'=>'Password',
										'rules'=>'trim|required',
									) 								
							  ) ,
				'country'=>array(
 								array(
										'field'=>'country_name',
										'label'=>'Country Name',
										'rules'=>'trim|required',
									)							
							  ) ,			  
		
				'state_validation'=>array(
 								array(
										'field'=>'country_id',
										'label'=>'Country ',
										'rules'=>'trim|required',
									),
								array(
										'field'=>'state_name',
										'label'=>'State',
										'rules'=>'trim|required',
									) 								
							  ),
				'city_validation'=>array(
				                
 								array(
										'field'=>'state_id',
										'label'=>'State ',
										'rules'=>'trim|required',
									),
								array(
										'field'=>'city_name',
										'label'=>'City',
										'rules'=>'trim|required',
									) 								
							  ),			  
			     
				 'area_validation'=>array(
				               
								array(
										'field'=>'city_id',
										'label'=>'City ',
										'rules'=>'trim|required',
									),
								array(
										'field'=>'area_name',
										'label'=>'Area',
										'rules'=>'trim|required',
									) 								
							  ),
				'food_type_Val'=>array(
 								array(
										'field'=>'food_cat_name',
										'label'=>'Food Type Name',
										'rules'=>'trim|required',
									)							
							  ) ,				  
				'add_restaurant'=>array(
				               
							   array(
									'field'=>'email',
									'label'=>'Email ',
									'rules'=>'trim|required|valid_email',
							    ),
							    array(
									'field'=>'paypal_email',
									'label'=>'Paypal Email ',
									'rules'=>'trim|required|valid_email',
							    ),
								array(
									'field'=>'restaurant_name',
									'label'=>'Restaurant Name ',
									'rules'=>'trim|required',
								),
								array(
									'field'=>'user_name',
									'label'=>'Owner Name ',
									'rules'=>'trim|required',
								),
								array(
									'field'=>'contact',
									'label'=>'Contact ',
									'rules'=>'trim|required',
								),array(
									'field'=>'start_day',
									'label'=>'Start Day ',
									'rules'=>'trim|required',
								),
								array(
									'field'=>'close_day',
									'label'=>'Close Day ',
									'rules'=>'trim|required',
								),
								array(
									'field'=>'open_time',
									'label'=>'Open Time ',
									'rules'=>'trim|required',
								),
								array(
									'field'=>'close_time',
									'label'=>'Close Time ',
									'rules'=>'trim|required',
								),
								array(
									'field'=>'city_id',
									'label'=>'City ',
									'rules'=>'trim|required',
								),
								
								array(
									'field'=>'address',
									'label'=>'Address ',
									'rules'=>'trim|required',
								)							
							  ),
			    'menu_val'=>array(
 								array(
										'field'=>'menu_title',
										'label'=>'Menu Title',
										'rules'=>'trim|required',
									)							
							  ) ,
				'food_item_val'=>array(
 								array(
										'field'=>'rest_menu_id',
										'label'=>'Menu',
										'rules'=>'trim|required',
									),	
								array(
										'field'=>'item_name',
										'label'=>'Item Name',
										'rules'=>'trim|required',
									),	
								array(
										'field'=>'item_price',
										'label'=>'Item Price',
										'rules'=>'trim|required',
									)								
							  ) ,	
				'coupon_val'=>array(
 								array(
										'field'=>'coupon_code',
										'label'=>'Code',
										'rules'=>'trim|required',
									),	
								array(
										'field'=>'discount',
										'label'=>'Discount',
										'rules'=>'trim|required',
									),	
								array(
										'field'=>'validity_start_date',
										'label'=>'Start Date',
										'rules'=>'trim|required',
									),		
								array(
										'field'=>'validity_end_date',
										'label'=>'End date',
										'rules'=>'trim|required',
									)								
							  ) ,	
				 'charges_val'=>array(
 								array(
										'field'=>'min_price',
										'label'=>'Min price',
										'rules'=>'trim|required',
									),	
								array(
										'field'=>'max_price',
										'label'=>'Max price',
										'rules'=>'trim|required',
									),	
								array(
										'field'=>'restaurant_per',
										'label'=>'Restaurant %',
										'rules'=>'trim|required',
									),		
								array(
										'field'=>'restaurant_amount',
										'label'=>'Restaurant amount',
										'rules'=>'trim|required',
									),
								array(
										'field'=>'del_weekday_per',
										'label'=>'Weekdays %',
										'rules'=>'trim|required',
									),		
								array(
										'field'=>'del_weekday_amount',
										'label'=>'Weekdays amount',
										'rules'=>'trim|required',
									),
								array(
										'field'=>'del_weekend_per',
										'label'=>'Weekend %',
										'rules'=>'trim|required',
									),		
								array(
										'field'=>'del_weekend_amount',
										'label'=>'Weekend amount',
										'rules'=>'trim|required',
									)										
							  ) ,				  
				'estTime'=>array(
 								array(
										'field'=>'est_time',
										'label'=>'Time',
										'rules'=>'trim|required',
									)							
							  ) ,			  			  		  						  			  
			    'forget_password'=>array(
 								array(
										'field'=>'email_id',
										'label'=>'E-mail',
										'rules'=>'trim|required',
									),
								array(
										'field'=>'new_password',
										'label'=>'New Password',
										'rules'=>'trim|required',
									),
							    array(
										'field'=>'con_password',
										'label'=>'Confirm Password',
										'rules'=>'trim|required',
									) 		 								
							  ),	
				'change_password'=>array(
 								array(
										'field'=>'password',
										'label'=>'Current Password',
										'rules'=>'trim|required',
									),
								array(
										'field'=>'newPassword',
										'label'=>'New Password',
										'rules'=>'trim|required',
									),
							    array(
										'field'=>'RePassword',
										'label'=>'Confirm Password',
										'rules'=>'trim|required|matches[newPassword]',
									) 		 								
							  ),				  			  			  						  	   			   
							  													  
			)
?>