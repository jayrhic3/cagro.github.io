<?php

include('connection.php');

if(isset($_POST["user_id"]))
{
    $id=$_POST['user_id'];
    $query2="DELETE FROM record_assistance_beneficiary WHERE beneficiary_id = '$id'";
    $statement2 = $connection->prepare($query2);
    $statement2->execute();
	
	$statement = $connection->prepare(
		"DELETE FROM recent_request WHERE created_at = :id"
	);
	$result = $statement->execute(
		array(
			':id'	=>	$_POST["user_id"]
		)
	);
	
	if(!empty($result))
	{
		echo 'Data Deleted';
    }
    
   
}



?>