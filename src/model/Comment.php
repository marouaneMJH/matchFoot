<?php
require_once __DIR__ . '/Model.php';


// use Person;

class Comment extends Model
{

    use DbConnection;

    protected static $table = 'comments';

    public static $id = "id";
    public static $user_id = "user_id";
    public static $match_id = "match_id";
    public static $comment_reply_id = "comment_reply_id";
    public static $comment = "comment";
    public static $date = "date";



    public function __construct($id = null, $user_id = null, $match_id = null, $comment_reply_id = null, $comment = null, $date = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->match_id = $match_id;
        $this->comment_reply_id = $comment_reply_id;
        $this->comment = $comment;
        $this->date = $date;
    }
}
