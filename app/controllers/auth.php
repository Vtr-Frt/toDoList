<?php
require __DIR__ . '/../models/User.php';

function login(): void{
    $error = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $user = User::findByEmail($email);

        if($email && $user->verifyPassword($password)){
            $user->login_user();
        }
    } else {
        require __DIR__ . '/../views/connexion.php';
    }
    
}

function register(): void{
    $error = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $check = User::findByEmail($email);

        //Check if the email is already registred
        if(is_null($check)){
            $db = db();

            User::insertUser($email, $password);

            require __DIR__ . '/../views/connexion.php';
        } else {
            $error = "Email already registred";
            require __DIR__ . '/../views/connexion.php';
        }
    } else {
        require __DIR__ . '/../views/inscrire.php';
    }
    
}

