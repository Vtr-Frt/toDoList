<?php

function processAjoutTask(): void{
    /**
     * Add task processus
     */
    requireAuth();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $isGroup = 0;
        if(isset($_POST['isGroup']))
            $isGroup = 1;
        
        if(isset($title, $description, $_POST['dateLimite']) && strtotime($_POST['dateLimite']) > strtotime(date('Y-m-d'))){
            $db = db();
            
            Task::insertTask($db, $_SESSION['userId'], $title, $description, $_POST['dateLimite'], $isGroup);
            flash("Tache ajoutée");
            header('Location: index.php?action=addTask');
            exit();
        }
    }
    require __DIR__ . '/../views/addTask.php';
    exit();
    
}

function deleteTask(): void{
    /**
     * Delete a task processus
     */
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
    /**
     * Recover all the tasks to show all the pending tasks of a user properly
     */
    requireAuth();
    $db = db();
    $groupTask = [];
    $idGroup = User::findByEmail($db, $_SESSION['email'])->getGroupId();
    if($idGroup !== null)
        $groupTask = Task::taskGroup($db, $idGroup);

    $tasks = Task::taskUser($db, $_SESSION['userId']);
    require __DIR__ . '/../views/displayTasks.php';
    exit();
}

function taskComplete(){
    /**
     * Complete task procesuss
     */
    requireAuth();
    $db = db();
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $task = Task::findById($db, $_GET['id']);
        $task->completeTask($db, $_SESSION['userId']);
    }
    
    showTasks();
}

function showHistorique(){
    /**
     * Recover all the tasks to show the user historique properly
     */
    requireAuth();
    $db = db();
    $tasks = Task::taskUserDone($db, $_SESSION['userId']);
    require __DIR__ . '/../views/historique.php';
    exit();
}