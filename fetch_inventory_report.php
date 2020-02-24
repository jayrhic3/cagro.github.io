<?php
include('connection.php');
include('function_inventory_report.php');
$query = ''; 
$output = array();
$status=$_POST['status'];
$status_r=$_POST['status_r'];
$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];

if($status=='All'&&$status_r=='Latest'&&$datefrom==''&&$dateto==''){
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
inventory_all_products where status_updated="Latest") as t2 ';

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
        $sub_array[] = $row["units"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
        $sub_array[] = $row["dates"];
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
else if($status=='All'&&$status_r=='Old'&&$datefrom==''&&$dateto==''){
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
inventory_all_products where status_updated="Old") as t2 ';

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
        $sub_array[] = $row["units"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
        $sub_array[] = $row["dates"];
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
else if($status=='All'&&$status_r=='Summary'&&$datefrom==''&&$dateto==''){
    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));
$query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
sum(quantity) as quan,sum(despensed) as despense,status as stat,id as d,created_at as created from 
inventory_all_products group by product_name,units) as t2 ';

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
        $sub_array[] = $row["units"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
        $sub_array[] = $cdate;
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
else if($status!='All'&&$status_r=='Latest'&&$datefrom==''&&$dateto==''){
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
    inventory_all_products where status_updated="Latest" and type_product="'.$status.'") as t2 ';

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
        $sub_array[] = $row["units"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
        $sub_array[] = $row["dates"];
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
else if($status!='All'&&$status_r=='Old'&&$datefrom==''&&$dateto==''){
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
    inventory_all_products where status_updated="Old" and type_product="'.$status.'") as t2 ';

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
        $sub_array[] = $row["units"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
        $sub_array[] = $row["dates"];
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
else if($status!='All'&&$status_r=='Summary'&&$datefrom==''&&$dateto==''){
    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));
$query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
sum(quantity) as quan,sum(despensed) as despense,status as stat,id as d,created_at as created from 
inventory_all_products where type_product="'.$status.'" group by product_name,units) as t2 ';

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
        $sub_array[] = $row["units"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
        $sub_array[] = $cdate;
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
else if($status=='All'&&$status_r=='Latest'&&$datefrom!=''&&$dateto!=''){
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
inventory_all_products where status_updated="Latest" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t2 ';

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
        $sub_array[] = $row["units"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
        $sub_array[] = $row["dates"];
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
if($status=='All'&&$status_r=='Old'&&$datefrom!=''&&$dateto!=''){
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
inventory_all_products where status_updated="Old" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t2 ';

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
        $sub_array[] = $row["units"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
        $sub_array[] = $row["dates"];
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
if($status=='All'&&$status_r=='Summary'&&$datefrom!=''&&$dateto!=''){
    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
    sum(quantity) as quan,sum(despensed) as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'" group by product_name,units) as t2 ';

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
        $sub_array[] = $row["units"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
        $sub_array[] = $cdate;
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
else if($status!='All'&&$status_r=='Latest'&&$datefrom!=''&&$dateto!=''){
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
inventory_all_products where type_product="'.$status.'" and status_updated="Latest" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t2 ';

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
        $sub_array[] = $row["units"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
        $sub_array[] = $row["dates"];
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
else if($status!='All'&&$status_r=='Old'&&$datefrom!=''&&$dateto!=''){
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
inventory_all_products where type_product="'.$status.'" and status_updated="Old" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t2 ';

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
        $sub_array[] = $row["units"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
        $sub_array[] = $row["dates"];
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
if($status!='All'&&$status_r=='Summary'&&$datefrom!=''&&$dateto!=''){
    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
    sum(quantity) as quan,sum(despensed) as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="'.$status.'" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'" group by product_name,units) as t2 ';

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
        $sub_array[] = $row["units"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
        $sub_array[] = $cdate;
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
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.unit_description as unit_desc,t2.unit_quantity as unit_qty,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,unit_description as unit_description,unit_quantity as unit_quantity,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="'.$status.'") as t2 ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.unit_description LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.unit_quantity LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["unit_desc"];
        $sub_array[] = $row["units"];
        $sub_array[] = $row["unit_qty"];
        $sub_array[] = $row["quantity"];
        $sub_array[] = $row["despensed"];
        $sub_array[]=$row["quantity"]+$row["despensed"];
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