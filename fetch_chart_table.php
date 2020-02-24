<?php
session_start();
include('connection.php');

$year=$_POST['year'];
$type=$_POST['type'];
$yearf=$_POST['yearf'];
$yeart=$_POST['yeart'];
$datef=$_POST['datef'];
$datet=$_POST['datet'];

if($type==='Monthly'){

        include('function_chart_table.php');
        $query = ''; 
        $output = array();
        $query .= 'SELECT t1.num as num,t1.mon as mon,t1.created_at as created_at 
        from (select count(distinct beneficiary_id) as num,month(created_at) as mon,
        created_at as created_at from record_assistance_beneficiary where year(created_at)="'.$year.'"
         group by month(created_at)) as t1 ';
        if(isset($_POST["search"]["value"]))
        {
            $query .= 'WHERE num LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR mon LIKE "%'.$_POST["search"]["value"].'%" ';
        }
        if(isset($_POST["order"]))
        {
            $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
            $query .= 'ORDER BY created_at DESC ';
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
}else if($type==='Yearly')
{
    include('function_chart_table.php');
    $query = ''; 
    $output = array();
    $query .= 'SELECT t1.year as year,t1.num as num,t1.created_at as created_at from
     (select count(distinct beneficiary_id) as num,year(created_at) as year,
      created_at as created_at from record_assistance_beneficiary where year(created_at)
       between "'.$yearf.'" and "'.$yeart.'" group by year(created_at)) as t1 ';
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.num LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.year LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = '';
            $sub_array[] = $row['year'];
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
}else if($type==='Customize')
{
    include('function_chart_table.php');
    $query = ''; 
    $output = array();
    $query .= 'SELECT t1.dateni as dateni,t1.num as num from (select count(distinct beneficiary_id) as num
    ,DATE_FORMAT(created_at,"%Y-%m-%d") as dateni from record_assistance_beneficiary where 
    DATE_FORMAT(created_at,"%Y-%m-%d") between "'.$datef.'" and "'.$datet.'" 
    group by DATE_FORMAT(created_at,"%Y-%m-%d")) as t1 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.num LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.dateni LIKE "%'.$_POST["search"]["value"].'%" ';
    }
    if(isset($_POST["order"]))
    {
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY t1.dateni DESC ';
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