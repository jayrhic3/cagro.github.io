<?php
session_start();
include('connection.php');

$year=$_POST['year'];
$type=$_POST['type'];
$yearf=$_POST['yearf'];
$yeart=$_POST['yeart'];
$datef=$_POST['datef'];
$datet=$_POST['datet'];

if($type=='Monthly'){

        include('function_chart_table.php');

        $query = ''; 
        $output = array();

        $query .= 'select t2.num as num,t2.created_at as created,t2.product_name as name,t2.type_product as type,t2.month as mon from (select sum(t2.quantity) as num,t2.created_at as created_at, t1.product_name as product_name,t1.type_product as type_product,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at) = "'.$year.'" group by month(t2.created_at),t1.type_product) as t2 ';

        if(isset($_POST["search"]["value"]))
        {
            $query .= 'WHERE t2.num LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR t2.month LIKE "%'.$_POST["search"]["value"].'%" ';
        }
        if(isset($_POST["order"]))
        {
            $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
            $query .= 'ORDER BY t2.created_at DESC ';
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
                $sub_array[] = '';
                $sub_array[] = '';
                $sub_array[] = date("F", mktime(0, 0, 0, $row['mon'], 10));
                $sub_array[] = $row["type"];
                $sub_array[] = '';
                $sub_array[] = $row["num"];
                $data[] = $sub_array;
            }

        $output = array(
            "draw"				=>	intval($_POST["draw"]),
            "recordsTotal"		=> 	$filtered_rows,
            "recordsFiltered"	=>	get_total_all_records(),
            "data"				=>	$data
        );

        echo json_encode($output);

}else if($type=='Yearly')
{
    include('function_chart_table.php');
    $query = ''; 
    $output = array();

    $query .= 'SELECT sum(t2.quantity) as num,t2.created_at as cre,t1.product_name as name,t1.type_product as type,year(t2.created_at) as year from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at) between "'.$yearf.'" and "'.$yeart.'" group by t1.type_product,year(t2.created_at) ';
    
    if(isset($_POST["order"]))
    {
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY t2.created_at DESC ';
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
            $sub_array[] = '';
            $sub_array[] = $row['year'];
            $sub_array[] = '';
            $sub_array[] = $row["type"];
            $sub_array[] = '';
            $sub_array[] = $row["num"];
            $data[] = $sub_array;
        }

    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"		=> 	$filtered_rows,
        "recordsFiltered"	=>	get_total_all_records(),
        "data"				=>	$data
    );
    echo json_encode($output);
}else if($type=='Customize')
{
    include('function_chart_table.php');
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.quantity as num,t1.type_product as type,t1.product_name as name,t2.created_at as dateni,t1.type_product as type from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where DATE_FORMAT(t2.created_at,"%Y-%m-%d") between "'.$datef.'" and "'.$datet.'" ';

    
    if(isset($_POST["order"]))
    {
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY t2.created_at DESC ';
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
            $sub_array[] = date('F j, Y',strtotime($row['dateni']));
            $sub_array[] = '';
            $sub_array[] = '';
            $sub_array[] = $row["type"];
            $sub_array[] = $row["name"];
            $sub_array[] = $row["num"];
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