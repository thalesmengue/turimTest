<?php

$host = "localhost";
$database = "turimTest";
$username = "root";
$pass = "#Thales99#";

$conn = new PDO("mysql:host=$host;dbname=$database", $username, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

