<?php
class Group{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name){
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int{return $this->id;}
    public function getName(): string{return $this->name;}

    public static function newGroup(PDO $db, string $name): int{
        $stmt = $db->prepare('INSERT INTO groupe (name) VALUE (?);');
        $stmt->execute([$name]);
        return $db->lastInsertId();
    }

    public static function deleteGroup(PDO $db, int $id){
        $stmt = $db->prepare('DELETE group WHERE id = ? ;');
        $stmt->execute([$id]);
    }

}