<?php include_once 'header.php'; include_once 'menu.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">Country <small> Management</small></h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/admin/home"> Home </a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>/index.php/adminhome/addCountries">Country  Management</a></li> 
                    </ul>
                </div>
            </div>
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
                        <div class="portlet-title"><div class="caption"><i class="fa fa-plus-square"></i> Add Country</div></div>
                        
                        <div class="portlet-body form">
                            <form id="add_country"  method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
                                <div class="form-body">
                                	<div class="form-group"><label class="col-md-3 control-label">Continent</label>
                                        <div class="col-md-4">
                                        	<select name="continent" id="continent" class="form-control">
                                        		<?php
                                        		$continent=$this->admin_model->getRecord('continents', array());
												if($continent!=0)
                                        		{
                                        			foreach ($continent as $valuec) 
                                        			{
                                        		?>
                                        		<option <?php if(isset($detail)){ echo $detail[0]['continent_id']==$valuec['continent_id']?'selected="selected"':'';}?> value="<?php echo $valuec['continent_id'];?>"><?php echo $valuec['continent_name'];?></option>
                                        		<?php
                                        		} }
                                        		?>
                                        	</select>
                                        	<label class="error" for="continent" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('continent');?></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">Country Name</label>
                                        <div class="col-md-4">
                                            <input type="text" value="<?php if(isset($detail)){ echo $detail[0]['country_name'];}?>" name="country_name" id="country_name" class="form-control"  placeholder="Country name">		
                                            <label class="error" for="country_name" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('country_name');?></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">Nombre del país</label>
                                        <div class="col-md-4">
                                            <input type="text" value="<?php if(isset($detail)){ echo $detail[0]['country_spanish'];}?>" name="country_spanish" id="country_spanish" class="form-control"  placeholder="Nombre del país">		
                                            <label class="error" for="country_spanish" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('country_spanish');?></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">Number</label>
                                        <div class="col-md-4">
                                            <input type="text" value="<?php if(isset($detail)){ echo $detail[0]['number'];}?>" name="number" id="number" class="form-control"  placeholder="Number">		
                                            <label class="error" for="number" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('number');?></span>
                                        </div>
                                    </div>
                                    <div class="form-actions fluid" style="margin-top:0px; padding-top:0px; padding-bottom:0px;">
                                        <div class="col-md-offset-3 " style="margin-left: 0px; padding-left: 0px; text-align: right;">
                                        	<?php
                                        	if(isset($detail))
                                        	{
                                        		echo '<button type="submit" name="update" class="btn blue">Update</button>';	
                                        	}
											else 
											{
												echo '<button type="submit" name="submit" class="btn blue">Submit</button>';	
											}
                                        	?>
                                            
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
                        <div class="portlet-title"><div class="caption"><i class="fa fa-edit"></i>Country List</div></div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                <thead>
                                    <tr> 
                                    	 <th style="width:5%;">Sr.no</th>
                                    	 <th>Continent</th> 
                                    	 <th>Country</th>
                                    	 <th>País</th>
                                    	 <th>Number</th>
                                    	 <th style="width: 280px;">ACTION </th> 
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
                                            <td style="font-size: 15px;"><?php echo $value['continent_name']; ?></td>
                                            <td style="font-size: 15px;"><?php echo $value['country_name']; ?></td>
                                            <td style="font-size: 15px;"><?php echo $value['country_spanish']; ?></td>
                                            <td style="font-size: 15px;"><?php echo $value['number']; ?></td>
                                            <td><a style="padding-left: 10px;" href="<?php echo base_url()?>index.php/adminhome/addCountries/<?php echo $value['country_id'];?>">
                                               <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <a style="padding-left: 10px;" onclick="return confirm('Are you sure? You Want To Delete This?')" 
                                                 href="<?php echo base_url()?>index.php/adminhome/deleteCountries/<?php echo $value['country_id'];?>">
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
        <!-- BEGIN PAGE LEVEL PLUGINS -->
			<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/fuelux/js/spinner.min.js"></script>
			<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
			<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
			<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
			<script src="<?php echo base_url(); ?>assets/plugins/jquery.pwstrength.bootstrap/src/pwstrength.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/plugins/typeahead/typeahead.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url(); ?>assets/scripts/core/app.js"></script>
        <script src="<?php echo base_url(); ?>assets/scripts/custom/table-editable.js"></script>
        <script>
            jQuery(document).ready(function () {
                App.init();
                TableEditable.init();
            });
        </script>
        <!--script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/fuelux/js/spinner.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script-->
        <script src="<?php echo base_url(); ?>assets/scripts/custom/components-form-tools.js"></script>
        <script>
	        jQuery(document).ready(function() {       
	           // initiate layout and plugins
	           App.init();
	           ComponentsFormTools.init();
	        });   
	    </script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/JQueryValidation.js"></script>
    </body>
   </html>