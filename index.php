<?php
session_start();
if(isset($_SESSION['position'])){
  if($_SESSION['position']=="Secretary"||$_SESSION['position']=="secretary"){
    header('location:dashboard.php');
  }
  elseif($_SESSION['position']=="Planning"||$_SESSION['position']=="planning"){
    header('location:dashboard2.php');
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
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">

    <!-- Datatable -->

    
</head>
<style>
    .btn-primary{
        margin-left:170px;
    }
    .reg{
        margin-left:90px;
    }
    .footer{
        position: fixed;
        left:0;
        bottom:0;
        width:100%;
        background-color: white;
        color: #343957;
        text-align: center;
    }
    .back{
        background-image: url("assets/images/green.jpg");
        background-size: 1500px;
        /*background-color: #0b6623; */
    }
    body {
  overflow: hidden; /* Hide scrollbars */
    }
</style>

<body class="back">
    <div class="mx-auto mt-4" style="width: 400px;">
        <div class="card card-body " style="height: 38rem;">
            <form method="post" id="user_form">
            <img src="assets/images/infosteam.png" class="img-fluid" alt="Responsive image">
                <h1 style="text-align:center;">Sign in</h1>
                <div class="form-group">
                    <label>User Name:</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                    <span id="username_error"></span>
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <div class="row">
                        <div class="col-md-10">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            <span id="password_error"></span><br>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-default ti-eye" id="check"></button>
                            <button type="button" class="btn btn-default ti-close" id="check2"></button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" id="login" value="Login">
                    
                </div>
            </form>
        </div>
    </div>
</div>

</body>

<div class="footer">
    <h6>2019 © DAVAO DEL NORTE STATE COLLEGE - INSTITUTE OF INFORMATION TECHNOLOGY. - <a href="http://dnsc.edu.ph/">www.dnsc.edu.ph</a></h6>
</div>
    
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>

</html>

<script>
$(document).ready(function(){ 
    $('#check2').hide();
    $('#check').show();
    
    $('#check').click(function(){
        $('#check').hide();
        $('#check2').show();
        $('#password').get(0).type='text';
    });

    $('#check2').click(function(){
        $('#check2').hide();
        $('#check').show();
        $('#password').get(0).type='password';
    });

    $(document).on('submit', '#user_form', function(event){
		event.preventDefault();
        var username=$('#username').val()
        var password=$('#password').val()

        if(username == '' ){
			$('#username_error').text('*User Name is Required');
			$('#username_error').css({"color":"#FF0000"});
			$('#username').css({"border-color":"#FF0000"});
		}else{
			$('#username_error').text('')
			$('#username').css({"border-color":""});
		}	
        if(password == '' ){
			$('#password_error').text('*Password is Required');
			$('#password_error').css({"color":"#FF0000"});
			$('#password').css({"border-color":"#FF0000"});
		}else{
			$('#password_error').text('')
			$('#password').css({"border-color":""});
		}	

        if(password!='' && username!=''){
            $.ajax({
				url:"check_login.php",
				method:'POST',
                dataType:"json",
				data:{'username':username,'password':password},
				success:function(data)
				{
                    alert(data.errors);
                    if(data.position=="secretary"||data.position=="Secretary"){
                        document.location.href="dashboard.php";
                    }
                    else if(data.position=="Planning"){
                        document.location.href="dashboard2.php";
                    }
                    else if(data.position=="Admin"){
                        document.location.href="dashboard3.php";
                    }
				}
			    });

        }
        
    });

});
</script>