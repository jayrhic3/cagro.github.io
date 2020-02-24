<?php
include('connection.php');
if(isset($_POST["user_id"]))
{
	$output = array();
	$statement = $connection->prepare(
		"SELECT * FROM beneficiaries 
		WHERE id = '".$_POST["user_id"]."' 
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output["lastname"] = $row["lastname"];
		$output["firstname"] = $row["firstname"];
		$output["middlename"] = $row["middlename"];
        $output["purok"] = $row["purok"];
        $output["barangay"] = $row["barangay"];
        $output["mobnum"] = $row["mobnum"];
        $output["beneficiary_type"] = $row["beneficiary_type"];
        $output["mucipality"] = $row["mucipality"];
        $output["gender"] = $row["gender"];
        $output["bday"] = $row["bday"];
        $output["province"] = $row["province"];
		$output["personnel"] = $row["personnel"];
		$output["pagibig"] = $row["pag_ibig"];
		$output["phil"] = $row["phil"];
		$output["other_id"] = $row["other_id"];
		
	}
	echo json_encode($output);
}
?>