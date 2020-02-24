<?php
session_start();
include('connection.php');

if(!isset($_SESSION['username'])){
    header('location:index.php');
}

$sub_array2 = array();
$sub_array3 = array();

$query2="SELECT description FROM beneficiary_type";
$statement2 = $connection->prepare($query2);
$statement2->execute();
$result2 = $statement2->fetchAll();
foreach($result2 as $row2)
{
	$sub_array2[] = $row2["description"];
}

$query3="SELECT name FROM personel";
$statement3 = $connection->prepare($query3);
$statement3->execute();
$result3 = $statement3->fetchAll();
foreach($result3 as $row3)
{
    $sub_array3[] = $row3["name"];
}


?>

<!DOCTYPE html>
<html >

<head>
  
    <title>Cagro Information System</title>

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link type="image/x-icon" href="assets/images/cagro5.png" rel="shortcut icon">
    
    

    <!-- Common -->
    <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/lib/helper.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Datatable -->
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="assets/css/jquery-ui.css" rel="stylesheet" />
   <style>
        .form-control{
            border-color:#000000;
        }
        #assis,#other{
            height:20px;
            width:20px;
        }
        .modal-header{
            background-color:skyblue;
        }
        .text{
            font-size:20px;
            color:black;
        }
        .oth{
            font-size:20px;
            color:black;
        }
        #check1,#check2{
            height:20px;
            width:20px;
        }
        .fed{
            font-size:20px;
            color:black;
        }
   </style>

    
    
</head>

<body>

