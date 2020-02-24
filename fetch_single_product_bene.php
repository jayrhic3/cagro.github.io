<?php
session_start();

include('connection.php');
include('function_single_product.php');

$id="";
$id.="".$_SESSION['single_id'];
$type=$_POST['type'];

if($type=='All'){
$query = ''; 
$output = array();
$query .= 'SELECT t2.product_name as product_name,t2.units as unit,t1.quantity as quantity,
t1.word_created as word,t1.created_at as created,t1.unique_id as id,t2.id as idni,t1.status as stat from inventory_all_products as t2
 inner join beneficiary_record_product as t1 on t2.id=t1.product_id and
  t1.request_id="'.$id.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.units LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = '<div  class="update" data-id="'.$row["id"].'" data-column="product_name">' . $row["product_name"] . '</div>';
        $sub_array[] = '<div  class="update" data-id="'.$row["id"].'" data-column="unit">' . $row["unit"] . '</div>';
        $sub_array[] = '<div  class="update" data-id="'.$row["id"].'" data-column="quantity">' . $row["quantity"] . '</div>';
        if($row['stat']=='On Going'){
            $sub_array[] = '<div style="background-color:yellow" class="update" data-id="'.$row["id"].'" data-column="stat">' . $row["stat"] . '</div>';
        }else if($row['stat']=='Done'){
            $sub_array[] = '<div style="background-color:yellowgreen" class="update" data-id="'.$row["id"].'" data-column="stat">' . $row["stat"] . '</div>';
        }else if($row['stat']=='Pending'){
            $sub_array[] = '<div style="background-color:pink" class="update" data-id="'.$row["id"].'" data-column="stat">' . $row["stat"] . '</div>';
        }else if($row['stat']=='Cancel'){
            $sub_array[] = '<div style="background-color:red" class="update" data-id="'.$row["id"].'" data-column="stat">' . $row["stat"] . '</div>';
        }
        $sub_array[] = '<div  class="update" data-id="'.$row["id"].'" data-column="word">' . $row["word"] . '</div>';
        if($row['stat']=='Done'){
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil view" data-toggle="modal" data-target="#userModal3" disabled></button>';
        }else{
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil view" data-toggle="modal" data-target="#userModal3"></button>';
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

}else{
$query = ''; 
$output = array();
$query .= 'SELECT t2.product_name as product_name,t2.units as unit,t1.quantity as quantity,
t1.word_created as word,t1.created_at as created,t1.unique_id as id,t2.id as idni,t1.status as stat from inventory_all_products as t2
 inner join beneficiary_record_product as t1 on t2.id=t1.product_id and
  t1.request_id="'.$id.'" and t2.type_product="'.$type.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.units LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = '<div  class="update" data-id="'.$row["id"].'" data-column="product_name">' . $row["product_name"] . '</div>';
        $sub_array[] = '<div  class="update" data-id="'.$row["id"].'" data-column="unit">' . $row["unit"] . '</div>';
        $sub_array[] = '<div  class="update" data-id="'.$row["id"].'" data-column="quantity">' . $row["quantity"] . '</div>';
        if($row['stat']=='On Going'){
            $sub_array[] = '<div style="background-color:yellow" class="update" data-id="'.$row["id"].'" data-column="stat">' . $row["stat"] . '</div>';
        }else if($row['stat']=='Done'){
            $sub_array[] = '<div style="background-color:yellowgreen" class="update" data-id="'.$row["id"].'" data-column="stat">' . $row["stat"] . '</div>';
        }else if($row['stat']=='Pending'){
            $sub_array[] = '<div style="background-color:pink" class="update" data-id="'.$row["id"].'" data-column="stat">' . $row["stat"] . '</div>';
        }else if($row['stat']=='Cancel'){
            $sub_array[] = '<div style="background-color:red" class="update" data-id="'.$row["id"].'" data-column="stat">' . $row["stat"] . '</div>';
        }
        $sub_array[] = '<div  class="update" data-id="'.$row["id"].'" data-column="word">' . $row["word"] . '</div>';
        if($row['stat']=='Done'){
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil view" data-toggle="modal" data-target="#userModal3" disabled></button>';
        }else{
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil view" data-toggle="modal" data-target="#userModal3"></button>';
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

}








/*
$connect = mysqli_connect("localhost", "root", "", "cagro");
$columns = array('num', 'qty','unit','item_description','created_at');
session_start();
$id=$_SESSION['single_id'];
echo $id;
$query = "SELECT * FROM beneficiary_record_product WHERE request_id=$id";


$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["request_id"].'" data-column="first_name">' . $row["num"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["request_id"].'" data-column="first_name">' . $row["qty"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["request_id"].'" data-column="last_name">' . $row["unit"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["request_id"].'" data-column="first_name">' . $row["item_description"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["request_id"].'" data-column="first_name">' . $row["created_at"] . '</div>';
 $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["request_id"].'">Delete</button>';
 $data[] = $sub_array;
}

function get_all_data($connect,$id)
{
 $query = "SELECT * FROM beneficiary_record_product WHERE request_id=$id";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect,$id),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);
*/

?>