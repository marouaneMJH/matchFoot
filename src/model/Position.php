<?php 
require_once  __DIR__ . '/Model.php';

class Position extends Model {
    
    public static $table = 'position';
    public static $id = 'id';
    public static $tag = 'tag';
    public static $name = 'name';

    public function __construct($id, $tag, $name) {
        $this->id = $id;
        $this->tag = $tag;
        $this->name = $name;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }
}