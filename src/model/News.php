<?php
require_once __DIR__ . '/Model.php';


// use Person;

class News extends Model
{

    use DbConnection;

    protected static $table = 'news';

    public static $id="id";
    public static $admin_id="admin_id";
    public static $title="title";
    public static $content="content";
    public static $category="category";
    public static $status="status";
    public static $image_path="image_path";
    public static $date="date";


    
    public function __construct($id = null, $admin_id = null, $title = null, $content = null, $category = null, $status = null, $date = null) {
        $this->id = $id;
        $this->admin_id = $admin_id;
        $this->title = $title;
        $this->content = $content;
        $this->category = $category;
        $this->status = $status;
        $this->date = $date;
    }



}