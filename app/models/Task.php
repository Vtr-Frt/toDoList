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
    public static function insertTask(PDO $db, string $title, string $description, string $dateLimite): void{
        $stmt = $db->prepare('INSERT INTO task (nom, description, date_limite) VALUES (?, ?, ?)');
        $stmt->execute([$title, $description, $dateLimite]);
    }
}