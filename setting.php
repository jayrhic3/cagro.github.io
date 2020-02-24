<?php
session_start();
include('connection.php');

$id=$_SESSION['id'];
if(!isset($_SESSION['username'])){
    header('location:index.php');
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
                                    if($statement = $connection->prepare('SELECT COUNT(title) as num from notification WHERE event_status="Unread"')){
                                        $statement->execute();
                                        $result = $statement->fetchAll();
                                        foreach($result as $row)
                                        {
                                            $count=$row['num'];
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
                                        
                                            if($statement = $connection->prepare('SELECT * from notification order by start_event desc limit 3')){
                                                $statement->execute();
                                                $result = $statement->fetchAll();
                                                
                                                if(!empty($result)){

                                                

                                                foreach($result as $row)
                                                {
                                                 
                                        
                                        ?>

                                            <li>
                                                <a >
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/notif.png" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right"><?php echo $row['event_status'] ?></small>
                                                        <div class="notification-heading"><?php echo $row['title'] ?></div>
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

                <div class="row">
                            <!-- /# column -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                    <h3>Settings</h3>
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
        document.location.href="profile_secretary.php";
    });
    $('#setting').click(function(){
        document.location.href="setting.php";
    });
    $('#view_notif').click(function(){
        document.location.href="notification_table.php";
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