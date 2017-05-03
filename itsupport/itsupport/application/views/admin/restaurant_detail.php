<?php include_once 'header.php'; include_once 'menu.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12"><h3 class="page-title">Restaurant<small> Detail</small></h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/admin/home"> Home </a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>index.php/adminhome/restaurantList">Restaurant Management</a><i class="fa fa-angle-right"></i></li>
                        <li><a href="<?php echo base_url(); ?>index.php/adminhome/restaurantList">Restaurant Detail</a></i></li>
                    </ul>
                </div>
            </div>
            
            <script type="text/javascript"> 
		        function showimagepreview(input) {
		            if (input.files && input.files[0]) {
		            var filerdr = new FileReader();
		            filerdr.onload = function(e) {
		                $('#imgprvw').attr('src', e.target.result);
		                }
		                filerdr.readAsDataURL(input.files[0]);
		            }else{
		                 //$('#imgprvw').empty();
		                 document.getElementById('imgprvw').src='';
		            }
		        }
		       
		    </script>        
		    <script type="text/javascript">
		       function resetimage()
		        {
		        	var link = document.getElementById('imgPath').value;
		            document.getElementById('imgprvw').src = link;
		        }
		    </script>
            <style>
			    .multiselect {
			        width: 200px;
			    }
			    .selectBox {
			        position: relative;
			    }
			    .selectBox select {
			        width: 100%;
			        font-weight: bold;
			    }
			    .overSelect {
			        position: absolute;
			        left: 0; right: 0; top: 0; bottom: 0;
			    }
			    .checkboxes {
			        display: none;
			        border: 1px #dadada solid;
			        padding-left: 2px;
			    }
			    .checkboxes label {
			        display: block;
			    }
			    .checkboxes label:hover {
			        background-color: #1e90ff;
			    }
			</style>
			
			<script>
				// register event on form, not submit button
				$('#addRestaurant').submit(onSubmit)
			    var expanded = false;
			    function showAvailCheck() {
			        var checkboxes = document.getElementById("foodCheckboxes");
			        if (!expanded) {
			            foodCheckboxes.style.display = "block";
			            expanded = true;
			        } else {
			            foodCheckboxes.style.display = "none";
			            expanded = false;
			        }
			    }
			    
			</script>	
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
				function showCity()
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
					var stateId = document.getElementById('state_id').value;
					var ajaxPath = document.getElementById('ajaxpath').value;
					
					xmlhttp.open("get", ajaxPath+"ajaxFunctionCity/" + stateId , true);
					xmlhttp.send();
					
					xmlhttp.onreadystatechange = function()
					{
						
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
						{
							
							//var a=xmlhttp.responseText; alert(a);
							var abc = document.getElementById('city_id').innerHTML = xmlhttp.responseText;
						}
					}
				 }
				function showAreaByCity()
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
					var cityId = document.getElementById('city_id').value;
					var ajaxPath = document.getElementById('ajaxpath').value;
					
					xmlhttp.open("get", ajaxPath+"ajaxFunctionAreaByCity/" + cityId , true);
					xmlhttp.send();
					
					xmlhttp.onreadystatechange = function()
					{
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
						{
							//var a=xmlhttp.responseText; alert(a);
							var abc = document.getElementById('select2_sample2').innerHTML = xmlhttp.responseText;
						}
					}
				 }
				
            </script>
            
            <?php
			    //echo "<pre>";
			    //print_r($data[0]);
				$editId = $countryId =  $stateId = $cityId = $areaId = $address = $userName = $paypal_email = '';
				$email = $password = $contact = $restaurant_name = $start_day = $close_day = $editImage= '';
				$open_time = $open_time = $close_time = $min_amount = $description = $is_available = '';
				$tax = $avail_distance = $delivery_time = $retry_time_limit = $area_arr = '';
				$mapLat = '22.719569';$mapLong = '75.857726';
				
				$food_arr = array();
				if(!empty($data)){
					   $editId = $data[0]['restaurant_id'];
					   $countryId = $data[0]['country_id']; 
					   $stateId = $data[0]['state_id'];
					   $cityId = $data[0]['city_id'];
					   $areaId = $data[0]['area_id'];
					   $address = $data[0]['address']; 
					   $userName = $data[0]['user_name'];
					   
					   $email = $data[0]['email'];
					   $password = $data[0]['password'];
					   $paypal_email = $data[0]['paypal_email'];
					   $contact = $data[0]['contact'];
					   $restaurant_name = $data[0]['restaurant_name'];
					   $editImage = $data[0]['restaurant_img']; 
					   $start_day = $data[0]['start_day'];
					   $close_day = $data[0]['close_day'];
					   $open_time = $data[0]['open_time'];
					   $close_time = $data[0]['close_time']; 
					   $min_amount = $data[0]['min_amount']; 
					   $description = $data[0]['description']; 
					   $is_available = $data[0]['is_available']; 
					   $food_arr = $data[0]['food_arr']; 
					   $area_arr = $data[0]['area_arr']; 
					   $tax = $data[0]['tax']; 
					   $avail_distance = $data[0]['avail_distance']; 
					   $delivery_time = $data[0]['delivery_time']; 
					   $retry_time_limit = $data[0]['retry_time_limit'];
                       $mapLat = $data[0]['latitude'];
					   $mapLong = $data[0]['longitude'];
				 }
                 $mapdata = array(
					  'lat' => $mapLat,
					  'lng' => $mapLong
				 );
			?>
			
			<script></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0QRAyhRea36B42kTGNRRaR8iHvQ6_j5k"  type="text/javascript"></script>
            
            <script type="text/javascript">
             //function mapview(str){
                
                var markers = <?php echo json_encode($mapdata);?>;
                //(markers);
				var map;
				var marker;
                var myLatlng = new google.maps.LatLng(markers.lat, markers.lng);
				//var myLatlng = new google.maps.LatLng(22.719569,75.857726);
				//(myLatlng);
				var geocoder = new google.maps.Geocoder();
				var infowindow = new google.maps.InfoWindow();
				function initialize(){
					var mapOptions = {
						zoom: 18,
						center: myLatlng,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					};
				
					map = new google.maps.Map(document.getElementById("myMap"), mapOptions);
					
					marker = new google.maps.Marker({
						map: map,
						position: myLatlng,
						draggable: true
					});
				
					geocoder.geocode({'latLng': myLatlng }, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							if (results[0]) {
								$('#latitude,#longitude').show();
								$('#address').val(results[0].formatted_address);
								$('#latitude').val(marker.getPosition().lat());
								$('#longitude').val(marker.getPosition().lng());
								infowindow.setContent(results[0].formatted_address);
								infowindow.open(map, marker);
							}
						}
					});
				
				    google.maps.event.addListener(marker, 'dragend', function() {
				
					    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
							if (status == google.maps.GeocoderStatus.OK) {
								if (results[0]) {
									$('#address').val(results[0].formatted_address);
									$('#latitude').val(marker.getPosition().lat());
									$('#longitude').val(marker.getPosition().lng());
									infowindow.setContent(results[0].formatted_address);
									infowindow.open(map, marker);
								}
							}
						});
					});
				    
				}
				
				google.maps.event.addDomListener(window, 'load', initialize);
			//}
			</script>
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
                                <a class="btn btn-default green btn-sm" href="<?php echo base_url(); ?>index.php/adminhome/restaurantList">
                                <i class=""></i> View Restaurant List</a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form id="addRestaurant" action="<?php echo base_url(); ?>index.php/adminhome/addRestaurant" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
                                <div class="form-body">
                                    <div class="form-group" style="margin-bottom:0px;">
                                        <div class="col-md-8">
                                        	<h3>Login Info</h3><hr/>
                                        	<label class="col-md-3 control-label">Email Id</label>
                                        	<input type="text" hidden id="ajaxpath" name="ajaxpath" value="<?php echo base_url(); ?>index.php/adminhome/" />
                                        	<input hidden id="imgPath" name="imgPath" value="<?php echo base_url(); ?>images/images.png"  />
                                        	
                                        	<input type="text" hidden value="<?php echo $editId; ?>" name="update_id"/>
                                            <div class="col-md-9"  style="margin-bottom: 15px;">
                                                <input id="email" <?php echo ($email != '')? 'readonly':'' ?> name="email" value="<?php echo $email; ?>" class="controls form-control" type="text" placeholder="Enter email id">
                                                <label class="error" for="email" generated="true" style="color: Red;  font-weight: normal;"></label>
                                                <span style="color:red;font-size: 13px;"><?php echo form_error('email'); ?></span>
                                            </div>
                                            <!--label class="col-md-3 control-label">Password </label>
                                            <div class="col-md-9"  style="margin-bottom: 15px;">
                                                <input type="password" disabled value="<?php echo $password; ?>" name="password" id="password" class="form-control" placeholder="Enter password">
                                                <label class="error" for="password" generated="true" style="color: Red;  font-weight: normal;"></label>
                                                <span style="color:red;font-size: 13px;"><?php echo form_error('password'); ?></span>
                                            </div-->
                                            <h3>Paypal Info</h3><hr/>
                                            <label class="col-md-3 control-label">Paypal Email</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" value="<?php echo $paypal_email; ?>" name="paypal_email" id="paypal_email" class="form-control" placeholder="Enter paypal email">
                                                <label class="error" for="paypal_email" generated="true" style="color: Red;  font-weight: normal;"></label>
                                                <span style="color:red;font-size: 13px;"><?php echo form_error('paypal_email'); ?></span>
                                            </div>
                                            <h3>Restaurant Info</h3><hr/>
                                            <label class="col-md-3 control-label">Restaurant Name</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" value="<?php echo $restaurant_name; ?>" name="restaurant_name" id="restaurant_name" class="form-control" placeholder="Enter restaurant name">
                                                <label class="error" for="restaurant_name" generated="true" style="color: Red;  font-weight: normal;"></label>
                                                <span style="color:red;font-size: 13px;"><?php echo form_error('restaurant_name'); ?></span>
                                            </div>
                                            <label class="col-md-3 control-label">Restaurant Image</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <?php if($editImage != ""){ ?>
	                                            <img id="imgprvw" src="<?php echo base_url().'images/restaurant_images/'.$editImage; ?>" width="100" height="100"/>
	                                            <?php } else { ?>
	                                            <img id="imgprvw" src="<?php echo base_url(); ?>images/images.png" width="100" height="100"/>
	                                            <?php } ?>
	                                            <!--input type="file" value="<?php echo $editImage; ?>" name="item_img" id="filUpload" onChange="showimagepreview(this)"/-->
	                                            <input type="hidden"   name="restaurant_img"  id="restaurant_img" value="<?php echo $editImage; ?>" />
	                                                <?php if ( !empty($editId)) { ?>
	                                                <input type="file" accept=".png,.PNG,.jpg,.JPG,.jpeg,.JPEG" name="restaurant_img1" id="filUpload" onChange="showimagepreview(this)"/>
	                                                <label class="error" for="filUpload" generated="true" style="color:Red;font-weight: normal;"></label>
	                                                <?php  } else {  ?>
	                                                <input type="file" accept=".png,.PNG,.jpg,.JPG,.jpeg,.JPEG" name="restaurant_img" id="filUpload" onChange="showimagepreview(this)"/>
	                                                <label class="error" for="filUpload" generated="true" style="color:Red; font-weight: normal;"></label>
	                                                <?php  } ?><p class="help-block"></p>
	                                                <span style="color:red;"><?php ?></span>
	                                            <label class="error" for="restaurant_img" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            </div>
                                            <label class="col-md-3 control-label">Owner Name</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <input type="text" value="<?php echo $userName; ?>" name="user_name" id="user_name" class="form-control" placeholder="Enter restaurant owner name">
                                                <label class="error" for="user_name" generated="true" style="color: Red;  font-weight: normal;"></label>
                                                <span style="color:red;font-size: 13px;"><?php echo form_error('user_name'); ?></span>
                                            </div>
                                            <label class="col-md-3 control-label">Contact no.</label>
                                            <div class="col-md-9"  style="margin-bottom: 15px;">
                                                <input type="text" value="<?php echo $contact; ?>" name="contact" id="contact" class="form-control" placeholder="Enter contact no">
                                                <label class="error" for="contact" generated="true" style="color: Red;  font-weight: normal;"></label>
                                                <span style="color:red;font-size: 13px;"><?php echo form_error('contact'); ?></span>
                                            </div>
                                            <label class="col-md-3 control-label">Open Days</label>
                                            <div class="col-md-9"  style="margin-bottom: 15px;">
                                                 <div class="input-group input-large "  >
		                                            <select class="form-control " id="start_day" name="start_day" >
			                                            <option value="">Day</option>
			                                            <?php $dayList = array('mon','tue','wed','thu','fri','sat','sun');
			                                            foreach ($dayList as $value) { ?>
			                                                <option value="<?php echo $value; ?>"
			                                                <?php echo ($start_day == $value)?'selected':''; ?>><?php echo ucfirst($value); ?></option>
			                                                <?php } ?>
			                                        </select>
			                                        <label class="error" for="start_day" generated="true" style="color: Red;  font-weight: normal;"></label>
		                                            <span style="color:red;font-size: 13px;"><?php echo form_error('start_day'); ?></span>
		                                            <span class="input-group-addon"> to </span>
			                                        <select class="form-control " id="close_day" name="close_day" >
				                                          <option value="">Day</option>
				                                          <?php $dayList = array('mon','tue','wed','thu','fri','sat','sun');
				                                          foreach ($dayList as $value) { ?>
				                                              <option value="<?php echo $value; ?>"
				                                               <?php echo ($close_day == $value)?'selected':''; ?>><?php echo ucfirst($value); ?></option>
				                                           <?php } ?>
				                                   </select>
		                                           <label class="error" for="close_day" generated="true" style="color: Red;  font-weight: normal;"></label>
		                                        </div>
		                                        <span style="color:red;font-size: 13px;"><?php echo form_error('close_day'); ?></span>
                                            </div>
                                            <label class="col-md-3 control-label">Working Timing</label>
                                            <div class="col-md-9"  style="margin-bottom: 15px;">
                                                 <div class="input-group input-large "  >
		                                            
			                                        <input type="text" id="open_time" name="open_time" value="<?php echo $open_time; ?>" class="form-control timepicker timepicker-24">
													<!--span class="input-group-btn">
														<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
													</span-->
			                                        <label class="error" for="open_time" generated="true" style="color: Red;  font-weight: normal;"></label>
		                                            <span style="color:red;font-size: 13px;"><?php echo form_error('open_time'); ?></span>
		                                            <span class="input-group-addon"> to </span>
			                                           
			                                        <input type="text" id="close_time" name="close_time" value="<?php echo $close_time; ?>" class="form-control timepicker timepicker-24">
													<!--span class="input-group-btn">
														<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
													</span-->
			                                        <label class="error" for="close_time" generated="true" style="color: Red;  font-weight: normal;"></label>
		                                        </div>
		                                        
		                                        <span style="color:red;font-size: 13px;"><?php echo form_error('close_time'); ?></span>
                                            </div>
                                            <label class="col-md-3 control-label">Min Amount </label>
                                            <div class="col-md-9"  style="margin-bottom: 15px;">
                                                <input type="text" value="<?php echo $min_amount; ?>" name="min_amount" id="min_amount" class="form-control" placeholder="Enter min amount for book an order">
                                                <label class="error" for="min_amount" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            </div>
                                            <label class="col-md-3 control-label">Tax (%) </label>
                                            <div class="col-md-9"  style="margin-bottom: 15px;">
                                                <input type="text" min="1" max="20" value="<?php echo $tax; ?>" name="tax" id="tax" class="form-control" placeholder="Enter tax apply on order">
                                                <label class="error" for="tax" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            </div>
                                            <!--label class="col-md-3 control-label">Available Distance (Km)</label>
                                            <div class="col-md-9"  style="margin-bottom: 15px;">
                                                <input type="text" min="10" max="50" value="<?php echo $avail_distance; ?>" name="avail_distance" id="avail_distance" class="form-control" placeholder="Enter available distance for take order">
                                                <label class="error" for="avail_distance" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            </div-->
                                            <label class="col-md-3 control-label">Est. Delivery Time (Min) </label>
                                            <div class="col-md-9"  style="margin-bottom: 15px;">
                                                <input type="text" min="10" max="60" value="<?php echo $delivery_time; ?>" name="delivery_time" id="delivery_time" class="form-control" placeholder="Enter estimate delivery time">
                                                <label class="error" for="delivery_time" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            </div>
                                            <label class="col-md-3 control-label">Retry Time Limit (Min) </label>
                                            <div class="col-md-9"  style="margin-bottom: 15px;">
                                                <input type="text" min="1" max="10" value="<?php echo $retry_time_limit; ?>" name="retry_time_limit" id="retry_time_limit" class="form-control" placeholder="Enter retry time limit">
                                                <label class="error" for="retry_time_limit" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            </div>
                                            <label class="col-md-3 control-label">Description</label>
                                            <div class="col-md-9">
                                                <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter description"><?php echo $description; ?></textarea>
                                                <label class="error" for="description" generated="true" style="color: Red;  font-weight: normal;"></label>
                                            </div>
                                            <label class="col-md-3 control-label">Restaurant Type</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
	                                             <div  onclick="showAvailCheck()">
										            <select class="form-control ">
										                <option value="">Select Type</option>
										            </select>
										            <div class="overSelect"></div>
										        </div>
										        <?php 
                                            	    $resultList=$this->admin_model->getRecordSql("SELECT * FROM `food_category` ORDER BY `food_cat_name` ASC;"); 
													$i = 1;
													if(!empty($resultList)){
                                            	?>
										        <div class="checkboxes" id="foodCheckboxes">
										        	<?php
														 foreach($resultList as $avl){
										        	?>
										            <label for="<?php echo $i; ?>">
										            <input id="food_cat_id[]" name="food_cat_id[]" type="checkbox" <?php echo (in_array($avl['food_cat_id'], $food_arr)) ? 'checked':''; ?> value="<?php echo $avl['food_cat_id']; ?>" id="<?php echo $i; ?>"/><?php echo $avl['food_cat_name']; ?></label>
										        <?php $i++; } ?>
										        </div>
										        <?php } ?>
	                                            <label class="error" for="food_cat_id" generated="true" style="color: Red;  font-weight: normal;"></label>
	                                            <span style="color:red;"><?php echo form_error('food_cat_id');?></span>
                                            </div>
                                            <h3>Delivery Address </h3><hr/>
                                            <label class="col-md-3 control-label">Country</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <select <?php echo ($countryId != '')?'disabled':'' ?> class="form-control" id="country_id" name="country_id" onchange="showState(this.value)">
	                                                <option value="">Select country</option>
	                                                <?php $resultList=$this->admin_model->getRecord('country',array());
	                                                foreach ($resultList as $value) { ?>
	                                                <option value="<?php echo $value['country_id']; ?>"
	                                                        <?php echo ($countryId == $value['country_id']) ? 'selected' : ''; ?>><?php echo $value['country_name']; ?></option>
	                                                    <?php } ?>
	                                            </select>
	                                            <?php if($countryId != ''){ ?><input hidden id="country_id" name="country_id" value="<?php echo $countryId; ?>" /><?php } ?>
	                                            <label class="error" for="country_id" generated="true" style="color: Red;  font-weight: normal;"></label>
                                                <span style="color:red;"><?php echo form_error('country_id');?></span>
                                            </div>
                                            <label class="col-md-3 control-label">State</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <select <?php echo ($stateId != '')?'disabled':'' ?> class="form-control" id="state_id" name="state_id" onchange="showCity(this.value)">
	                                                <option value="">Select state</option>
	                                                <?php $resultList=$this->admin_model->getRecord('state',array());
	                                                foreach ($resultList as $value) { ?>
	                                                <option value="<?php echo $value['state_id']; ?>"
	                                                        <?php echo ($stateId == $value['state_id']) ? 'selected' : ''; ?>><?php echo $value['state_name']; ?></option>
	                                                    <?php } ?>
	                                            </select>
	                                            <?php if($stateId != ''){ ?><input hidden id="state_id" name="state_id" value="<?php echo $stateId; ?>" /><?php } ?>
	                                            <label class="error" for="state_id" generated="true" style="color: Red;  font-weight: normal;"></label>
	                                            <span style="color:red;"><?php echo form_error('state_id');?></span>
                                            </div>
                                            <label class="col-md-3 control-label">City</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <select <?php echo ($cityId != '')?'disabled':'' ?> class="form-control" id="city_id" name="city_id" onchange="showAreaByCity(this.value)" >
	                                                <option value="">Select city</option>
	                                                <?php $resultList=$this->admin_model->getRecord('city',array());
	                                                foreach ($resultList as $value) { ?>
	                                                <option value="<?php echo $value['city_id']; ?>"
	                                                        <?php echo ($cityId == $value['city_id']) ? 'selected' : ''; ?>><?php echo $value['city_name']; ?></option>
	                                                    <?php } ?>
	                                            </select>
	                                            <?php if($cityId != ''){ ?><input hidden id="city_id" name="city_id" value="<?php echo $cityId; ?>" /> <?php } ?>
	                                            <label class="error" for="city_id" generated="true" style="color: Red;  font-weight: normal;"></label>
	                                            <span style="color:red;"><?php echo form_error('city_id');?></span>
                                            </div>
                                            <!--label class="col-md-3 control-label">Area</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <select class="form-control" id="area_id" name="area_id" >
	                                                <option value="">Select area</option>
	                                                <?php $resultList=$this->admin_model->getRecord('area',array());
	                                                foreach ($resultList as $value) { ?>
	                                                <option value="<?php echo $value['area_id']; ?>"
	                                                        <?php echo ($areaId == $value['area_id']) ? 'selected' : ''; ?>><?php echo $value['area_name']; ?></option>
	                                                    <?php } ?>
	                                            </select>
	                                            <label class="error" for="area_id" generated="true" style="color: Red;  font-weight: normal;"></label>
	                                            <span style="color:red;"><?php echo form_error('area_id');?></span>
                                            </div-->
                                            <label class="col-md-3 control-label">Area</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <div class="form-group" class="form-horizontal form-row-seperated">
													<div class="col-md-9">
														<select name="rest_area_list[]" id="select2_sample2" class="form-control select2" data-placeholder="Select" multiple>
															<?php if(!empty($area_arr) || $cityId != ''){ ?>
															<optgroup label="Area List">
															<?php 
			                                                      $areaAllList=$this->admin_model->getRecord('area',array('city_id'=>$cityId));
																  if(!empty($areaAllList)){
																  	 foreach ($areaAllList as $value) { 
			                                                ?>
			                                                <option value="<?php echo $value['area_id']; ?>"
			                                                        <?php echo (in_array($value['area_id'], $area_arr)) ? 'selected' : ''; ?>><?php echo $value['area_name']; ?></option>
			                                                <?php } } ?>
															</optgroup>
															<?php } ?>
														</select>
													</div>
												</div>
                                            </div>
                                            <!--label class="col-md-3 control-label">Address</label>
                                            <div class="col-md-9">
                                                <textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter address"><?php echo $address; ?></textarea>
                                                <label class="error" for="address" generated="true" style="color: Red;  font-weight: normal;"></label>
                                                <span style="color:red;font-size: 13px;"><?php echo form_error('address'); ?></span>
                                            </div-->
                                            <h3>Address Info</h3><hr/>
                                            <label class="col-md-3 control-label">Pick Your Address</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <div id="myMap"></div>
                                                <!--input hidden id="address" type="text" style="width:600px;"/><br/-->
                                            </div>
                                            <div class="col-md-3 control-label"></div>
                                            <div class="col-md-9" style="margin-bottom: 15px;padding-left: 0px;">
                                            	<div class="col-md-6" ><input readonly type="text" hidden="true" name="latitude" id="latitude" class="form-control" placeholder="Latitude"/> </div>
												<div class="col-md-6" ><input readonly type="text" hidden="true" name="longitude" id="longitude" class="form-control" placeholder="Longitude"></div>
                                            </div>
                                            <label class="col-md-3 control-label">Address</label>
                                            <div class="col-md-9">
                                                <textarea readonly name="address" id="address" class="form-control" rows="3" placeholder="Enter address"><?php echo $address; ?></textarea>
                                                <label class="error" for="address" generated="true" style="color: Red;  font-weight: normal;"></label>
                                                <span style="color:red;font-size: 13px;"><?php echo form_error('address'); ?></span>
                                            </div>
                                            <label class="col-md-3 control-label">Is Active</label>
                                            <div class="col-md-9" style="margin-bottom: 15px;">
                                                <div class="checkbox-list">
                                                    <label id="checkbox" style="padding-top:7px;">
                                                        <input <?php echo ($is_available == 0)?'checked':''; ?> type="checkbox" value="0" name="is_available" id="inlineCheckbox" <br>
                                                        <span>(If you tick checkbox then this restaurant can take orders)</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div><div class="col-md-4"> </div>
                                    </div>
                                    <div class="form-actions fluid" style="margin-bottom:0px; padding-top:0px; padding-bottom:0px;">
                                        <div class="col-md-offset-9 " style="margin-left: 40%; padding-left: 0px; text-align: left;">
                                            <button type="submit" name="submit" onclick="lengthCheck()" class="btn blue">Submit</button>
                                            <?php if($editId == ''){ ?>
                                            <button type="reset" onclick="resetimage()" class="btn blue">Reset</button> 
                                            <?php } else{ ?>
                                            <a href="<?php echo base_url(); ?>index.php/adminhome/restaurantList" class="btn blue">Cancel</a>	
                                            <?php } ?>	
                                        </div>
                                    </div>
                                </div>        
                            </form>
                            
                            <div class="col-md-6">
					
				            </div>
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
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap2-typeahead.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
	    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2/select2.min.js"></script>
	    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js"></script>
	    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js"></script>
        
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
    
				
        <!-- END JAVASCRIPTS -->  
        <script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/JQueryValidation.js"></script>
        
   </html>