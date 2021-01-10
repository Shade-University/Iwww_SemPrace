<?php
$mapping = array("admin" => "AdministrationPage",
                "teacher"=> "TeacherPage",
                "student" =>"StudentPage");

require_once './controller/LoginPageController.php';

$loginPageController = new LoginPageController();


$wrong = false;
if (isset($_POST['login'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $user = $loginPageController->login($_POST['username'], $_POST['password'], $_POST['remember']);
        if ($user) {
            header('Location: index.php?page=' . $mapping[$user['role']]);
        } else {
            $wrong = true;
        }
    } else {
        $wrong = true;
    }
}
?>

<div class="login-page">
    <form id="form" class="login-form" method="post">
        <div class="flex-box">
            <div class="col">
                <div class="radio-btn-group">
                    <input id="admin-role" type="radio" checked="checked" name="role" value="admin">
                    <label for="admin-role" class="custom-radio">Administrator</label><br>
                    <input id="teacher-role" type="radio" name="role" value="teacher">
                    <label for="teacher-role" class="custom-radio">Teacher</label><br>
                    <input id="student-role" type="radio" name="role" value="student">
                    <label for="student-role" class="custom-radio">Student</label>
                </div>
            </div>
            <div class="col">
                <div class="input-group">
                    <input type="text" name="username" placeholder="user@domain.cz"/>
                </div>
                <div class="input-group <? if ($wrong) echo "wrong" //Improvement - Error message?>">
                    <input type="password" name="password" placeholder="Password"/>
                    <span class="msg">Wrong username or password</span>
                </div>
            </div>
            <div class="col">
                <input id="remember" name="remember" type="checkbox" disabled checked="checked">
                <label for="remember" class="custom-checkbox">Remember me</label>
            </div>
            <!-- Improvement - Captcha-->
            <div class="col">
                <button class="submit-btn" type="submit" name="login" form="form"><span>log in</span></button>
            </div>
        </div>
    </form>
</div>