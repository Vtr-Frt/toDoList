<?php

function showProfile(){
    requireAuth();
    require __DIR__ . '/../views/compte.php';
    exit();
}

function updateProfile(){
    requireAuth();
    require __DIR__ . '/../views/compteChange.php';
    exit();
}

function updatePseudo(){
    requireAuth();
    if(isset($_POST['newName']) && is_string($_POST['newName'])){
            $newPseudo = trim($_POST['newName'] ?? '');
            $db = db();
            User::updatePseudo($db, $newPseudo, $_SESSION['userId']);
            flash("Pseudo changé");
    } else {
        flash("Pseudo invalide", 'error'); 
    }

    header("Location: index.php?action=updateProfil");
    exit();
}

function updatePassword(){
    requireAuth();
    if(isset($_POST['newPassword']) && is_string($_POST['newPassword']) && sizeof($_POST['newPassword']) >= 4){
            $newPassword = trim($_POST['newPassword'] ?? '');
            $db = db();
            User::updatePassword($db, $newPassword, $_SESSION['userId']);
            flash("Mot de passe changé");
    } else {
        flash("Mot de passe invalide", 'error');
    }

    header("Location: index.php?action=updateProfil");
    exit();
}

function updatePP(PDO $db, int $userId, array $file) {
    
}

function joinGroup(){
    
    if(isset($_POST['joinGroup']) && is_int($_POST['joinGroup'])){
        $db = db();
        if(User::checkGroup($db, $_POST['joinGroup'])){
            $groupId = trim($_POST['joinGroup'] ?? '');
            User::joinGroup($db, $groupId, $_SESSION['userId']);
            flash("Groupe rejoins");
        } else {
            flash("Groupe inexistant", 'error');
        }
    } else {
        flash("Groupe invalide", 'error');
    }

    header("Location: index.php?action=updateProfil");
    exit();
}

function quitGroup(){
    $db = db();
    User::quitGroup($db, $_SESSION['userId']);
    flash("Groupe quitté");
    header("Location: index.php?action=updateProfil");
    exit();
}