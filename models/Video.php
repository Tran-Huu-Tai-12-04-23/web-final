<?php
    class Video {
        private $db;
        public function __construct() {
            $database = new DB();
            $this->db = $database->getInstance();
        }
        public function getVideo($video_id) {
            $query = "SELECT Video.*, User.*, COUNT(DISTINCT likes.like_id) AS like_count, COUNT(DISTINCT View.view_id) AS view_count, COUNT(DISTINCT follower.follower_id) AS follow_count
            FROM Video
            INNER JOIN User ON Video.user_id = User.user_id
            LEFT JOIN likes ON Video.video_id = likes.video_id
            LEFT JOIN View ON Video.video_id = View.video_id
            LEFT JOIN follower ON User.user_id = follower.user_id
            where Video.video_id = '$video_id'  and video.deleted = 0 and video.mode_private = 0 
            GROUP BY Video.video_id, User.user_id;
            ";
            $res = $this->db->query($query); 
            if(!$res) return null;
            if(mysqli_num_rows($res) > 0) {
                return mysqli_fetch_assoc($res);
            }
            return (array('video_id' => 0, 'user_id'=>0, 'profile_picture'=>'', 'thumbnails'=>'', 'title'=>'', 'description'=>'', 'username'=>'', 'upload_date'=>'', 'view_count'=>0, 'like_count'=>0,'follow_count'=>0));
        }
        
        
        
        public function getAllVideoPublic() {
            $query = "SELECT video.*, user.username FROM video INNER JOIN user ON video.user_id = user.user_id and video.mode_private = 0  and video.deleted = 0 ";
            $res = $this->db->query($query); 
            if(!$res) return null;
            if(  mysqli_num_rows($res) == 0) {
                return null;
            }
            if(  mysqli_num_rows($res) > 0 ) {
                return $res;
            }
            return  null;
        }
        public function getAllUsers() {
            $query = "SELECT * FROM user";
            $result = $this->db->query($query);
            if (mysqli_num_rows($result)!==0) {
                while($row = mysqli_fetch_assoc($result)){
                    $array[] = $row;
                }
                return $array;
            }else {
                return $message;
            }
            
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
                return $data;
            }else {
                return $message;
            }
        }

        function increaseViews( $user_id, $video_id) {
            // Insert new view into View table
            $query = "INSERT INTO View (user_id, video_id) VALUES ('$user_id', '$video_id')";
            $result = $this->db->query($query); 
            if ($result !==0) {
                return ;
            }else {
                echo 'false';
                return "Failure";
            }
          }


        public function searchVideo() {
            if(isset($_GET['data'])) {
                $nameSearch = $_GET['data']??'';
                $query = "SELECT video.*, user.user_id, user.username, user.profile_picture
                FROM video, user
                WHERE (title LIKE '%$nameSearch%' OR description LIKE '%nameSearch%' or user.username like '%$nameSearch') and video.user_id = user.user_id  and video.deleted = 0
                limit 18
                ";
                $res = $this->db->query($query);
                if($res && mysqli_num_rows($res) > 0 ) {
                    return mysqli_fetch_all($res, MYSQLI_ASSOC);
                } else {
                    // echo json_encode(array('status' => false, 'message' => 'Not found video for '.$nameSearch));
                    return [];
                }
            }
            return [];
            echo json_encode(array('status' => false, 'message' => 'Please enter search video'));
        }

        
    }

?>