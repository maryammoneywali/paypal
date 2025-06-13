<?php
$host = "localhost";
$user = "ueriqk8ffq5t4";
$password = "m4gr4vnd96qv";
$database = "dbrdqgu0lcgx6l";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
