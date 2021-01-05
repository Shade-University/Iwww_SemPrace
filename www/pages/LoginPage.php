<div class="login-wrapper">

    <div class="login-form-student">
        <div class="role-choose">
            <div class="card" data-role="Admin">
                <img class="avatar" alt="admin" src="../img/admin.svg">
                <h2 class="title">Admin</h2>
            </div>
            <div class="card" data-role="Teacher">
                <img class="avatar" alt="teacher" src="../img/teacher.svg">
                <h2 class="title">Teacher</h2>
            </div>
            <div class="card" data-role="Student">
                <img class="avatar" alt="student" src="../img/student.svg">
                <h2 class="title">Student</h2>
            </div>
        </div>

        <form class="form-show" action="../classes/login.php" method="post">
            <button class="btn-back">Back</button>
            <img class="img-avatar" alt="teacher" src="../img/teacher.svg">
            <div class="container">
                <label for="username"><strong>Username</strong></label>
                <input type="text" placeholder="" id="username" required>
                <label for="password"><strong>Password</strong></label>
                <input type="password" placeholder="" id="password" required>
                <input class="invisible role-var" type="text" id="role" value="">
                <button class="login" type="submit">Login</button>
            </div>
        </form>
    </div>

    <script type="text/javascript" src="../js/LoginPage.js"></script>