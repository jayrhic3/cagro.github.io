<?php 
session_start();

$_SESSION['request_id']=$_POST['request_id'];
$_SESSION['beneficiary_id']=$_POST['bene_id'];
$_SESSION['type']=$_POST['type'];





?>