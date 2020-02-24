<?php
include('connection.php');
if(isset($_POST["id"]))
{
    $output = array();
	$statement = $connection->prepare(
		"SELECT * FROM users 
		WHERE id = '".$_POST["id"]."' 
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output["image"]= $row["profiles"];
		$output["id"]= $row["id"];
		$output["username"]= $row["username"];
		$output["position"]= $row["position"];
		$output["firstname"]= $row["firstname"];
		$output["lastname"]= $row["lastname"];
		$output["middlename"]= $row["middlename"];
		$output["purok"]= $row["purok"];
		$output["barangay"]= $row["barangay"];
		$output["municipality"]= $row["municipality"];
		$output["bday"]= $row["bday"];
		$output["mobnum"]= $row["mobnum"];
		$output["gender"]= $row["gender"];
		
	}
	echo json_encode($output);
}
?>