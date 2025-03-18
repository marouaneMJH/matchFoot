<?php

require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Admin.php';
require_once __DIR__ . '/../helper/UploadFileHelper.php';

class AuthController
{

    public static function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            isset($_POST['username']) ? $username = trim($_POST['username']) : $username = '';
            isset($_POST['displayed_name']) ? $displayed_name = trim($_POST['displayed_name']) : $displayed_name = '';
            isset($_POST['email']) ? $email = trim($_POST['email']) : $email = '';
            isset($_POST['password']) ? $password = $_POST['password'] : $password = '';
            isset($_POST['confirm_password']) ? $confirm_password = $_POST['confirm_password'] : $confirm_password = '';
            $profile_path = null;

            if (empty($username)  || empty($email) || empty($password) || empty($confirm_password)) {
                $error = 'All fields are required';
                include __DIR__ . '/../views/signup.php';
                return;
            }

            if ($password !== $confirm_password) {
                $error = 'Passwords do not match';
                include __DIR__ . '/../views/signup.php';
                return;
            }

            $existingUser = User::getUserByEmailOrUsername($email, $username);
            if ($existingUser) {
                $error = 'User already exists';
                include __DIR__ . '/../views/signup.php';
                return;
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
            $res_array = json_decode($res, true);
            if ($res_array['status'] === 201) {
                header('Location: /login');
                exit;
            }

            $error = 'An error occurred during signup';
            include __DIR__ . '/../views/signup.php';
            return;
        } else {
            include __DIR__ . '/../views/signup.php';
            return;
        }
    }

    public static function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            isset($_POST['email']) ? $email = trim($_POST['email']) : $email = '';
            isset($_POST['username']) ? $username = trim($_POST['username']) : $username = '';
            isset($_POST['password']) ? $password = trim($_POST['password']) : $password = '';

            if (empty($email) || empty($password)) {
                $error = 'All fields are required';
                include __DIR__ . '/../views/login.php';
                return;
            }
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // First, check in Admin table
            $admin = Admin::getData([
                'email' => $email,
                'password' => $password
            ]);
            //var_dump($admin);
            
            if ($admin) {
                // if (password_verify($password, password_hash($admin[Admin::$password],PASSWORD_DEFAULT)) ) {
                    session_start();
                    $_SESSION['user'] = $admin;
                    $_SESSION['admin_id'] = $admin[0]['id'];
                   
                    if ($admin[0][Admin::$roleId] == 1) {
                        $_SESSION['user_type'] = 'admin';
                        header('Location: ../admin_space/dashboard/Dashboard.php');
                        exit;
                    } else {
                       
                        $_SESSION['user_type'] = 'admin_tournament';

                        header('Location: ../admin_tournament_space/Dashboard.php');
                        exit;
                    }
                // }
            }



            // Finally, check in User table
            $user = User::getUserByEmailOrUsername($email, $username);
            if ($user) {
                if (password_verify($password, $user->password)) {
                    session_start();
                    $_SESSION['user'] = $user;
                    $_SESSION['user_type'] = 'user';
                    $_SESSION['user_id'] = $user->id;

                    header('Location: /user/dashboard');
                    exit;
                }
            }

            // If no valid user is found or password doesn't match
            $error = 'Invalid credentials';
            include __DIR__ . '/../views/login.php';
            return;
        } else {
            include __DIR__ . '/../views/login.php';
            return;
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
}
