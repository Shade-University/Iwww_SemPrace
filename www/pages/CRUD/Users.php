<?php
require_once './controller/UsersController.php';

$controller = new UsersController();

if (isset($_GET['deleteUser'])) {
    $controller->deleteUser($_GET['deleteUser']);
    header("Location: index.php?page=AdministrationPage"); //To remove get parameter
} elseif (isset($_GET['editUser'])) {
    $editUser = $controller->getUser($_GET['editUser']); //Parameter removed in javascript on modal close
}

if($_POST['action'] == "addUser") {
    $controller->createUser($_POST);
} elseif($_POST['action'] == "editUser") {
    $controller->updateUser($_POST);
}

?>

<div class="card" data-page="users">
    <h2>User</h2>
    <div class="control-row">
        <div class="search-form-wrap">
            <form class="search-form flex-box">
                <div class="input-box">
                    <label>
                        <input id="searchBar" type="search" placeholder="Search" name="Search"
                               onkeyup="searchTable('searchBar', 'usersTable', 2)">
                    </label>
                </div>
                <div class="search-btn">
                    <button><img src="./img/search.svg" alt="Search icon"></button>
                </div>
            </form>
        </div>
        <button class="btn-add" data-modal-anchor="create-user">
            <span class="icon"></span>
            <span>Create new user</span>
        </button>
    </div>
    <div class="table-wrap">
        <? $controller->createUserTable(); ?>
    </div>
</div>

<div class="modal-window <? if (isset($_GET['editUser'])) echo 'show'; ?>">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Edit user: <strong><? echo $editUser['id'] ?></strong></p>
        <form id="editUserForm" class="edit-form flex-box" method="post" action="?page=AdministrationPage">
            <input type="hidden" name="id" value="<? echo $editUser['id'] ?>">
            <div class="input-box">
                <label for="firstname">First name *</label>
                <input type="text" name="firstname" id="firstname" placeholder="First name *" required
                       value="<? echo $editUser['firstname'] ?>">
            </div>
            <div class="input-box">
                <label for="lastname">Last name *</label>
                <input type="text" name="lastname" id="lastname" placeholder="Last name *" required
                       value="<? echo $editUser['lastname'] ?>">
            </div>
            <div class="input-box">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" placeholder="Email *" required
                       value="<? echo $editUser['email'] ?>">
            </div>
            <div class="input-box">
                <label for="password">Password *</label>
                <input type="text" name="password" id="password" placeholder="Password *" required
                       value="<? echo $editUser['password'] ?>">
            </div>
            <div class="input-box">
                <label for="role">Role</label>
                <select name="role" id="role">
                    <option value="admin" <? if ($editUser['role'] == "admin") echo 'selected'; ?>>Administrator
                    </option>
                    <option value="teacher" <? if ($editUser['role'] == "teacher") echo 'selected'; ?>>Teacher</option>
                    <option value="student" <? if ($editUser['role'] == "student") echo 'selected'; ?>>Student</option>
                </select>
            </div>
            <input type="hidden" value="editUser" name="action">
            <div class="input-box ib-placeholder"></div>
            <div class="input-box">
                <button type="submit" form="editUserForm">Save</button>
            </div>
            <div class="input-box">
                <button type="reset" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-window" data-modal="create-user">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Create user</p>
        <form id="createUserForm" class="edit-form flex-box" method="post" action="?page=AdministrationPage">
            <div class="input-box">
                <label for="firstname">First name *</label>
                <input type="text" name="firstname" id="firstname" placeholder="First name *" required>
            </div>
            <div class="input-box">
                <label for="lastname">Last name *</label>
                <input type="text" name="lastname" id="lastname" placeholder="Last name *" required>
            </div>
            <div class="input-box">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" placeholder="Email *" required">
            </div>
            <div class="input-box">
                <label for="password">Password</label>
                <input type="text" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="input-box">
                <label for="role">Role</label>
                <select name="role" id="role">
                    <option value="admin">Administrator</option>
                    <option value="teacher">Teacher</option>
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