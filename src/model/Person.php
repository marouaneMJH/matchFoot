<?php

namespace person;

require_once __DIR__ . '/../database/connectDB.php';
use DateTime;
use DbConnection;

class Person {
    protected $pdo;
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $birthDate;
    protected $age;
    
    public function __construct($pdo, $id, $firstName, $lastName, $birthDate){
        $this->pdo = $pdo ?? DbConnection::connect();
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
    }

        public function getAge() {
        $birthDate = new DateTime($this->birthDate);
        $currentDate = new DateTime();
        $age = $currentDate->diff($birthDate)->y;
        return $age;
    }

}

