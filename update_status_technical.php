<?php
include('connection.php');

        $id=$_POST['user_id'];
        $status=$_POST['status'];

		$query="UPDATE record_assistance_beneficiary SET status = '$status' WHERE service_id = '$id'";
		$statement = $connection->prepare($query);
        $result = $statement->execute();

        $query2="UPDATE recent_request SET status = '$status' WHERE service_id = '$id'";
		$statement2 = $connection->prepare($query2);
		$result2 = $statement2->execute();
		if(!empty($result))
		{
			echo 'Succesfully Updated';
		}else{
			echo "wrong";
		}
	
?>