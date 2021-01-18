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
