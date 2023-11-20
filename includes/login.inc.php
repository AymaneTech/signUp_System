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
            header("location: http://localhost/signUp_system/?username=$username");
        }
        else{
            session_start();
            $_SESSION["incorrectPwd"] = "invalid password";
            header("location: http://localhost/signUp_system/authentication/login.php?erro=email incorrect");
        }
    }else {
        session_start();
        $_SESSION["incorrectPwd"] = "there is no account with this email";
        header("location: http://localhost/signUp_system/authentication/login.php?erro=email incorrect");
    }
    exit();

}

if(isset($_POST["login"])){
    checkAccountExisting($pdo, $pwd);
}