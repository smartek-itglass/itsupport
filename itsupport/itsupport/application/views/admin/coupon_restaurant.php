
<?php include_once 'header.php'; include_once 'menu.php'; ?>
    <script>
        function getCode()
        {
            var xmlhttp;
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            var Id = document.getElementById('code').value;
            xmlhttp.open("get", "couponCode/" + Id, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    //var a=xmlhttp.responseText; alert(a);
                    var abc = document.getElementById('coupon_code').value = xmlhttp.responseText;
                }
            }
        }
    </script> 
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">Coupon <small> Management</small></h3>
                    <ul class="page-breadcrumb breadcrumb">
                    	<li class="btn-group">
                            <a href="<?php echo base_url(); ?>/index.php/adminlevelone/couponList" class="btn default yellow-stripe">
                            <?php  ?><i class="fa fa-angle-left"></i><span class="hidden-480"> Back </span></a>
                        </li>
                        <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/admin/home"> Home </a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>/index.php/adminlevelone/couponList">Coupon  Management</a></li> 
                    </ul>
                </div>
            </div>
           <?php
			    //echo "<pre>";
			    //print_r($data);
			    $_coupon_code = $_reffer_user_count = '';
			    $_coupon_id=$_coupon_code=$_discount=$_discount_type="";
				$couponDiscount = $startDate = $endDate = '';
				if(!empty($data)){ 
					  //foreach($data as $editVal){
						  //if(isset($editVal['is_edit']) && $editVal['is_edit'] == 1){
						     $_coupon_id           = $data[0]['coupon_id'];
							 $_coupon_code         = $data[0]['coupon_code'];
							 $_reffer_user_count   = $data[0]['reffer_user_count'];
							 $_discount            = $data[0]['discount'];
							 $_discount_type       = $data[0]['discount_type'];
							
							 $couponDiscount = $data[0]['discount']." ".$data[0]['discount_type'];
							 $startDate = date("d-m-Y", strtotime($data[0]['validity_start_date'])); 
							 $endDate = date("d-m-Y", strtotime($data[0]['validity_end_date'])); 
						// }
					 //}
				 }
			?>
			<div class="row">
                <div class="col-xs-12">
                    <div class="well">
                        <h4 style="margin-top:0px;"><?php echo $_coupon_code; ?></h4>
                        <h5>No of Reffer : <?php echo $_reffer_user_count; ?></h5>
                        <h5>Discount : <?php echo $couponDiscount; ?></h5>
                        <h5>Validity : <?php echo $startDate." upto ".$endDate; ?></h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title"><div class="caption"><i class="fa fa-reorder"></i> Restaurant List </div></div>
                        <div class="portlet-body form">
							<!-- BEGIN FORM-->
							<form action="<?php echo base_url(); ?>index.php/adminlevelone/restaurantCoupon/<?php echo $_coupon_id; ?>" method="post" class="form-horizontal form-row-sepe">
								<div class="form-body">
									<h4 class="form-section">Set Coupon to restaurant</h4>
									<div class="form-group">
										<label class="control-label col-md-3">Select Restaurant</label>
										<div class="col-md-4">
											<select name="restaurant_list[]" id="select2_sample2" class="form-control select2" data-placeholder="Select" multiple>
												<optgroup label="Restaurant">
												<?php 
                                                      $sql = "SELECT * FROM `restaurant_info` WHERE `restaurant_id` NOT IN 
                                                             (SELECT `restaurant_id` FROM `restaurant_coupon` WHERE `coupon_code` = '".$_coupon_code."') 
                                                             ORDER BY `restaurant_name` ASC ";
		                                              $resultList = $result = $this->admin_model->getRecordSql($sql);
													  if(!empty($resultList)){
													  	 foreach($resultList as $rest){
                                                ?>
                                                <option value="<?php echo $rest['restaurant_id']; ?>"><?php echo $rest['restaurant_name']; ?></option>
                                                <?php } } ?>
												</optgroup>
											</select>
										</div>
										<div>
											<button type="submit" name="submit" class="btn purple"><i class="fa fa-check"></i> Submit</button>
											<button type="reset" class="btn default">Cancel</button>
										</div>
									 </div>
								</div>
								<!--div class="form-actions fluid">
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-offset-3 col-md-9">
												<button type="submit" class="btn purple"><i class="fa fa-check"></i> Submit</button>
												<button type="button" class="btn default">Cancel</button>
											</div>
										</div>
									</div>
								</div-->
							</form>
							<!-- END FORM-->
							<div class="form-body">
							     <h4 class="form-section">Restaurant List</h4>
							     <div class="portlet-body">
									 <div class="table-responsive">
									 	<?php 
										   if(!empty($data)){
										   	   $restaurant_list = $data['restaurant_list'];
										   	   //print_r($restaurant_list);
										       if(!empty($restaurant_list)){    	    
									    ?>
										<table class="table table-hover">
											<thead>
												<tr>
													<th> # </th>
													<th> Restaurant Name </th>
													<th> Create Date </th>
													<th> Set Active/Inactive </th>
													<th> Status </th>
												</tr>
											</thead>
											<tbody>
												<?php $i=1; foreach( $restaurant_list as $list) {?>
												<tr>
													<td style="font-size: 15px;"> <?php echo $i;?> </td>
													<td style="font-size: 15px;"> <?php echo $list['restaurant_name']; ?> </td>
													<td style="font-size: 15px;"> <?php echo date("d-m-Y", strtotime($list['created'])); ?> </td>
													<td> 
											            <?php if($list['is_active'] == 0){ ?>
														<a href="<?php echo base_url().'index.php/adminlevelone/activeRestaurantCoupon/'.$list['rest_coupon_id']; ?>" class="btn red">Inactive Now</a>
														<?php }else{ ?> 
														<a href="<?php echo base_url().'index.php/adminlevelone/activeRestaurantCoupon/'.$list['rest_coupon_id']; ?>" class="btn green">Active Now</a>
														<?php } ?>
													<td style="font-size: 15px;">
														<?php if($list['is_active'] == 0){ ?>
														<!--span class="label label-sm label-success">Active</span-->
														Active
														<?php }else{ ?> 
														<!--span class="label label-sm label-danger">Inactive</span-->
														Inactive
														<?php } ?>
													</td>
												</tr>
												<?php $i++; } ?>
											</tbody>
										</table>
										<?php  } } ?>
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
    <script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/scripts/core/app.js"></script>
    <script>
        $('#sample_editable').dataTable({
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });

            jQuery('#sample_editable_wrapper .dataTables_filter input').addClass("form-control input-medium input-inline"); // modify table search input
            jQuery('#sample_editable_wrapper .dataTables_length select').addClass("form-control input-small"); // modify table per page dropdown
            jQuery('#sample_editable_wrapper .dataTables_length select').select2({
                showSearchInput : false //hide search box with special css class
            });
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/scripts/custom/components-pickers.js"></script>
    <script>
        $(document).ready(function() {
            // initiate layout and plugins
            App.init();
            ComponentsPickers.init();
        });
    </script>
    <script>
            $('.select2').select2({
                placeholder: "Select",
                allowClear: true
            });
    </script>
    
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/JQueryValidation.js"></script>
    </body>
    </html>