<?php include_once 'header.php'; include_once 'menu.php'; ?>
    <div class="page-content-wrapper">
		<div class="page-content">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="page-title">Order <small> details <?php $localtime = localtime();
$localtime_assoc = localtime(time(), true);
//print_r($localtime_assoc); ?></small></h3>
                            <ul class="page-breadcrumb breadcrumb">
                                <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/admin/home"> Home</a><i class="fa fa-angle-right"></i></li>
                                <?php  ?><li><a href="<?php echo base_url(); ?>index.php/admin/home">Dashboard</a></li> <?php  ?>
                                <?php  ?> <li><a href="<?php echo base_url(); ?>index.php/adminlevelone/orderList">Order</a></li><?php ?>
                            </ul>
                        </div>
                    </div>
                    <?php  
                       //echo "<pre/>";
		               //($data);	
		               $id = $this->uri->segment(3);
					   $last_segment = $this->uri->segment(4);
					   if( $last_segment == ''){
					   	   $link = 'index.php/adminlevelone/orderList';
					   }else{
					   	   $link = 'index.php/adminlevelone/orderList/'.$id;
					   }
		               $dvcTimeZone = date_default_timezone_get();
					   date_default_timezone_set($dvcTimeZone);
		               $restaurant_status = $order_status = '';
					   $orderDate = $data[0]['order_date'].' '.$data[0]['order_time'];
					   $order_date_end_time = $this->admin_model->convertTime($orderDate,$dvcTimeZone);
		               $order_server_date = date('Y-m-d,H:i:s',strtotime($order_date_end_time));
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-title">
                                    
                                    <div class="caption">
                                        <i class="fa fa-shopping-cart"></i>Order # <?php echo $data[0]['order_id']; ?>
                                        <span class="hidden-480">
                                            | <?php echo date('d-m-Y', strtotime($data[0]['order_date']));?>
                                        </span>
                                    </div>
                                    <div class="actions">
                                    
                                        <a href="<?php echo base_url().$link ?>" class="btn default yellow-stripe">
                                        <i class="fa fa-angle-left"></i><span class="hidden-480"> Back </span></a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-actions-wrapper " style="margin-bottom:30px;">
                                        <span> Pickup & delivery assign to : </span>
                                        <?php echo $data[0]['deliverer_name']; ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="portlet yellow box">
                                                <div class="portlet-title"><div class="caption"><i class="fa fa-cogs"></i>Order Details </div> </div>
                                                <div class="portlet-body">
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Order #: </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['order_id'];?> </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Order Date & Time: </div>
                                                        <div class="col-md-7 value"> <?php echo date('d-m-Y ,H:i:s', strtotime($order_server_date)); ?></div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Order Status: </div>
                                                        <?php 
                                                                if($data[0]['order_status_id'] < 1){
																	 if($data[0]['restaurant_status'] == 0){
																	 	  $restaurant_status = 'Pending';
																	 }elseif($data[0]['restaurant_status'] == 2){
																	 	  $restaurant_status = 'Rejected';
																	 }
																}else{
																	 $order_status = $data[0]['order_status'];
																}
																if($data[0]['is_canceled'] == 1){
																	$restaurant_status = 'Canceled';
																}
                                                        ?>
                                                        <div class="col-md-7 value">
                                                        	<?php if($restaurant_status == ''){ ?>
                                                        		<span class="label label-success"><?php echo $order_status ?></span>
                                                        	<?php }elseif($restaurant_status != ''){ ?>
                                                        		<span class="label label-danger"><?php echo $restaurant_status ?></span>
                                                        	<?php } ?>
                                                        	
                                                        </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name">Order Pick Up Date : </div>
                                                        <div class="col-md-7 value">
                                                            <?php $orderD = $data[0]['order_date'];  $orderDate = explode('-', $orderD); 
                                                            echo $orderDate[2].'-'.$orderDate[1].'-'.$orderDate[0];?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Order Delivery Time : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['delivery_time']; ?></div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Order Delivery Date : </div>
                                                        <div class="col-md-7 value">
                                                            <?php echo ($data[0]['delivery_date'] != '')? date('d-m-Y', strtotime($data[0]['delivery_date'])):''; ?>
                                                        </div>
                                                    </div>
                                                    <?php  ?><div class="row static-info">
                                                        <div class="col-md-5 name"> Coupon Code : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['coupon_code']; ?></div>
                                                    </div> <?php  ?>
                                                    <?php  ?><div class="row static-info">
                                                        <div class="col-md-5 name"> Coupon Discount Type: </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['discount_type']; ?></div>
                                                    </div><?php  ?>
                                                   
                                                    
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Estimated Time : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['estm_time'].' Min'; ?> </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Payment Type : </div>
                                                        <div class="col-md-7 value">Paypal<?php //echo ($data[0]['payment_type'] != 1)?'Cash':'Paypal'; ?> </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> User Comment : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['delivery_instruction']; ?> </div>
                                                    </div>
                                                    <!--div class="row static-info"><div class="col-md-5 name"> <h3>Order Item</h3></div></div>
                                                    <div class="row static-info">
                                                        <div class="col-md-4 value"> Item Name </div>
                                                        <div class="col-md-4 value"> Price </div>
                                                        <div class="col-md-4 value"> Quality </div>
                                                    </div>
                                                    
                                                    <div class="row static-info">
                                                        <div class="col-md-4 name"> </div>
                                                        <div class="col-md-4 value"></div>
                                                        <div class="col-md-4 value"></div>
                                                    </div-->
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="portlet blue box">
                                                <div class="portlet-title"><div class="caption"><i class="fa fa-cogs"></i>Customer Information </div></div>
                                                <?php  ?>
                                                <div class="portlet-body">
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Customer Name : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['user_name']; ?></div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Email : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['user_email']; ?></div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Contact Number : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['user_mobile']; ?></div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Shipping Address : </div>
                                                        <div class="col-md-7 value"><?php echo ($data[0]['flat_no'] != '')? $data[0]['flat_no']." ,":''; 
                                                                                          echo $data[0]['address']." ,".$data[0]['zipcode']; ?></div>
                                                    </div>
                                                </div><?php  ?>
                                            </div>
                                            <!--div class="portlet red box">
                                                <div class="portlet-title"><div class="caption"><i class="fa fa-cogs"></i>Dry Cleaner Information</div></div>
                                                <?php  ?>
                                                <div class="portlet-body">
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name">Laundry Name : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['laundry_name']; ?></div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Email : </div>
                                                        <div class="col-md-7 value"> <?php echo $data[0]['email']; ?> </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Contact Number : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['username']; ?></div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Address : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['laundry_address']." ".$data[0]['landmark_address']." ,".$data[0]['city_name']." ,".$data[0]['state_name']; ?></div>
                                                    </div>
                                                </div><?php ?>
                                            </div-->
                                            <?php  ?>
                                            <div class="portlet green box">
                                                <div class="portlet-title"><div class="caption"><i class="fa fa-cogs"></i>Deliverer Information </div></div>
                                                <?php
                                                    ?>
                                                <div class="portlet-body">
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Deliverer Name : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['deliverer_name']; ?></div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Email : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['deliverer_email']; ?> </div>
                                                    </div>
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> Contact Number : </div>
                                                        <div class="col-md-7 value"><?php echo $data[0]['deliverer_contact']; echo ($data[0]['deliverer_alt_contact'] != '')? ','.$data[0]['deliverer_alt_contact']:''; ?> </div>
                                                    </div>
                                                    <!--div class="row static-info">
                                                        <div class="col-md-5 name"> Address : </div>
                                                        <div class="col-md-7 value"> <?php echo $data[0]['address']." ,".$data[0]['city_name']." ,".$data[0]['state_name']; ?> </div>
                                                    </div-->
                                                </div><?php ?>
                                            </div><?php  ?>
                                        </div>
                                        <?php 
                                            //print_r($data[0]['item_list']);
                                            $payment_type = $data[0]['payment_type'];
                                            if(!empty($payment_type == 1)){
                                        ?>
                                        <!----- split order user ----->
                                        <div class="col-md-12 col-sm-12">
											<div class="portlet blue box">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-cogs"></i>Split Cost Detail
													</div>
													
												</div>
												<div class="portlet-body">
													<div class="table-responsive">
														<table class="table table-hover table-bordered table-striped">
															<thead>
																<tr>
																	<th>Sr</th>
																	<th>User Name</th>
																	<th>Split Amount</th>
																	<th>Request Status</th>
																	<th>Payment Status</th>
																</tr>
															</thead>
															<tbody>
																<?php 
			                                                        //print_r($data[0]['item_list']);
			                                                        $split_list = $data[0]['payment_detail'];
			                                                        if(!empty($split_list)){
																	   foreach($split_list as $split){
																	   	
																		$req_status = ($split['request_status'] == 0)?'Pending':(($split['request_status'] == 1)?'Accepted' : 'Rejected'); 
																		$pay_status = ($split['payment_status'] == 0)?'Pending':(($split['payment_status'] == 1)?'Paid' : 'Rejected');	
			                                                    ?>
																<tr>
																	<td>1</td>
																	<td><?php echo $split['user_name']; ?></td>
																	<td><?php echo $split['amount']; ?></td>
																	<td><?php echo $req_status; ?></td>
																	<td><?php echo $pay_status; ?></td>
																</tr>
																<?php } } ?>
															</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
                                        <!---- split order table ------>
                                        <?php } ?>
										<div class="col-md-12 col-sm-12">
											<div class="portlet purple box">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-cogs"></i>Shopping Cart
													</div>
													
												</div>
												<div class="portlet-body">
													<div class="table-responsive">
														<table class="table table-hover table-bordered table-striped">
															<thead>
																<tr>
																	<th>Sr</th>
																	<th>Product</th>
																	<th>Price</th>
																	<th>Quantity</th>
																	<th>Total</th>
																</tr>
															</thead>
															<tbody>
																<?php 
			                                                        //print_r($data[0]['item_list']);
			                                                        $item_list = $data[0]['item_list'];
			                                                        if(!empty($item_list)){
			                                                        	
																	   foreach($item_list as $item){	
			                                                    ?>
																<tr>
																	<td>1</td>
																	<td><?php echo $item['item_name']; ?></td>
																	<td><?php echo $item['price']; ?></td>
																	<td><?php echo $item['quantity']; ?></td>
																	<td><?php echo $item['total_price']; ?></td>
																</tr>
																<?php } } ?>
															</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-md-6">
												</div>
												<div class="col-md-6">
													<div class="well">
														<div class="row static-info align-reverse">
															<div class="col-md-8 name"> Discount Amount: </div>
															<div class="col-md-3 value"><?php echo $data[0]['discount_amount']; ?></div>
														</div>
														<div class="row static-info align-reverse">
															<div class="col-md-8 name"> Sub Total: </div>
															<div class="col-md-3 value"><?php echo $data[0]['sub_total']; ?></div>
														</div>
														<div class="row static-info align-reverse">
															<div class="col-md-8 name"> Tax: </div>
															<div class="col-md-3 value"><?php echo $data[0]['tax']; ?></div>
														</div>
														<div class="row static-info align-reverse">
															<div class="col-md-8 name"> Total Amount: </div>
															<div class="col-md-3 value"><?php echo $data[0]['total_amount']; ?></div>
														</div>
														
														
													</div>
												</div>
											</div>			
                                        
                                    </div>
                                </div>
                            </div>
                            
                           
                            
                        </div>
                    </div>
			</div>
		</div>
        <?php include_once 'footer.php'; ?>
        <!--script src="<?php echo base_url(); ?>assets/scripts/core/app.js"></script>
        <script src="<?php echo base_url(); ?>assets/scripts/custom/table-editable.js"></script>
        <script>
            jQuery(document).ready(function () {
                App.init();
                TableEditable.init();
            });
        </script-->  
        <script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/JQueryValidation.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap2-typeahead.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
		<!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/clockface/js/clockface.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="<?php echo base_url(); ?>assets/scripts/core/app.js"></script>
		<script src="<?php echo base_url(); ?>assets/scripts/custom/components-pickers.js"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
		<script>
	        jQuery(document).ready(function() {       
	           // initiate layout and plugins
	           App.init();
	           ComponentsPickers.init();
	        });   
        </script>
        
        <!-- END JAVASCRIPTS -->  
        </body>
   </html>