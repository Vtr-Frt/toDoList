<?php

session_start();

require __DIR__ . '/../app/views/header.php';

if(isset($_GET['action']))
    switch($_GET['action']){
        case 'connexion':
            require __DIR__ . '/../app/views/connexion.php';
            break;
} else {
    require __DIR__ . '/../app/views/home.php';
}

require __DIR__ . '/../app/views/footer.php';