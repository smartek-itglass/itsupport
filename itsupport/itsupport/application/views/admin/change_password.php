
<?php include_once 'header.php'; include_once 'menu.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">Change  <small> Password</small></h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/admin/home"> Home </a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>/index.php/adminlevelone/changePassword">Change Password</a></li> 
                    </ul>
                </div>
            </div>
           <?php
			    //echo "<pre>";
			    //print_r($data);
				
			?>
            <div class="row">
                <div class="col-md-6 " style="width:70%;">
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
                        <div class="portlet-title"><div class="caption"><i class="fa fa-reorder"></i>Change Password</div></div>
                        <div class="portlet-body form">
                            <form id="changePassword" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/adminlevelone/changePassword" class="form-horizontal" role="form">
                                <div class="form-body">
                                    <div class="form-group">	
                                        <label class="col-md-3 control-label">Current Password</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="password" value="<?php  ?>" name="password" id="password" class="form-control" placeholder="Current Password">
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            </div>
                                            <span class="help-block" style="color:red;font-size: 13px;"><?php  ?></span>
                                            <label class="error" for="password" generated="true" style="color: Red;  font-weight: normal;"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">	
                                        <label class="col-md-3 control-label">New Password</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="password" value="<?php  ?>" id="newPassword" name="newPassword" class="form-control" placeholder="New Password">
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            </div>
                                            <span class="help-block" style="color:red;font-size: 13px;"><?php  ?></span>
                                            <label class="error" for="newPassword" generated="true" style="color: Red;  font-weight: normal;"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">	
                                        <label class="col-md-3 control-label">Re-type New Password</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="password" value="<?php   ?>" id="RePassword"  name="RePassword" class="form-control" placeholder="Re-type New Password">
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            </div>
                                            <span class="help-block" style="color:red;font-size: 13px;"><?php  ?></span>
                                            <label class="error" for="RePassword" generated="true" style="color: Red;  font-weight: normal;"></label>
                                        </div>
                                    </div>
                                    <div class="form-actions fluid">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" name="submit" class="btn blue">Change Password</button>
                                            <button type="reset" class="btn default">Reset</button>
                                        </div>
                                    </div>
                                </div>        
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!---- row --->
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
    </body>
   </html>