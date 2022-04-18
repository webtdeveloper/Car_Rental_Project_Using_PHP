<?php
session_start(); // Starting Session
$error=''; 

if (isset($_POST['submit'])) {
if (empty($_POST['customer_username']) || empty($_POST['customer_password'])) {
$error = "Username or Password is invalid";
}
else
{
// Define $username and $password
$customer_username=$_POST['customer_username'];
$customer_password=$_POST['customer_password'];
require 'connection.php';
$conn = Connect();

$query = "SELECT customer_username, customer_password FROM customers WHERE customer_username=? AND customer_password=? LIMIT 1";

$stmt = $conn->prepare($query);
$stmt -> bind_param("ss", $customer_username, $customer_password);
$stmt -> execute();
$stmt -> bind_result($customer_username, $customer_password);
$stmt -> store_result();

if ($stmt->fetch()) 
{
	$_SESSION['login_customer']=$customer_username; 
	header("location: index.php"); 
} else {
$error = "Username or Password is invalid";
}
mysqli_close($conn); 
}
}
?>