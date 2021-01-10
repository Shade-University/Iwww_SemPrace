<?php
include("Connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = mysqli_prepare($db, "SELECT id FROM user WHERE username = ? and password = ?");
        mysqli_stmt_bind_param($stmt, "s", $_POST['username']);
        mysqli_stmt_bind_param($stmt, "s", $_POST['password']);


        if (mysqli_stmt_execute($stmt)) {
            /* store result */
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                $_SESSION['login_user'] = $_POST['username'];
                $_SESSION['login_role'] = $_POST['role'];

                if ($_POST['role'] == "Admin")
                    header("location: AdministrationPage.php");
                else if ($_POST['role'] == "Teacher")
                    header("location: TeacherPage.php");
                else if ($_POST['role'] == "Student")
                    header("location: StudentPage.php");
                else
                    $error = "Your role does not match";
            } else {
                $error = "Your Login Name or Password is invalid";
            }
            echo $error;
        }
}
?>