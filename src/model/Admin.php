<?php
require_once __DIR__.'/Model.php';

class Admin extends Model{
    protected static $table = 'admin';

    public static $id="id";
    public static $firstName="name";
    public static $lastName="surname";
    public static $birthDate="birth_date";
    public static $phoneNumber="phone_number";
    public static $email="email";
    public static $password="password";
    public static $profilePath="profile_path";
    public static $roleId="role_id";
    public static $createdAt="created_at";


    public function __construct($id, $firstName, $lastName, $birthDate, $phoneNumber, $email, $password, $roleId) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->password = $password;
        $this->roleId = $roleId;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    

    
}