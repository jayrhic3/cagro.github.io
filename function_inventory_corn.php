<?php


function get_total_all_records()
{
	include('connection.php');
	$statement = $connection->prepare("SELECT * FROM inventory_all_products WHERE type_product='Corn_Seeds'");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>