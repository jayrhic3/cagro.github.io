<?php
include('connection.php');
include('function_ongoing.php');
$query = ''; 
$output = array();

$name=$_POST['name'];
$id=$_POST['id'];
$status=$_POST['status'];
$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];

if($name=='All' && $status=='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
    t2.word_created as dates,t2.service_id as id,t2.created_at as dateni,t2.status as stat,t2.assistance_recieved as ass from 
    beneficiaries as t1 inner join recent_request as t2 on t1.id = t2.beneficiary_id ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.status LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["lastname"];
            $sub_array[] = $row["firstname"];
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name!='All' && $status=='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where t2.beneficiary_id="'.$id.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name=='All' && $status!='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where t2.status="'.$status.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name!='All' && $status!='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where t2.status="'.$status.'" and t2.beneficiary_id="'.$id.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name=='All' && $status=='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
      BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name!='All' && $status=='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
      BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.beneficiary_id="'.$id.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name=='All' && $status!='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
      BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.status="'.$status.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name!='All' && $status!='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
      BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.status="'.$status.'" and t2.beneficiary_id="'.$id.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name=='All' && $status=='All' && $datefrom!='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where t2.beneficiary_id="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name=='All' && $status=='All' && $datefrom=='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where t2.beneficiary_id="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name=='All' && $status!='All' && $datefrom=='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where t2.beneficiary_id="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name=='All' && $status!='All' && $datefrom!='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where t2.beneficiary_id="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name!='All' && $status=='All' && $datefrom=='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where t2.beneficiary_id="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name!='All' && $status=='All' && $datefrom!='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where t2.beneficiary_id="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name!='All' && $status!='All' && $datefrom=='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where t2.beneficiary_id="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
else if($name!='All' && $status!='All' && $datefrom!='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where t2.beneficiary_id="") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
if($status=='All' && $datefrom=='' && $dateto==''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
t2.word_created as dates,t2.service_id as id,t2.created_at as dateni,t2.status as stat,t2.assistance_recieved as ass from 
beneficiaries as t1 inner join recent_request as t2 on t1.id = t2.beneficiary_id ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.status LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["lastname"];
        $sub_array[] = $row["firstname"];
        $sub_array[] = $row["middlename"];
        $sub_array[] = $row["ass"];
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
else if($status!='All' && $datefrom=='' && $dateto==''){
$query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
t2.word_created as dates,t2.service_id as id,t2.created_at as dateni,t2.status as stat,t2.assistance_recieved as ass from 
beneficiaries as t1 inner join recent_request as t2 on t1.id = t2.beneficiary_id and t2.status="'.$status.'" ';

if(isset($_POST["search"]["value"]))
{
    $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR t2.status LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $sub_array[] = $row["lastname"];
        $sub_array[] = $row["firstname"];
        $sub_array[] = $row["middlename"];
        $sub_array[] = $row["ass"];
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
else if($status=='All' && $datefrom!='' && $dateto!=''){
    $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
    t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
     from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
     t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
     t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
     recent_request as t2 on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
      BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t1 ';
    
    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["middlename"];
            $sub_array[] = $row["ass"];
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
    else if($status!='All' && $datefrom!='' && $dateto!=''){
        $query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
        t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
         from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
         t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
         t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
         recent_request as t2 on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
          BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.status="'.$status.'") as t1 ';
        
        if(isset($_POST["search"]["value"]))
        {
            $query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
            $query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
                $sub_array[] = $row["middlename"];
                $sub_array[] = $row["ass"];
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
else if($status!='All' && $datefrom=='' || $dateto==''){
$query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
recent_request as t2 on t1.id=t2.beneficiary_id where t2.status="") as t1 ';

if(isset($_POST["search"]["value"]))
{
$query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
$query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
$query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
    $sub_array[] = $row["middlename"];
    $sub_array[] = $row["ass"];
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
else if($status=='All' && $datefrom=='' || $dateto==''){
$query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
recent_request as t2 on t1.id=t2.beneficiary_id where t2.status="") as t1 ';

if(isset($_POST["search"]["value"]))
{
$query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
$query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
$query .= 'OR t1.middlename LIKE "%'.$_POST["search"]["value"].'%" ';
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
    $sub_array[] = $row["middlename"];
    $sub_array[] = $row["ass"];
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