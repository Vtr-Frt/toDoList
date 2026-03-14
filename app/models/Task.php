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

    // Static //
    public static function all(PDO $db): array{
        /**
         * Make a list of all of the task in the database
         * 
         * @param PDO database used
         * @return array List of all of the Task in the database 
         */
        $tasks = [];
        $stmt = $db->prepare('SELECT * FROM task;');
        $stmt->execute();
        $data = $stmt->fetchAll();

        foreach($data as $task){
            $tasks[] = new Task($task['id'], $task['nom'], $task['description'], $task['date_limite'], $task['status']);
        }
        return $tasks;
    }

    public static function findById(PDO $db, int $id): Task|null{
        /**
         * Search a task in the database by his id
         * 
         * @param PDO $db database used
         * @param int $id task id which needs to be found
         * @return ?Task if not found null else the Task object found
         */
        $stmt = $db->prepare('SELECT * FROM task WHERE id = ? ;');
        $stmt->execute([$id]);
        $task = $stmt->fetch();

        if (!$task) return null;

        return new Task($id, $task['nom'], $task['description'], $task['date_limite'], $task['status']);
    }

    public static function taskUser(PDO $db, int $userId): array{
        /**
         * Search all the pending task of a specific user
         * 
         * @param PDO $db database used
         * @param int $userId ID of the user whose tasks are being searched for
         * @return array list of all of the task found related to the user ID
         */
        $tasks = [];
        $stmt = $db->prepare('SELECT task.*
            FROM task
            JOIN user_task ON task.id = user_task.id_task
            WHERE user_task.id_user = ? AND task.status = "pending";'
        );
        $stmt->execute([$userId]);
        $data = $stmt->fetchAll();
        foreach($data as $task){
            $tasks[] = new Task($task['id'], $task['nom'], $task['description'], $task['date_limite'], $task['status']);
        }
        return $tasks;
    }

    public static function taskGroup(PDO $db, int $groupId): array{
        $stmt = $db->prepare('SELECT task.* FROM task 
        JOIN user_task,  ON task.id = user_task.id_task
        JOIN user ON user.id = user_task.user_id 
        WHERE user.group_id = ? ;');
        $stmt->execute([$groupId]);
        $data = $stmt->fetchAll();
        foreach($data as $task){
            $tasks[] = new Task($task['id'], $task['nom'], $task['description'], $task['date_limite'], $task['status']);
        }
        return $tasks;
    }

    public static function taskUserDone(PDO $db, int $userId): array{
        /**
         * Return all the task done by a user
         * 
         * @param PDO $db database used
         * @param int $userId user Id
         * @return array list of all of the task done by this user
         */
        $tasks = [];
        $stmt = $db->prepare('
        SELECT task.*, task_history.completed_date
        FROM task
        JOIN user_task ON task.id = user_task.id_task
        JOIN task_history ON task.id = task_history.id_task
        WHERE user_task.id_user = ? AND task.status = "done"
    ');
        $stmt->execute([$userId]);
        $data = $stmt->fetchAll();
        foreach($data as $task){
            $tasks[] = new Task($task['id'], $task['nom'], $task['description'], $task['date_limite'], $task['status'], $task['completed_date']);
        }
        return $tasks;
    }

    public static function insertTask(PDO $db, int $userId, string $title, string $description, string $dateLimite): void{
        /**
         * Insert a new task in the database
         * 
         * @param PDO $id database used
         * @param int $userId user ID
         * @param string $title title of the task
         * @param string $description description of the task
         * @param string $dateLimite limit date of the task
         */
        $stmt = $db->prepare('INSERT INTO task (nom, description, date_limite) VALUES (?, ?, ?)');
        $stmt->execute([$title, $description, $dateLimite]);
        $idTask = $db->lastInsertId();
        $stmt = $db->prepare('INSERT INTO user_task (id_task, id_user) VALUES (?, ?)');
        $stmt->execute([$idTask, $userId]);
    }

    public static function cancelTask(PDO $db, int $id): void{
        /**
         * Delete a task of the database by its ID
         * 
         * @param PDO $db database used
         * @param int $id task ID
         */
        $stmt = $db->prepare('DELETE FROM user_task WHERE id_task = ?');
        $stmt->execute([$id]);
        $stmt = $db->prepare('DELETE FROM task WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function appartientUtilisateur(PDO $db, int $taskId, int $userId): bool {
        /**
         * Check if a task is owned by a user
         * 
         * @param PDO $db database used
         * @param int $taskId task ID
         * @param int $userId user ID
         * @return bool True => this task is owned by this user | False => this task is not owned by this user
         */
        $stmt = $db->prepare('SELECT 1 FROM user_task WHERE id_task = ? AND id_user = ?');
        $stmt->execute([$taskId, $userId]);
        return (bool)$stmt->fetch();
    }

    public static function expireOverdue(PDO $db): void {
        /**
         * Set the status of a task on expired if the limite date of the task is passed
         * 
         * @param PDO database used
         */
        $stmt = $db->prepare('UPDATE task SET status = "expired" WHERE date_limite < CURDATE() AND status = "pending"');
        $stmt->execute();
    }

    // Instance //
    public function completeTask(PDO $db, int $userId): void{
        /**
         * Change the status of the calling task to done and add the task to the historic
         * 
         * @param PDO $db database used
         * @param int $userId user ID
         */
        $stmt = $db->prepare('UPDATE task SET status="done" WHERE id=?;');
        $stmt->execute([$this->getId()]);
        $stmt = $db->prepare('INSERT INTO task_history (id_user, id_task) VALUES (?,?);');
        $stmt->execute([$userId, $this->getId()]);
    }

    public function getIdProprio(): int{
        /**
         * Return the user ID of the owner of the calling task
         * 
         * @return int user ID of the owner of the task
         */
        $db = db();
        $stmt = $db->prepare('SELECT id_user FROM user_task WHERE id_task = ?');
        $stmt->execute([$this->getId()]);
        $data = $stmt->fetch();
        return (int)$data['id_user'];
    }

    
}