<?php
session_start(); 
$error=''; 

if (isset($_POST['submit'])) {
if (empty($_POST['client_username']) || empty($_POST['client_password'])) {
$error = "Username or Password is invalid";
}
else
{
// Define $username and $password
$client_username=$_POST['client_username'];
$client_password=$_POST['client_password'];

require 'connection.php';
$conn = Connect();


$query = "SELECT client_username, client_password FROM clients WHERE client_username=? AND client_password=? LIMIT 1";


$stmt = $conn->prepare($query);
$stmt -> bind_param("ss", $client_username, $client_password);
$stmt -> execute();
$stmt -> bind_result($client_username, $client_password);
$stmt -> store_result();

if ($stmt->fetch())  
{
	$_SESSION['login_client']=$client_username; 
	header("location: index.php"); 
} else {
$error = "Username or Password is invalid";
}
mysqli_close($conn); 
}
}
?>