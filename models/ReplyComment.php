<?php
    class ReplyComment {
        private $db;
        public function __construct() {
            $database = new DB();
            $this->db = $database->getInstance();
        }
       
        public function getReplyComment($video_id) {
            $query = "SELECT comment.*, user.* FROM comment, user where comment.user_id = user.user_id and comment.video_id = $video_id order by comment_date desc";
            $result = $this->db->query($query);
            if(!$result) return null;
            if (mysqli_num_rows($result)!==0) {
                return $result;
            }
            $this->db->close();
            return null;
        }
        
    }

?>