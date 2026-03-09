<?php 
class User {
    private ?int $id;
    private ?int $groupeId;
    private string $email;
    private string $username;
    private string $password_hash;
    
    public function __construct(?int $id, string $email, string $username , string $password_hash, ?int $groupeId = null){   
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->groupeId = $groupeId;
    }

    // Accesseur //
    public function getId(): ?int{return $this->id;}
    public function getGroupId(): ?int{return $this->groupeId;}
    public function getEmail(): string{return $this->email;}
    public function getUsername(): string{return $this->username;}
    public function getPassword(): string{return $this->password_hash;}

    // Static //
    public static function getProfilPicture(PDO $db, int $userId): string{
        /**
         * Get the user profil pictur
         * 
         * @param PDO $db database used
         * @param int $userId user ID
         * @return string encode data of the profil picture
         */
        $stmt = $db->prepare('SELECT profile_picture FROM user WHERE id = ?');
        $stmt->execute([$userId]);
        $data = $stmt->fetch();
        return base64_encode($data['profile_picture']);
    }

    public static function setProfilPicture(PDO $db,string $picture, int $userId): void{
        /**
         * Set user a new profil picture
         * 
         * @param PDO $db database used
         * @param mixed $picture new profil picture
         * @param int $userId user ID
         */
        $stmt = $db->prepare('UPDATE user SET profile_picture = ? WHERE id = ? ;');
        $stmt->execute([$picture, $userId]);
    }

    public static function findByEmail(PDO $db, string $email): ?User{
        /**
         * Search the informations of a user by his email.
         * 
         * @param PDO $db database used
         * @param string $email user email
         * @return ?User if not found null else User object with all of the information founds
         */
        $stmt = $db->prepare('SELECT * FROM user WHERE email = ?');
        $stmt->execute([$email]);
        $data = $stmt->fetch();

        if (!$data) return null;

        return new User($data['id'], $data['email'], $data['username'],$data['password'], $data['group_id']);

    }
    
    public static function insertUser(PDO $db, string $email, string $username,string $password): void{
        /**
         * Add a new user to the database.
         * 
         * @param PDO $db database used
         * @param string $email new user email
         * @param string $username new user username
         * @param string $password user password in plain text
         */
        $stmt = $db->prepare('INSERT INTO USER (email, username, password) VALUES (?, ?, ?);');
        $stmt->execute([$email, $username, password_hash($password, PASSWORD_BCRYPT)]);
    }

    public static function logoutUser(){
        /**
         * Disconnect the user
         * 
         */
        session_destroy();
    }

    // Instance //
    public function loginUser(): void{
        /**
         * Connect the user by stocking all of his informations in $_SESSION
         * 
         */
        $_SESSION['userId'] = $this->getId();
        $_SESSION['email'] = $this->getEmail();
        $_SESSION['username'] = $this->getUsername();
        $_SESSION['groupeId'] = $this->getGroupId();
    }
}