<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
            <div class="nano">
                <div class="nano-content">
                    <ul>
                        <div class="logo"><a href="index.html"><img src="assets/images/cagro1.png" alt="" /><span>CAGRO</span></a></div>
                        <li class="label">Home</li>
                        <li><a href="dashboard.php"><i class="ti-home"></i>Dashboard</a></li>
                        <li><a href="secretary.php"><i class="ti-user"></i>Beneficiaries</a></li>
                        <li><a href="recent_request.php"><i class="ti-bell"></i>Requests</a></li>
                        <li><a class="sidebar-sub-toggle"><i class="ti-panel"></i> Records <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                            <li><a href="planning_agrisupplies.php"><i class="ti-folder"></i>Agri Supplies</a></li>
                            <li><a href="planning_technical_assistance.php"><i class="ti-folder"></i>Technical Assistance</a></li>
                            <li><a href="planning_farm_mechanization.php"><i class="ti-folder"></i>Farm Mechanization</a></li>
                            <li><a href="planning_other_assistance.php"><i class="ti-folder"></i>Other Assistance</a></li>
                            </ul>
                        </li>
                        <li class="label">Events</li>
                        <li><a href="project_programs.php"><i class="ti-calendar"></i>Activities</a></li>
                        <li class="label">Reports</li>
                        <li><a href="ongoing_bene_record__secretary.php"><i class="ti-folder"></i>Beneficiary Reports</a></li>
                        <li><a href="transaction_report_secretary.php"><i class="ti-folder"></i>Transaction Report</a></li>
                        <li><a href="feedback_report_secretary.php"><i class="ti-folder"></i>Feedback Report</a></li>
                    </ul>
                </div>
            </div>
        </div>
    <!-- /# sidebar -->


    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                            <h4 id="datetime"></h4>
                            <h5 id="time"></h5>
                    </div>
                    <div class="float-right">
                        <div class="dropdown dib">
                            <div class="header-icon" data-toggle="dropdown">
                                <?php 
                                    $count;
                                    if($statement3 = $connection->prepare('SELECT COUNT(title) as num from notification WHERE event_status="Unread"')){
                                        $statement3->execute();
                                        $result3 = $statement3->fetchAll();
                                        foreach($result3 as $row3)
                                        {
                                            $count=$row3['num'];
                                        }
                                    }
                                
                                ?>
                                <i class="ti-alarm-clock"></i><span style="color:red;font-size:12px;"><b><?php 
                                if($count==0){
                                    echo "";
                                }else{
                                echo $count; 
                                }
                                
                                ?></b></span>
                                <div class="drop-down dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-content-heading">
                                        <span class="text-left">Recent Notifications</span>
                                    </div>
                                    <div class="dropdown-content-body">
                                        <ul>

                                        <?php 
                                        
                                            if($statement4 = $connection->prepare('SELECT * from notification order by start_event desc limit 3')){
                                                $statement4->execute();
                                                $result4 = $statement4->fetchAll();
                                                
                                                if(!empty($result4)){

                                                

                                                foreach($result4 as $row4)
                                                {
                                                 
                                        
                                        ?>

                                            <li>
                                                <a >
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/notif.png" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right"><?php echo $row4['event_status'] ?></small>
                                                        <div class="notification-heading"><?php echo $row4['title'] ?></div>
                                                    </div>
                                                </a>
                                            </li>

                                        <?php 
                                        
                                            }

                                            echo '<li class="text-center">
                                            <a href="#" id="view_notif" class="more-link">See All</a>
                                        </li>';
                                        }else{
                                            echo '<li class="text-center">
                                            <a href="#" >No Nofication</a>
                                                </li>';
                                        }
                                    }
                                        
                                        
                                        ?>
                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                        <div class="dropdown dib">
                            <div class="header-icon" data-toggle="dropdown">
                                <span class="user-avatar"><?php echo $_SESSION["username"]; ?>
                                    <i class="ti-angle-down f-s-10"></i>
                                </span>
                                <div class="drop-down dropdown-profile dropdown-menu dropdown-menu-right">
                               
                                    <div class="dropdown-content-body">
                                        <ul>
                                            <li>
                                                <a id="profile">
                                                    <i class="ti-user"></i>
                                                    <span>Profile</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a id="setting">
                                                    <i class="ti-settings"></i>
                                                    <span>Setting</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a id="logout">
                                                    <i class="ti-power-off"></i>
                                                    <span>Logout</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                
                <!-- /# row -->

                <div class="row" id="table_div">
                            <!-- /# column -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h3>Beneficiaries</h3>
                                        </div>
                                        <div class="col-md-4">
                                            <div align="right">
                                                <button type="button" id="add_button" class="btn btn-info ti-plus btn-sm"> Beneficiary</button>
                                                <input type="hidden" id="id_msg">
                                            </div>
                                        </div>
                                    </div>
                                            <table id="user_data" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Last Name</th>
                                                        <th >First Name</th>
                                                        <th>Middle Name</th>
                                                        <th width="15%">Date Registered</th>
                                                        <th width="12%">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- /# column -->
                        </div>

                        <div class="row" id="insert_div">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h2>Registration Form</h2>
                                            </div>
                                            <div class="col-md-4">
                                                <div align="right">
                                                    <button type="button" id="close_button" class="btn btn-secondary ti-back-left btn-sm"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" id="user_form">

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span> First Name:</label>  
                                                        <input type="text" class="form-control" name="firstname" id="firstname">
                                                        <span id="firstname_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Last Name:</label>  
                                                        <input type="text" class="form-control" name="lastname" id="lastname">
                                                        <span id="lastname_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Middle Name:</label>
                                                        <input type="text" class="form-control" name="middlename" id="middlename">
                                                        <span id="middlename_error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Province:</label>
                                                        <select name="province" id="province" class="form-control">
                                                            <option value=""></option>
                                                            <?php 
                                                            
                                                                $query_drop="select * from province";
                                                                $statement10 = $connection->prepare($query_drop);
                                                                $statement10->execute();
                                                                $result10 = $statement10->fetchAll();
                                                                foreach($result10 as $row)
                                                                {
                                                                   echo '<option value="'.$row["description"].'">'.$row["description"].'</option>';
                                                                }

                                                            ?>
                                                        </select>
                                                        <span id="province_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Municipality:</label>
                                                        <select name="muni" id="muni" class="form-control">
                                                            <option value=""></option>
                                                        </select>
                                                        <span id="muni_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Barangay:</label>
                                                        <select name="barang" id="barang" class="form-control">
                                                            <option value=""></option>
                                                        </select>
                                                        <span id="barang_error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Purok:</label>
                                                        <input type="text" name="purok" id="purok" class="form-control">
                                                        <span id="purok_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Beneficiary Type:</label>
                                                        <input type="text" class="form-control" name="bene_type" id="bene_type">
                                                        <span id="bene_type_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Gender:</label>
                                                        <input type="text" class="form-control" name="gender" id="gender">
                                                        <span id="gender_error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Birth Date:</label>
                                                        <input type="date" class="form-control" name="bday" id="bday">
                                                        <span id="bday_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Personnel:</label>
                                                        <input type="text" class="form-control" name="personnel" id="personnel" value="<?php echo $_SESSION["name"]; ?>">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Mobile Number:</label>
                                                        <input type="text" class="form-control" name="mobnum" id="mobnum" maxlength="11">
                                                        <span id="mobnum_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label>SSS ID</label>
                                                        <input type="text" class="form-control" name="id_other" id="id_other">
                                                        <span id="cid_other_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Pag-ibig</label>
                                                        <input type="text" class="form-control" name="pagibig" id="pagibig">
                                                        <span id="cid_other_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Philhealth</label>
                                                        <input type="text" class="form-control" name="phil" id="phil">
                                                        <span id="cid_other_error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" align="right">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <input type="hidden" name="operation" id="operation" />
                                                        <button type="button" class="btn btn-default" id="cancel_form">Cancel</button>
                                                        <input type="submit" name="action" id="action" class="btn btn-primary" value="Save" />
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="check_div">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h2>Profile</h2>
                                            </div>
                                            <div class="col-md-4">
                                                <div align="right">
                                                    <button type="button" id="close_check" class="btn btn-secondary ti-back-left btn-sm"></button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <form method="post" id="check_form">

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>First Name:</label>  
                                                        <input type="text" class="form-control" name="cfirstname" id="cfirstname">
                                                        <span id="cfirstname_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Last Name:</label>  
                                                        <input type="text" class="form-control" name="clastname" id="clastname">
                                                        <span id="clastname_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Middle Name:</label>  
                                                        <input type="text" class="form-control" name="cmiddlename" id="cmiddlename">
                                                        <span id="cmiddlename_error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Province:</label>
                                                        <select name="cprovince" id="cprovince" class="form-control">
                                                            <option value=""></option>
                                                            <?php 
                                                            
                                                                $query_drop2="select * from province";
                                                                $statement11 = $connection->prepare($query_drop2);
                                                                $statement11->execute();
                                                                $result11 = $statement11->fetchAll();
                                                                foreach($result11 as $row)
                                                                {
                                                                echo '<option value="'.$row["description"].'">'.$row["description"].'</option>';
                                                                }
                                                            
                                                            ?>
                                                        </select>
                                                        <span id="cprovince_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Municipality:</label>
                                                        <select name="cmuni" id="cmuni" class="form-control">
                                                            <option value=""></option>
                                                            <?php 
                                                            
                                                                $query_drop3="select * from municipality";
                                                                $statement12 = $connection->prepare($query_drop3);
                                                                $statement12->execute();
                                                                $result12 = $statement12->fetchAll();
                                                                foreach($result12 as $row)
                                                                {
                                                                echo '<option value="'.$row["description"].'">'.$row["description"].'</option>';
                                                                }
                                                                
                                                            ?>
                                                        </select>
                                                        <span id="cmuni_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Barangay:</label>
                                                        <select name="cbarang" id="cbarang" class="form-control">
                                                            <option value=""></option>
                                                            <?php 
                                                            
                                                                $query_drop4="select * from barangay";
                                                                $statement13 = $connection->prepare($query_drop4);
                                                                $statement13->execute();
                                                                $result13 = $statement13->fetchAll();
                                                                foreach($result13 as $row)
                                                                {
                                                                echo '<option value="'.$row["description"].'">'.$row["description"].'</option>';
                                                                } 
                                                                
                                                            ?>
                                                        </select>
                                                        <span id="cbarang_error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Purok:</label>
                                                        <input type="text" name="cpurok" id="cpurok" class="form-control">
                                                        <span id="cpurok_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Beneficiary Type:</label>
                                                        <input type="text" class="form-control" name="cbene_type" id="cbene_type">
                                                        <span id="cbene_type_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Gender:</label>
                                                        <input type="text" class="form-control" name="cgender" id="cgender">
                                                        <span id="cgender_error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Birth Date:</label>
                                                        <input type="date" class="form-control" name="cbday" id="cbday">
                                                        <span id="cbday_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Personnel:</label>
                                                        <input type="text" class="form-control" name="cpersonnel" id="cpersonnel">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label><span style="color:red;">*</span>Mobile Number:</label>
                                                        <input type="text" class="form-control" name="cmobnum" id="cmobnum" maxlength="11">
                                                        <span id="cmobnum_error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label>SSS ID</label>
                                                        <input type="text" class="form-control" name="cid_other" id="cid_other">
                                                        <span id="cid_other_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Pag-ibig</label>
                                                        <input type="text" class="form-control" name="cpagibig" id="cpagibig">
                                                        <span id="cid_other_error"></span>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Philhealth</label>
                                                        <input type="text" class="form-control" name="cphil" id="cphil">
                                                        <span id="cid_other_error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" align="right">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <input type="hidden" name="cuser_id" id="cuser_id" />
                                                        <input type="hidden" name="coperation" id="coperation" />
                                                        <button type="button" class="btn btn-default" id="close_form">Close</button>
                                                        <input type="submit" name="caction" id="caction" class="btn btn-primary" value="Insert" />
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="footer">
                                    <p>2019 © DAVAO DEL NORTE STATE COLLEGE - INSTITUTE OF INFORMATION TECHNOLOGY. - <a href="www.dnsc.edu.ph">www.dnsc.edu.ph</a></p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

