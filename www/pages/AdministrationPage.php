<?php
?>

<html lang="en">
<head>
    <title>School system - Administration</title>
    <meta charset="windows-1250">

    <link rel="stylesheet" href="../css/admin-page.css"/>
</head>
<body>
<div class="wrapper">
    <header class="menu-bar">
        <div class="left-menu">
            <div class="logo">
                <img class="logo" width="100" alt="Logo" src="../img/school.svg"/>
            </div>
            <div class="logo-text"><h1>School system - Administration</h1></div>
        </div>
        <div class="right-menu">
            <form action="../classes/logout.php">
                <button class="btn-back">Log out</button>
            </form>
            <!-- TODO:: Poslat formou nebo zavolat logout.php z a href ? -->
        </div>
    </header>

    <div class="left-pane">
        <img class="avatar" src="../img/admin.svg"/>
        <div class="list">
            <a class="list-item-users selected">Users</a>
            <a class="list-item-create">Create users</a>
            <a class="list-item-import">Import/Export users</a>
        </div>
        <!-- TODO:: Dělat odkaz nebo bez href ? -->
    </div>
    <section class="container">
        <div class="users show">
            <table class="users-table">
                <tr>
                    <th>ID</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
                <!-- TODO:: foreach z DB -->
                <tr>
                    <td>1</td>
                    <td>Lukáš</td>
                    <td>Svoboda</td>
                    <td>Lukas.Svoboda@email.cz</td>
                    <td>Student</td>
                    <td><button>Delete</button></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Lukáš</td>
                    <td>Svoboda</td>
                    <td>Lukas.Svoboda@email.cz</td>
                    <td>Student</td>
                    <td><button>Delete</button></td>
                </tr>
            </table>
        </div>
        <div class="create-user hide">
            <form action="../classes/createUser.php">
                <table class="create-user-table">
                    <tr>
                        <th><label for="firstname">Firstname</label></th>
                        <td><input type="text" id="firstname"/></td>
                        <th><label for="lastname">Lastname</label></th>
                        <td><input type="text" id="lastname"/></td>
                    </tr>
                    <tr>
                        <th><label for="email">Email</label></th>
                        <td colspan="3"><input type="email" id="email"/></td>
                    </tr>
                    <tr>
                        <th><label for="password">Password</label></th>
                        <td colspan="3"><input type="password" id="password"/></td>
                    </tr>
                    <tr>
                        <th><label for="role">Role</label></th>
                        <td>
                            <select name="role" id="role">
                                <option value="Student">Student</option>
                                <option value="Teacher">Teacher</option>
                                <option value="Admin">Administrator</option>
                            </select>
                        </td>
                        <td></td>
                        <td>
                            <button>Create user</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="import-users hide">
            <div class="cards-form">
                <div class="card" data-choice="Import">
                    <img class="icon" alt="Import" src="../img/import.svg">
                    <h2 class="title">Import users</h2>
                </div>
                <div class="card" data-role="Export">
                    <img class="icon" alt="Export" src="../img/export.svg">
                    <h2 class="title">Export users</h2>
                </div>
            </div>

        </div>

    </section>
</div>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/AdministrationPage.js"></script>
</body>
</html>
