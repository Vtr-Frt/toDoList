<?php 
require __DIR__ . '/../db.php';
class User {
    public ?int $id;
    public string $email;
    public string $password_hash;
    
    public function __construct(?int $id, string $email, string $password_hash){   
        $this->id = $id;
        $this->email = $email;
        $this->password_hash = $password_hash;
    }


    public static function findByEmail(PDO $db, string $email): ?User{

        $stmt = $db->prepare('SELECT * FROM user WHERE email = ?');
        $stmt->execute([$email]);
        $data = $stmt->fetch();

        if (!$data) return null;

        return new User($data['id'], $data['email'], $data['password']);

    }
    
    public static function insertUser(PDO $db, string $email, string $password){
        
        $stmt = $db->prepare('INSERT INTO USER (email, password) VALUES (?, ?);');
        $stmt->execute([$email, hash(algo: 'sha256', data:$password)]);
    }


    public function verifyPassword(PDO $db, string $password): ?bool{
        $db = db();

        $stmt = $db->prepare('SELECT * FROM user WHERE email=? and password=?;');
        $stmt->execute([$this->email, $password]);
        $data = $stmt->fetch();

        if (!$data) return null;

        return true;
    }

    public function login_user(): void{
        $_SESSION['userId'] = $this->id;
        $_SESSION['email'] = $this->email;
    }
}