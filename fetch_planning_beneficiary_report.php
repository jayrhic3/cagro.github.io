<?php
include('connection.php');
include('function_planning_beneficiary_report.php');
$query = ''; 
$output = array();

$status=$_POST['status'];
$prod=$_POST['prod'];
$type=$_POST['type'];
$id=$_POST['id'];
$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];

if($status=='All' && $type=='All' && $prod=='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status!='All' && $type=='All' && $prod=='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id and t3.beneficiary_id="'.$id.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status!='All' && $type!='All' && $prod=='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id 
    and t3.beneficiary_id="'.$id.'" and t2.type_product="'.$type.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status=='All' && $type!='All' && $prod=='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
    and t2.type_product="'.$type.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status=='All' && $type=='All' && $prod!='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
    and t2.product_name="'.$prod.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status!='All' && $type=='All' && $prod!='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
    and t2.product_name="'.$prod.'" and t3.beneficiary_id="'.$id.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status=='All' && $type!='All' && $prod!='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
    and t2.product_name="'.$prod.'" and t2.type_product="'.$type.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status!='All' && $type!='All' && $prod!='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
    and t2.product_name="'.$prod.'" and t2.type_product="'.$type.'" and t3.beneficiary_id="'.$id.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status=='All' && $type=='All' && $prod=='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id and 
    date_format(t3.created_at,"%Y-%m-%d") between "'.$datefrom.'" and "'.$dateto.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status!='All' && $type=='All' && $prod=='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id and 
    t3.beneficiary_id="'.$id.'" and date_format(t3.created_at,"%Y-%m-%d") between "'.$datefrom.'" and "'.$dateto.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status!='All' && $type!='All' && $prod=='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id 
    and t3.beneficiary_id="'.$id.'" and t2.type_product="'.$type.'" and
    date_format(t3.created_at,"%Y-%m-%d") between "'.$datefrom.'" and "'.$dateto.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status=='All' && $type!='All' && $prod=='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
    and t2.type_product="'.$type.'" and date_format(t3.created_at,"%Y-%m-%d") between "'.$datefrom.'" and "'.$dateto.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status=='All' && $type=='All' && $prod!='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
    and t2.product_name="'.$prod.'" and date_format(t3.created_at,"%Y-%m-%d") between "'.$datefrom.'" and "'.$dateto.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status!='All' && $type=='All' && $prod!='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
    and t2.product_name="'.$prod.'" and t3.beneficiary_id="'.$id.'" and date_format(t3.created_at,"%Y-%m-%d") between
     "'.$datefrom.'" and "'.$dateto.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status=='All' && $type!='All' && $prod!='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
    and t2.product_name="'.$prod.'" and t2.type_product="'.$type.'" and
    date_format(t3.created_at,"%Y-%m-%d") between "'.$datefrom.'" and "'.$dateto.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
else if($status!='All' && $type!='All' && $prod!='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,
    t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
    t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
    and t2.product_name="'.$prod.'" and t2.type_product="'.$type.'" and t3.beneficiary_id="'.$id.'" and 
    date_format(t3.created_at,"%Y-%m-%d") between "'.$datefrom.'" and "'.$dateto.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.type_product LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.quantity LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t3.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY t3.created_at DESC ';
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
/*
else if($status=='All'&&$datefrom!=''&&$dateto!=''){
    $query .= 'SELECT t1.firstname as firstname,t1.lastname as lastname,t1.type_product as type,
    t1.product_name as product,t1.quantity as quantity,t1.created_at as created,t1.word_created as cre 
    from (select t1.firstname as firstname,t1.lastname as lastname,t2.type_product as type_product,
    t2.product_name as product_name,t3.quantity as quantity,t3.created_at as created_at,
    t3.word_created as word_created from beneficiaries as t1 inner join inventory_all_products as t2 
    inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id 
    where date_format(t3.created_at,"%Y-%m-%d") between "'.$datefrom.'" and "'.$dateto.'") as t1 ';

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
}
*/
?>