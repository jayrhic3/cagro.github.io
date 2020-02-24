<?php
include('connection.php');
if(isset($_POST["user_id"]))
{
	$output1 = '';
	$output2 = '';
	$output=array();
    $id=$_POST['user_id'];
    $query="SELECT * FROM request_services WHERE request_id='$id'";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output1.= $row["service_recieved"].",";
		
	}

	$query2="SELECT * FROM request_services WHERE request_id='$id'";
	$statement2 = $connection->prepare($query2);
	$statement2->execute();
	$result2 = $statement2->fetchAll();
	foreach($result2 as $row2)
	{
		$output2.= $row2["service_id"].",";
		
	}

	$output["assistant"]=$output1;
	$output["service"]=$output2;

	echo json_encode($output);
}
?>