<!-- modal -->
        <div id="userModal" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="assistance_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Choose Assistance</h4>
                            <b><button type="button" class="close" data-dismiss="modal"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                            <?php 
                                $query2 = "SELECT description FROM assistance";
                                $statement2 = $connection->prepare($query2);
                                $statement2->execute();
                                $result2 = $statement2->fetchAll();
                                foreach($result2 as $row2)
                                {
                                    $des=$row2['description'];
                                    echo "<div class='form-group text'>
                                            <input type='checkbox' id='assis' value='".$des."' name='assis[]' class='assil'> ".$des." 
                                        </div>";
                                }
                                    
                            ?>
                                <div class="form-group oth" >
                                    <input type="checkbox" id="other">Others
                                </div>
                                <div class="form-group" id="other_input">
                                    <label >Please Specify:</label>
                                    <input type="text" id="other_text" class="form-control">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="asis_user_id" id="asis_user_id" />
                            <input type="button" id="addassis" class="btn btn-success" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="userModal2" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="Recomendation_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Feedback Form</h4>
                            <b><button type="button" class="close" data-dismiss="modal"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                                <div class="form-group">
                                    <h6>Type of Assistance(Optional):</h6>
                                    <select name="type_assis" id="type_assis" class="form-control">
                                        <option value=""></option>
                                        <option value="Agri Supplies">Agri Supplies</option>
                                        <option value="Technical Assistance">Technical Assistance</option>
                                        <option value="Farm Mechanization">Farm Mechanization</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div><hr>
                                <div class="form-group fed">
                                    <h6>Rating</h6>
                                    <input type="checkbox" id="check1" value="Satisfied"> Satisfied <br>  
                                    <input type="checkbox" id="check2" value="DisSatisfied"> DisSatisfied
                                </div><hr>
                                <div class="form-group">
                                    <h6>Comment/Recommendation:</h6>
                                    <textarea name="comment" id="comment" class="form-control" cols="30" rows="10"></textarea>
                                </div>
                           
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="fed_id" id="fed_id" />
                            <input type="button" id="add_rating" class="btn btn-success" value="Submit" />
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="close_comment">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="userModal3" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="add_assis_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Are you sure want to add Assistance to <span id="name_nila"></span>?</h4>
                            <b><button type="button" id="close_con_ass" class="close" data-dismiss="modal"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                               
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="fed_id" id="fed_id" />
                            <input type="button" id="add_assis" class="btn btn-success" value="Yes" />
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="close_con">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <!-- Common -->
    
    

