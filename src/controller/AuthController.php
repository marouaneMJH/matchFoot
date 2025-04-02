<?php

require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Admin.php';
require_once __DIR__ . '/../helper/UploadFileHelper.php';
require_once __DIR__ . '/../model/Model.php';
class AuthController
{

    public static function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {



            // check if the form is submitted
            if ($error_result =self::checkSignupForm($_POST) !== null)
            {
                session_start();
                $_SESSION['error-signup'] = $error_result;
                self::redirectToSignup();
                exit;
            }


            $profile_path = null;
            $username = trim($_POST['username']);
            $displayed_name = trim($_POST['displayed_name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $profile_path = null;

            $existingUser = User::getUserByEmailOrUsername($email, $username);
            // Check if the user already exists in the database
            if ($existingUser) {
                session_start();
                $_SESSION['error-signup'] = 'User already exists';
                self::redirectToSignup();
                exit;
            }


            if (isset($_FILES["profile_image"])) {
                $image = $_FILES["profile_image"];
                $uploadDir = __DIR__ . "/../public/uploads/profiles/";
                $profile_path = uploadImage($image, $uploadDir);
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $created_at = date('Y-m-d H:i:s');
            $displayed_name = $displayed_name ?? $username;



            $res = User::create($username, $displayed_name, $email, $hashed_password, $created_at, $profile_path);
            var_dump($res);
            if ($res) {
                self::redirectToLogin();
                exit;
            }

            session_start();
            $_SESSION['error-signup'] = 'An error occurred during signup';
            self::redirectToSignup();
            exit;

        } else {
            self::redirectToSignup();
            exit;
        }
    }

    public static function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // check if the user already logged in
            if(self::isLoggedIn())
            {
                session_start();
                $user_type = $_SESSION['user_type'];
                self::redirectToDashboard($user_type);
                exit;
            }
            // check if the form is submitted
            if ($error_result = self::checkLoginForm($_POST) !== null) {
                session_start();
                $_SESSION['error-login'] = $error_result;
                self::redirectToLogin();
                exit;
            }

            // get the form data
            isset($_POST['email']) ? $email = trim($_POST['email']) : $email = '';
            isset($_POST['username']) ? $username = trim($_POST['username']) : $username = '';
            isset($_POST['password']) ? $password = trim($_POST['password']) : $password = '';


            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // First, check in Admin table
            $admin = Admin::getData([
                'email' => $email,
            ]);

            if(self::loginAdmin($email, $password)) 
                exit;
            
            if(self::loginUser($email, $username, $password)) 
                exit;
            
            // If no valid user is found or password doesn't match
            session_start();
            $_SESSION['error-login'] = 'Invalid credentials';
            self::redirectToLogin();
            exit;
        } 
    }

    public static function logout()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            $error = 'User not logged in';
            include __DIR__ . '/../views/login.php';
            return;
        }
        session_destroy();
        header('Location: /login');
        exit;
    }

    // helper function to check if user is logged in
    public static function isLoggedIn()
    {
        session_start();
        if (isset($_SESSION['user'])  && isset($_SESSION['admin'])){
            self::redirectToDashboard($_SESSION['user_type']);
            return true;

        }
        return false;
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

    private static function redirectToDashboard(string|null $userType = null)
    {
        if ($userType !== null)
        {

            if ($userType === 'admin') {
                header('Location: ../admin_page/AdminDashboard.php');
                exit;
            } elseif ($userType === 'user') {
                header('Location: ../user_page/UserDashboard.php');
                exit;
            }
        }

        session_start();
        if (!isset($_SESSION['user_type'])) {
            header('Location: Login.php');
            exit;
        }
        $userType = $_SESSION['user_type'];
        if ($userType === 'admin') {
            header('Location: ../admin_page/AdminDashboard.php');
        } elseif ($userType === 'user') {
            header('Location: ../user_page/UserDashboard.php');
        } else {
            header('Location: Login.php');
        }
        exit;
    }

    private static function loginUser(string $email, string $username,string $password)
    {
        $user = User::getUserByEmailOrUsername($email, $username);

        if ($user && password_verify($password, $user->password)) {
            session_start();
            $_SESSION['user'] = $user;
            $_SESSION['user_type'] = 'user';
            $_SESSION['user_id'] = $user->id;
            self::redirectToDashboard();
            return true;
        }
        return false;
    }

    private static function loginAdmin(string $email, string $password)
    {
        $admin = Admin::getData([
            'email' => $email,
        ]);

        if ($admin && password_verify($password, $admin[0]['password'])){ 
            session_start();
            $_SESSION['admin'] = $admin;
            $_SESSION['admin_id'] = $admin[0]['id'];
            self::redirectToDashboard();
            return true;
        }
        return false;
    }

    private static function checkSignupForm(array $form)
    {
        if (
            empty($form['username']) ||
            empty($form['displayed_name']) ||
            empty($form['email']) ||
            empty($form['password']) ||
            empty($form['confirm_password'])
        ) {
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
