<?php
include("database.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $delete_id = $_POST['property_id'];
    mysqli_query($conn, "DELETE FROM property WHERE Property_id = '$delete_id'");
    // delete from rent ?
    header("Location: myRealty.php");
}