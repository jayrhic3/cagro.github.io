<?php
include('connection.php');
session_start();

        $id=$_POST['user_id'];
		$operation=$_POST['operation'];
		$date_s=$_POST['date_s'];
        $date_e=$_POST['date_e'];
        $area=$_POST['area'];
		$operator=$_POST['operator'];
        $stat=$_POST['stat'];

		$query="UPDATE record_assistance_beneficiary SET operation = '$operation',date_started='$date_s', 
		date_ended ='$date_e',area='$area',operator='$operator',status='$stat'
         WHERE service_id = '$id'";
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