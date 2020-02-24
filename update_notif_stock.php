<?php
include('connection.php');

        $id=$_POST['cid'];
        $quantity=$_POST['quantity'];

        $query2="UPDATE inventory_all_products SET quantity='$quantity' WHERE id = '$id'";
		$statement2 = $connection->prepare($query2);
		$result2 = $statement2->execute();
		if(!empty($result2))
		{
			echo 'Succesfully Updated';
		}else{
			echo "wrong";
		}
	
?>