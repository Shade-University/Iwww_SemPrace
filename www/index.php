<?php
    session_start();
    define("MAIN_PAGE","LoginPage"); # define default page
    ob_start(); # To fix some weird redirect error
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Tomas Vondra">
    <meta name="description" content="School system">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School system</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/default.css" />
    <?php
    $cssFile = "./css/" . $_GET["page"] . ".css";
    if (file_exists($cssFile)) {
        echo "<link rel=\"stylesheet\" href=\"$cssFile\"/>";
    } else {
        echo "<link rel=\"stylesheet\" href=\"../css/" . MAIN_PAGE . ".css\"/>";
    }
    #Select right css file to page
    ?>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/shared.js"></script>
</head>

<body>
<div id="content">
    <?php
    $pathToFile = "./pages/" . $_GET["page"] . ".php";
    if (file_exists($pathToFile)) {
        include $pathToFile;
    } else {
        include "./pages/" . MAIN_PAGE . ".php";
    }
    #Select right page
    ?>
</div>
</body>
</html>
