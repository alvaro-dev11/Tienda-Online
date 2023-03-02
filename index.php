<?php require "./inc/Session_start.php"; ?>

<!DOCTYPE html>
<html lang="es">

<?php require_once "./inc/Head.php"; ?>

<body>


    <?php
    if (!isset($_GET['vista']) || $_GET['vista'] == "" || $_GET['vista']=="index") {

        $_GET['vista'] = "home";
    }

    if (is_file("./pages/" . $_GET['vista'] . ".php") && $_GET['vista'] != "login" && $_GET['vista'] != "admin" && $_GET['vista'] != "404" && $_GET['vista'] != "product_img") {
        // <!-- Header -->
        include "./inc/NavBar.php";
        // <!-- Main -->
        include "./pages/" . $_GET['vista'] . ".php";

        // Footer
        include "./inc/Footer.php";

        // JS
        include "./inc/Scripts.php";
    } else {
        if ($_GET['vista'] == "404") {
            include "./pages/404.php";
        } elseif ($_GET['vista'] == "login") {
            include "./pages/login.php";
        } elseif ($_GET['vista'] == "admin") {
            // <!-- Header -->
            include "./inc/NavBar.php";
            include "./pages/admin.php";
            include "./inc/Scripts.php";
        } elseif ($_GET['vista'] == "product_img"){
            // <!-- Header -->
            include "./inc/NavBar.php";
            include "./pages/product_img.php";
            include "./inc/Scripts.php";
        }else{
            include "./pages/404.php";
        }
    }

    ?>

</body>

</html>