<?php 
require_once __DIR__ . '/Model.php';

class GoalType extends Model {
    protected static $table = 'goal_type';
    public static $id='id';
    public static $name='name';
    public static $description='description';


    
}