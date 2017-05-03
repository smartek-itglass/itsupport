<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
    </head>
    
    <body style="padding:30px;">
         <form method="post" action="<?php echo base_url().'index.php/User/restaurantList'; ?>">
             <table>
                <tr>
                   <td>user_id</td>
                   <td><input type="" name="user_id" value="" /></td>
                <tr>
                <tr>
                   <td>city_id</td>
                   <td><input type="" name="city_id" value="" /></td>
                <tr>
                <tr>
                   <td>area_id</td>
                   <td><input type="" name="area_id" value="" /></td>
                <tr>
                <tr>
                   <td>text</td>
                   <td><input type="" name="text" value="" /></td>
                <tr>
                <tr>
                   <td>sort_by</td>
                   <td>
                   	<select name="sort_by" >
                   		<option value="" >select</option>
                   		<option value="nearest" >nearest</option>
                   		<option value="farthest" >farthest</option>
                   		<option value="low" >low</option>
                   		<option value="high" >high</option>
                   	</select>
                   </td>
                <tr>
                <tr>
                   <td>max_price</td>
                   <td><input type="" name="max_price" value="" /></td>
                <tr>
                <tr>
                   <td>min_price</td>
                   <td><input type="" name="min_price" value="" /></td>
                <tr>
                <tr>
                   <td>food category</td>
                   <td><input type="" name="food_category" value='[{"food_cat_id":"1"},{"food_cat_id":"2"},{"food_cat_id":"3"}]' /></td>
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
                   <td>page_no</td>
                   <td><input type="" name="page_no" value="" /></td>
                <tr>
                <tr>
                   <td>limit</td>
                   <td><input type="" name="limit" value="" /></td>
                <tr>
                <tr>
                   <td><input type="submit" name="submit" value="Submit" /></td>
                <tr>
             </table>
         </form>
    </body>
</html>