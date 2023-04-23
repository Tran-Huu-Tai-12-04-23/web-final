<?php
    class Comment {
        private $db;
        public function __construct() {
            $database = new DB();
            $this->db = $database->getInstance();
        }
        public function getVideo($video_id){
            $query = "SELECT video.*, user.username, user.profile_picture FROM video, user WHERE video_id = '$video_id' and user.user_id = video.user_id";
            $res = $this->db->query($query); 
            if(!$res) return null;
            if(  mysqli_num_rows($res) > 0 ) {
                return mysqli_fetch_assoc($res);
            }
            $this->db->close();
            return  null;
        }
        
        public function getAllVideoPublic($videoID) {
            $query = "SELECT video.*, user.username FROM video INNER JOIN user ON video.user_id = user.user_id";
            $res = $this->db->query($query); 
            if(!$res) return null;
            if(  mysqli_num_rows($res) > 0 ) {
                return $res;
            }
            $this->db->close();
            return  null;
        }
        public function getAllComment($video_id) {
            $query = "SELECT comment.*, user.* FROM comment, user where comment.user_id = user.user_id and comment.video_id = $video_id order by comment_date desc";
            $result = $this->db->query($query);
            if(!$result) return null;
            if (mysqli_num_rows($result)!==0) {
                return $result;
            }
            $this->db->close();
            return null;
        }
        public function deleteUser($id) {
            $query = "UPDATE user SET delete=1";
            if ($this->db->query($query) === true) {
                return 'Delete user successfully!!';
            }else {
                return 'Delete user fail!!';
            }
        }
        public function destroyUser($id) {
            $query = "DELETE FROM user WHERE user_id  = $id";
            if ($this->db->query($query) === true) {
                return 'Destroy user successfully!!';
            }else {
                return 'Destroy user fail!!';
            }
        }
        public function getDataFromDb($filed, $query, $message) {
            $result = $this->db->query($query);
            if (mysqli_num_rows($result)!==0) {
                $row = mysqli_fetch_array($result);
                $data = $row[$filed];
                $this->db->close();
                return $data;
            }else {
                return $message;
            }
        }
        
    }

?>