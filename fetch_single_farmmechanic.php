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
		$output["coor"] = $row["coordinate"];
		$output["sched"] = $row["tentative"];
    }
	echo json_encode($output);
}
?>