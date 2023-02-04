<?php

//Database connection function
function dbConnect()
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "list";

    $conn = mysqli_connect($hostname, $username, $password, $database) or die("Database connection failed.");
    return $conn;
}

$conn = dbConnect();