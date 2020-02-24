<?php
include('connection.php');
session_start();

        $id=$_POST['user_id'];
		$farm=$_POST['farm'];
		$coor=$_POST['coor'];
		$sched=$_POST['sched'];
		$_SESSION['id_farm']=$id;

		$query="UPDATE record_assistance_beneficiary SET farm_site = '$farm',coordinate='$coor', 
		tentative ='$sched'  WHERE service_id = '$id'";
		$statement = $connection->prepare($query);
		$result = $statement->execute();
		if(!empty($result))
		{
			echo 'Updated Succesfully!';
		}else{
			echo "Unsuccessful!";
		}
	
?>