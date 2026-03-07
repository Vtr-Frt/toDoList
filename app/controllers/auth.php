<?php

function login(): void{
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $db = db();
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $user = User::findByEmail($db, $email);

        if($email && $user !== null && password_verify($password, $user->getPassword())) {
            $user->loginUser();
            header('Location: index.php');
            exit();
            
        } else {
            flash("Information de connexion erronées", 'error');
            header('Location: index.php?action=connexion');
            exit();
        }
    }
    require __DIR__ . '/../views/connexion.php';
    exit();
}

function logout(): void{
    User::logoutUser();
    header('Location: index.php');
    exit();
}

function register(): void{

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $db = db();
        $email = trim($_POST['email'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $check = User::findByEmail($db, $email);

        //Check if the email is already registred
        if($check === null){
            User::insertUser($db, $email, $username,$password);
            flash("Compte enregistré");
            header('Location: index.php?action=register');
            exit();
        }
        //Affiche message erreur si email déjà enregistré
        flash("Email déjà enregistré", 'error');
        header('Location: index.php?action=register');
        exit();
    }
    
    require __DIR__ . '/../views/inscrire.php';
    exit();
}
