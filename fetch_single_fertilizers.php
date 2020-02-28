<?php
include('connection.php');
if(isset($_POST["user_id"]))
{
    $output=array();
    $id=$_POST['user_id'];
    $query="SELECT * FROM inventory_all_products WHERE id=$id";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
        $output["product_name"] = $row["product_name"];
        $output["units"] = $row["units"];
        $output["quantity"] = $row["quantity"];
        $output["xdate"] = $row["expiry_date"];
        $output["id"]=$row["id"];
	}
	echo json_encode($output);
}
?>