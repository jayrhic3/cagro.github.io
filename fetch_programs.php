<?php
include('connection.php');
include('function_programs.php');
$query = ''; 
$output = array();
$query .= 'SELECT * from project_program ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE title LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR start_event LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR start_event_word LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR end_event_word LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER by start_event DESC ';
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
        $sub_array[] = $row["title"];
        $dates=date('F j, Y',strtotime($row["start_event"]));
        $sub_array[] = $dates;
        $datee=date('F j, Y',strtotime($row["end_event"]));
        $sub_array[] = $datee;
        $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-eye check" data-toggle="modal" data-target="#userModal"></button><button type="button" name="update" id="'.$row["id"].'" class="btn btn-danger ti-trash btn-sm delete" ></button>';
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