<?php
include("database.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $delete_uname = $_POST['owner_user_name'];
    mysqli_query($conn, "DELETE FROM customer WHERE User_name = '$delete_uname'");
    mysqli_query($conn, "DELETE FROM owner WHERE Owner_user_name = '$delete_uname'");
    // on delete cascade in database
    header("Location: admin.php");
}