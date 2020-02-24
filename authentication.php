<?php 

$DATABASE_HOST = "localhost"; 
$DATABASE_USER = "root"; 
$DATABASE_PASS = ""; 
$DATABASE_NAME = "cagro";

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$username=$_POST['username'];
$position=$_POST['position'];
$password=$_POST['password'];
$mix="";
if ($stmt = $con->prepare('SELECT id, password FROM users WHERE username = ?')) {
        //1 Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        //1 Store the result so we can check if the account exists in the database.
        if ($stmt->num_rows > 0) {
        //1 Username already exists
        echo 'Username exists, please choose another!';
    } else{
        if ($stmt = $con->prepare('INSERT INTO users (username, password, position,salt,profiles) VALUES (?, ?, ?, ?,?)')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in. 
            $salt=rand().'paypa';
            $mix.=$salt;
            $mix.=$password;
            $profile="user.png";
            $passhash = password_hash($mix."DNSC_SECURITY", PASSWORD_DEFAULT);

            $stmt->bind_param('sssss', $username,$passhash,$position,$salt,$profile);
            $stmt->execute();
            echo 'You have successfully registered, you can now login';
            } else	{
            //1 Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields. echo 'Could not prepare statement!';
            }
    }

    $con->close();
}
?>

