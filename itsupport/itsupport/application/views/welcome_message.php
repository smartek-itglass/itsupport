<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
		padding-bottom: 20px;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to Fooder App!</h1>

	<div id="body">
         <?php //echo base_url(); ?>  
          <a href="<?php echo base_url().'index.php/User/userRegisterView'; ?>" >User Register</a></br>
          <a href="<?php echo base_url().'index.php/User/userSocialLoginView'; ?>" >social login/signUp</a></br>
          <a href="<?php echo base_url().'index.php/User/userLoginView'; ?>" >User login</a></br>
          <a href="<?php echo base_url().'index.php/User/countryStateList'; ?>" > Country StateList</a></br>
          <a href="<?php echo base_url().'index.php/User/cityAreaListView'; ?>" > City Area List</a></br>
          <a href="<?php echo base_url().'index.php/UserSettings/forgotPasswordView'; ?>" > User Forgot Password</a></br>
          <a href="<?php echo base_url().'index.php/User/restaurantListView'; ?>" > Restaurant List</a></br>
          <a href="<?php echo base_url().'index.php/User/filterOptionView'; ?>" >Filter Option</a></br>
          <a href="<?php echo base_url().'index.php/User/restaurantInfoView'; ?>" > Restaurant Info</a></br>
          <a href="<?php echo base_url().'index.php/UserSettings/changePasswordView'; ?>" > Change Password</a></br>
          
          <a href="<?php echo base_url().'index.php/User/orderAddressView'; ?>" > Order Address</a></br>
          <a href="<?php echo base_url().'index.php/Order/placeOrderView'; ?>" > Place Order </a></br>
          <a href="<?php echo base_url().'index.php/Order/orderHistoryView'; ?>" > Order History </a></br>
          <a href="<?php echo base_url().'index.php/Order/orderAllDetailView'; ?>" > Order Detail </a></br>
          <a href="<?php echo base_url().'index.php/Order/orderReviewView'; ?>" > Order Review </a></br>
          <a href="<?php echo base_url().'index.php/User/updateUserProfileView'; ?>" > Update User Profile </a></br>
          <a href="<?php echo base_url().'index.php/Order/contactRequestView'; ?>" > Contact Request </a></br>
          <a href="<?php echo base_url().'index.php/User/allNotificationView'; ?>" > All Notification </a></br>
          <a href="<?php echo base_url().'index.php/Order/responseContactReqView'; ?>" > Contact Request Response </a></br>
          <a href="<?php echo base_url().'index.php/Order/resendOrderView'; ?>" > Retry Order </a></br>
          <a href="<?php echo base_url().'index.php/Order/cancleOrderView'; ?>" > Cancle Order </a></br>
          <a href="<?php echo base_url().'index.php/User/userLogoutView'; ?>" >User logout</a></br>
          <a href="<?php echo base_url().'index.php/Order/responseSplitReqView'; ?>" > Split Request Response </a></br>
          <a href="<?php echo base_url().'index.php/Order/allUserListView'; ?>" > User List </a></br>
          <a href="<?php echo base_url().'index.php/Order/splitOrderHistoryView'; ?>" > Split Order History </a></br>
          <a href="<?php echo base_url().'index.php/Order/orderSplitPaymentView'; ?>" > Split Order Payment </a></br>
          <a href="<?php echo base_url().'index.php/PromoCode/promoCodeListView'; ?>" > Promo Code List </a></br>
          <a href="<?php echo base_url().'index.php/PromoCode/promoCodeListView'; ?>" > Promo Code List </a></br>
          <a href="<?php echo base_url().'index.php/PromoCode/redeemCodeView'; ?>" > Redeem Promo Code </a></br>
          <a href="<?php echo base_url().'index.php/UserSettings/userContactUsView'; ?>" > Contact Us</a></br>
          <a href="<?php echo base_url().'index.php/UserSettings/userDeleteAccountView'; ?>" > Delete account</a></br>
          
          
         <h3>Deliverer</h3> 
         
         <a href="<?php echo base_url().'index.php/Deliverer/delivererRegisterView'; ?>" >Deliverer Register</a></br>
         <a href="<?php echo base_url().'index.php/Deliverer/delivererLoginView'; ?>" >Deliverer login</a></br>
         <a href="<?php echo base_url().'index.php/DelivererSettings/forgotPasswordView'; ?>" > Deliverer Forgot Password</a></br>
         <a href="<?php echo base_url().'index.php/Deliverer/updateStatusView'; ?>" > Update Status</a></br>
         <a href="<?php echo base_url().'index.php/DelivererSettings/changePasswordView'; ?>" > Change Password</a></br>
         <a href="<?php echo base_url().'index.php/Deliverer/orderRequestListView'; ?>" > Order Request List </a></br>
         <a href="<?php echo base_url().'index.php/Deliverer/orderRequestResponseView'; ?>" > Order Request Response </a></br>
         <a href="<?php echo base_url().'index.php/Deliverer/delOrderHistoryView'; ?>" > Del Order History </a></br>
         <a href="<?php echo base_url().'index.php/Deliverer/delAssignOrderView'; ?>" > Del Assign Order </a></br>
         <a href="<?php echo base_url().'index.php/Deliverer/delContactRequestView'; ?>" > Del contact request </a></br>
         <a href="<?php echo base_url().'index.php/Deliverer/delAllNotificationView'; ?>" > All notification </a></br>
         <a href="<?php echo base_url().'index.php/Deliverer/delResContactReqView'; ?>" > Del contact response </a></br>
         <a href="<?php echo base_url().'index.php/Deliverer/delStatusUpdateView'; ?>" > Del status update </a></br>
         <a href="<?php echo base_url().'index.php/DelivererInfo/delSignatureView'; ?>" > Del signature </a></br>
         <a href="<?php echo base_url().'index.php/DelivererInfo/delUpdateProfileView'; ?>" > Del update profile </a></br>
         <a href="<?php echo base_url().'index.php/DelivererInfo/delivererLogoutView'; ?>" > Deliverer logout </a></br>
         <a href="<?php echo base_url().'index.php/DelivererSettings/delDeleteAccountView'; ?>" > Delete Account</a></br>
         <a href="<?php echo base_url().'index.php/DelivererSettings/delContactUsView'; ?>" > Deliverer Contact Us </a></br>
         
	</div>
</div>
</body>
</html>