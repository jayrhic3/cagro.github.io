<?php
session_start();
include('connection.php');
include('function_farm_mechnization.php');
$query = ''; 
$output = array();

$id=$_SESSION['beneficiary_id'];
$query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.tentative as tenta,
t1.word_created as dates,t1.service_id as id,t1.id as userid,t1.created_at as dateni,t1.coordinate as coor,
t1.status as stat,t1.assistance_recieved as recev,t1.farm_site as farm_site from (select t1.lastname as lastname,t1.firstname as firstname,
t1.middlename as middlename,t2.word_created as word_created,t2.coordinate as coordinate,t2.tentative as tentative,t2.service_id as service_id,t1.id as id,
t2.created_at as created_at,t2.status as status,t2.farm_site as farm_site,t2.assistanced_received as assistance_recieved from beneficiaries as t1 inner join record_assistance_beneficiary as t2
 on t1.id=t2.beneficiary_id and t2.assistanced_received="Farm Mechanization" 
 where t2.beneficiary_id="'.$id.'") as t1 ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.status LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t1.created_at DESC ';
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
        $sub_array[] = $row["farm_site"];
        $sub_array[] = $row["coor"];
        if($row['tenta']=='0000-00-00'){
            $sub_array[] = '';
        }else{
            $sub_array[] = date('F j, Y',strtotime($row["tenta"]));
        }
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
        if($row["stat"]=='Done'){
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-eye showrecord"></button>';
        }else{
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil check" data-toggle="modal" data-target="#userModal"></button> <button type="button" name="check" id="'.$row["id"].'" class="btn btn-success btn-sm ti-eye show_update"></button>';
        }
        
        
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