
    <?php include_once 'header.php'; ?>
    <?php include_once'menu.php'; ?>	
    
    <!---------------------------------------- Start Body Top Content -------------------------------------->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">Order <small>List</small></h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/admin/home"> Home </a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>index.php/admin/home"> Dashboard </a></li>
                        <li class="pull-right"><div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range"><i class="fa fa-calendar"></i><span></span><i class="fa fa-angle-down"></i></div>
                        </li>
                    </ul>
                </div>
            </div>
            
           <div class="row">
                <div class="col-md-12">
                    <div class="tabbable tabbable-custom boxless tabbable-reversed">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_0" data-toggle="tab"> Order List <?php //echo $id = $this->uri->segment(3);  ?> </a>
                            </li>
                            <li class="dropdown" id="drop_menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Orders filter by <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                	<li> <a href="<?php echo base_url(); ?>index.php/adminlevelone/orderList" >All order</a> </li>
                                    <li> <a href="<?php echo base_url(); ?>index.php/adminlevelone/orderList/0" >Pendding order</a> </li>
                                    <li> <a href="<?php echo base_url(); ?>index.php/adminlevelone/orderList/1" >Accepted order</a> </li>
                                    <li> <a href="<?php echo base_url(); ?>index.php/adminlevelone/orderList/2" >Being prepared order</a> </li>
                                    <li> <a href="<?php echo base_url(); ?>index.php/adminlevelone/orderList/3" >Picked up by deliverer order</a> </li>
                                    <li> <a href="<?php echo base_url(); ?>index.php/adminlevelone/orderList/4" >Delivery on the way order</a> </li>
                                    <li> <a href="<?php echo base_url(); ?>index.php/adminlevelone/orderList/5" >Closed order</a> </li>
                                    <li> <a href="<?php echo base_url(); ?>index.php/adminlevelone/orderList/6" >Canceled order</a></li>
                                </ul>
                            </li>
                        </ul>
                        <?php
                             $id = $this->uri->segment(3);
							 if($id != ''){
							 	$link = 'index.php/adminlevelone/orderDetail/'.$id.'/';
								$export =  'index.php/adminlevelone/orderExport/'.$id.'/';
							 }else{
							 	$link = 'index.php/adminlevelone/orderDetail/';
								$export =  'index.php/adminlevelone/orderExport/';
							 }
                        ?>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_0">
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption"> <i class="fa fa-reorder"></i>All Order </div>
                                        <div class="actions">
                                            <div class="btn-group">
                                                <a href="<?php echo base_url().$export ?>" class="btn default ">
                                                    <i class="fa fa-share"></i>
                                                    <span class="hidden-480">Export to Excel</span>
                                                    <!--i class="fa fa-angle-down"></i-->
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet-body ">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                                <thead>
                                                    <tr>
                                                        <th>Sr.no</th>
                                                        <th> Order Id</th>
                                                        <th> Order date </th>
                                                        <th> Customer </th>
                                                        <th> Restaurant Name </th>
                                                        <th> Order amount ($)</th>
                                                        <th> Status </th>
                                                        <th> Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php  
                                                         
                                                         if(isset($data)){
                                                         	if(!empty($data)){
                                                         		$i=1;
                                                         		foreach($data as $val){
                                                         		$order_id = $val['order_id']; $restaurant_status ='';	
                                                         		$orderId = $this->admin_model->encrypt_decrypt('encrypt', $order_id);	
																$restaurant_status = '';
																if($val['order_status_id'] < 1){
																	 if($val['restaurant_status'] == 0){
																	 	  $restaurant_status = 'Pending';
																	 }elseif($val['restaurant_status'] == 2){
																	 	  $restaurant_status = 'Rejected';
																	 }
																}
																if($val['is_canceled'] == 1){
																	$restaurant_status = 'Canceled';
																}
															    $restaurant_status;
																//echo $val['order_status_id'];
                                                    ?> 
                                                    <tr>
                                                        <td><?php echo $i;?></td>
                                                        <td><?php echo $val['order_id']; ?></td>
                                                        <td><?php echo date('d-m-Y' ,strtotime($val['order_date'])); ?></td>
                                                        <td><?php echo ucfirst($val['first_name']).' '.ucfirst($val['last_name']); ?></td>
                                                        <td><?php echo $val['restaurant_name']; ?></td>
                                                        <td><?php echo $val['total_amount']; ?></td>
                                                        <td>
                                                        	<?php //echo ($val['order_status'] != '')?$val['order_status']:'Pending order'; ?>
                                                        	<?php if($restaurant_status != ''){ ?><span class="label label-sm label-danger"><?php echo $restaurant_status;?> order</span><?php } 
                                                        	elseif($val['order_status_id'] == 1){ ?><span class="label label-sm label-warning"><?php echo $val['order_status']; ?></span><?php }
															elseif($val['order_status_id'] == 2){ ?><span class="label label-sm label-info"><?php echo $val['order_status']; ?></span><?php }
															elseif($val['order_status_id'] == 3){ ?><span class="label label-sm label-warning"><?php echo $val['order_status']; ?></span><?php }
															elseif($val['order_status_id'] == 4){ ?><span class="label label-sm label-info"><?php echo $val['order_status']; ?></span><?php }
															elseif($val['order_status_id'] == 5){ ?><span class="label label-sm label-success"><?php echo $val['order_status']; ?></span><?php }?>				
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo base_url().$link.$orderId ?>" class="btn default btn-xs green-stripe">
                                                                View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; } } } ?>    
                                                </tbody>
                                            </table>
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
    <!---------------------------------------- End Body Top Content -------------------------------------->
    <!---------------------------------------- Start Student  Show-------------------------------------->
    <!---------------------------------------- End Student  Show-------------------------------------->

    <?php include_once 'footer.php'; ?>
     <script src="<?php echo base_url(); ?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/scripts/core/app.js"></script>
    <script src="<?php echo base_url(); ?>assets/scripts/custom/table-editable.js"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            TableEditable.init();
        });
    </script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/JQueryValidation.js"></script>

    <script>
        $(document).ready(function() {
            $("#drop_menu").click(function() {
                $("#drop_menu").addClass("open");
            });
        });
    </script>    
    </body>
    </html>
