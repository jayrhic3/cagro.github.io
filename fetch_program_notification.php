<?php
include('connection.php');
include('function_programs_notification.php');
$query = ''; 
$output = array();
$query .= 'SELECT * from notification ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE title LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR start_event LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR event_status LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY event_status DESC ';
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
        if($row['event_status']=='Unread'){
			$sub_array[] = '<b><p style="color:red"> '.$row["event_status"].'</p></b>';
		}elseif($row['event_status']=='Read'){
            $sub_array[] = '<b><p style="color:yellowgreen"> '.$row["event_status"].'</p></b>';
        }
        $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-eye check" ></button>';
        
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