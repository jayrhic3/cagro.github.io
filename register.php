<?php


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
    <link href="dist/js/bootstrap.min.css" rel="stylesheet">
    <link href="dist/js/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <!-- Datatable -->

    
</head>
<style>
    .panel{
        width:450px;
        margin-top:120px;
        margin-left:520px;
    }
    .btn-primary{
        margin-left:170px;
    }
    .reg{
        margin-left:190px;
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
        background-color: #343957; 
    }
</style>

<body class="back">

    <div class="panel">
        <div class="panel-body">
            <form method="post" id="user_form">
                <h1 style="text-align:center;">Register</h1> <br>
                <div class="form-group">
                    <label>User Name:</label>
                    <input type="text" name="username" id="username" class="form-control">
                    <span id="username_error"></span>
                </div>
                <div class="form-group">
                    <label>Position:</label>
                    <select name="position" id="position" class="form-control">
                        <option value=""></option>
                        <option value="Admin">Admin</option>
                        <option value="Secretary">Secretary</option>
                        <option value="Planning">Planning</option>
                    </select>
                    <span id="position_error"></span>
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" id="example-progress" class="form-control password xample-tooltip">
                    <div id="example-progress-bar-container">
                    <span id="password_error"></span>
                </div>
                <div class="form-group">
                    <label>Retype Password:</label>
                    <input type="password" name="repassword" id="repassword" class="form-control">
                    <span id="repassword_error"></span><br>
                    <input type="checkbox" id="check">Show Password
                </div><hr>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" id="register" value="Register">
                    <p class="reg"><a href="login.php">Login</a> </p>
                </div>
            </form>
        </div>
    </div>
    

</body>

<div class="footer">
    <h6>2019 © DAVAO DEL NORTE STATE COLLEGE - INSTITUTE OF INFORMATION TECHNOLOGY. - <a href="http://dnsc.edu.ph/">www.dnsc.edu.ph</a></h6>
</div>
    
    
    
    
    <script src="js/jquery.min.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <script src="dist/js/password-score.js"></script>
    <script src="dist/js/password-score-options.js"></script>
    <script src="dist/js/bootstrap-strength-meter.js"></script>

   


</html>


<script>
$(document).ready(function(){ 


    $('#example-getting-started-input').strengthMeter('text', {
            container: $('#example-getting-started-text')
        });
        $('#example-tooltip').strengthMeter('tooltip');
		$('#example-progress').strengthMeter('progressBar', {
            container: $('#example-progress-bar-container')
        });

        $('#check').click(function(){
        if(document.getElementById('check').checked){
            $('.password').get(0).type='text';
            $('#repassword').get(0).type='text';
        }else{
            $('.password').get(0).type='password';
            $('#repassword').get(0).type='password';
        }
        });

    $(document).on('submit', '#user_form', function(event){
		event.preventDefault();
        var username=$('#username').val()
        var position=$('#position').val()
        var password=$('.password').val()
        var repassword=$('#repassword').val()

        if(username == '' ){
			$('#username_error').text('*User Name is Required');
			$('#username_error').css({"color":"#FF0000"});
			$('#username').css({"border-color":"#FF0000"});
		}else{
			$('#username_error').text('')
			$('#username').css({"border-color":""});
		}
        if(position == '' ){
			$('#position_error').text('*Position is Required');
			$('#position_error').css({"color":"#FF0000"});
			$('#position').css({"border-color":"#FF0000"});
		}else{
			$('#position_error').text('')
			$('#position').css({"border-color":""});
		}	
        if(password == '' ){
			$('#password_error').text('*Password is Required');
			$('#password_error').css({"color":"#FF0000"});
			$('.password').css({"border-color":"#FF0000"});
		}else{
			$('#password_error').text('')
			$('.password').css({"border-color":""});
		}	
        
        if(username != '' && password != ''){
            if(password!=repassword){
                $('#repassword').css({"border-color":"#FF0000"});
                $('.password').css({"border-color":"#FF0000"});
                $('#repassword_error').text('*Password Did not Match');
                $('#repassword_error').css({"color":"#FF0000"});
            }else{
                $('#repassword').css({"border-color":""});
                $('.password').css({"border-color":""});
                $('#repassword_error').text('');
                $('#repassword_error').css({"color":""});

                $.ajax({
				url:"authentication.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
                    alert(data);
                    document.location.href="login.php";
				}
			    });

            }
        }

    });

});
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','dist/js/analytics.js','ga');

  ga('create', 'UA-46156385-1', 'cssscript.com');
  ga('send', 'pageview');

</script>