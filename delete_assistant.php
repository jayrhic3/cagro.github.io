<?php

include('connection.php');

if(isset($_POST["user_id"]))
{
	
	$statement = $connection->prepare(
		"DELETE FROM record_assistance_beneficiary WHERE service_id = :id"
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