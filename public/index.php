<?php

session_start();

require __DIR__ . '/../app/models/User.php';

require __DIR__ . '/../app/controllers/auth.php';
require __DIR__ . '/../app/helper.php';

require __DIR__ . '/../app/views/header.php';

if(isset($_GET['action']))
    switch($_GET['action']){
        case 'connexion':
            login();
            break;
        case 'register':
            register();
            break;
} else {
    require __DIR__ . '/../app/views/home.php';
}

require __DIR__ . '/../app/views/footer.php';