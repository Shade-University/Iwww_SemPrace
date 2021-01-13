<?php
require_once './controller/AdministrationPageController.php';
    $controller = new AdministrationPageController();

    if(!$_SESSION['email']) {
        header("Location: ./index.php");
    }

    if($_GET['deleteUser']) {
        $controller->deleteUser($_GET['deleteUser']);
        header("Location: index.php?page=AdministrationPage"); //To remove get parameter
    } elseif ($_GET['editUser']) {
        $editUser = $controller->getUser($_GET['editUser']); //Parameter removed in javascript on modal close
    }

    if($_POST['action'] == "addUser") {
        $controller->createUser($_POST);
    } elseif($_POST['action'] == "editUser") {
        $controller->updateUser($_POST);
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
                <li><a href="#" class="nav-item active" data-page-anchor="users"><span>Users</span></a></li>
                <li><a href="#" class="nav-item import-data"><span>Import</span></a></li>
                <li><a href="#" class="nav-item"><span>Export</span></a></li>
                <li class="sub-menu">
                    <a href="#" class="nav-item"><span>CRUD</span></a>
                    <div class="sm-box">
                        <a href="#">Student</a>
                        <a href="#">Učitel</a>
                        <a href="#">Administrátor</a>
                        <a href="#">Předmět</a>
                        <a href="#">Známky</a>
                        <a href="#">Učitel-Předměty</a>
                        <a href="#">Předmět-Studenti</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col content-col">
            <div class="nav-icon-wrap">
                <div class="nav-icon"><div></div><div></div></div>
            </div>
            <div class="card" data-page="users">
                <h2>User</h2>
                <div class="control-row">
                    <div class="search-form-wrap">
                        <form class="search-form flex-box">
                            <div class="input-box">
                                <input id="seachBar" type="search" placeholder="Search" name="Search" onkeyup="searchUsers()">
                            </div>
                            <div class="search-btn">
                                <button><img src="./img/search.svg" alt="Search icon"></button>
                            </div>
                        </form>
                    </div>
                    <button class="btn-add-user" data-modal-anchor="create-user">
                        <span class="icon"></span>
                        <span>Create new user</span>
                    </button>
                </div>
                <div class="table-wrap">
                    <? $controller->createUserTable(); ?>
                </div>
            </div>
        </div>
    </section>

    <div class="modal-window <? if($_GET['editUser']) echo 'show';?>">
        <div class="layer-hide"></div>
        <div class="modal-box edit-add-user">
            <p>Edit user: <strong class="edit-user-id"><? echo $editUser['id'] ?></strong></p>
            <form id="editUserForm" class="edit-form flex-box" method="post" action="index.php?page=AdministrationPage">
                <input type="hidden" name="id" value="<? echo $editUser['id'] ?>">
                <div class="input-box">
                    <label for="First name">First name *</label>
                    <input type="text" name="firstname" placeholder="First name *" value="<? echo $editUser['firstname'] ?>">
                </div>
                <div class="input-box">
                    <label for="Last name">Last name *</label>
                    <input type="text" name="lastname" placeholder="Last name *" value="<? echo $editUser['lastname'] ?>">
                </div>
                <div class="input-box">
                    <label for="Email">Email *</label>
                    <input type="email" name="email" placeholder="Email *" value="<? echo $editUser['email'] ?>">
                </div>
                 <div class="input-box">
                    <label for="password">Password *</label>
                    <input type="text" name="password" placeholder="Password *" value="<? echo $editUser['password'] ?>">
                </div>
                <div class="input-box">
                    <label for="role">Role</label>
                    <select name="role">
                        <option value="admin" <? if($editUser['role'] == "admin") echo 'selected'; ?>>Administrator</option>
                        <option value="teacher" <? if($editUser['role'] == "teacher") echo 'selected'; ?>>Teacher</option>
                        <option value="student" <? if($editUser['role'] == "student") echo 'selected'; ?>>Student</option>
                    </select>
                </div>
                <input type="hidden" value="editUser" name="action">
                <div class="input-box ib-placeholder"></div>
                <div class="input-box">
                    <button type="submit" form="editUserForm" class="hide-modal">Save</button>
                </div>
                <div class="input-box">
                    <button type="reset" class="hide-modal">Storno</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-window">
        <div class="layer-hide"></div>
        <div class="modal-box edit-add-user">
            <p>Create user</p>
            <form id="createUserForm" class="edit-form flex-box" method="post" action="index.php?page=AdministrationPage">
                <div class="input-box">
                    <label for="First name">First name *</label>
                    <input type="text" name="firstname" placeholder="First name *" required>
                </div>
                <div class="input-box">
                    <label for="Last name">Last name *</label>
                    <input type="text" name="lastname" placeholder="Last name *" required>
                </div>
                <div class="input-box">
                    <label for="Email">Email *</label>
                    <input type="email" name="email" placeholder="Email *" required>
                </div>
                <div class="input-box">
                    <label for="password">Password</label>
                    <input type="text" name="password" placeholder="Password" required>
                </div>
                <div class="input-box">
                    <label for="role">Role</label>
                    <select name="role">
                        <option value="admin">Administrator</option>
                        <option value="prof">Professor</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <div class="input-box ib-placeholder"></div>
                <input type="hidden" name="action" value="addUser">
                <div class="input-box">
                    <button type="submit" form="createUserForm">Create</button>
                </div>
                <div class="input-box">
                    <button type="reset" form="createUserForm" class="hide-modal">Storno</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="./js/AdministrationPage.js"></script>
