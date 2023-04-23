<?php
    class User {
        private $db;
        public function __construct() {
            $database = new DB();
            $this->db = $database->getInstance();
        }
        public function getUserDetail($user_id){
            if(!empty($user_id)) {
                $query = "SELECT user.*, user_details.*  FROM user_details, user  WHERE user_details.user_id = $user_id and user.user_id = user_details.user_id";
                $res = $this->db->query($query); 
                if( !$res) return [];
                if(  mysqli_num_rows($res) > 0 ) {
                    return mysqli_fetch_assoc($res);
                }
                return  array('full_name'=>'', 'date_of_birth'=>'', 'email'=>'', 'phone_number'=>'', 'address'=>'');
            }
            return  array('full_name'=>'', 'date_of_birth'=>'', 'email'=>'', 'phone_number'=>'', 'address'=>'');
        }
        public function getId() {
            return $this->id;
        }
        public function getIsAdmin() {
            return $this->isAdmin;
        }
        public function getPass() {
            return $this->pass;
        }
        public function getUserNameFromDb( $id, $username) {
            $query = "SELECT * from user where user_id = '$id' or username = '$username'";
            $data = $this->getDataFromDb('username',$query, 'get user fail!!', $this->db);
            return  $data;
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
        function checkFollowUser( $user_id, $guest_id) {
            $query = "SELECT COUNT(*) FROM Follower WHERE guest_id = '$guest_id' AND user_id = '$user_id'";
            $result = $this->db->query($query);
            if (mysqli_num_rows($result)!==0) {
                $row = mysqli_fetch_array($result);
                $data = $row['COUNT(*)'];
                return $data;
            }else {
                exit();
            }
        }
        public function checkUserLikeVideo($video_id, $user_id) {
            if( isset($video_id) && isset($user_id) ) {
                $query = "SELECT count(*) FROM likes where user_id = '$user_id' and video_id = '$video_id'";
                $result = $this->db->query($query);
                if (mysqli_num_rows($result)!==0) {
                    $row = mysqli_fetch_array($result);
                    $data = $row['count(*)'];
                    // $this->db->close();
                    return $data;
                }else {
                    exit();
                }
            }
        }
    }

?>