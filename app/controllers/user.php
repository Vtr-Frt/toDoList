<?php

function showProfile(){
    requireAuth();
    require '/../views/compte.php';
}


function updateProfile(){
    requireAuth();
    require '/../views/compteChange.php';
}
