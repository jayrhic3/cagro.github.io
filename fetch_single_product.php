<?php
include('connection.php');
if(isset($_POST["user_id"]))
{
    $output=array();
    $id=$_POST['user_id'];
    $query="SELECT * FROM beneficiary_record_product WHERE unique_id='$id'";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
        $output["quantity"] = $row["quantity"];
        $output["status"] = $row["status"];
        $output["unique_id"]=$row["unique_id"];
	}
	echo json_encode($output);
}
?>