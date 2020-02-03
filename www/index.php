<html lang="en">
<head>
    <title>School system</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="assets/css/login-page.css"/>
</head>
<body>
<div class="login-wrapper">

    <div class="login-form-student">
        <div class="role-choose">
            <div class="card" data-role="Admin" data-login-type="Admin name">
                <img class="avatar" alt="admin" src="assets/img/admin.svg">
                <h2 class="title">Admin</h2>
            </div>
            <div class="card" data-role="Teacher" data-login-type="E-mail">
                <img class="avatar" alt="teacher" src="assets/img/teacher.svg">
                <h2 class="title">Teacher</h2>
            </div>
            <div class="card" data-role="Student" data-login-type="Student ID">
                <img class="avatar" alt="student" src="assets/img/student.svg">
                <h2 class="title">Student</h2>
            </div>
        </div>

        <form class="form-show" action="TODO" method="post">
            <button class="btn-back">Back</button>
            <img class="img-avatar" alt="teacher" src="assets/img/teacher.svg">
            <div class="container">
                <label for="uname"><strong><span class="role-title"></span></strong></label>
                <input type="text" placeholder="" id="uname" required>
                <label for="psw"><strong>Password</strong></label>
                <input type="password" placeholder="" id="psw" required>
                <input class="invisible role-var" type="text" value="">
                <button class="login" type="submit">Login</button>
            </div>
        </form>
    </div>

    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/index.js"></script>
</div>
</body>
</html>
