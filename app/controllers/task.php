<?php

function processAjoutTask(): void{
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if(isset($title, $description, $_POST['dateLimite']) && strtotime($_POST['dateLimite']) > strtotime(date('Y-m-d'))){
            $db = db();
            Task::insertTask($db, $title, $description, $_POST['dateLimite']);
            flash("Tache ajoutée");
            header('Location: index.php?action=addTask');
            exit();
        }
    }
    require __DIR__ . '/../views/addTask.php';
    exit();
    
}

function deleteTask(): void{
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $db = db();
        Task::cancelTask($db, $_GET['id']);
        flash("Tache annulée");
        header('Location: index.php?action=cancelTask');
        exit();
    }
    require __DIR__ . '/../views/displayTasks.php';
    exit();

}

function showTasks(){
    $db = db();
    $tasks = Task::all($db);
    //$tasks = Task::taskUser($db);
    require __DIR__ . '/../views/displayTasks.php';
    exit();
}

function taskComplete(){
    $db = db();
    $task = Task::findById($db, $_GET['id']);
    $task->completTask($db);
    showTasks();
}

function showHistorique(){
    $db = db();
    $tasks = Task::taskUserDone($db);
    require __DIR__ . '/../views/historique.php';
    exit();
}