<?php
require_once __DIR__ . '/../database/connectDB.php';

class User implements JsonSerializable
{
    use DbConnection;

    private static $table = 'user';

    private $id;
    private $username;
    private $displayed_name;
    private $email;
    private $password;
    private $profile_path;
    private $profile_image;
    private $birth_date; // Added missing property declaration
    private $created_at;

    // Base URL for profile images - should be configurable
    private static $IMAGE_BASE_URL = 'http://efoot/images?file=';

    /**
     * User constructor
     * 
     * @param int $id User ID
     * @param string $username Username
     * @param string $displayed_name Display name
     * @param string $email Email address
     * @param string $password Hashed password
     * @param string $created_at Creation timestamp
     * @param string $birth_date Birth date
     * @param string|null $profile_path Path to profile image
     */
    public function __construct(
        $id, 
        $username, 
        $displayed_name, 
        $email, 
        $password, 
        $created_at, 
        $birth_date,
        $profile_path = null
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->displayed_name = $displayed_name;
        $this->email = $email;
        $this->password = $password;
        $this->profile_path = $profile_path;
        $this->birth_date = $birth_date; // Fixed property name
        $this->created_at = $created_at;
        
        // Set profile_image only if profile_path exists
        if ($profile_path) {
            $this->profile_image = self::$IMAGE_BASE_URL . $profile_path;
        } else {
            $this->profile_image = null;
        }
    }

    /**
     * Get user by ID
     * 
     * @param int $id User ID
     * @return User|null User object or null if not found
     */
    public static function getUser($id)
    {
        try {
            $table = self::$table;
            $pdo = self::connect();
            $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                return self::createFromArray($userData);
            }
            return null;
        } catch (PDOException $e) {
            error_log("Error fetching user: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get user by email or username
     * 
     * @param string $email Email address
     * @param string $username Username
     * @return User|null User object or null if not found
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
                return self::createFromArray($userData);
            }
            return null;
        } catch (PDOException $e) {
            error_log("Error fetching user by email/username: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create User object from database row
     * 
     * @param array $userData User data from database
     * @return User User object
     */
    private static function createFromArray(array $userData): User
    {
        return new User(
            $userData['id'],
            $userData['username'],
            $userData['displayed_name'],
            $userData['email'],
            $userData['password'],
            $userData['created_at'],
            $userData['birth_date'],
            $userData['profile_path']
        );
    }

    /**
     * Create a new user in the database
     * 
     * @param string $username Username
     * @param string $displayed_name Display name
     * @param string $email Email address
     * @param string $password Hashed password
     * @param string $birth_date Birth date
     * @param string $created_at Creation timestamp
     * @param string|null $profile_path Path to profile image
     * @return User|null User object or null on failure
     */
    public static function create($username, $displayed_name, $email, $password, $birth_date, $created_at, $profile_path = null)
    {
        // Basic validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            error_log("Invalid email format");
            return null;
        }
        
        if (empty($username) || empty($displayed_name)) {
            error_log("Username and display name cannot be empty");
            return null;
        }

        try {
            $pdo = self::connect();
            $table = self::$table;
            
            $stmt = $pdo->prepare("INSERT INTO `$table` (username, displayed_name, email, password, birth_date, profile_path, created_at) 
                                VALUES (:username, :displayed_name, :email, :password, :birth_date, :profile_path, :created_at)");
            
            $stmt->execute([
                'username' => $username, 
                'displayed_name' => $displayed_name, 
                'email' => $email, 
                'password' => $password,
                'birth_date' => $birth_date, 
                'profile_path' => $profile_path, 
                'created_at' => $created_at
            ]);
            
            $id = $pdo->lastInsertId();
            
            return new User(
                $id, 
                $username, 
                $displayed_name, 
                $email, 
                $password, 
                $created_at, 
                $birth_date,
                $profile_path
            );
        } catch (PDOException $e) {
            error_log("Database error creating user: " . $e->getMessage());
            return null;
        } catch (Exception $e) {
            error_log("General error creating user: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Update user details
     * 
     * @param array $data Associative array of fields to update
     * @return bool True on success, false on failure
     */
    public function update(array $data = [])
    {
        if (empty($data)) {
            return false;
        }
        
        try {
            $table = self::$table;
            $pdo = self::connect();
            
            $sets = [];
            $params = ['id' => $this->id];
            
            foreach ($data as $field => $value) {
                // Only update if the field is a valid property
                if (property_exists($this, $field)) {
                    $sets[] = "`$field` = :$field";
                    $params[$field] = $value;
                    
                    // Update the object property
                    $this->$field = $value;
                }
            }
            
            if (empty($sets)) {
                return false;
            }
            
            $setClause = implode(', ', $sets);
            $sql = "UPDATE `$table` SET $setClause WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute($params);
            
            // Update profile_image if profile_path was updated
            if (isset($data['profile_path'])) {
                $this->profile_image = $data['profile_path'] ? self::$IMAGE_BASE_URL . $data['profile_path'] : null;
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete user from database
     * 
     * @return bool True on success, false on failure
     */
    public function delete()
    {
        try {
            $table = self::$table;
            $pdo = self::connect();
            $stmt = $pdo->prepare("DELETE FROM `$table` WHERE id = :id");
            $result = $stmt->execute(['id' => $this->id]);
            return $result;
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * JSON serialization method
     * 
     * @return array Data to be serialized
     */
    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'displayed_name' => $this->displayed_name,
            'email' => $this->email,
            'profile_path' => $this->profile_path,
            'profile_image' => $this->profile_image,
            'birth_date' => $this->birth_date,
            'created_at' => $this->created_at
        ];
    }

    // Getters

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getDisplayedName()
    {
        return $this->displayed_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getHashedPassword()
    {
        return $this->password;
    }

    public function getProfilePath()
    {
        return $this->profile_path;
    }

    public function getProfileImage()
    {
        return $this->profile_image;
    }

    public function getBirthDate()
    {
        return $this->birth_date;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Convert user object to JSON string
     * 
     * @return string JSON representation
     */
    public function __toString()
    {
        return json_encode($this);
    }
}