<?php
date_default_timezone_set('Asia/Jerusalem');

$host="localhost";
$username = "isomerte_sowdb";
$password = "y4^h]%]&e?Nz";
$database="isomerte_sowdb";

$conn = new mysqli($host,$username,$password,$database);

$conn->set_charset("utf8");
