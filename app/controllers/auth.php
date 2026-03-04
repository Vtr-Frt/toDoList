<?php
require __DIR__ . '/../models/User.php';

function login(): void{
    $error = null;
    $db = db();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $user = User::findByEmail($db, $email);

        if($email && $user->verifyPassword($db, $password)){
            $user->login_user();
            
        }
    } else {
        require __DIR__ . '/../views/connexion.php';
    }
    
}

function register(): void{

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $db = db();
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $check = User::findByEmail($db, $email);

        //Check if the email is already registred
        if($check === null){
            User::insertUser($db, $email, $password);
        } else {
            $error = "Email already registred";
        }
        require __DIR__ . '/../views/connexion.php';
        exit();
    } else {
        require __DIR__ . '/../views/inscrire.php';
        exit();
    }
    
}
