<?php
require_once __DIR__ . '/../database/connectDB.php';


require 'Person.php';

// use Person;

class News extends Model
{

    use DbConnection;

    protected static $table = 'news';

    public static $id="id";
    public static $admin_id="admin_id";
    public static $date="date";
    public static $description="description";


    
    public function __construct($id = null, $admin_id = null, $date = null, $description = null) {
        $this->id = $id;
        $this->admin_id = $admin_id;
        $this->date = $date;
        $this->description = $description;
    }



}