<?php
session_start();
include('connection.php');
if(!isset($_SESSION['username'])){
    header('location:index.php');
}

$id=$_SESSION['id'];

$query="SELECT * from inventory_all_products";
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{
    if($row['quantity']>20){
        $quer="UPDATE inventory_all_products SET status='Available' WHERE id=".$row['id']." ";
        $statement7 = $connection->prepare($quer);
        $statement7->execute();
    }else if($row["quantity"]<=0){
        $quer="UPDATE inventory_all_products SET status='Not Available' WHERE id=".$row['id']." ";
        $statement7 = $connection->prepare($quer);
        $statement7->execute();
    }else if($row["quantity"]<=20){
        $quer="UPDATE inventory_all_products SET status='Low Stock' WHERE id=".$row['id']." ";
        $statement7 = $connection->prepare($quer);
        $statement7->execute();
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  
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
   

    
    
</head>
<style>
    .card{
        width:600px;
        margin-left:300px;
    }
</style>

<body>

<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
            <div class="nano">
                <div class="nano-content">
                <ul>
                        <div class="logo"><a href="index.html"><img src="assets/images/cagro1.png" alt="" /><span>CAGRO</span></a></div>
                        <li class="label">Home</li>
                        <li><a href="dashboard3.php"><i class="ti-home"></i>Dashboard</a></li>
                        <li class="label">Secretary Reports</li>
                        <li><a href="admin_beneficiary_reports_secretary.php"><i class="ti-folder"></i>Beneficiary Reports</a></li>
                        <li><a href="admin_transactional_report.php"><i class="ti-folder"></i>Transactional Reports</a></li>
                        <li><a href="admin_feedback_report.php"><i class="ti-folder"></i>Feedback Reports</a></li>
                        <li class="label">Planning Reports</li>
                        <li><a href="admin_inventory_reports.php"><i class="ti-folder"></i>Inventory Reports</a></li>
                        <li><a href="admin_planning_barangay_report.php"><i class="ti-folder"></i>Barangay Reports</a></li>
                        <li><a href="admin_planning_beneficiary_report.php"><i class="ti-folder"></i>Beneficiary Reports</a></li>
                        <li><a href="admin_planning_statistical_report.php"><i class="ti-folder"></i>Statistical Reports</a></li>
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
                                    if($statement3 = $connection->prepare('SELECT count(product_name) as num from inventory_all_products where status!="Available"')){
                                        $statement3->execute();
                                        $result3 = $statement3->fetchAll();
                                        foreach($result3 as $row3)
                                        {
                                            $count=$row3['num'];
                                        }
                                    }
                                
                                ?>
                                <i class="ti-bell"></i><span style="color:red;font-size:12px;"><b><?php 
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
                                        
                                            if($statement4 = $connection->prepare('SELECT * from inventory_all_products where status!="Available" order by created_at desc limit 3')){
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
                                                        <small class="notification-timestamp pull-right"><?php echo $row4['status'] ?></small>
                                                        <div class="notification-heading"><?php echo $row4['product_name'] ?></div>
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
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Hello,
                                    <span>Welcome to Cagro Setting</span>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Setting</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->

                <div class="row">
                            <!-- /# column -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>Change Password</h3>
                                            <form id="form_edit_pass">
                                                <div class="form-group">
                                                    <label>Old Password:</label>
                                                    <input type="password" id="oldpass" name="oldpass" class="form-control">
                                                    <span id="oldpass_error"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label>New Password:</label>
                                                    <input type="password" id="newpass" name="newpass" class="form-control">
                                                    <span id="newpass_error"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Retype New Password:</label>
                                                    <input type="password" id="repass" name="repass" class="form-control">
                                                    <span id="repass_error"></span><br>
                                                    <input type="checkbox" id="check">Show Password
                                                </div>
                                                <div class="form-group" align="right">
                                                    <input type="button" value="Submit" class="btn btn-primary check" id="<?php echo $_SESSION['id']; ?>">
                                                </div>
                                            </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /# column -->
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
        <div id="userModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="upload_form" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Upload Photo</h4>
                            <b><button type="button" class="close" data-dismiss="modal"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                           <input type="file" name="user_image" id="user_image">
                           <span id="user_uploaded_image"></span>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="use_id" id="use_id" />
						    <input type="hidden" name="operation" id="operation" />
                            <input type="submit" id="addpic" class="btn btn-success" value="Save" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

    $('#check').click(function(){
        if(document.getElementById('check').checked){
            $('#oldpass').get(0).type='text';
            $('#newpass').get(0).type='text';
            $('#repass').get(0).type='text';
        }else{
            $('#oldpass').get(0).type='password';
            $('#newpass').get(0).type='password';
            $('#repass').get(0).type='password';
        }
    });

    $('#logout').click(function(){
        document.location.href="logout.php";
    });
    $('#profile').click(function(){
        document.location.href="profile_admin.php";
    });
    $('#setting').click(function(){
        document.location.href="admin_setting.php";
    });
    $('#view_notif').click(function(){
        document.location.href="notification_table_inventory_admin.php";
    });
   


    $(document).on('click', '.check', function(){

		var oldpass = $('#oldpass').val();
        var newpass = $('#newpass').val();
        var repass = $('#repass').val();
        var user_id = $(this).attr("id");
        var pass='<?php echo $_SESSION['password']; ?>';
        if(oldpass==''){
            $('#oldpass_error').text('*Old Password is Required');
			$('#oldpass_error').css({"color":"#FF0000"});
			$('#oldpass').css({"border-color":"#FF0000"});
        }else{
            $('#oldpass_error').text('');
			$('#oldpass').css({"border-color":""});
        }
        if(newpass==''){
            $('#newpass_error').text('*New Password is Required');
			$('#newpass_error').css({"color":"#FF0000"});
			$('#newpass').css({"border-color":"#FF0000"});
        }else{
            $('#newpass_error').text('');
			$('#newpass').css({"border-color":""});
        }
        if(repass==''){
            $('#repass_error').text('*Please Retype the New Password');
			$('#repass_error').css({"color":"#FF0000"});
			$('#repass').css({"border-color":"#FF0000"});
        }else{
            $('#repass_error').text('');
			$('#repass').css({"border-color":""});
        }

        if(oldpass!='' && newpass!='' && repass!=''){
            if(newpass!=repass){
                $('#repass_error').text('*Password Didnt Match');
                $('#repass_error').css({"color":"#FF0000"});
			    $('#repass').css({"border-color":"#FF0000"});
                $('#newpass_error').css({"color":"#FF0000"});
			    $('#newpass').css({"border-color":"#FF0000"});
            }else{
                $('#repass_error').text('');
			    $('#repass').css({"border-color":""});
                $('#newpass_error').text('');
			    $('#newpass').css({"border-color":""});
                    if(oldpass!=pass){
                        $('#oldpass_error').text('*Old Password is Incorrect');
			            $('#oldpass_error').css({"color":"#FF0000"});
			            $('#oldpass').css({"border-color":"#FF0000"});
                    }else{
                        $('#oldpass_error').text('');
			            $('#oldpass').css({"border-color":""});

                        $.ajax({
                        url:"update_password.php",
                        method:"POST",
                        data:{'id':user_id,'newpass':newpass,'oldpass':oldpass},
                        dataType:"json",
                        success:function(data)
                        {
                            alert(data.error);
                            document.location.href="logout.php";
                        }
                        });
                    }
            }

            
        }
		
	});

   
});
</script>