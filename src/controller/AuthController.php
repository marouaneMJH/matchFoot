<?php

require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Admin.php';
require_once __DIR__ . '/../helper/UploadFileHelper.php';
require_once __DIR__ . '/../model/Model.php';

class AuthController
{
    private static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function signup()
    {
        try {
            error_log("Signup function called"); // Debugging
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                error_log("Received POST request: " . json_encode($_POST));
    
                // Validate required fields
                if (empty($_POST['username']) || empty($_POST['displayName']) || empty($_POST['email']) || empty($_POST['password'])) {
                    error_log("Missing required fields");
                    $_SESSION['error-signup'] = "All fields are required.";
                    return;
                }
    
                $username = $_POST['username'];
                $displayName = $_POST['displayName'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $createdAt = date('Y-m-d H:i:s');
    
                $profilePath = null;
                if (!empty($_FILES['profileImage']['name'])) {
                    error_log("Handling profile image upload...");
                    $uploadDir = __DIR__ . "/../../../uploads/";
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $profilePath = $uploadDir . basename($_FILES['profileImage']['name']);
                    move_uploaded_file($_FILES['profileImage']['tmp_name'], $profilePath);
                }
    
                error_log("Calling User::create...");
                $user = User::create($username, $displayName, $email, $password, $createdAt, $profilePath);
                
                if ($user) {
                    error_log("User created successfully!");
                    header("Location: Login.php");
                    exit();
                } else {
                    error_log("User creation failed");
                    $_SESSION['error-signup'] = "An error occurred during signup.";
                }
            }
        } catch (Exception $e) {
            error_log("Signup error: " . $e->getMessage());
            $_SESSION['error-signup'] = "An error occurred during signup.";
        }
    }
    

    public static function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            self::redirectToLogin();
        }

        self::startSession();

        if (self::isLoggedIn()) {
            self::redirectToDashboard($_SESSION['user_type'] ?? null);
        }

        if (($error_result = self::checkLoginForm($_POST)) !== null) {
            $_SESSION['error-login'] = $error_result;
            self::redirectToLogin();
        }

        $email = trim($_POST['email'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (self::loginAdmin($email, $password) || self::loginUser($email, $username, $password)) {
            exit;
        }

        $_SESSION['error-login'] = 'Invalid credentials';
        self::redirectToLogin();
    }

    public static function logout()
    {
        self::startSession();

        if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
            self::redirectToLogin();
            exit;
        }
        
        session_destroy();
        self::redirectToLogin();

        exit;
    }

    public static function isLoggedIn()
    {
        self::startSession();
        if(isset($_SESSION['user']) || isset($_SESSION['admin']))
        {
            self::redirectToDashboard($_SESSION['user_type'] ?? null);
            return true;
        };

        return false;
    }

    public static function checkAuth()
    {
        self::startSession();
        if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
            self::redirectToLogin();
        }
        if (isset($_SESSION['user'])) {
            self::redirectToDashboard('user');
        } elseif (isset($_SESSION['admin'])) {
            self::redirectToDashboard('admin');
        }
    }

    private static function redirectToLogin()
    {
        header('Location: Login.php');
        exit;
    }

    private static function redirectToSignup()
    {
        header('Location: Signup.php');
        exit;
    }

    private static function redirectToDashboard(?string $userType = null)
    {
        self::startSession();
        $userType = $userType ?? $_SESSION['user_type'] ?? null;
        
        if ($userType === 'admin') {
            if(isset($_SESSION['admin_role_id']) && $_SESSION['admin_role_id'] == 1) {
                header('Location: ../admin_space/dashboard/Dashboard.php');
                exit;
            } else {
                header('Location: ../admin_tournament_space/Dashboard.php');
                exit;
            }
        } else
        {
            header('Location: ../user_space/Accueil.php');       
            exit;
        }
    }

    private static function loginUser(string $email, string $username, string $password)
    {
        $user = User::getUserByEmailOrUsername($email, $username);

        if ($user && password_verify($password, $user->password)) {
            self::startSession();
            $_SESSION['user'] = $user;
            $_SESSION['user_type'] = 'user';
            $_SESSION['user_id'] = $user->id;
            self::redirectToDashboard('user');
        }
        return false;
    }

    private static function loginAdmin(string $email, string $password)
    {
        $admin = Admin::getData(['email' => $email]);

        if ($admin && password_verify($password, $admin[0]['password'])) {
            self::startSession();
            $_SESSION['admin'] = $admin;
            $_SESSION['user_type'] = 'admin';
            $_SESSION['admin_id'] = $admin[0]['id'];
            $_SESSION['admin_role_id'] = $admin[0]['role_id'];
            if(isset($admin[0]['role_id']) && $admin[0]['role_id'] == 2) {
                $_SESSION['tournament_id'] = 2;
            } 

            self::redirectToDashboard('admin');
        }
        return false;
    }

    private static function checkSignupForm(array $form)
    {
        if (empty($form['username']) || empty($form['email']) || empty($form['password']) || empty($form['confirm_password'])) {
            return 'All fields are required';
        }

        if ($form['password'] !== $form['confirm_password']) {
            return 'Passwords do not match';
        }

        return null;
    }

    public static function checkLoginForm($form)
    {
        if (empty($form['email']) || empty($form['password'])) {
            return 'All fields are required';
        }
        return null;
    }
}
