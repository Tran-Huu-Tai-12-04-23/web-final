<?php 
    class Middleware {
        private $db;
        public function __construct() {
            $database = new DB();
            $this->db = $database->getInstance();
        }
        public function checkLogin($isLogin) {
            if( !$isLogin ) {
                echo "<script>window.location.href = '".BASE_URL."'</script>";
            }
        }
        public function checkIsAdmin($isAdmin) {
            if( !$isAdmin ) {
                echo "<script>window.location.href = '".BASE_URL."'</script>";
            }  
        }

        public function checkIsChannel($userId ) {
            $query = "Select * from channel where user_id = $userId";
            $res = $this->db->query($query);
            if( $res and mysqli_num_rows($res) > 0  ) {
                return array('status'=> true,'message'=>'Chanel already exists!!');
            }else if( $res) {
                echo "<script>window.location.href = '".BASE_URL."me/create-new-channel&m=You have to create new channel!!&t=warn"."'</script>";
                return array('status'=> false,'message'=>'You have to cerate new chanel!!');
            }else {
                return array('status'=> false,'message'=>'Err server!!');
            }
        }
       
    }

?>