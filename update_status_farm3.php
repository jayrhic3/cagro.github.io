<?php
include('connection.php');
session_start();

        $id=$_POST['user_id'];
		$resched=$_POST['resched'];
		$reason=$_POST['reason'];
        $stat=$_POST['stat'];

		$query="UPDATE record_assistance_beneficiary SET resched = '$resched',reason='$reason',
        status='$stat' WHERE service_id = '$id'";
		$statement = $connection->prepare($query);
        $result = $statement->execute();

        $query2="UPDATE recent_request SET status='$stat'
         WHERE service_id = '$id'";
		$statement2 = $connection->prepare($query2);
        $result2 = $statement2->execute();

		if(!empty($result2))
		{
			echo 'Succesfully Updated';
		}else{
			echo "wrong";
		}
	
?>