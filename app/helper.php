<?php

function flash(string $message, string $type = 'success'): void{
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function get_flash(): ?array {
    if (!isset($_SESSION['flash'])) return null;
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $f;
}

function requireAuth(): void {
    if (!isset($_SESSION['userId'])) {
        header('Location: index.php?action=connexion');
        exit();
    }
}