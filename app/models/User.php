<?php 
require __DIR__ . '/../db.php';
class User {
    private ?int $id;
    private string $email;
    private string $password_hash;
    
    public function __construct(?int $id, string $email, string $password_hash){   
        $this->id = $id;
        $this->email = $email;
        $this->password_hash = $password_hash;
    }

    // Accesseur //
    public function getId(){return $this->id;}
    public function getEmail(){return $this->email;}


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

    public static function logoutUser(){
        unset( $_SESSION['userId']);
        unset($_SESSION['email']);
    }


    public function verifyPassword(PDO $db, string $password): bool{

        $stmt = $db->prepare('SELECT * FROM user WHERE email=? and password=?;');
        $stmt->execute([$this->email, hash(algo: 'sha256', data: $password)]);
        $data = $stmt->fetch();

        if (!$data) return false;

        return true;
    }

    public function login_user(): void{
        $_SESSION['userId'] = $this->getId();
        $_SESSION['email'] = $this->getEmail();
    }
}