<?php
include('connection.php');
if(isset($_POST["user_id"]))
{
    $output=array();
    $id=$_POST['user_id'];
    $query="SELECT t1.quantity as quantity,t2.product_name as prod,t1.status as status,t1.unique_id as unique_id,t2.quantity as quan FROM beneficiary_record_product as t1 inner join inventory_all_products as t2 on t1.product_id = t2.id WHERE t1.unique_id='$id'";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
        $output["quantity"] = $row["quantity"];
        $output["status"] = $row["status"];
		$output["unique_id"]=$row["unique_id"];
		$output["quan"] = $row["quan"];
		$output["prod"] = $row["prod"];
	}
	echo json_encode($output);
}
?>