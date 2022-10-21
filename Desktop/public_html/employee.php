<?php
session_start();
include "include/helper.php";
include 'include/db.inc.php';
// בדיקת התחברות של המשתמש
if( !isLogin() ){
    header('location:index.php');
    exit;
}

// בדיקה האם ת.ז של הלקוח קיימת בבסיס הנתונים
if( !isset($_SESSION['emloyee_id']) ){
    header('location:emloyee.php');
    exit;
}


$customer_id = $_SESSION['emloyee_id'];
$tab_id = 1;
// או מטופס החיפוש או מהקישור "הירשם"
if( isset($_REQUEST['tab_id']) ){
    $tab_id = $_REQUEST['tab_id'];
}

/****************** פרטים אישיים ***************/
// update_customer
if( isset( $_REQUEST['update_emloyee']) ) {
    $name = $_REQUEST['name'];
    $id_number = $_REQUEST['id_number'];
    $role_id = $_REQUEST['role_id'];
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $city = $_REQUEST['city'];
    $address = $_REQUEST['address'];
    
    $update = "UPDATE `customers` SET `name`='$name', 
                                      `id_number`='$id_number', 
                                      `role_id`=$role_id, 
                                      `username`='$username', 
                                      `password`='$password', 
                                      `email`='$email',
                                      `phone`='$phone',
                                      `city`='$city',
                                      `address`='$address', 
                                      WHERE `id`=$emloyee_id";
    $conn->query( $update );
    $personalE_info_updated = true;
}

if( isset( $_REQUEST['delete_emloyee']) ) {
    $conn->query( "DELETE FROM `emloyees` WHERE `id`=$emloyee_id");
    $_SESSION['emloyee_deleted'] = true;
    header('location:emloyees.php');
    exit;
}

$result = $conn->query("SELECT * FROM `emloyees` WHERE `id`=$emloyee_id");
$emloyee = $result->fetch_array(MYSQLI_ASSOC);


include 'views/header.php';
?>
   
<?php
include 'views/footer.php';
