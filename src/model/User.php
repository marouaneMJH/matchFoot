<?php
require_once __DIR__ . '/../database/connectDB.php';

class User  implements JsonSerializable
{
    use DbConnection;

    private static $table = 'users';



    private $id;
    private $username;
    private $displayed_name;
    private $email;
    private $password;
    private $profile_path;
    private $profile_image;
    private $created_at;

    public function __construct($id, $username, $displayed_name, $email, $password, $created_at, $profile_path = null,$profile_image=null)
    {

        $this->id = $id;
        $this->username = $username;
        $this->displayed_name = $displayed_name;
        $this->email = $email;
        $this->password = $password;
        $this->profile_path = $profile_path;
        $this->profile_image = $profile_image;
        $this->created_at = $created_at;
    }

    public static function getUser($id)
    {

        try {
            $table = self::$table;
            $pdo = self::connect();
            $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                $user = new User(
                    $userData['id'],
                    $userData['username'],
                    $userData['displayed_name'],
                    $userData['email'],
                    $userData['password'],
                    $userData['created_at'],
                    $userData['profile_path'],
                    'http://efoot/images?file='.$userData['profile_path']
                );

                //$user->profile_image = urlencode($user->profile_path);
                return $user;
            }
        } catch (PDOException $e) {
            $e->getMessage();
            return;
        }
    }

    /**
     * * Get user by email or username
     * * @param string $email 
     * * @param string $username
     * * @return User|null
     * * This method retrieves a user from the database by their email or username.
     * * It returns a User object if found, or null if not found.
     */
    public static function getUserByEmailOrUsername($email, $username)
    {
        try {
            $table = self::$table;
            $pdo = self::connect();
            $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE email = :email OR username = :username");
            $stmt->execute(['email' => $email, 'username' => $username]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                $user = new User(
                    $userData['id'],
                    $userData['username'],
                    $userData['displayed_name'],
                    $userData['email'],
                    $userData['password'],
                    $userData['created_at'],
                    $userData['profile_path'],
                    'http://efoot/images?file='.$userData['profile_path']
                );

                //$user->profile_image = urlencode($user->profile_path);
                return $user;
            }
        } catch (PDOException $e) {
            $e->getMessage();
            return null;
        }
    }

    public static function create($username, $displayed_name, $email, $password, $created_at, $profile_path = null)
    {


        try {
            $pdo = self::connect();
            $table = self::$table;
            $stmt = $pdo->prepare(" INSERT INTO `$table` (username, displayed_name, email, password, profile_path, created_at) 
                                VALUES (:username, :displayed_name, :email, :password, :profile_path, :created_at)");
            $stmt->execute(['username' => $username, 'displayed_name' => $displayed_name, 'email' => $email, 'password' => $password, 'profile_path' => $profile_path, 'created_at' => $created_at]);
            $id = $pdo->lastInsertId();
            $user = new User($id, $username, $displayed_name, $email, $password,$created_at,$profile_path);
            http_response_code(201);
            return json_encode(['message' => 'User created successfully', 'status' => 201, 'user' => $user]);
        } catch (PDOException $th) {
            http_response_code(500);
            return json_encode(['message' => 'Failed to create the user', 'error' => $th, 'status' => 500]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update() {}


    //To be Updated
    public function delete()
    {

        try {
            $table = self::$table;
            $pdo = self::connect();
            $stmt = $pdo->prepare("DELETE FROM `$table` WHERE id = :id");
            $stmt->execute(['id' => $this->id]);
            return true;
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }



    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'displayed_name' => $this->displayed_name,
            'email' => $this->email,
            'profile_path' => $this->profile_path,
            'profile_image' => $this->profile_image,
            'created_at' => $this->created_at
        ];
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProfilePath()
    {
        return $this->profile_path;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getDisplayedName()
    {
        return $this->displayed_name;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getHashedPassword()
    {
        return $this->password;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }


    public function __toString()
    {
        return json_encode($this);
    }
    
}
