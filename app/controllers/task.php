<?php

function processAjoutTask(): void{
    requireAuth();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if(isset($title, $description, $_POST['dateLimite']) && strtotime($_POST['dateLimite']) > strtotime(date('Y-m-d'))){
            $db = db();
            Task::insertTask($db, $_SESSION['userId'], $title, $description, $_POST['dateLimite']);
            flash("Tache ajoutée");
            header('Location: index.php?action=addTask');
            exit();
        }
    }
    require __DIR__ . '/../views/addTask.php';
    exit();
    
}

function deleteTask(): void{
    requireAuth();
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(isset($_GET['id']) && is_numeric($_GET['id'])){
            $db = db();
            if(Task::appartientUtilisateur($db, $_GET['id'], $_SESSION['userId'])){
                Task::cancelTask($db, $_GET['id']);
                flash("Tache annulée");
                header('Location: index.php?action=cancelTask');
                exit();
            }
        }
    }
    require __DIR__ . '/../views/displayTasks.php';
    exit();

}

function showTasks(){
    requireAuth();
    $db = db();
    Task::expireOverdue($db);
    //$tasks = Task::all($db);
    $tasks = Task::taskUser($db);
    require __DIR__ . '/../views/displayTasks.php';
    exit();
}

function taskComplete(){
    $db = db();
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $task = Task::findById($db, $_GET['id']);
        $task->completeTask($db, $_SESSION['userId']);
    }
    
    showTasks();
}

function showHistorique(){
    $db = db();
    $tasks = Task::taskUserDone($db);
    require __DIR__ . '/../views/historique.php';
    exit();
}