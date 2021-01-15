<?php
define("CRUD_MAIN_PAGE","Users"); # define default page
require_once './controller/AdministrationPageController.php';

    $controller = new AdministrationPageController();

    if(!$_SESSION['email']) {
        header("Location: ./index.php");
    }

    if(isset($_FILES['importFile'])) {
        $controller->importFile($_FILES['importFile']);
    }
?>

<div class="overview-page admin-page">
    <section class="op-body flex-box">
        <div class="col nav-col">
            <a class="logout-user" href="./classes/logout.php">
                <img src="./img/logout.svg" alt="Log out">
                <span>Log Out</span>
            </a>
            <div class="logged-user">
                <p>User:</p>
                <h3 class="line-overflow" title="<?php echo $_SESSION['fullname'] ?>"><?php echo $_SESSION['fullname'] ?></h3>
            </div>

            <ul class="nav-menu">
                <li><a href="?page=AdministrationPage" class="nav-item <? if(!$_GET['crud'] || $_GET['crud'] == "Users") echo "active" ?>"><span>Users</span></a></li>
                <li>
                    <form id="importForm" method="post" enctype="multipart/form-data">
                        <input id="file-input" type="file" onchange="document.getElementById('importForm').submit();" name="importFile" accept=".csv" style="display: none;" />
                        <a type="submit" class="nav-item import-data" onclick="document.getElementById('file-input').click();"><span>Import users</span></a>
                    </form>

                </li>
                <li><a href="exportFile.php" class="nav-item"><span>Export users</span></a></li>
                <li class="sub-menu">
                    <a href="#" class="nav-item <? if($_GET['crud'] && $_GET['crud'] != "Users") echo "active" ?>"><span>CRUD</span></a>
                    <div class="sm-box">
                        <a href="?page=AdministrationPage&crud=Subjects">Subjects</a>
                        <a href="?page=AdministrationPage&crud=Rooms">Rooms</a>
                        <a href="?page=AdministrationPage&crud=Grades">Grades</a>
                        <a href="?page=AdministrationPage&crud=Schedules">Schedules</a>
                        <a href="?page=AdministrationPage&crud=ScheduleUser">Schedule-User</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col content-col">
            <div class="nav-icon-wrap">
                <div class="nav-icon"><div></div><div></div></div>
            </div>

            <?php
            $pathToFile = "./pages/CRUD/" . $_GET["crud"] . ".php";
            if (file_exists($pathToFile)) {
                include $pathToFile;
            } else {
                include "./pages/CRUD/" . CRUD_MAIN_PAGE . ".php";
            }
            #Select right page
            ?>
        </div>
    </section>


</div>
<script type="text/javascript" src="./js/AdministrationPage.js"></script>
