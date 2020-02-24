<?php
include('connection.php');
if(isset($_POST["user_id"]))
{
    $output=array();
    $id=$_POST['user_id'];
    $query="SELECT * FROM record_assistance_beneficiary WHERE service_id='$id'";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output["farm"] = $row["farm_site"];
		$output["status"] = $row["status"];
		$output["operation"] = $row["operation"];
		$output["date_started"] = $row["date_started"];
		$output["date_ended"] = $row["date_ended"];
		$output["area"] = $row["area"];
		$output["operator"] = $row["operator"];
		$output["resched"] = $row["resched"];
		$output["reason"] = $row["reason"];
    }
	echo json_encode($output);
}
?>