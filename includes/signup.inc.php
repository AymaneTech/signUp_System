<?php
include ('db.php');


if(isset($_POST["register"])){
    register();
}

function register(){
    global $pdo;

    $username = $_POST["username"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwd2 = $_POST["pwd2"];

    // check password
    if($pwd !== $pwd2){
        session_start();
        $_SESSION["incorrectPwd"] = "invalid password";
        header("Location: http://localhost/signUp_system/signup.php?password=inccorect");
    }
    // if is correct i put user info in an array
    else {
        $userInfo= [
            'username' => $username,
            'email' => $email,
            'pwd' => hash_password($_POST["pwd"])
        ];
        insertUserData($pdo, $userInfo);
        session_start();
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["password"] = $userInfo["pwd"];
        $_SESSION["username"] = $_POST["username"];

        header("location: http://localhost/signUp_system");

    }
    exit();
}
// function that insert data in database
function insertUserData($pdo, $userInfo){
    $insertQuery = "INSERT INTO users (username, email, password) VALUES (?, ?, ?);";
    $stmt = $pdo->prepare($insertQuery);
    $stmt->bindParam(1, $userInfo['username'], PDO::PARAM_STR);
    $stmt->bindParam(2, $userInfo['email'], PDO::PARAM_STR);
    $stmt->bindParam(3, $userInfo['pwd'], PDO::PARAM_STR);

    $stmt->execute();
    echo "registred succefly";
}

function hash_password($pwd){
    $options = ['cost' => 12];
    return password_hash($pwd, PASSWORD_BCRYPT, $options);

}
