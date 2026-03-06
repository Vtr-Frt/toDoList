<?php

class Task {
    private int $id;
    private string $title;
    private string $description;
    private string $dateLimite;

    public function __construct(int $id, string $title, string $description, string $dateLimite){
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->dateLimite = $dateLimite;
    }

    // Accesseur //
    public function getId(): int{return $this->id;}
    public function getTitle(): string{return $this->title;}
    public function getDescription(): string{return $this->description;}
    public function getDateLimite(): string{return $this->dateLimite;}

    public static function all(PDO $db){
        $tasks = [];
        $stmt = $db->prepare('SELECT * FROM task;');
        $stmt->execute();
        $data = $stmt->fetchAll();

        foreach($data as $task){
            $tasks[] = new Task($task['id'], $task['nom'], $task['description'], $task['date_limite']);
        }
        return $tasks;
    }

    public static function taskUser(PDO $db){
        $tasks = [];
        $stmt = $db->prepare('SELECT task.*
            FROM task
            JOIN user_task ON task.id = user_task.id_task
            WHERE user_task.id_user = ?;'
        );
        $stmt->execute([$_SESSION['userId']]);
        $data = $stmt->fetchAll();
        foreach($data as $task){
            $tasks[] = new Task($task['id'], $task['nom'], $task['description'], $task['date_limite']);
        }
        return $tasks;
    }

    public static function insertTask(PDO $db, string $title, string $description, string $dateLimite): void{
        $stmt = $db->prepare('INSERT INTO task (nom, description, date_limite) VALUES (?, ?, ?)');
        $stmt->execute([$title, $description, $dateLimite]);
        $idTask = $db->lastInsertId();
        $stmt = $db->prepare('INSERT INTO user_task (id_task, id_user) VALUES (?, ?)');
        $stmt->execute([$idTask, $_SESSION['userId']]);
    }

    public static function cancelTask(PDO $db, int $id): void{
        $stmt = $db->prepare('DELETE FROM user_task WHERE id_task = ?');
        $stmt->execute([$id]);
        $stmt = $db->prepare('DELETE FROM task WHERE id = ?');
        $stmt->execute([$id]);
    }

    
}