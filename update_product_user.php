<?php
include('connection.php');

        $id=$_POST['id_product'];
        $status=$_POST['status'];
        $quantity=$_POST['quantity'];

        $query2="UPDATE beneficiary_record_product SET quantity = '$quantity',status='$status' WHERE unique_id = '$id'";
		$statement2 = $connection->prepare($query2);
		$result2 = $statement2->execute();
		if(!empty($result2))
		{
			echo 'Updated Succesfully!';
		}else{
			echo "Unsuccessful!";
		}
	
?>