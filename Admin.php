<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("database.php");
$loggedIn = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
$username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$usertype = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : '';

if ($usertype != "admin") {
    header("location: index.php");
}
include("processOwner.php");
include("processTenant.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/bootstrap.css">
    <link rel="stylesheet" href="./CSS/Admin.css">
    <link rel="stylesheet" href="./CSS/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Profile</title>
</head>

<body>

    <?php include('./Templates/navbar.php'); ?>


    <!------------------------------------------START SECTION---------------------------------------->

    <section>
        <div class="container">
            <button class="Add-users" onclick="redirectToAddUser()">Add User</button>
        </div>
        <script>
            function redirectToAddUser() {
                window.location.href = "addUser.php";
            }
        </script>
    </section>

    <section>
        <div class="container">
            <div class="row align-items-center">
                <h3 class="col-12 col-md-3 col-lg-2 text-start">Tenants:</h3>
                <label class="col-4 col-md-2 col-lg-2 text-center">Search: </label>
                <input class="col-5 col-md-4 col-lg-3" placeholder="User Name" type="text">
            </div>

            <form action="processTenant.php" method="POST">
                <div class="Tenants container">
                    <?php
                    $query_tenant = "SELECT Tenant_user_name
                                 FROM tenant
                                 LIMIT 6";
                    $result_tenant = mysqli_query($conn, $query_tenant);
                    while ($row_tenant = mysqli_fetch_array($result_tenant)) {
                        $tenant_user_name = $row_tenant['Tenant_user_name'];
                    ?>
                        <input type="hidden" name="tenant_user_name" value=<?php echo $tenant_user_name ?>>
                        <div class="infornation-row row justify-content-between">
                            <h5 class="col-5 col-sm-7"><?php echo $tenant_user_name ?></h5>
                            <button class="Delete col-3 col-sm-2" type="submit" name="delete" value="<?php echo $tenant_user_name ?>">Delete</button>
                            <button class="Update col-3 col-sm-2" type="submit" name="update" value="<?php echo $tenant_user_name ?>">Update</button>
                        </div>
                        <hr>
                    <?php } ?>
            </form>
        </div>
        <div class="row align-items-center" style="margin-top: 50px;">
            <h3 class="col-12 col-md-3 col-lg-2 text-start">Owners:</h3>
            <label class="col-4 col-md-2 col-lg-2 text-center">Search: </label>
            <input class="col-5 col-md-4 col-lg-3" placeholder="User Name" type="text">
        </div>
        <form action="processOwner.php" method="POST">
            <div class="Tenants container align-items-center">
                <?php
                $query_owner = "SELECT Owner_user_name, COUNT(Property_id)
                                FROM owner LEFT JOIN property USING (Owner_user_name)
                                GROUP BY Owner_user_name 
                                LIMIT 6";
                $result_owner = mysqli_query($conn, $query_owner);
                while ($row_owner = mysqli_fetch_array($result_owner)) {
                    $owner_user_name = $row_owner['Owner_user_name'];
                    $num_properties = $row_owner['COUNT(Property_id)'];
                ?>
                    <input type="hidden" name="owner_user_name" value=<?php echo $owner_user_name ?>>
                    <div class="infornation-row row justify-content-between align-items-center">
                        <h5 class="col-6 col-lg-2"><?php echo $owner_user_name ?></h5>
                        <p class="col-6 col-lg-2">No. of properties <span><?php echo $num_properties ?></span></p>
                        <button <?php echo ($num_properties > 0 ? "" : "style = 'visibility: hidden';") ?> class="Show-properties col-4 col-lg-2" type="submit" name="show" value="<?php echo $owner_user_name ?>">Show properties</button>
                        <button class="Delete col-3 col-lg-2" type="submit" name="delete" value="<?php echo $owner_user_name ?>">Delete</button>
                        <button class="Update col-3 col-lg-2" type="submit" name="update" value="<?php echo $owner_user_name ?>">Update</button>
                    </div>
                <?php } ?>

                <hr>
            </div>
        </form>
        </div>
    </section>
    <!------------------------------------------End SECTION---------------------------------------->


    <script src="./js/popper.min.js"></script>
    <script src="./js/jquery-3.6.4.min.js"></script>
    <script src="./js/bootstrap.js"></script>
    <script src="./js/browse.js"></script>


</body>

</html>