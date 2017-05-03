
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
                        <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/admin/home"> Home </a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>/index.php/adminlevelone/couponList">Coupon  Management</a></li> 
                    </ul>
                </div>
            </div>
           <?php
			    //echo "<pre>";
			    //print_r($data);
			    $_coupon_code = $_reffer_user_count = '';
			    $_coupon_id=$_coupon_code=$_discount=$_validity_start_date=$_validity_end_date=$_discount_type="";
				if(!empty($data)){ 
					  foreach($data as $editVal){
						  if(isset($editVal['is_edit']) && $editVal['is_edit'] == 1){
							  
						     $_coupon_id = $editVal['coupon_id'];
							 $_coupon_code = $editVal['coupon_code'];
							 $_reffer_user_count = $editVal['reffer_user_count'];
							 $_discount = $editVal['discount']; 
							 $_discount_type = $editVal['discount_type']; 
							 $_validity_start_date = $editVal['validity_start_date']; 
							 $_validity_end_date = $editVal['validity_end_date']; 
						  }
					  }
				 }
				 
			?>
            <div class="row">
 
                <div class="col-md-10 ">
                	<?php if($this->session->flashdata('success_msg') != ''){ ?>
                	<div class="alert alert-success">
					  <strong>Success !</strong> <?php echo $this->session->flashdata('success_msg'); ?>
					</div>
					<?php } if($this->session->flashdata('error_msg') != ''){ ?>
					<div class="alert alert-danger">
					  <strong>Error !</strong> <?php echo $this->session->flashdata('error_msg'); ?>
					</div>	
					<?php } ?>	
                    <div class="portlet box blue">
                        <div class="portlet-title"><div class="caption"><i class="fa fa-plus-square"></i> Add Coupon</div></div>
                        
                        <div class="portlet-body form">
                            <form id="couponMaster" action="<?php echo base_url(); ?>index.php/adminlevelone/couponList" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
                                <div class="form-body">
                                	<div class="form-group"><label class="col-md-3 control-label">Coupon code</label>
                                        <div class="col-md-9" style="margin-bottom:15px; padding-left:0px;">
                                            <div class="col-md-6" >
                                                <input type="text" hidden value="<?php echo $_coupon_id; ?>" name="update_id" />
                                                <input type="text" readonly id="coupon_code" value="<?php echo $_coupon_code;  ?>" name="coupon_code"  class="form-control" >		
                                            </div> <?php if ($_coupon_id == '') { ?>
                                            <div class="col-md-2">
                                                <input type="button" class="btn btn-default" value="Generate Code" id="code" onClick="getCode(this.value)">
                                            </div><?php } ?>
                                            <div class="col-md-12">
                                               <label class="error" for="coupon_code" generated="true" style="color: Red; margin-left:15px; font-weight: normal;"></label>
	                                            <span style="color:red;"><?php echo form_error('coupon_code');?></span>                     	
	                                        </div> 
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">No of Reffer<?php echo $_reffer_user_count; ?></label>
                                        <div class="col-md-4">
                                            <input type="number" min="0" value="<?php echo $_reffer_user_count; ?>" name="reffer_user_count" id="reffer_user_count" class="form-control"  placeholder="Enter Reffer Count">		
                                            <label class="error" for="reffer_user_count" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('reffer_user_count');?></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">Discount</label>
                                        <div class="col-md-9">
                                            <div class="input-inline input-medium">
                                                <input  name="discount" value="<?php echo $_discount; ?>" type="text" class="form-control">
                                            </div>
                                            <div class="radio-list" style="float:right;margin-right:42%;">
                                                <label class="radio-inline"><input type="radio" name="discount_type" id="" <?php echo ($_discount_type == '%')?'checked':''; ?> value="%" checked> % </label>
                                                <label class="radio-inline"><input type="radio" name="discount_type" id="" <?php echo ($_discount_type == '$')?'checked':''; ?> value="$" ><li class=" fa fa-usd"></li> </label>
                                            </div>
                                            <label class="error" for="discount" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('discount');?></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">Date</label>
                                        <div class="col-md-9" style="margin-bottom:20px; padding-left:0px;">
                                            <div class="col-md-6" style="width: 38%;">
                                             <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                                <input type="text" name="validity_start_date" id="validity_start_date" value="<?php echo $_validity_start_date; ?>" class="form-control" readonly>
                                                <span class="input-group-btn">
                                                     <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>   
                                            </div>
                                            <div class="col-md-6">
                                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                                <input type="text" id="validity_end_date" name="validity_end_date" value="<?php echo $_validity_end_date; ?>" class="form-control" readonly>
                                                <span class="input-group-btn">
                                                     <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>   
                                            </div>
                                            <label class="error" for="validity_start_date" generated="true" style="color: Red; margin-left:15px; font-weight: normal;"></label>
                                            <label class="error" for="validity_end_date" generated="true" style="color: Red; margin-left:100px; font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('validity_start_date');?></span> 
                                            <span style="color:red;"><?php echo form_error('validity_end_date');?></span>
                                        </div>
                                    </div>
                                    <div class="form-actions fluid" style="margin-top:0px; padding-top:0px; padding-bottom:0px;">
                                        <div class="col-md-offset-3 " style="margin-left: 0px; padding-left: 0px; text-align: right;">
                                            
                                            <button type="submit" name="submit" class="btn blue">Submit</button>
                                            <!--a href="#" class="btn defaults">Cancel</a-->
                                            <button type="reset" name="btn_reset" class="btn default">Reset</button>
                                        </div>
                                    </div>
                                </div>        
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title"><div class="caption"><i class="fa fa-edit"></i>Coupon List</div></div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                <thead>
                                    <tr> 
                                    	<th style="width:5%;">Sr.no</th> 
                                        <th>Coupon code</th>
                                        <th>No Of Reffer</th>
                                        <th>Discount</th>
                                        <th>Valid From</th> 
                                        <th>Valid Upto</th>
                                        <th>Set coupon to Restaurant </th>
                                        <th >ACTION </th> 
                                   </tr>		
                                </thead>
                                <tbody> 
                            	<?php
                                	if(isset($data))
									{
										if($data !='')
										{
											$i=1;
											foreach ($data as $value) 
											{
								?>   
                                       <tr>
                                        	<td><?php echo $i;?></td>
                                            <td style="font-size: 15px;"><?php echo $value['coupon_code']; ?></td>
                                            <td style="font-size: 15px;"><?php echo $value['reffer_user_count']; ?></td>
                                            <td style="font-size: 15px;"><?php echo $value['discount'].' '.$value['discount_type']; ?></td>
                                            <td style="font-size: 15px;"><?php echo date("d-m-Y", strtotime($value['validity_start_date'])); ?></td>
                                            <td style="font-size: 15px;"><?php echo date("d-m-Y", strtotime($value['validity_end_date'])); ?></td>
                                            <td style="font-size: 15px;">
                                            	<a href="<?php echo base_url()?>index.php/adminlevelone/restaurantCoupon/<?php echo $value['coupon_id'];?>" class="btn default btn-xs green-stripe">
                                                Set to Restauarant </a>
                                            </td>
                                            <td><a style="padding-left: 10px;" href="<?php echo base_url()?>index.php/adminlevelone/editCoupon/<?php echo $value['coupon_id'];?>">
                                               <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <a style="padding-left: 10px;" onclick="return confirm('Are you sure? You Want To Delete This?')" 
                                                 href="<?php echo base_url()?>index.php/adminlevelone/deleteCoupon/<?php echo $value['coupon_id'];?>">
                                            <span class="glyphicon glyphicon-trash"></span></a>
                                            </td>
                                       </tr>
                                       <?php	
													$i++;
												}
											}
										}
                                    	?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'footer.php'; ?>
        <<script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>assets/scripts/core/app.js"></script>
        <script src="<?php echo base_url(); ?>assets/scripts/custom/table-editable.js"></script>
        <script>
            jQuery(document).ready(function () {
                App.init();
                TableEditable.init();
            });
        </script>
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/clockface/js/clockface.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
            <!--script src="<?php echo base_url(); ?>assets/scripts/core/app.js"></script>
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
            </script-->
            <script src="<?php echo base_url(); ?>assets/scripts/custom/components-pickers.js"></script>
            <script>
                jQuery(document).ready(function() {       
                   // initiate layout and plugins
                   App.init();
                   ComponentsPickers.init();
                });   
            </script>
            
            <script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/JQueryValidation.js"></script>
    </body>
   </html>