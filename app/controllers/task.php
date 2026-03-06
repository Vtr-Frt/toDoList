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

function showTasks(){
    $db = db();
    $tasks = Task::taskUser($db);
    require __DIR__ . '/../views/displayTasks.php';
    exit();
}