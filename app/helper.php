<?php

function flash(string $message, string $type = 'success'): void{
    /**
     * Stock a error or succes message
     * 
     * @param string $message Message to be register
     * @param string $type Message type (success or error)
     */
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function get_flash(): ?array {
    /**
     * Display the alert message
     * 
     * @return ?array Message displayed with type
     */
    if (!isset($_SESSION['flash'])) return null;
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $f;
}

function requireAuth(): void {
    /**
     * Check if the user is logged
     * 
     */
    if (!isset($_SESSION['userId'])) {
        header('Location: index.php?action=connexion');
        exit();
    }
}