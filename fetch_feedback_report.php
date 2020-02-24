<?php
include('connection.php');
include('function_feedback.php');
$query = ''; 
$output = array();
$status=$_POST['status'];
$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];
$assistance=$_POST['assistance'];

if($status=='All'&&$assistance=='All'&&$datefrom==''&&$dateto==''){
    $query .= 'SELECT t2.beneficiary_id as bene_id,t2.assistance_received as ass,t2.rating as rate,
t2.comment as comment,t2.word_created as created from comment_recommendation as t2 inner join 
beneficiaries as t1 on t2.beneficiary_id=t1.id ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t2.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.rating LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.comment LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["ass"];
        $sub_array[] = $row["rate"];
        $sub_array[] = $row["comment"];
        $sub_array[] = $row["created"];
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
else if($status=='All'&&$assistance!='All'&&$datefrom==''&&$dateto==''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where t2.assistance_received="'.$assistance.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status!='All'&&$assistance=='All'&&$datefrom==''&&$dateto==''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where t2.rating="'.$status.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status!='All'&&$assistance!='All'&&$datefrom==''&&$dateto==''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where t2.rating="'.$status.'" and t2.assistance_received="'.$assistance.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status=='All'&&$assistance=='All'&&$datefrom!=''&&$dateto!=''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
      BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status!='All'&&$assistance=='All'&&$datefrom!=''&&$dateto!=''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
      BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.rating="'.$status.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status=='All'&&$assistance!='All'&&$datefrom!=''&&$dateto!=''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
      BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.assistance_received="'.$assistance.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status!='All'&&$assistance!='All'&&$datefrom!=''&&$dateto!=''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
      BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.assistance_received="'.$assistance.'" and t2.rating="'.$status.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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

//error handling
else if($status=='All'&&$assistance=='All'&&$datefrom!=''&&$dateto==''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where t2.rating="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status=='All'&&$assistance=='All'&&$datefrom==''&&$dateto!=''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where t2.rating="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status!='All'&&$assistance=='All'&&$datefrom!=''&&$dateto==''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where t2.rating="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status!='All'&&$assistance=='All'&&$datefrom==''&&$dateto!=''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where t2.rating="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status=='All'&&$assistance!='All'&&$datefrom==''&&$dateto!=''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where t2.rating="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status=='All'&&$assistance!='All'&&$datefrom!=''&&$dateto==''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where t2.rating="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status!='All'&&$assistance!='All'&&$datefrom!=''&&$dateto==''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where t2.rating="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
else if($status!='All'&&$assistance!='All'&&$datefrom==''&&$dateto!=''){
    $query .= 'SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
    t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
    assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
    t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
    on t1.id=t2.beneficiary_id where t2.rating="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.rating LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.comment LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["ass"];
            $sub_array[] = $row["rate"];
            $sub_array[] = $row["comment"];
            $sub_array[] = $row["created"];
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
    $query .= 'SELECT t2.beneficiary_id as bene_id,t2.assistance_received as ass,t2.rating as rate,
t2.comment as comment,t2.word_created as created from comment_recommendation as t2 inner join 
beneficiaries as t1 on t2.beneficiary_id=t1.id and t2.rating="'.$status.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t2.beneficiary_id LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.assistance_received LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.rating LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.comment LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["bene_id"];
        $sub_array[] = $row["ass"];
        $sub_array[] = $row["rate"];
        $sub_array[] = $row["comment"];
        $sub_array[] = $row["created"];
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