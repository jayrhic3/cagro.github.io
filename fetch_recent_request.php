<?php
include('connection.php');
include('function_recent.php');
$query = ''; 
$output = array();
$query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as mid,t1.id as ins,t2.request_id as id,t2.word_created as dates
from beneficiaries as t1 inner join recent_request as t2 on t1.id=t2.beneficiary_id ';
if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'group by t1.id ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= 'group by t1.id ORDER BY t2.created_at DESC ';
    
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
        $sub_array[] = $row["mid"];
        $sub_array[] = '<button type="button" name="check" id="'.$row["ins"].'" class="btn btn-warning btn-sm ti-eye view_single"></button>';
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