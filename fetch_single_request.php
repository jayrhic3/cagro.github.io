<?php
include('connection.php');
if(isset($_POST["user_id"]))
{
	$output1 = '';
	$output=array();
    $id=$_POST['user_id'];
    $query="SELECT * FROM recent_request WHERE request_id='$id'";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output1.= $row["assistance_recieved"].",";
		
	}

	$output["assistant"]=$output1;
	echo json_encode($output);
}
?>