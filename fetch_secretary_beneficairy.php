<?php
include('connection.php');
include('function_secretary_beneficiaries.php');
$query = '';
$output = array();
$query .= "SELECT * FROM beneficiaries ";
if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE lastname LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR firstname LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR middlename LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY created_at DESC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	
	$sub_array = array();
	$sub_array[] = $row["lastname"];
    $sub_array[] = $row["firstname"];
	$sub_array[] = $row["middlename"];
	$date=date('F j, Y',strtotime($row["created_at"]));
    $sub_array[] = $date;
	$sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning ti-eye btn-sm check"></button><button type="button" name="update" id="'.$row["id"].'" class="btn btn-success btn-sm ti-plus update" data-toggle="modal" data-target="#userModal"></button><button type="button" name="msg" id="'.$row["id"].'" class="btn btn-default btn-sm ti-comment msg"></button>';
	$data[] = $sub_array;
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records(),
	"data"				=>	$data
);
echo json_encode($output);
?>