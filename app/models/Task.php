<?php

class Task {
    private int $id;
    private string $title;
    private string $description;
    private string $dateLimite;
    private string $status;
    private ?string $dateDone;

    public function __construct(int $id, string $title, string $description, string $dateLimite, string $status, ?string $dateDone=null){
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->dateLimite = $dateLimite;
        $this->status = $status;
        $this->dateDone = $dateDone;
    }


    public function setDateDone(){
        $this->dateDone = date('Y-m-d');
    }

    // Accesseur //
    public function getId(): int{return $this->id;}
    public function getTitle(): string{return $this->title;}
    public function getDescription(): string{return $this->description;}
    public function getDateLimite(): string{return $this->dateLimite;}
    public function getStatus(): string{return $this->status;}
    public function getDateDone(): ?string{return $this->dateDone;}

    public static function all(PDO $db){
        $tasks = [];
        $stmt = $db->prepare('SELECT * FROM task;');
        $stmt->execute();
        $data = $stmt->fetchAll();

        foreach($data as $task){
            $tasks[] = new Task($task['id'], $task['nom'], $task['description'], $task['date_limite'], $task['status']);
        }
        return $tasks;
    }

    public static function findById(PDO $db, int $id){
        $stmt = $db->prepare('SELECT * FROM task WHERE id = ? ;');
        $stmt->execute([$id]);
        $task = $stmt->fetch();

        return new Task($id, $task['nom'], $task['description'], $task['date_limite'], $task['status']);
    }

    public static function taskUser(PDO $db){
        $tasks = [];
        $stmt = $db->prepare('SELECT task.*
            FROM task
            JOIN user_task ON task.id = user_task.id_task
            WHERE user_task.id_user = ? AND task.status = "pending";'
        );
        $stmt->execute([$_SESSION['userId']]);
        $data = $stmt->fetchAll();
        foreach($data as $task){
            $tasks[] = new Task($task['id'], $task['nom'], $task['description'], $task['date_limite'], $task['status']);
        }
        return $tasks;
    }

    public static function taskUserDone(PDO $db){
        $tasks = [];
        $stmt = $db->prepare('
        SELECT task.*, task_history.completed_date
        FROM task
        JOIN user_task ON task.id = user_task.id_task
        JOIN task_history ON task.id = task_history.id_task
        WHERE user_task.id_user = ? AND task.status = "done"
    ');
        $stmt->execute([$_SESSION['userId']]);
        $data = $stmt->fetchAll();
        foreach($data as $task){
            $tasks[] = new Task($task['id'], $task['nom'], $task['description'], $task['date_limite'], $task['status'], $task['completed_date']);
        }
        return $tasks;
    }

    public static function insertTask(PDO $db, int $userId,string $title, string $description, string $dateLimite): void{
        $stmt = $db->prepare('INSERT INTO task (nom, description, date_limite) VALUES (?, ?, ?)');
        $stmt->execute([$title, $description, $dateLimite]);
        $idTask = $db->lastInsertId();
        $stmt = $db->prepare('INSERT INTO user_task (id_task, id_user) VALUES (?, ?)');
        $stmt->execute([$idTask, $userId]);
    }

    public static function cancelTask(PDO $db, int $id): void{
        $stmt = $db->prepare('DELETE FROM user_task WHERE id_task = ?');
        $stmt->execute([$id]);
        $stmt = $db->prepare('DELETE FROM task WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function appartientUtilisateur(PDO $db, int $taskId, int $userId): bool {
        $stmt = $db->prepare('SELECT 1 FROM user_task WHERE id_task = ? AND id_user = ?');
        $stmt->execute([$taskId, $userId]);
        return (bool)$stmt->fetch();
    }

    public static function expireOverdue(PDO $db): void {
        $stmt = $db->prepare('UPDATE task SET status = "expired" WHERE date_limite < CURDATE() AND status = "pending"');
        $stmt->execute();
    }

    public function completeTask(PDO $db, int $userId){
        $stmt = $db->prepare('UPDATE task SET status="done" WHERE id=?;');
        $stmt->execute([$this->getId()]);
        $stmt = $db->prepare('INSERT INTO task_history (id_user, id_task) VALUES (?,?);');
        $stmt->execute([$userId, $this->getId()]);
    }

    public function getIdProprio(): int{
        $db = db();
        $stmt = $db->prepare('SELECT id_user FROM user_task WHERE id_task = ?');
        $stmt->execute([$this->getId()]);
        $data = $stmt->fetch();
        return (int)$data['id_user'];
    }

    
}