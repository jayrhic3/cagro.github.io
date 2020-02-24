<?php 
session_start();
$DATABASE_HOST = "localhost"; 
$DATABASE_USER = "root"; 
$DATABASE_PASS = ""; 
$DATABASE_NAME = "cagro";

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$output=array();
$username=$_POST['username'];
$pass=$_POST['password'];
$mix="";
if ($stmt = $con->prepare('SELECT id, password,position,salt,lastname,firstname FROM users WHERE username = ?')) {
        //1 Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        //1 Store the result so we can check if the account exists in the database.
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password,$position,$salt,$lastname,$firstname);
            $stmt->fetch();
                $mix.=$salt;
                $mix.=$pass;
                if (password_verify($mix."DNSC_SECURITY", $password)){
                    $output['errors']="Login Successful!";
                    $_SESSION['username']=$username;
                    $_SESSION['position']=$position;
                    $_SESSION['id']=$id;
                    $_SESSION['password']=$pass;
                    $output['position']=$position;
                    $_SESSION['name']=$firstname." ".$lastname;
                       
                }else{
                    $output['errors']="Wrong Password";
                }
        } else{
            $output['errors']= "you are not register, please check your User Name";
        }
        
    $con->close();
    echo json_encode($output);
}
?>

