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
			echo 'Updated Succesfully!';
		}else{
			echo "Unsuccessful!";
		}
	
?>