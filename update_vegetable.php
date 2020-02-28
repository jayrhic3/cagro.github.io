<?php
include('connection.php');

        $id=$_POST['cid'];
        $product_name=$_POST['product_name'];
        $unit=$_POST['unit'];
        $quantity=$_POST['quantity'];

        $query2="UPDATE inventory_all_products SET product_name = '$product_name',units='$unit',quantity='$quantity' WHERE id = '$id'";
		$statement2 = $connection->prepare($query2);
		$result2 = $statement2->execute();
		if(!empty($result2))
		{
			echo 'Succesfully Updated';
		}else{
			echo "wrong";
		}
	/*
		$id=$_POST['cid'];
        $product_name=$_POST['product_name'];
        $unit=$_POST['unit'];
		$quantity=$_POST['quantity'];
		
		$query1="UPDATE inventory_all_products set status_updated='old' WHERE id = '$id' ";
		$statement1 = $connection->prepare($query1);
		$result1 = $statement1->execute();

		$query = "INSERT INTO inventory_all_products 
		(product_name, units , quantity,despensed,type_product,status_updated) 
		VALUES ('$product_name','$unit','$quantity','0','Vegetables_Seedlings/Seeds','latest')";
		$statement = $connection->prepare($query);
		$result = $statement->execute();
		if(!empty($result))
		{
			echo 'Succesfully Updated';
		}else{
			echo "wrong";
		}
		*/
?>