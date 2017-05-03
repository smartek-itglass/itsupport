<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
    </head>
    
    <body style="padding:30px;">
         <form method="post" action="<?php echo base_url().'index.php/Order/orderHistory'; ?>">
             <table>
                
                <tr>
                   <td>user_id</td>
                   <td><input type="" name="user_id" value="" /></td>
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
                   <td><input type="submit" name="btn_register" value="Submit" /></td>
                <tr>
             </table>
         </form>
    </body>
</html>