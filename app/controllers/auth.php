<?php

function login(): void{
    $error = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $user = User::findByEmail($email);

        if($email && $user->verifyPassword($password)){
            $user->login();
        }
    }
}

function register(){
    $error = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $check = User::findByEmail($email);

        if(is_null($check)){
            
        }
    }
}

