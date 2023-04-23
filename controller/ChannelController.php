<?php 
    require_once './config/index.php';
    require_once 'Controller.php';
    class ChannelController  extends Controller{
        private $db ;
        public function __construct(){
            $database = new DB();
            $this->db = $database->getInstance();
        }
        public function connectDb() {
            $database = new DB();
            $this->db = $database->getInstance();
        }


        public function createNewChannel(){
            ob_end_clean();
            if(isset($_POST['name_channel']) and isset($_POST['descriptions_channel']) and isset($_POST['user_id'] ) ) {
                $name_channel = $_POST['name_channel']??'';    
                $descriptions_channel = $_POST['descriptions_channel']??'';    
                $background_url = $_POST['background_channel_url']??'';
                $background = $_FILES['background_channel']??null;
                $user_id = $_POST['user_id']??'';
                
                if ($background && !is_null($background) && $background["error"] == UPLOAD_ERR_OK) {
                    $target_dir = "./assets/upload_img/";
                    $ext = pathinfo($background["name"], PATHINFO_EXTENSION);
                    $background_url = $target_dir . "background_channel" . $user_id . "." . $ext;
                    $target_file = $target_dir . basename($background_url);
                    if (!move_uploaded_file($background["tmp_name"], $target_file)) {
                        echo json_encode(array('status'=>'false', 'message'=>"Load background failed"));
                        $this->db->close();
                        return;
                    }
                }else if($background_url == 'default') {
                    $background_url = './assets/images/background-default.png';
                }
                $query = "INSERT into channel(user_id, channel_name, channel_description,background ) values($user_id, '$name_channel', '$descriptions_channel', '$background_url')";
                $res= $this->db->query($query);
                if( $res ) {
                    echo json_encode(array('status'=>true, 'message'=> "Create new channel successfully!!"));
                }else {
                    echo json_encode(array('status'=>false, 'message'=> "Create new channel fail!!"));
                }
                $this->db->close();
            }else {
                echo json_encode(array('status' => false, 'message'=>'Create new channel failed!!'));
                $this->db->close();
            }
        }

        public function updateChannel(){
            ob_end_clean();
            if(isset($_POST['name_channel']) and isset($_POST['descriptions_channel']) and isset($_POST['user_id'] ) ) {
                $name_channel = $_POST['name_channel']??'';    
                $descriptions_channel = $_POST['descriptions_channel']??'';    
                $background_url = $_POST['background_channel_url']??'';
                $background = $_FILES['background_channel']??null;
                $user_id = $_POST['user_id']??'';
                
                if ($background && !is_null($background) && $background["error"] == UPLOAD_ERR_OK) {
                    $target_dir = "./assets/upload_img/";
                    $ext = pathinfo($background["name"], PATHINFO_EXTENSION);
                    $background_url = $target_dir . "background_channel" . $user_id . "." . $ext;
                    $target_file = $target_dir . basename($background_url);
                    if (!move_uploaded_file($background["tmp_name"], $target_file)) {
                        echo json_encode(array('status'=>'false', 'message'=>"Load background failed"));
                        return;
                    }
                }else if($background_url == 'default') {
                    $background_url = './assets/images/background-default.png';
                }
                $query = "UPDATE channel SET channel_name='$name_channel', channel_description='$descriptions_channel', background='$background_url' WHERE user_id=$user_id";
                $res = $this->db->query($query);
                if( $res ) {
                    echo json_encode(array('status'=>true, 'message'=> "Update channel successfully!!"));
                }else {
                    echo json_encode(array('status'=>false, 'message'=> "Update channel fail!!"));
                }
                $this->db->close();
            }else {
                echo json_encode(array('status' => false, 'message'=>'Create new channel failed!!'));
                $this->db->close();
                return;
            }
        }


        public function getInformationOfChannel() {
            ob_end_clean();
            if(isset($_POST['id'])) {
                $user_id = $_POST['id']??''; 
                $query = "SELECT u.user_id, u.username, u.profile_picture, u.email, c.channel_id, c.channel_name, c.channel_description, c.background, f.num_followers
                FROM User u
                JOIN Channel c ON u.user_id = c.user_id
                LEFT JOIN (
                    SELECT user_id, COUNT(*) AS num_followers
                    FROM Follower
                    GROUP BY user_id
                ) f ON u.user_id = f.user_id
                WHERE u.deleted = 0 and u.user_id = '$user_id'
                ORDER BY u.user_id
                ";

                $res = $this->db->query($query);
                if($res and mysqli_num_rows($res) > 0 ) {
                    echo json_encode(array('status' => true, 'message'=> 'Channel available!!', 'data'=> json_encode(mysqli_fetch_assoc($res) )));
                    $this->db->close();
                    return;
                }if($res and mysqli_num_rows($res) == 0){
                    echo json_encode(array('status' => false, 'message'=> 'Channel is not available!!'));
                    $this->db->close();
                    return;
                }else {
                    echo json_encode(array('status' => false, 'message'=> 'Server is not available!!'));
                    $this->db->close();
                    return;
                }
                
            }
        }

    }

?>