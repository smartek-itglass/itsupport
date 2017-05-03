
<?php include_once 'header.php'; include_once 'menu.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">City <small> Management</small></h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/admin/home"> Home </a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>/index.php/adminhome/City">City  Management</a></li> 
                    </ul>
                </div>
            </div>
            <script>
            	
            	function showState()
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
					var countryId = document.getElementById('country_id').value;
					var ajaxPath = document.getElementById('ajaxpath').value;
					//alert(cityId);
					xmlhttp.open("get", ajaxPath+"ajaxFunctionState/" + countryId , true);
					xmlhttp.send();
					
					xmlhttp.onreadystatechange = function()
					{
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
						{
							//var a=xmlhttp.responseText; alert(a);
							var abc = document.getElementById('state_id').innerHTML = xmlhttp.responseText;
						}
					}
				 }
            </script>
           <?php
			    //echo "<pre>";
			    //print_r($data);
				$editId = $editName= $stateId = '';
				if(!empty($data)){ 
					  foreach($data as $editVal){
						  if(isset($editVal['is_edit']) && $editVal['is_edit'] == 1){
							  
						     $editId = $editVal['city_id'];
							 $stateId = $editVal['state_id'];
							 $editName = $editVal['city_name']; 
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
                        <div class="portlet-title"><div class="caption">
                        	<i class="fa fa-plus-square"></i> Add City</div></div>
                        
                        <div class="portlet-body form">
                            <form id="cityAdd" action="<?php echo base_url(); ?>index.php/adminhome/City" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
                                <div class="form-body">
                                	<input type="text" hidden id="ajaxpath" value="<?php echo base_url(); ?>index.php/adminhome/" />
                                	<div class="form-group"><label class="col-md-3 control-label">Country</label>
                                        <div class="col-md-4">
                                            <select class="form-control" id="country_id" name="country_id" onchange="showState(this.value)">
                                                <option value="">Select Country</option>
                                                <?php $resultList=$this->admin_model->getRecord('country',array());
                                                foreach ($resultList as $value) { ?>
                                                <option value="<?php echo $value['country_id']; ?>"
                                                        <?php echo ($stateId == $value['country_id']) ? 'selected' : ''; ?>><?php echo $value['country_name']; ?></option>
                                                    <?php } ?>
                                            </select>
                                            <label class="error" for="country_id" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('country_id');?></span>
                                        </div>
                                    </div>
                                	<div class="form-group"><label class="col-md-3 control-label">State</label>
                                        <div class="col-md-4">
                                            <select class="form-control" id="state_id" name="state_id" onchange="showCity(this.value)">
                                                <option value="">Select State</option>
                                                <?php $resultList=$this->admin_model->getRecord('state',array());
                                                foreach ($resultList as $value) { ?>
                                                <option value="<?php echo $value['state_id']; ?>"
                                                        <?php echo ($stateId == $value['state_id']) ? 'selected' : ''; ?>><?php echo $value['state_name']; ?></option>
                                                    <?php } ?>
                                            </select>
                                            <label class="error" for="state_id" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('state_id');?></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">City</label>
                                        <div class="col-md-4">
                                            <input type="text" hidden name="update_id" value="<?php echo $editId; ?>" />
                                            <input type="text" value="<?php echo $editName; ?>" name="city_name" id="city_name" class="form-control"  placeholder="Enter City">		
                                            <label class="error" for="city_name" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('city_name');?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="form-actions fluid" style="margin-top:0px; padding-top:0px; padding-bottom:0px;">
                                        <div class="col-md-offset-3 " style="margin-left: 0px; padding-left: 0px; text-align: right;">
                                            
                                            <button type="submit" name="submit" class="btn blue">Submit</button>
                                            <?php if($editId != ''){ ?>
                                            <a href="<?php echo base_url(); ?>/index.php/adminhome/City" class="btn blue">Cancel</a>		
                                            <?php } else{ ?>	
                                            <!--a href="#" class="btn defaults">Cancel</a-->
                                            <button type="reset" name="btn_reset" class="btn default">Reset</button>
                                            <?php } ?>
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
                        <div class="portlet-title"><div class="caption"><i class="fa fa-edit"></i>City List</div></div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                <thead>
                                    <tr> <th style="width:5%;">Sr.no</th> 
                                    <th>City </th>
                                    <th>State </th>
                                    <th style="width: 280px;">ACTION </th> </tr>		
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
                                            <td style="font-size: 15px;"><?php echo ucfirst($value['city_name']); ?></td>
                                            <td style="font-size: 15px;"><?php echo ucfirst($value['state_name']); ?></td>
                                            <td><a style="padding-left: 10px;" href="<?php echo base_url()?>index.php/adminhome/editCity/<?php echo $value['city_id'];?>">
                                               <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <a style="padding-left: 10px;" onclick="return confirm('Are you sure? You Want To Delete This?')" 
                                                 href="<?php echo base_url()?>index.php/adminhome/deleteCity/<?php echo $value['city_id'];?>">
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