<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Shopluxe";

$conn= mysqli_connect($servername, $username, $password) or die ("could not connect to mysql");
mysqli_select_db($conn,$dbname) or die ("no database");
