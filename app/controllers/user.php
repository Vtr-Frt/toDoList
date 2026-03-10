<?php

function showProfile(){
    requireAuth();
    require __DIR__ . '/../views/compte.php';
}


function updateProfile(){
    requireAuth();
    require __DIR__ . '/../views/compteChange.php';
}


function updatePseudo(){
    //TODO: changer pseudo
}

function updatePassword(){
    //TODO: changer mot de passe
}

function updatePP() {
    //TODO: changer PP
}

function joinGroup(){
    //TODO: rejoindre Groupe
}

function quitGroup(){
    //TODO: quitter groupe
}