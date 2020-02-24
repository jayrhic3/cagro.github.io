<?php
include('connection.php');
include('function_planning_beneficiary_report.php');
$query = ''; 
$output = array();

$barangay=$_POST['barangay'];
$muni=$_POST['muni'];
$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];

if($muni=='All' && $barangay=='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
    t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
    t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
    t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3 
    inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id) as t1 ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["lastname"];
        $sub_array[] = $row["firstname"];
        $sub_array[] = $row["product_name"];
        $sub_array[]=$row["dates"];
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
else if($muni!='All' && $barangay=='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
    t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
    t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
    t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3 
    inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id and 
    t1.mucipality="'.$muni.'") as t1 ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["lastname"];
        $sub_array[] = $row["firstname"];
        $sub_array[] = $row["product_name"];
        $sub_array[]=$row["dates"];
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
else if($muni!='All' && $barangay!='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
    t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
    t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
    t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3 
    inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id and 
    t1.barangay="'.$barangay.'") as t1 ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["lastname"];
        $sub_array[] = $row["firstname"];
        $sub_array[] = $row["product_name"];
        $sub_array[]=$row["dates"];
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
else if($muni=='All' && $barangay=='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
    t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
    t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
    t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3 
    inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id and 
    date_format(t3.created_at,"%Y-%m-%d") between "'.$datefrom.'" and "'.$dateto.'") as t1 ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["lastname"];
        $sub_array[] = $row["firstname"];
        $sub_array[] = $row["product_name"];
        $sub_array[]=$row["dates"];
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
else if($muni!='All' && $barangay=='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
    t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
    t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
    t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3 
    inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id and 
    date_format(t3.created_at,"%Y-%m-%d") between "'.$datefrom.'" and "'.$dateto.'" and t1.mucipality="'.$muni.'") as t1 ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["lastname"];
        $sub_array[] = $row["firstname"];
        $sub_array[] = $row["product_name"];
        $sub_array[]=$row["dates"];
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
else if($muni!='All' && $barangay!='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
    t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
    t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
    t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3 
    inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id and 
    date_format(t3.created_at,"%Y-%m-%d") between "'.$datefrom.'" and "'.$dateto.'" and t1.barangay="'.$barangay.'") as t1 ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["lastname"];
        $sub_array[] = $row["firstname"];
        $sub_array[] = $row["product_name"];
        $sub_array[]=$row["dates"];
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
else{
    $query .= ' SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
    t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
    t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
    t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3
     inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id where 
     t1.barangay="'.$barangay.'") as t1 ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["lastname"];
        $sub_array[] = $row["firstname"];
        $sub_array[] = $row["product_name"];
        $sub_array[]=$row["dates"];
        $data[] = $sub_array;
    }

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records(),
	"data"				=>	$data
);
echo json_encode($output);
}/*
else if($datefrom==''&&$dateto==''&&$id!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.type_product as type,
    t1.product_name as product,t1.quantity as quantity,t1.created_at as created,t1.word_created as cre 
    from (select t1.lastname as lastname,t1.firstname as firstname,t2.type_product as type_product,
    t2.product_name as product_name,t3.quantity as quantity,t3.created_at as created_at,
    t3.word_created as word_created from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id 
    where t3.beneficiary_id="'.$id.'") as t1 ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["lastname"];
        $sub_array[] = $row["firstname"];
        $sub_array[] = $row["type"];
        $sub_array[] = $row["product"];
        $sub_array[]=$row["quantity"];
        $sub_array[]=$row["cre"];
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
else if($datefrom!=''&&$dateto!=''&&$id!=''&&$status!='All'){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.type_product as type,
    t1.product_name as product,t1.quantity as quantity,t1.created_at as created,t1.word_created as cre 
    from (select t1.lastname as lastname,t1.firstname as firstname,t2.type_product as type_product,
    t2.product_name as product_name,t3.quantity as quantity,t3.created_at as created_at,
    t3.word_created as word_created from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id 
    where t3.beneficiary_id="'.$id.'" and date_format(t3.created_at,"%Y-%m-%d") between "'.$datefrom.'" and "'.$dateto.'") as t1 ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["lastname"];
        $sub_array[] = $row["firstname"];
        $sub_array[] = $row["type"];
        $sub_array[] = $row["product"];
        $sub_array[]=$row["quantity"];
        $sub_array[]=$row["cre"];
        $data[] = $sub_array;
    }

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records(),
	"data"				=>	$data
);
echo json_encode($output);
}*/
?>