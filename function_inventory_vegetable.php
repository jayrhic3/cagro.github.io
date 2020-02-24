<?php


function get_total_all_records()
{
	include('connection.php');
	$statement = $connection->prepare("SELECT * FROM inventory_all_products where type_product='Vegetables_Seedlings/Seeds'");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>