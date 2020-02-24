<?php
session_start();
include('connection.php');
include('function_service_request.php');
$query = ''; 
$output = array();
$id=$_SESSION['beneficiary_id'];
$query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.ser_id as ins,
t1.request_id as id,t1.word_created as dates,t1.created_at as dateni,t1.status as stat from (select t1.firstname as firstname,
t1.lastname as lastname,t1.middlename as middlename,t2.created_at as created_at,t2.ser_id as ser_id,t2.request_id as request_id,
t2.word_created as word_created,t2.status as status from beneficiaries as t1 inner join record_services_beneficiary as t2 
on t1.id=t2.beneficiary_id where t2.beneficiary_id="'.$id.'" group by t2.request_id) as t1 ';
if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= 'ORDER BY t1.created_at desc ';
    
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
        if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
        $sub_array[] = $row["dates"];
        $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" value="'.$row["ins"].'" class="btn btn-warning btn-sm ti-eye check" data-toggle="modal" data-target="#userModal"></button>';
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