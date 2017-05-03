<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
    </head>
    
    <body style="padding:30px;">
         <form method="post" action="<?php echo base_url().'index.php/Order/placeOrder'; ?>">
             <table>
                
                <tr>
                   <td>user_id</td>
                   <td><input type="" name="user_id" value="" /></td>
                <tr>
                <tr>
                   <td>restaurant_id</td>
                   <td><input type="" name="restaurant_id" value="" /></td>
                <tr>
                <tr>
                   <td>order_date</td>
                   <td><input type="" name="order_date" value="" /></td>
                <tr>
                <tr>
                   <td>order_time</td>
                   <td><input type="" name="order_time" value="" /></td>
                <tr>
                <tr>
                   <td>flat_no</td>
                   <td><input type="" name="flat_no" value="" /></td>
                <tr>
                <tr>
                   <td>street</td>
                   <td><input type="" name="street" value="" /></td>
                <tr>
                <tr>
                   <td>address</td>
                   <td><input type="" name="address" value="" /></td>
                <tr>
                <tr>
                   <td>landmark</td>
                   <td><input type="" name="landmark" value="" /></td>
                <tr>
                <tr>
                   <td>zipcode</td>
                   <td><input type="" name="zipcode" value="" /></td>
                <tr>
                <tr>
                   <td>latitude</td>
                   <td><input type="" name="latitude" value="" /></td>
                <tr>									
                <tr>
                   <td>longitude</td>
                   <td><input type="" name="longitude" value="" /></td>
                <tr>
                
                <tr>
                   <td>delivery_instruction</td>
                   <td><input type="" name="delivery_instruction" value="" /></td>
                <tr>
                <tr>
                   <td>estm_time</td>
                   <td><input type="" name="estm_time" value="" /></td>
                <tr>
                <tr>
                   <td>coupon_code</td>
                   <td><input type="" name="coupon_code" value="" /></td>
                <tr>
                <tr>
                   <td>discount_amount</td>
                   <td><input type="" name="discount_amount" value="" /></td>
                <tr>
                <tr>
                   <td>tax</td>
                   <td><input type="" name="tax" value="" /></td>
                <tr>
                <tr>
                   <td>total_amount</td>
                   <td><input type="" name="total_amount" value="" /></td>
                <tr>
                <tr>
                   <td>payment_type</td>
                   <td><input type="" name="payment_type" value="" /></td>
                <tr>
                <tr>
                   <td>payment_detail</td>
                   <td><input type="" name="payment_detail" value='[{"amount":"100","is_split":"0","paypal_id":"2666","transaction_id":"2666","payment_status":"1"},{"amount":"200","is_split":"0","paypal_id":"1565","transaction_id":"2666","payment_status":"1"}]' /></td>
                <tr>		
                <tr>
                   <td>item_list</td>
                   <td><input type="" name="item_list" value='[{"food_item_id":"1","price":"40","quantity":"2"},{"food_item_id":"2","price":"90","quantity":"1"}]' /></td>
                <tr>
                
               
                <tr>
                   <td><input type="submit" name="btn_register" value="Submit" /></td>
                <tr>
             </table>
         </form>
    </body>
</html>