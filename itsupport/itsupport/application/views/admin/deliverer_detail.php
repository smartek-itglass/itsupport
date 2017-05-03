<?php include_once 'header.php'; include_once 'menu.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12"><h3 class="page-title">Deliverer<small> Detail</small></h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/admin/home"> Home </a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>index.php/adminlevelone/delivererList">Deliverer Management</a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>index.php/adminlevelone/delivererList">Deliverer Detail</a></i></li>
                    </ul>
                </div>
            </div>
            
            <?php
			    //echo "<pre>";
			    //print_r($data[0]);
				$editId = $countryId =  $stateId = $cityId = $areaId = $address = $last_name = '';
				$email = $password = $contact = $alt_contact = $first_name = $gender = $flat_no = '';
				$street = $street = $landmark = $zip_code = $description = $is_available = '';
				$area_name = $city_name = $state_name = $country_name = '';
				$food_arr = array();
				if(!empty($data)){
					
					   $editId = $data[0]['deliverer_id'];
					   $email = $data[0]['email'];
					   $password = $data[0]['password'];
					  
					   $first_name = $data[0]['first_name'];
					   $last_name = $data[0]['last_name'];
					   $contact = $data[0]['contact'];
					   $alt_contact = $data[0]['alt_contact'];
					   $gender = $data[0]['gender'];
					   $balance = $data[0]['balance'];
					   $flat_no = $data[0]['flat_no'];
					   $street = $data[0]['street'];
					   $address = $data[0]['address']; 
					   $landmark = $data[0]['landmark']; 
					   $areaId = $data[0]['area_id'];
					   $cityId = $data[0]['city_id'];
					   $stateId = $data[0]['state_id'];
					   $countryId = $data[0]['country_id']; 
					   $zip_code = $data[0]['zip_code'];
					   
					   $area_name = $data[0]['area_name'];
					   $city_name = $data[0]['city_name'];
					   $state_name = $data[0]['state_name'];
					   $country_name = $data[0]['country_name'];
					   
				 }
			?>
            <div class="row">
                <div class="col-md-12 ">
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
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-reorder"></i> Details</div>
                            <div class="caption" style="float: right;">
                                <a class="btn btn-default green btn-sm" href="<?php echo base_url(); ?>index.php/adminlevelone/delivererList">
                                <i class=""></i> View Deliverer List</a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
                                <div class="form-body">
                                    <div class="form-group" style="margin-bottom:0px;">
                                        <div class="col-md-8">
                                        	
                                        	<h3>Login Info</h3><hr/>
                                        	<label class="col-md-3 control-label">Email Id</label>
                                        	<input hidden id="imgPath" name="imgPath" value="<?php echo base_url(); ?>images/images.png"  />
                                        	<input type="text" hidden value="<?php echo $editId; ?>" name="update_id"/>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input value="<?php echo $email; ?>" disabled class="controls form-control" type="text" >
                                            </div>
                                            <label class="col-md-3 control-label">Password </label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="password" disabled value="<?php echo $password; ?>" class="form-control" >
                                            </div>
                                            
                                            <h3>Deliverer Info</h3><hr/>
                                            <label class="col-md-3 control-label">First Name</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" disabled value="<?php echo $first_name; ?>" class="form-control" >
                                            </div>
                                            <label class="col-md-3 control-label">Last Name</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" disabled value="<?php echo $last_name; ?>" class="form-control" >
                                            </div>
                                            <label class="col-md-3 control-label">
                                            	contact </label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" disabled value="<?php echo $contact; ?>" class="form-control" >
                                            </div>
                                            <label class="col-md-3 control-label">
                                            	Alternate contact </label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" disabled value="<?php echo $alt_contact; ?>" class="form-control" >
                                            </div>
                                            <label class="col-md-3 control-label">Gender</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                            	 <input type="radio" <?php echo ($gender == 0)?'checked':''; ?> value="0" name="gender" id="gender" class="form-control" >Male
                                            	 <input type="radio" <?php echo ($gender == 1)?'checked':''; ?> value="1" name="gender" id="gender" class="form-control" >Female
                                            	 <input type="radio" <?php echo ($gender == 2)?'checked':''; ?>  value="2" name="gender" id="gender" class="form-control" >Other
                                            </div>
                                            <label class="col-md-3 control-label">Balance</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" disabled value="<?php echo $balance; ?>" class="form-control" >
                                            </div>
                                            <h3>address Info</h3><hr/>
                                            <label class="col-md-3 control-label">Flat no.</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" disabled value="<?php echo $flat_no; ?>" class="form-control" >
                                            </div>
                                            <label class="col-md-3 control-label">street</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" disabled value="<?php echo $street; ?>" class="form-control" >
                                            </div>
                                            <label class="col-md-3 control-label">Landmark</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;" >
                                                <textarea class="form-control" disabled rows="3" ><?php echo $landmark; ?></textarea>
                                            </div>
                                            
                                            <label class="col-md-3 control-label">address</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;" >
                                                <textarea class="form-control" disabled rows="3" ><?php echo $address; ?></textarea>
                                            </div>
                                            <label class="col-md-3 control-label">Zip Code </label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" disabled value="<?php echo $zip_code; ?>" class="form-control" >
                                            </div>
                                            <label class="col-md-3 control-label">Area </label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" disabled value="<?php echo $area_name; ?>" class="form-control" >
                                            </div>
                                            <label class="col-md-3 control-label">City </label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" disabled value="<?php echo $city_name; ?>" class="form-control" >
                                            </div>
                                            <label class="col-md-3 control-label">State </label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" disabled value="<?php echo $state_name; ?>" class="form-control" >
                                            </div>
                                            <label class="col-md-3 control-label">Country </label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" disabled value="<?php echo $country_name; ?>" class="form-control" >
                                            </div>
                                            
                                        </div><div class="col-md-4"> </div>
                                    </div>
                                    <div class="form-actions fluid" style="margin-bottom:0px; padding-top:0px; padding-bottom:0px;">
                                        <div class="col-md-offset-9 " style="margin-left: 40%; padding-left: 0px; text-align: left;">
                                            <a href="<?php echo base_url(); ?>index.php/adminlevelone/delivererList" class="btn blue">Back</a>	
                                        </div>
                                    </div>
                                </div>        
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        <link href="<?php echo base_url(); ?>assets/css/pages/invoice.css" rel="stylesheet" type="text/css"/>
	    <script src="<?php echo base_url(); ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	    <script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
	     <script src="<?php echo base_url(); ?>assets/scripts/core/app.js"></script>
        <script src="<?php echo base_url(); ?>assets/scripts/custom/table-editable.js"></script>
        <script>
            jQuery(document).ready(function () {
                App.init();
                TableEditable.init();
            });
        </script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/JQueryValidation.js"></script>
   </html>