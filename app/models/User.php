<?php 

class User {
    public ?int $id;
    public string $email;
    public string $password_hash;
    
    public function __construct(?int $id, string $email, string $password_hash){   
        $this->id = $id;
        $this->email = $email;
        $this->password_hash = $password_hash;
    }


    public static function findByEmail(string $email): ?User{
        $db = db();

        $stmt = $db->prepare('SELECT * FROM user WHERE email = ?');
        $stmt->execute([$email]);
        $data = $stmt->fetch();

        if (!$data) return null;

        return new User($data['id'], $data['email'], $data['password']);

    }
}