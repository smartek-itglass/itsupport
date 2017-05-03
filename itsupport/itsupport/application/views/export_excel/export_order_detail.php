<?php 
    if(isset($data)){
       if(!empty($data)){
       	$filename = "order_detail.xls"; 
        $flag = false;
        //foreach($data as $val1){
            
            foreach ($data as $val) {
            	$restaurant_status = '';
				if($val['order_status_id'] < 1){
					 if($val['restaurant_status'] == 0){
					 	  $restaurant_status = 'Pending';
					 }elseif($val['restaurant_status'] == 2){
					 	  $restaurant_status = 'Rejected';
					 }
				}else{
					$restaurant_status = $val['order_status'];
				}
				if($val['is_canceled'] == 1){
					$restaurant_status = 'Canceled';
				}
               
                $arr = array(
                    'Order Id' => $val['order_id'],
                    'Order Date' => $val['order_date'],
                    'Customer Name' => $val['first_name'].' '.$val['last_name'],
                    'Restaurant Name' => $val['restaurant_name'],
                    'total_amount' => $val['total_amount'],
                    'order_status' => $restaurant_status
                   
                );
                if(!$flag){
                    // display field/column names as first row
                    echo implode("\t", array_keys($arr)) . "\r\n";
                    echo "\n";
                } 
                $flag = true;
                echo implode("\t", array_values($arr)) . "\r\n";
            }
            echo "\n";
        //}
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel");
    } } ?>
