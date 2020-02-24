<?php
include('connection.php');
include('function_inventory_organic.php');
$query = ''; 
$output = array();
$query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
quantity as quan,despensed as despense,status as stat,id as d,created_at as created from 
inventory_all_products where status!="Available") as t2 ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t2.created DESC ';
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
        $sub_array[] = $row["product_name"];
        $sub_array[] = $row["quantity"];
        if($row["quantity"]>20){
            $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
        }else if($row["quantity"]<=0){
            $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
        }else if($row["quantity"]>0 && $row["quantity"]<=20){
            $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
        }
          
        $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil check" data-toggle="modal" data-target="#userModal"></button>';
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