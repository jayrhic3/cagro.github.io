<?php
include('connection.php');

		$id=$_POST['cid'];
        $product_name=$_POST['product_name'];
        $unit=$_POST['unit'];
		$quantity=$_POST['quantity'];
		$date=date('Y-m-d H:i:s');
		$cdate=date('F j, Y',strtotime($date));
		
		$query1="UPDATE inventory_all_products set status_updated='Old' WHERE id = '$id' ";
		$statement1 = $connection->prepare($query1);
		$result1 = $statement1->execute();

		$query = "INSERT INTO inventory_all_products 
		(product_name, units , quantity,despensed,type_product,status_updated,word_created) 
		VALUES ('$product_name','$unit','$quantity','0','Corn_Seeds','Latest','$cdate')";
		$statement = $connection->prepare($query);
		$result = $statement->execute();
		if(!empty($result))
		{
			echo 'Succesfully Renew';
		}else{
			echo "wrong";
		}
?>