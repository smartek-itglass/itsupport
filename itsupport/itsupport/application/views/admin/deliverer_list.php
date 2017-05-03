<?php include_once 'header.php'; include_once 'menu.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12"><h3 class="page-title">Deliverer <small> Management</small></h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/admin/home"> Home </a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>index.php/adminlevelone/delivererList">Deliverer Management</a></li> 
                    </ul>
                </div>
            </div>
             
            <div class="row">
                <div class="col-md-12">
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
                            <div class="caption"><i class="fa fa-edit"></i>Deliverer List</div>
                            <!--div class="caption" style="float: right;">
                                <a class="btn btn-default green btn-sm" href="<?php echo base_url(); ?>index.php/adminlevelone/addUser">
                                    <i class="fa fa-plus-square"></i> Add New User</a>
                            </div-->
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                <thead>
                                	<tr>
                                		<th style="width:5%;">Sr.no</th>
                                		<th>Name</th>
                                		<th>Email</th>
                                        <th>mobile</th>
                                        <th>City</th>
                                        <th>Duty Status</th>
                                        <th>Approved Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:13px;">
                                	<?php
                                	if(isset($data))
									{
										//print_r($data);
										if($data !='')
										{
											$i=1;
											foreach ($data as $value) 
											{
												?>   
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $value['first_name'].' '.$value['last_name']; ?></td>
                                            <td><?php echo $value['email']; ?></td>
                                            <td><?php echo $value['contact']; ?></td>
                                            <td><?php echo $value['city_name']; ?></td>
                                            <td><?php echo ($value['duty_status'] == 0)?'On':'Off'; ?></td>
                                            <td><a href="<?php echo base_url(); ?>index.php/adminlevelone/approveDeliverer/<?php echo $value['deliverer_id']; ?>" style="text-decoration: none;" >
                                            	<?php if($value['is_approved'] == 0){?>
                                            	<span class="label label-sm label-success">Approved</span>
                                            	<?php }else{ ?>
                                            	<span class="label label-sm label-danger">Approved Now</span>
                                            	<?php } ?></a>
                                            </td>
                                            <td>                                                           
                                                <a style="padding-left: 10px;" href="<?php echo base_url(); ?>index.php/adminlevelone/editDeliverer/<?php echo $value['deliverer_id']; ?>">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                                <!--a style="padding-left: 10px;" onclick="return confirm('Are you sure? You Want To Delete This?')" href="<?php echo base_url(); ?>index.php/adminlevelone/deleteUser/<?php echo $value['user_id']; ?>">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a-->
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
    </body>
    </html>
    