</body>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
    <script src="assets/js/lib/menubar/sidebar.js"></script>
    <script src="assets/js/lib/preloader/pace.min.js"></script>
    <script src="js/moment.min.js"></script>
    

</html>

<script>
$(document).ready(function(){
    var interval=setInterval(function(){
        var momentNow=new moment();
        $('#datetime').html(momentNow.format('MMMM DD, YYYY')+' '+momentNow.format('dddd').substring(0,3).toUpperCase());
        $('#time').html(momentNow.format('A hh:mm:ss'));
   },100);
    $('#other_input').hide();
    
    $(function() {
        $('#bene_type').autocomplete({
            source: <?php echo json_encode($sub_array2); ?>,
            minLength: 0
        }).focus(function () {
            if ($(this).autocomplete("widget").is(":visible")) {
                return;
            }
            $(this).data("uiAutocomplete").search($(this).val());
        });
    });

    $(function() {
        $('#cbene_type').autocomplete({
            source: <?php echo json_encode($sub_array2); ?>,
            minLength: 0
        }).focus(function () {
            if ($(this).autocomplete("widget").is(":visible")) {
                return;
            }
            $(this).data("uiAutocomplete").search($(this).val());
        });
    });

    $(function() {
        $('#gender').autocomplete({
            source: ["Male","Female"],
            minLength: 0
        }).focus(function () {
            if ($(this).autocomplete("widget").is(":visible")) {
                return;
            }
            $(this).data("uiAutocomplete").search($(this).val());
        });
    });
    $(function() {
        $('#cgender').autocomplete({
            source: ["Male","Female"],
            minLength: 0
        }).focus(function () {
            if ($(this).autocomplete("widget").is(":visible")) {
                return;
            }
            $(this).data("uiAutocomplete").search($(this).val());
        });
    });

    $(function() {
        $('#personnel').autocomplete({
            source: <?php echo json_encode($sub_array3); ?>,
            minLength: 0
        }).focus(function () {
            if ($(this).autocomplete("widget").is(":visible")) {
                return;
            }
            $(this).data("uiAutocomplete").search($(this).val());
        });
    });
    $(function() {
        $('#cpersonnel').autocomplete({
            source: <?php echo json_encode($sub_array3); ?>,
            minLength: 0
        }).focus(function () {
            if ($(this).autocomplete("widget").is(":visible")) {
                return;
            }
            $(this).data("uiAutocomplete").search($(this).val());
        });
    });

    $('#view_notif').click(function(){
        document.location.href="notification_table.php";
    });

    $('#other').click(function(){
        if(document.getElementById('other').checked){
            $(".assil").attr("disabled", true);
            $(".assil").attr("checked", false);
            $('#other_input').show();
        }else{
            $(".assil").attr("disabled", false);
            $('#other_input').hide();
        }
    });

    $('#check1').click(function(){
        if(document.getElementById('check1').checked){
            $('#check2').attr('checked',false);
        }else{

        }
    });

    $('#check2').click(function(){
        if(document.getElementById('check2').checked){
            $('#check1').attr('checked',false);
        }else{

        }
    });

    $(document).on('click','#close_comment',function(){
        $('#Recomendation_form')[0].reset();
    });

    $(document).on('click','#add_rating',function(){
        var user_id=$('#fed_id').val();
        var ass=$('#type_assis').val();
        var comment=$('#comment').val();
        var rate;
        if(document.getElementById('check1').checked){
            rate=$('#check1').val();
        }
        if(document.getElementById('check2').checked){
            rate=$('#check2').val();
        }

       if(comment!=''){
            $.ajax({
                url:"addcomment_beneficiary.php",
                method:'POST',
                data:{'user_id':user_id,'ass':ass,'rate':rate,'comment':comment},
                success:function(data)
                {
                    alert(data);
                    $('#Recomendation_form')[0].reset();
                    $('#userModal2').modal('hide');
                }
            });
       }else{
           alert("Comment Please!!");
       }
    });

    $('#insert_div').hide();
    $('#check_div').hide();

    $('#add_button').click(function(){
        $('#check_div').hide();
        $('#table_div').hide();
        $('#insert_div').show();
        $('#operation').val("Add");
    });

    $('#logout').click(function(){
        document.location.href="logout.php";
    });
    $('#profile').click(function(){
        document.location.href="profile_secretary.php";
    });
    $('#setting').click(function(){
        document.location.href="setting.php";
    });

    $('#close_button').click(function(){
        $('#table_div').show();
        $('#insert_div').hide();
        $('#check_div').hide();
    });
    $('#close_check').click(function(){
        $('#table_div').show();
        $('#insert_div').hide();
        $('#check_div').hide();
    });

    $('#cancel_form').click(function(){
        $('#check_div').hide();
        $('#table_div').show();
        $('#insert_div').hide();
        $('#user_form')[0].reset();
    });
    $('#close_form').click(function(){
        $('#check_div').hide();
        $('#table_div').show();
        $('#insert_div').hide();
    });
    
    var dataTable = $('#user_data').DataTable({
    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    select: true,
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
        url:"fetch_secretary_beneficairy.php",
        type:"POST"
    },
    "columnDefs":[
        {
            "targets":[0, 3, 3],
            "orderable":false,
        },
    ],

});

$(document).on('change','#province',function(){
    var province=$('#province').val();
    $('#muni option').remove();
    $.ajax({
			url:"fetch_municipality_drop.php",
			method:"POST",
			data:{province:province},
			dataType:"json",
			success:function(data)
			{
                var arr1=[];
                arr1=data.municipality.trim().split(',');
                for(var i=0;i<arr1.length-1;i++){
                    html="<option value='"+arr1[i]+"'>"+arr1[i]+"</option>";
                    
                    $('#muni').append(html);
                }
			}
		});
});

$(document).on('change','#cprovince',function(){
    var province=$('#cprovince').val();
    $('#cmuni option').remove();
    $.ajax({
			url:"fetch_municipality_drop.php",
			method:"POST",
			data:{province:province},
			dataType:"json",
			success:function(data)
			{
                var arr1=[];
                arr1=data.municipality.trim().split(',');
                for(var i=0;i<arr1.length-1;i++){
                    html="<option value='"+arr1[i]+"'>"+arr1[i]+"</option>";
                    
                    $('#cmuni').append(html);
                }
			}
		});
});


$(document).on('change','#muni',function(){
    var muni=$('#muni').val();
    $('#barang option').remove();
    $.ajax({
			url:"fetch_barangay_drop2.php",
			method:"POST",
			data:{muni:muni},
			dataType:"json",
			success:function(data)
			{
                var arr1=[];
                arr1=data.barangay.trim().split(',');
                for(var i=0;i<arr1.length-1;i++){
                    html="<option value='"+arr1[i]+"'>"+arr1[i]+"</option>";
                    
                    $('#barang').append(html);
                }
			}
		});
});

$(document).on('change','#cmuni',function(){
    var muni=$('#cmuni').val();
    $('#cbarang option').remove();
    $.ajax({
			url:"fetch_barangay_drop2.php",
			method:"POST",
			data:{muni:muni},
			dataType:"json",
			success:function(data)
			{
                var arr1=[];
                arr1=data.barangay.trim().split(',');
                for(var i=0;i<arr1.length-1;i++){
                    html="<option value='"+arr1[i]+"'>"+arr1[i]+"</option>";
                    
                    $('#cbarang').append(html);
                }
			}
		});
});


$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
        if(confirm("Are you sure you want to Add this Beneficiary?"))
		{
			var firstname = $('#firstname').val();
            var lastname = $('#lastname').val();
            var middlename=$('#middlename').val();
            var purok=$('#purok').val();
            var barang=$('#barang').val();
            var bene_type=$('#bene_type').val();
            var muni=$('#muni').val();
            var gender=$('#gender').val();
            var bday=$('#bday').val();
            var mobnum=$('#mobnum').val();
            var province=$('#province').val();
            var id_other=$('#id_other').val();
            
            if(firstname == '' ){
                $('#firstname_error').text('*First Name is Required');
                $('#firstname_error').css({"color":"#FF0000"});
                $('#firstname').css({"border-color":"#FF0000"});
            }else{
                $('#firstname_error').text('')
                $('#firstname').css({"border-color":"000000"});
            }	
            if(lastname == '' ){
                $('#lastname_error').text('*Last Name is Required');
                $('#lastname_error').css({"color":"#FF0000"});
                $('#lastname').css({"border-color":"#FF0000"});
            }else{
                $('#lastname_error').text('');
                $('#lastname').css({"border-color":"000000"});
            }	
            if(middlename == '' ){
                $('#middlename_error').text('*Middle Name is Required');
                $('#middlename_error').css({"color":"#FF0000"});
                $('#middlename').css({"border-color":"#FF0000"});
            }else{
                $('#middlename_error').text('');
                $('#middlename').css({"border-color":"000000"});
            }
            if(purok == '' ){
                $('#purok_error').text('*Purok Name is Required');
                $('#purok_error').css({"color":"#FF0000"});
                $('#purok').css({"border-color":"#FF0000"});
            }else{
                $('#purok_error').text('');
                $('#purok').css({"border-color":"000000"});
            }	
            if(barang == '' ){
                $('#barang_error').text('*Barangay Name is Required');
                $('#barang_error').css({"color":"#FF0000"});
                $('#barang').css({"border-color":"#FF0000"});
            }else{
                $('#barang_error').text('');
                $('#barang').css({"border-color":"000000"});
            }		
            if(bene_type == '' ){
                $('#bene_type_error').text('*Beneficiary Type Name is Required');
                $('#bene_type_error').css({"color":"#FF0000"});
                $('#bene_type').css({"border-color":"#FF0000"});
            }else{
                $('#bene_type_error').text('');
                $('#bene_type').css({"border-color":"000000"});
            }
            if(muni == '' ){
                $('#muni_error').text('*Municipality Name is Required');
                $('#muni_error').css({"color":"#FF0000"});
                $('#muni').css({"border-color":"#FF0000"});
            }else{
                $('#muni_error').text('');
                $('#muni').css({"border-color":"000000"});
            }
            if(gender == '' ){
                $('#gender_error').text('*Gender is Required');
                $('#gender_error').css({"color":"#FF0000"});
                $('#gender').css({"border-color":"#FF0000"});
            }else{
                $('#gender_error').text('');
                $('#gender').css({"border-color":"000000"});
            }
            if(bday == '' ){
                $('#bday_error').text('*Birthday is Required');
                $('#bday_error').css({"color":"#FF0000"});
                $('#bday').css({"border-color":"#FF0000"});
            }else{
                $('#bday_error').text('');
                $('#bday').css({"border-color":"000000"});
            }
            if(mobnum == '' ){
                $('#mobnum_error').text('*Mobile Number is Required');
                $('#mobnum_error').css({"color":"#FF0000"});
                $('#mobnum').css({"border-color":"#FF0000"});
            }else{
                $('#mobnum_error').text('');
                $('#mobnum').css({"border-color":"000000"});
            }
            if(province == '' ){
                $('#province_error').text('*Province is Required');
                $('#province_error').css({"color":"#FF0000"});
                $('#province').css({"border-color":"#FF0000"});
            }else{
                $('#province_error').text('');
                $('#province').css({"border-color":"000000"});
            }
            if(firstname != '' && lastname != '' && middlename!='' && purok!='' && barang!='' && bene_type!='' && muni!='' && gender!='' && bday!='' && mobnum!='' && province!='')
            {
                var filter=/^[0-9-+]+$/;
                if(filter.test(mobnum)){
                        if(mobnum.length!=11){
                            $('#mobnum_error').text('*Must be 11 digit');
                            $('#mobnum_error').css({"color":"#FF0000"});
                            $('#mobnum').css({"border-color":"#FF0000"});
                        }else{
                            //code here
                            $('#mobnum_error').text('')
                            $('#mobnum').css({"border-color":"000000"});
                        
                            $.ajax({
                                url:"insert_beneficiary.php",
                                method:'POST',
                                data:new FormData(this),
                                contentType:false,
                                processData:false,
                                success:function(data)
                                {
                                
                                    $('#user_form')[0].reset();
                                    $('#insert_div').hide();
                                    $('#table_div').show();
                                    alert(data);
                                    dataTable.ajax.reload();
                                }
                            });
                        }
                    }else{
                        $('#mobnum_error').text('*Invalid Mobile Number, must be a number');
                        $('#mobnum_error').css({"color":"#FF0000"});
                        $('#mobnum').css({"border-color":"#FF0000"});
                        }
                
            }
            else
            {

            }
		}else{

        }
		
    });
    $(document).on('click', '.msg', function(){
        var user_id = $(this).attr("id");
        $('#fed_id').val(user_id);
        $('#userModal2').modal('show');
    });

    $(document).on('click', '.check', function(){
		var user_id = $(this).attr("id");
		$.ajax({
			url:"fetch_single_beneficiary.php",
			method:"POST",
			data:{user_id:user_id},
			dataType:"json",
			success:function(data)
			{
				$('#table_div').hide();
                $('#insert_div').hide();
                $('#check_div').show();

				$('#cfirstname').val(data.firstname);
				$('#clastname').val(data.lastname);
				$('#cmiddlename').val(data.middlename);
                $('#cpurok').val(data.purok);
                $('#cbarang').val(data.barangay);
                $('#cmobnum').val(data.mobnum);
                $('#cbene_type').val(data.beneficiary_type);
                $('#cmuni').val(data.mucipality);
                $('#cgender').val(data.gender);
                $('#cbday').val(data.bday);
                $('#cpersonnel').val(data.personnel);
                $('#cprovince').val(data.province);
                $('#cid_other').val(data.other_id);
                $('#cpagibig').val(data.pagibig);
                $('#cphil').val(data.phil);
				$('#cuser_id').val(user_id);
				$('#caction').val("Save");
				$('#coperation').val("Save");
			}
		});
	});

    $(document).on('submit', '#check_form', function(event){
		event.preventDefault();
       
		var firstname = $('#cfirstname').val();
		var lastname = $('#clastname').val();
		var middlename=$('#cmiddlename').val();
        var purok=$('#cpurok').val();
        var barang=$('#cbarang').val();
        var bene_type=$('#cbene_type').val();
        var muni=$('#cmuni').val();
        var gender=$('#cgender').val();
        var bday=$('#cbday').val();
        var mobnum=$('#cmobnum').val();
        var cprovince=$('#cprovince').val();
        var cid_other=$('#cid_other').val();
        var cpagibig=$('#cpagibig').val();
        var cphil=$('#cphil').val();

		if(firstname == '' ){
			$('#cfirstname_error').text('*First Name is Required');
			$('#cfirstname_error').css({"color":"#FF0000"});
			$('#cfirstname').css({"border-color":"#FF0000"});
		}else{
			$('#cfirstname_error').text('')
			$('#cfirstname').css({"border-color":"000000"});
		}	
		if(lastname == '' ){
			$('#clastname_error').text('*Last Name is Required');
			$('#clastname_error').css({"color":"#FF0000"});
			$('#clastname').css({"border-color":"#FF0000"});
		}else{
			$('#clastname_error').text('');
			$('#clastname').css({"border-color":"000000"});
        }	
        if(middlename == '' ){
			$('#cmiddlename_error').text('*Middle Name is Required');
			$('#cmiddlename_error').css({"color":"#FF0000"});
			$('#cmiddlename').css({"border-color":"#FF0000"});
		}else{
			$('#cmiddlename_error').text('');
			$('#cmiddlename').css({"border-color":"000000"});
		}
        if(purok == '' ){
			$('#cpurok_error').text('*Purok Name is Required');
			$('#cpurok_error').css({"color":"#FF0000"});
			$('#cpurok').css({"border-color":"#FF0000"});
		}else{
			$('#cpurok_error').text('');
			$('#cpurok').css({"border-color":"000000"});
		}	
        if(barang == '' ){
			$('#cbarang_error').text('*Barangay Name is Required');
			$('#cbarang_error').css({"color":"#FF0000"});
			$('#cbarang').css({"border-color":"#FF0000"});
		}else{
			$('#cbarang_error').text('');
			$('#cbarang').css({"border-color":"000000"});
		}		
        if(bene_type == '' ){
			$('#cbene_type_error').text('*Beneficiary Type Name is Required');
			$('#cbene_type_error').css({"color":"#FF0000"});
			$('#cbene_type').css({"border-color":"#FF0000"});
		}else{
			$('#cbene_type_error').text('');
			$('#cbene_type').css({"border-color":"000000"});
		}
        if(muni == '' ){
			$('#cmuni_error').text('*Municipality Name is Required');
			$('#cmuni_error').css({"color":"#FF0000"});
			$('#cmuni').css({"border-color":"#FF0000"});
		}else{
			$('#cmuni_error').text('');
			$('#cmuni').css({"border-color":"000000"});
		}
        if(gender == '' ){
			$('#cgender_error').text('*Gender is Required');
			$('#cgender_error').css({"color":"#FF0000"});
			$('#cgender').css({"border-color":"#FF0000"});
		}else{
			$('#cgender_error').text('');
			$('#cgender').css({"border-color":"000000"});
		}
        if(bday == '' ){
			$('#cbday_error').text('*Birthday is Required');
			$('#cbday_error').css({"color":"#FF0000"});
			$('#cbday').css({"border-color":"#FF0000"});
		}else{
			$('#cbday_error').text('');
			$('#cbday').css({"border-color":"000000"});
		}
        if(mobnum == '' ){
			$('#cmobnum_error').text('*Birthday is Required');
			$('#cmobnum_error').css({"color":"#FF0000"});
			$('#cmobnum').css({"border-color":"#FF0000"});
		}else{
			$('#cmobnum_error').text('');
			$('#cmobnum').css({"border-color":"000000"});
		}
        if(cprovince == '' ){
			$('#cprovince_error').text('*Province is Required');
			$('#cprovince_error').css({"color":"#FF0000"});
			$('#cprovince').css({"border-color":"#FF0000"});
		}else{
			$('#cprovince_error').text('');
			$('#cprovince').css({"border-color":"000000"});
		}
        if(firstname != '' && lastname != '' && middlename!='' && purok!='' && barang!='' && bene_type!='' && muni!='' && gender!='' && bday!='' && mobnum!='' && cprovince!='')
		{
			var filter=/^[0-9-+]+$/;
            if(filter.test(mobnum)){
                    if(mobnum.length!=11){
                        $('#cmobnum_error').text('*Must be 11 digit');
                        $('#cmobnum_error').css({"color":"#FF0000"});
                        $('#cmobnum').css({"border-color":"#FF0000"});
                    }else{
                        //code here
                        $('#cmobnum_error').text('')
                        $('#cmobnum').css({"border-color":"000000"});
                       
                        $.ajax({
                            url:"insert_beneficiary.php",
                            method:'POST',
                            data:new FormData(this),
                            contentType:false,
                            processData:false,
                            success:function(data)
                            {
                            
                                $('#user_form')[0].reset();
                                $('#insert_div').hide();
                                $('#table_div').hide();
                                alert(data);
                                dataTable.ajax.reload();
                            }
                        });
                    }
                }else{
                    $('#cmobnum_error').text('*Invalid Mobile Number, must be a number');
                    $('#cmobnum_error').css({"color":"#FF0000"});
                    $('#cmobnum').css({"border-color":"#FF0000"});
                    }
			
		}
		else
		{
			alert("wrong");
		}
        
	});

    $(document).on('click', '.update', function(){
		var user_id = $(this).attr("id");
        $('#assistance_form')[0].reset();
        $('#asis_user_id').val(user_id);
	});
    

    $(document).on('click', '#addassis', function(){
        var assistant=[];
        var other=$('#other_text').val();
        var checked='';
        $('#assis:checked').each(function(i,e){
            assistant.push($(this).val());
            $('#other_text').val('');
        });
        if(other!=''){
            assistant.push($('#other_text').val());
            checked='check';
        }
        var user_id = $('#asis_user_id').val();
        if(assistant==''){
            alert("choose at least 1");
        }else{
            $.ajax({
			url:"fetch_single_beneficiary_secretary.php",
			method:"POST",
			data:{user_id:user_id},
			dataType:"json",
			success:function(data)
			{
				$('#name_nila').text(data);
			}
		});
            for(i=0;i<assistant.length;i++){
                var html='<p>* '+assistant[i]+'</p>';
                $('#userModal3 .modal-body').append(html);
            }
            $('#userModal3').modal('show');
            $('#userModal').modal('hide');
        }
	});
    
    $(document).on('click', '#close_con', function(){
        $('#userModal3').modal('hide');
        $('#userModal').modal('show');
        $('#userModal3 p').remove();
	});
    $(document).on('click', '#close_con_ass', function(){
        $('#userModal3').modal('hide');
        $('#userModal').modal('show');
        $('#userModal3 p').remove();
	});

    $(document).on('click', '#add_assis', function(){
        var assistant=[];
        var other=$('#other_text').val();
        var checked='';
        $('#assis:checked').each(function(i,e){
            assistant.push($(this).val());
        });
        if(other!=''){
            assistant.push($('#other_text').val());
            checked='check';
        }
        var user_id = $('#asis_user_id').val();
        if(assistant==''){
            alert("choose at least 1");
        }else{
            $.ajax({
				url:"addassistance_beneficiary.php",
				method:'POST',
				data:{'assis[]':assistant.join(),'user_id':user_id,'check':checked},
				success:function(data)
				{
                    alert(data);
                    window.open('print_recent_request.php');
                    location.reload();
				}
			});
        }
	});

    
});
</script>