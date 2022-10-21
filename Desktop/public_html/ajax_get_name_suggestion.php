<?php
include 'include/db.inc.php';
$name = $_REQUEST['str'];

$result = $conn->query( "SELECT `id`,`name` FROM `customers` WHERE `name` LIKE '$name%'");

$li = "";
while( $row = $result->fetch_assoc() ) {
    $li .= '<li onclick="setNameValue('.$row['id'].')" id="name_id_'.$row['id'].'">'.$row['name'].'</li>';
}
echo $li;

