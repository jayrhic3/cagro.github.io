<?php
include('connection.php');
include('function_agri_suplies.php');
$query = ''; 
$output = array();
$query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.id as ins,
t2.word_created as dates,t2.service_id as id,t2.created_at as dateni,t2.status as stat from 
beneficiaries as t1 inner join recent_request as t2 on t1.id = t2.beneficiary_id and t2.assistance_recieved ="Agri Supplies" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.status LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'group by t2.beneficiary_id ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'group by t2.beneficiary_id ORDER BY t2.created_at DESC ';
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
        /*
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
        
        $sub_array[] = '<button type="button" name="check" id="'.$row["ins"].'" class="btn btn-success btn-sm ti-plus check" data-toggle="modal" data-target="#userModal" > Type Product</button>';
        */
        $sub_array[] = '<button type="button" name="check" id="'.$row["ins"].'" class="btn btn-warning btn-sm ti-eye check"></button>';
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