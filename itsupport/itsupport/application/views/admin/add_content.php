<?php include_once 'header.php'; include_once 'menu.php'; ?>
<script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/ckeditor/samples/js/sample.js"></script>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">Content <small> Management</small></h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/admin/home"> Home </a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>index.php/adminhome/addContent">Content  Management</a></li> 
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
                        <div class="portlet-title"><div class="caption"><i class="fa fa-plus-square"></i> Add Content</div></div>
                        
                        <div class="portlet-body form">
                            <form id="add_content"  method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
                                <div class="form-body">
                                	<div class="row">
                                	<div class="main-group col-md-8">
                                    <div class="form-group">
                                    	<label class="col-md-4 control-label">Category Name</label>
                                        <div class="col-md-8">
                                        	<select name="category" id="category" class="form-control">
                                        		<option>SELECT CATEGORY</option>
                                        		<?php $cate=$this->admin_model->getRecord('category', array());
												if($cate!=0)
                                        		{
                                        			foreach ($cate as $valuec) 
                                        			{
														?>
														<option <?php if(isset($detail)){ echo $detail[0]['category_id']==$valuec['category_id']?'selected="selected"':'';}?> value="<?php echo $valuec['category_id'];?>"><?php echo $valuec['category_name'];?></option>
														<?php
													}
                                        		}
                                        		?>
                                        	</select>
                                            <label class="error" for="category" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('category');?></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-4 control-label">Title</label>
                                        <div class="col-md-8">
                                            <select name="title" id="title" class="form-control">
                                            	<option>SELECT TITLE</option>
                                        		<?php 
                                        		if(isset($detail))
												{
													$title=$this->admin_model->getRecord('title', array());
													if($title!=0)
	                                        		{
	                                        			foreach ($title as $valuet) 
	                                        			{
															?>
															<option <?php if(isset($detail)){ echo $detail[0]['title_id']==$valuet['title_id']?'selected="selected"':'';}?> value="<?php echo $valuet['title_id'];?>"><?php echo $valuet['title_name'];?></option>
															<?php
														}
	                                        		}
												}
                                        		?>
                                        		
                                        		 
                                        	</select>		
                                            <label class="error" for="title" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('title');?></span>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-4 control-label">Image</label>
                                        <div class="col-md-8">
                                        	<?php if(isset($detail)){
                                        		 echo '<input type="file" name="image1" id="image1" class="form-control">';
													}else
														{
															echo '<input type="file" name="image" id="image" class="form-control">';
														}
                                        		 ?>
                                            		
                                            <label class="error" for="image" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('image');?></span>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="group-img col-md-4">
                                    	<?php if(isset($detail)){ if($detail[0]['image']!=""){  ?>
                                    	<img src="<?php echo $this->admin_model->get_user_img_url('content', $detail[0]['image'])?>" width="150px" height="150px">	
                                    		<?php }}?>
                                    </div>
                                    </div>
                                    
                                    <div class="form-group row"><label class="col-md-2 control-label">Content</label>
                                        <div class="col-md-10">
                                        	<textarea id="content" name="content"><?php if(isset($detail)){ echo $detail[0]['content'];}?></textarea>		
                                            <label class="error" for="content" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('content');?></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-2 control-label">Contenido</label>
                                        <div class="col-md-10">
                                            <textarea id="content_spanish" name="content_spanish"><?php if(isset($detail)){ echo $detail[0]['cantent_spanish'];}?></textarea>		
                                            <label class="error" for="content_spanish" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            <span style="color:red;"><?php echo form_error('content_spanish');?></span>
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
            
        </div>
    </div>
    <script>
	initSample();
</script>
<script type="text/javascript">
      CKEDITOR.replace( 'content' );
      CKEDITOR.add            
   </script>
  <script type="text/javascript">
      CKEDITOR.replace( 'content_spanish' );
      CKEDITOR.add            
   </script> 
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
            
            $(document).ready(function(){
		    $("#category").change(function(){
		    	
		    	var category = $("#category").val();
		    	
		    	$.ajax({
		        	url: "<?php echo base_url()?>index.php/adminhome/getTitle/"+category,
		        	type: "GET",
		  			success: function(result){
		            $("#title").html(result);
		        }});
		    });
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