$(document).ready(function(){
$("#category").change(function(){
    	var myKeyVals = { category : $("#category").val()};
		//var city=$("#tag").val();
    	
    	 var tableVal={search_city:Settings.search_city};
    	
    	$.ajax({
        	url: Settings.base_url+"index.php/adminhome/getTitle",
        	type: "POST",
        	data: myKeyVals,
  			success: function(result){
            $("#g2").html(result);
        }});
    });
$("#tag2").click(function(){
    	
    	var myKeyVals = { city : $("#tag2").val()};
		//var city=$("#tag").val();
		
    	var go=$("#tag2").val();
    		
    	$.ajax({
        	url: "<?php echo base_url()?>index.php/classified/govindaPage",
        	type: "POST",
        	data: myKeyVals,
  			success: function(result){
            $("#g2").html(result);
        }});
    });
 $("#like_dislike").click(function(){
    	var user_id=$("#session").val();
    	if(user_id=='')
    	{
    		alert("Please Login Before Like");
    	}
    	else
    	{
    		var myKeyVals = { advertisement_id : $("#advertisement_id").val()};
			
	    	var go=$("#advertisement_id").val();
	    	 var tableVal={search_city:Settings.search_city};
	    	
	    	$.ajax({
	        	url: Settings.base_url+"index.php/classified/likeAdvertisement",
	        	type: "POST",
	        	data: myKeyVals,
	  			success: function(result){
	            $("#like_dislike").html(result);
	        }});
    	}
    		
    	
    });
  $("#favorite").click(function(){
 	var user_id=$("#session").val();
    	if(user_id=='')
    	{
    		alert("Please Login Before Favorite");
    	}
    	else
    	{
    		var myKeyVals = { advertisement_id : $("#advertisement_id").val()};
			//var city=$("#tag").val();
	    	var go=$("#advertisement_id").val();
	    	 var tableVal={search_city:Settings.search_city};
	    	
	    	$.ajax({
	        	url: Settings.base_url+"index.php/classified/favoriteAdvertisement",
	        	type: "POST",
	        	data: myKeyVals,
	  			success: function(result){
	            $("#favorite").html(result);
	        }});
    	}
    	
    });
     $("#submit_c").click(function(){
    	var user_id=$("#session").val();
    	if(user_id=='')
    	{
    		alert("Please Login Before Comment");
    	}
    	else
    	{
    		var myKeyVals = { advertisement_id : $("#advertisement_id").val(),comment : $("#comment").val()};
			//var city=$("#tag").val();
	    	var go=$("#comment").val();
	    	 var tableVal={search_city:Settings.search_city};
	    
	    	$.ajax({
	        	url: Settings.base_url+"index.php/classified/advertisementComment",
	        	type: "POST",
	        	data: myKeyVals,
	  			success: function(){
	            //$("#user_comment").html(result);
	            window.location = Settings.base_url+"index.php/classified/advertisementDetail/"+$("#advertisement_id").val();
	        }});
    	}	
    	
    });
   $("#follow_unfollow").click(function(){
    	var myKeyVals = { user : $("#user").val()};
		
    	var go=$("#user").val();
    	 var tableVal={search_city:Settings.search_city};
    	
    	$.ajax({
        	url: Settings.base_url+"index.php/web/followUnfollow",
        	type: "POST",
        	data: myKeyVals,
  			success: function(result){
            $("#follow_unfollow").html(result);
        }});
    });
       $("#follow_unfollow").click(function(){
       	
    	var myKeyVals = { user : $("#user").val()};
		var tableVal={search_city:Settings.search_city};
    	
    	$.ajax({
        	url: Settings.base_url+"index.php/web/getFollowerFollowing",
        	type: "POST",
        	data: myKeyVals,
  			success: function(result){
            $(".follows").html(result);
        }});
    }); 
    $("span").click(function(){
    	//var myKeyVals = { gallery_id : $("#image_id1").val(),advertisement_id:$("#advertisement_id").val()};
		
    	var del_id = $(this).attr('id');
    	var parent = $(this).parent();
    	 var tableVal={search_city:Settings.search_city};
    	
    	
    	$.post(Settings.base_url+"index.php/web/deletedGallery", {id:del_id,advertisement_id:$("#advertisement_id").val()},function(data){
    	parent.slideUp('slow', function() {$(this).remove();});
    	
		});
    });
       $("#block_unblock").click(function(){
       	
    	var myKeyVals = { user_id : $("#user_id").val()};
		
    	var go=$("#user_id").val();
    	 var tableVal={search_city:Settings.search_city};
    	
    	$.ajax({
        	url: Settings.base_url+"index.php/manager/blockUnblockUser",
        	type: "POST",
        	data: myKeyVals,
  			success: function(result){
            $("#block_unblock").html(result);
        }});
    });
	$(".delete_review").click(function(){
    	var del_id = $(this).attr('id');
    	var parent = $(this).parent();
    	 var tableVal={search_city:Settings.search_city};
    	
    	
    	$.post(Settings.base_url+"index.php/manager/deleteReview", {review_id:del_id},function(data){
    	parent.slideUp('slow', function() {$(this).remove();});
    	
		});
    }); 
     $("#eng").click(function(){
     	var url      = window.location.href; 
     	var myKeyVals = { language : 'english',direct:'web',re_url:url};
		var tableVal={search_city:Settings.search_city};
    	
    	$.ajax({
        	url: Settings.base_url+"index.php/classified/changeLanguage",
        	type: "POST",
        	data: myKeyVals,
  			});
  		location.reload(true);	
    });
	$("#are").click(function(){
     	var url      = window.location.href; 
     	var myKeyVals = { language : 'arebic',direct:'web_ar',re_url:url};
		var tableVal={search_city:Settings.search_city};
    	
    	$.ajax({
        	url: Settings.base_url+"index.php/classified/changeLanguage",
        	type: "POST",
        	data: myKeyVals,
  			});
  		location.reload(true);	
    });
    $('#review').click(function(){
    	var user_id=$("#session").val();
    	if(user_id=="")
    	{
    		alert("please login before Review and Rating");	
    	}
    	
    });
            /*  $("#image2").click(function(){
    	var myKeyVals = { gallery_id : $("#image_id2").val(),advertisement_id:$("#advertisement_id").val()};
		
    	var go=$("#image_id2").val();
    	 var tableVal={search_city:Settings.search_city};
    	
    	$.ajax({
        	url: Settings.base_url+"index.php/web/deletedGallery",
        	type: "POST",
        	data: myKeyVals,
  			success: function(result){
            $("#show_gallery").html(result);
        }});
    }); 
           $("#image3").click(function(){
    	var myKeyVals = { gallery_id : $("#image_id3").val(),advertisement_id:$("#advertisement_id").val()};
		
    	var go=$("#image_id3").val();
    	 var tableVal={search_city:Settings.search_city};
    	
    	$.ajax({
        	url: Settings.base_url+"index.php/web/deletedGallery",
        	type: "POST",
        	data: myKeyVals,
  			success: function(result){
            $("#show_gallery").html(result);
        }});
    }); 
           $("#image4").click(function(){
    	var myKeyVals = { gallery_id : $("#image_id4").val(),advertisement_id:$("#advertisement_id").val()};
		
    	var go=$("#image_id4").val();
    	 var tableVal={search_city:Settings.search_city};
    	
    	$.ajax({
        	url: Settings.base_url+"index.php/web/deletedGallery",
        	type: "POST",
        	data: myKeyVals,
  			success: function(result){
            $("#show_gallery").html(result);
        }});
    }); 
	$("#image5").click(function(){
    	var myKeyVals = { gallery_id : $("#image_id5").val(),advertisement_id:$("#advertisement_id").val()};
		
    	var go=$("#image_id5").val();
    	 var tableVal={search_city:Settings.search_city};
    	
    	$.ajax({
        	url: Settings.base_url+"index.php/web/deletedGallery",
        	type: "POST",
        	data: myKeyVals,
  			success: function(result){
            $("#show_gallery").html(result);
        }});
    });  */        
  /*  $("#submit").click(function(){
    	var tableVal={search_city:Settings.search_city};
    	var myKeyVals = { city : $("#city").val(),category:$("#cate").val(),sub_category: $("#div1").val(),keyword:$("#keyword").val()};
    	
		$.ajax({
        	url: Settings.base_url+"index.php/classified/govindaYadav",
        	type: "POST",
        	data: myKeyVals,
  			success: function(result){
            $("#govinda").html(result);
        }});
    });*/    
  });  