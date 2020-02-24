<?php
session_start();
include('connection.php');
include('function_transactions.php');
$status=$_POST['status'];
$query = ''; 
$output = array();
if($status=='All'){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t2.product_name as product,t3.created_at as creat,
    t3.quantity as quan,t3.status as stat,t3.word_created as word from beneficiaries as t1 inner join 
    beneficiary_record_product as t3 inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id 
    and t2.id=t3.product_id ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t3.status LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
    }
    if(isset($_POST["order"]))
    {
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY t3.created_at desc ';
        
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
            $sub_array[] = $row["product"];
            $sub_array[] = $row["quan"];
            if($row['stat']=='On Going'){
                $sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
            }elseif($row['stat']=='Pending'){
                $sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
            }elseif($row['stat']=='Done'){
                $sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
            }elseif($row['stat']=='Cancel'){
                $sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
            }
            $sub_array[] = $row["word"];
            $data[] = $sub_array;
        }
    
    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"		=> 	$filtered_rows,
        "recordsFiltered"	=>	get_total_all_records(),
        "data"				=>	$data
    );
    echo json_encode($output);
}else{
$query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t2.product_name as product,t3.created_at as creat,
t3.quantity as quan,t3.status as stat,t3.word_created as word from beneficiaries as t1 inner join 
beneficiary_record_product as t3 inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id 
and t2.id=t3.product_id and t3.status="'.$status.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.status LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= 'ORDER BY t3.created_at desc ';
    
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
        $sub_array[] = $row["product"];
        $sub_array[] = $row["quan"];
        if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
        $sub_array[] = $row["word"];
        $data[] = $sub_array;
    }

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records(),
	"data"				=>	$data
);
echo json_encode($output);
}

?>