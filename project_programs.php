<?php

session_start();
include('connection.php');
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
    <link href="js/fullcalendar.css" rel="stylesheet">
   

    <!-- Datatable -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <link href="assets/css/jquery-ui.css" rel="stylesheet" />
    <script src="js/moment.min.js"></script>
    <script src="js/fullcalendar.min.js"></script>
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/buttons.dataTables.min.css" rel="stylesheet" />
    <style>
        .back{
            background:skyblue;
        }
        #calendar .fc-widget-header{
            background-color:lightblue;
        }
        .form-control{
            border-color:black;
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
                
                <div class="row" id="show_calendar">
                            <!-- /# column -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                    <h3>Activities</h3>
                                        <div id="calendar"></div>
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



    <!-- Common -->
    <div id="userModal" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="event_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Create Event</h4>
                            <b><button type="button" class="close" data-dismiss="modal"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                           <div class="form-group">
                           <label >Event Name:</label>
                                <input type="text" id="event" class="form-control" name="event">
                                <span class="event_error"></span>
                           </div>
                           <div class="form-group">
                           <label >Event Description:</label>
                                <input type="text" id="des" class="form-control" name="des">
                                <span class="des_error"></span>
                           </div>
                            <div class="form-group">
                                <label>Barangay:</label>
                                <select name="barang" id="barang" class="form-control">
                                    <option value="All">All</option>
                                    <?php 
                                    
                                    $query2 = "SELECT description FROM barangay";
                                    $statement2 = $connection->prepare($query2);
                                    $statement2->execute();
                                    $result2 = $statement2->fetchAll();
                                    foreach($result2 as $row2)
                                    {
                                        $des=$row2['description'];
                                        echo "
                                                <option value='".$des."' name='assis[]'> ".$des." 
                                           </option>";
                                    }
                                    
                                    
                                    

                                    ?>
                                </select>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="asis_user_id" id="asis_user_id" />
                            <button id="addassis" class="btn btn-success">Add</button>
                            <button class="btn btn-default" id="close_add" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="userModal2" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="update_event_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Event</h4>
                            <b><button type="button" class="close" data-dismiss="modal"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                           <div class="form-group">
                           <label >Event Name:</label>
                                <input type="text" id="eventr" class="form-control" name="event">
                                <span class="event_error"></span>
                           </div>
                           <div class="form-group">
                           <label >Event Name:</label>
                                <input type="text" id="desr" class="form-control" name="desr">
                                <span class="desr_error"></span>
                           </div>
                           <div class="form-group">
                                <label>Barangay:</label>
                                <select name="barang2" id="barang2" class="form-control">
                                    <option value=""></option>
                                    <?php 
                                    
                                    $query3 = "SELECT description FROM barangay";
                                    $statement3 = $connection->prepare($query3);
                                    $statement3->execute();
                                    $result3 = $statement3->fetchAll();
                                    foreach($result3 as $row2)
                                    {
                                        $des=$row2['description'];
                                        echo "
                                                <option value='".$des."' name='assis[]'> ".$des." 
                                           </option>";
                                    }
                                    
                                    
                                    

                                    ?>
                                </select>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="asis_user_id" id="asis_user_id" />
                            <button id="Save" class="btn btn-success">Save</button>
                            <button id="Delete" class="btn btn-danger">Delete</button>
                            <button type="submit" class="btn btn-default" data-dismiss="modal" id="close_update">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    
    

</body>
   
    <script src="js/scripts.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
    <script src="assets/js/lib/menubar/sidebar.js"></script>
    <script src="assets/js/lib/preloader/pace.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/moment.min.js"></script>
    
    

</html>

<script>
$(document).ready(function(){
    var interval=setInterval(function(){
        var momentNow=new moment();
        $('#datetime').html(momentNow.format('MMMM DD, YYYY')+' '+momentNow.format('dddd').substring(0,3).toUpperCase());
        $('#time').html(momentNow.format('A hh:mm:ss'));
   },100);

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

    var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay,listMonth'
    },
    events: 'load_event.php',
    selectable:true,
    selectHelper:true,
    displayEventTime: false,
    
    select: function(start, end, allDay)
    {
        $('#userModal').modal('show');
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                    $('#addassis').click(function(){
                            var title=$('#event').val();
                            var des=$('#des').val();
                            var barang=$('#barang').val();
                                if(title!=''){
                                    $.ajax({
                                    url:"insert_event.php",
                                    type:"POST",
                                    data:{'title':title, 'start':start, 'end':end,'des':des,'barang':barang},
                                    success:function()
                                    {
                                        $('#userModal').modal('hide');
                                        
                                        alert("Added Successfully");
                                        $('#event_form')[0].reset();
                                        calendar.fullCalendar('refetchEvents');
                                    }
                                    });
                                }else{
                                    $('#event_form')[0].reset();
                                    $('#userModal').modal('hide');
                                    alert("No data");
                                }
                            
                    });
        
    },
    editable:true,
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var des = event.des;
     var barang = event.barang;
     var id = event.id;
     $.ajax({
      url:"update_event.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id,des:des,barang:barang},
      success:function(){
       calendar.fullCalendar('refetchEvents');
       alert('Event Update');
      }
     })
    },

    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var des = event.des;
     var barang = event.barang;
     var id = event.id;
     $.ajax({
      url:"update_event.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id,des:des,barang:barang},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Event Updated");
      }
     });
    },

    eventClick:function(event)
    {
        $('#userModal2').modal('show');
        $('#eventr').val(event.title);
        $('#desr').val(event.des);
        $('#barang2').val(event.barang);
        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");

        $('#Save').click(function(){
                var title=$('#eventr').val();
                var des =$('#desr').val();
                var barang =$('#barang2').val();
                var id = event.id;
                    $.ajax({
                    url:"update_event.php",
                    type:"POST",
                    data:{title:title, start:start, end:end, id:id,des:des,barang:barang},
                    success:function()
                    {
                    alert("Event Updated");
                    $('#userModal2').modal('hide');
                    calendar.fullCalendar('refetchEvents');
                    }
                    });
            });
            $('#Delete').click(function(){
                $('#userModal2').modal('hide');
                if(confirm("Are you sure you want to remove it?"))
                    {
                    var id = event.id;
                    $.ajax({
                    url:"delete_event.php",
                    type:"POST",
                    data:{id:id},
                    success:function()
                    {
                        alert("Event Removed");
                        $('#userModal2').modal('hide');
                        $('#update_event_form')[0].reset();
                        calendar.fullCalendar('refetchEvents');
                    }
                    })
                    }
            });
    },
    eventRender: function(event, element) {
                    element.css('background-color', '#ECB7C5');
                    element.css('color', '#000');
            },

   });

   
   $('#close_add').click(function(){
        $('#userModal2').modal('hide');
        $('#userModal').modal('hide');
        calendar.fullCalendar('refetchEvents');
   });
   $('#close_update').click(function(){
        $('#userModal2').modal('hide');
        $('#userModal').modal('hide');
        calendar.fullCalendar('refetchEvents');
   });

   $('#showtable').click(function(){
    document.location.href="table_calendar.php";
    });
    
});
</script>