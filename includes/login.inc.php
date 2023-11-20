<?php
include ('db.php');
include ('signup.inc.php');

global $pdo;

function checkAccountExisting($pdo, $pwd){
    $email = $_POST["email"];
    $Loginpwd = $_POST["password"];
    $checkSql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($checkSql);
    $stmt->execute([$email]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $username =  $row["username"];

    if($email === $row["email"]){
        if (password_verify($Loginpwd, $row["password"])){
            session_start();
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["email"] = $_POST["password"];

            header("location: http://localhost/signUp_system/");
        }
        else{
            header("location: http://localhost/signUp_system/authentication/login.php?incorrectPwd=password inccorect");
        }
    }else {
        header("location: http://localhost/signUp_system/authentication/login.php?incorrectPwd=there is no account with this email");
    }

    exit();

}

if(isset($_POST["login"])){
    checkAccountExisting($pdo, $pwd);
}