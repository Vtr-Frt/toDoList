<?php

session_start();

require __DIR__ . '/../app/views/header.php';

if($_GET['action'] == 'connexion'){
    require __DIR__ . '/../app/views/connexion.php';
}

require __DIR__ . '/../app/views/footer.php';