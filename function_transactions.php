<?php


function get_total_all_records()
{
	include('connection.php');
	$statement = $connection->prepare("SELECT * FROM beneficiary_record_product");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>