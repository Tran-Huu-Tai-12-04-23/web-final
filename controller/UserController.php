<?php 
    require_once './config/index.php';
    require_once 'Controller.php';
    class UserController  extends Controller{
        private $db ;
        public function __construct(){
            $database = new DB();
            $this->db = $database->getInstance();
        }
        public function connectDb() {
            $database = new DB();
            $this->db = $database->getInstance();
        }
        public function getDataFrom($query) {
            $result = $this->db->query($query);
            if ($result !== false && $result->num_rows > 0) {
                $row = mysqli_fetch_array($result);
                return $row;
            } else {
               return null;
            }
        }
        public function login($prevUrl) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST['username']) && $_POST['password'] ) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $query = "select * from user where username ='$username'";
                    $user = $this->getDataFrom($query);
                    if( !$user ){
                        echo '<script>addNotification("User not found!! please re-login", "err");</script>';
                        exit();
                    }   
                    if ($user && password_verify($password, $user['password'])) {
                        if($user['blocked'] == 1){
                            echo '<script>addNotification("Your account has been blocked!!", "err");</script>';
                            exit();
                        }
                        if($user['deleted'] == 1){
                            echo '<script>addNotification("Your account has been deleted!!", "err");</script>';
                            exit();
                        }
                        // session_start(); 
                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['isLogin'] = True;
                        $_SESSION['avatar'] = $user['profile_picture'];
                        $_SESSION['is_admin'] = $user['is_admin'];
                        // parent::reject($prevUrl[0]);
                        parent::returnHome();
                    } else {
                        echo '<script>addNotification("Invalid username or password!!", "err");</script>';
                        exit();
                    }
                }
                echo '<script>addNotification("Invalid username or password!!", "err");</script>';
                exit();
            }
        }
        
        public function getUserId($username) {
            $query = "SELECT user_id FROM user WHERE username = '$username'";
            $res = $this->db->query($query);
            if ($res && $res->num_rows > 0) {
                return (int) $res->fetch_assoc()['user_id'];
            } else {
                return null;
            }
        }
        
        public function insertUserDetails($username, $full_name, $email, $date_of_birth, $address, $phone_number) {
            $user_id = $this->getUserId($username);
            if ($user_id) {
                $query = "INSERT INTO user_details (user_id, full_name, date_of_birth, email, phone_number, address)
                          VALUES ($user_id, '$full_name', '$date_of_birth', '$email', '$phone_number', '$address')";
                $res = $this->db->query($query);
                if ($res) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        public function register($precvUrl){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST['username']) && $_POST['password'] && $_POST['confirm_password'] && $_POST['email']) {
                     $username = $_POST['username'];
                     $password = $_POST['password'];
                     $confirm_password = $_POST['confirm_password'];
                     $email = $_POST['email'];
                     $errors = array();
                     if (empty($username)) {
                         $errors[] = "Username is required";
                     }
                     if (empty($password)) {
                         $errors[] = "Password is required";
                     }
                     if ($password != $confirm_password) {
                         $errors[] = "Passwords do not match";
                     }
                     if (empty($errors)) {
                         $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                         $query = "SELECT * FROM user where username = '$username'";
                         if( mysqli_num_rows($this->db->query($query)) > 0 ) {
                             echo '<script>addNotification("User is Already!!", "err");</script>';
                             exit();
                         } else {
                            $query = "INSERT INTO user (username, password, email) VALUES ('$username', '$password', '$email')";
                            if ($this->db->query($query) === True) {
                                $insert = $this->insertUserDetails($username,'Updating', $email,'Updating', 'Updating' ,'Updating' );
                                if($insert == true ) {
                                    // parent::returnHome();
                                    parent::reject('login?m=Create new account successfully&&type=success');
                                    exit();
                                }else {
                                    echo '<script>addNotification("User is err!!", "err");</script>';
                                    exit();
                                }
                            } else {
                                 echo "Error: " . $query . "<br>" . $this->db->error;
                             }
                         }
                     } else {
                         return 'Registered failed!!!';
                     }
                 }
                
                }
            $this->db->close();


        }

        public function logout($prevUrl) {
            // session_start();
            session_destroy();
            parent::returnHome();
        }
        public function updateAvatar($user_id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if( isset($_POST['avatar-url'] ) && $_POST['avatar-url'] !== '' ) {
                    $avatar_url = $_POST['avatar-url'];
                    $this->uploadImageToDB($avatar_url, $user_id);
                } else {
                    $target_dir = "./assets/upload_img/"; 
                    $timestamp = time();
                    $new_file_name = "avatar-"."$user_id" . $timestamp . "." . basename($_FILES["avatar"]["name"]);
                    $target_file = $target_dir . $new_file_name;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $this->uploadImg($user_id,$target_file, $target_dir, $imageFileType, 'avatar');
                }
            }
            return;
        }

        public function uploadImg($user_id, $target_file, $target_dir, $imageFileType, $name_form){
            $uploadOk = 1;
                // Kiểm tra xem tập tin là ảnh hay không
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if($check !== false) {
                    // echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }
            // Kiểm tra xem tập tin đã tồn tại trên server hay chưa
            if (file_exists($target_file)) {
                $uploadOk = 0;
            }
            // Nếu không có lỗi, di chuyển tập tin ảnh lên thư mục lưu trữe
            $previousPageUrl = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '';
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES[$name_form]["tmp_name"], $target_file)) {
                    $this->uploadImageToDB($target_file, $user_id);
                } else {
                    $this->uploadImageToDB($target_file, $user_id);
                }
                echo '<script>addNotification("", "success");</script>';
                parent::reject('me/profile/');
            }else {
                echo '<script>addNotification("Change avatar fail!!", "err")</script>';
                parent::reject('me/profile/');
            }
        }
        
        public function updateProfile($user_id){
            // Check if the form has been submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $full_name = $_POST['full_name'];
                $date_of_birth = $_POST['date_of_birth'];
                $email = $_POST['email'];
                $phone_number = $_POST['phone_number'];
                $address = $_POST['address'];
                $target_dir = "./assets/upload_img/"; 
                $timestamp = time();
                $new_file_name = "avatar-"."$user_id" . $timestamp . "." . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $new_file_name;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // set data for user_details
                $user_detail =  $this->db->query("Select * from user_details where user_id = '$user_id'");
                $phone_old =  $this->db->query("Select * from user_details where phone_number = '$phone_number'");
                $query = "insert into user_details(user_id,date_of_birth, full_name, email, phone_number, address) values('$user_id','$date_of_birth','$full_name', '$email', '$phone_number', '$address')" ;
                if( mysqli_num_rows($user_detail) > 0) {
                    $query = "Update user_details set date_of_birth = '$date_of_birth', full_name = '$full_name', email = '$email', phone_number = '$phone_number', address = '$address' where user_id = '$user_id'";
                    $res =  $this->db->query($query);
                    // $this->uploadImg($user_id,$target_file, $target_dir, $imageFileType, 'image');
                    if($res) {
                        parent::reject('me/profile/?m=Save change profile successfully !!!&t=success');
                    }else {
                        parent::reject('me/profile/?m=Err edit!!&t=err');
                    }
                } else if( mysqli_num_rows($phone_old) > 0 ) {
                    parent::reject('me/profile/?m=Phone number is ready!!&t=err');
                }else if( $this->db->query($query) ) {
                    if( (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) ) {
                        // $this->uploadImg($user_id,$target_file, $target_dir, $imageFileType, 'image');
                    }
                }else {
                    echo '<script>addNotification("Err edit !!!", "err")</script>';
                }
            }

            $this->db->close();
        }

        public function changeUserName($user_id, $username) {
            ob_clean();
            if($user_id) {
                // $query = "SELECT * from user where username = '$username'";
                // $res = $this->db->query($query);
                // if( $res and mysqli_num_rows($res) > 0 ) {
                //     parent::reject('admin/user/edit?id='.$user_id.'&m=Username already!!&t=err');
                //     return false;
                // }
                $query = "UPDATE user set username = '$username' where user_id = $user_id";
                $res = $this->db->query($query);
                if($res) {
                    return true;
                }
                return false ;
            }
            return false ;
        }
        public function saveEditUser($user_id){
            ob_clean();
            // Check if the form has been submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $full_name = $_POST['full_name'] ?? '';
                $username = $_POST['username'] ?? '';
                $date_of_birth = $_POST['date_of_birth'] ?? '';
                $email = $_POST['email'] ?? '';
                $phone_number = $_POST['phone_number'] ??''; 
                $address = $_POST['address'] ?? '';
                $target_dir = "./assets/upload_img/"; 
                $timestamp = time();
                $new_file_name = "avatar-"."$user_id" . $timestamp . "." . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $new_file_name;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
                // Check if the phone number belongs to the same user
                $phone_old =  $this->db->query("SELECT * FROM user_details WHERE user_id != '$user_id' AND phone_number = '$phone_number'");
                if(mysqli_num_rows($phone_old) > 0) {
                    parent::reject('admin/user/edit?id='.$user_id.'&m=Phone number is already taken!!&t=err');
                    return;
                }
        
                // Set data for user_details
                $user_detail =  $this->db->query("SELECT * FROM user_details WHERE user_id = '$user_id'");
                $query = "INSERT INTO user_details(user_id, date_of_birth, full_name, email, phone_number, address) VALUES ('$user_id','$date_of_birth','$full_name', '$email', '$phone_number', '$address')";
        
                if(mysqli_num_rows($user_detail) > 0) {
                    $query = "UPDATE user_details SET date_of_birth = '$date_of_birth', full_name = '$full_name', email = '$email', phone_number = '$phone_number', address = '$address' WHERE user_id = '$user_id'";
                }
        
                $res =  $this->db->query($query);
                $changeUserName = $this->changeUserName($user_id, $username);
        
                if($res && $changeUserName) {
                    parent::reject('admin/user/edit?id='.$user_id.'&m=Save change profile successfully !!!&t=success');
                }else {
                    parent::reject('admin/user/edit?id='.$user_id.'&m=Err edit !!&t=err');
                }
        
                if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $this->uploadImg($user_id,$target_file, $target_dir, $imageFileType, 'image');
                }
            }
        
            $this->db->close();
        }
        

        public function uploadImageToDB($file_name, $user_id){
            echo $file_name;
            $query = "Update user set profile_picture = '$file_name'  where user_id = '$user_id'";
            // session_start();
            $_SESSION['avatar'] = $file_name;
            if( !$this->db->query($query)) {
                echo "There was an error uploading your";
            }
        }

        public function followUser() {
            ob_end_clean();
            if (isset($_POST['user_id']) && isset($_POST['guest_id'])) {
                $userId = $_POST['user_id'];
                $userIdGuest = $_POST['guest_id'];
                // Check if the user has already followed the other user
                $query = "SELECT follower_id FROM Follower WHERE user_id = ? AND guest_id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ii', $userId, $userIdGuest);
                $stmt->execute();
                $stmt->store_result();
                $num_rows = $stmt->num_rows;
        
                if ($num_rows > 0) {
                    // The user has already followed the other user, remove the follow relationship
                    $query = "DELETE FROM Follower WHERE user_id = ? AND guest_id = ?";
                    $stmt = $this->db->prepare($query);
                    $stmt->bind_param('ii', $userId, $userIdGuest);
                    if ($stmt->execute()) {
                        echo json_encode(array("status" => true, "message" => "UnFollowed successfully!", 'type'=>1));
                    } else {
                        echo json_encode(array("status" => false, "message" => "Error: " . $this->db->error));
                    }
                } else {
                    // The user has not followed the other user, insert the follow relationship
                    $query = "INSERT INTO Follower (user_id, guest_id, num_followers) VALUES (?, ?, 0)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bind_param('ii', $userId, $userIdGuest);
                    if ($stmt->execute()) {
                        echo json_encode(array("status" => true, "message" => "Followed successfully!", 'type'=>0));
                    } else {
                        echo json_encode(array("status" => false, "message" => "Error: " . $this->db->error));
                    }
                }
        
                // Close the database connection
                $this->db->close();
            } else {
                echo json_encode(array("status" => false, "message" => "Can't read data, data is empty!"));
            }
        }

        public function likeVideo() {
            ob_end_clean();
            $putData = file_get_contents('php://input');
            parse_str($putData, $putParams);
            if ( isset($putParams['user_id']) && isset( $putParams['video_id'])) {
                $userId = $putParams['user_id'];
                $videoId = $putParams['video_id'];
                // Check if the user has already liked the video
                $query = "SELECT like_id FROM likes WHERE user_id = ? AND video_id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ii', $userId, $videoId);
                $stmt->execute();
                $stmt->store_result();
                $num_rows = $stmt->num_rows;
        
                if ($num_rows > 0) {
                    // The user has already liked the video, remove the like
                    $query = "DELETE FROM likes WHERE user_id = ? AND video_id = ?";
                    $stmt = $this->db->prepare($query);
                    $stmt->bind_param('ii', $userId, $videoId);
                    if ($stmt->execute()) {
                        echo json_encode(array("status" => true, "message" => "Unliked successfully!", 'type'=>1));
                    } else {
                        echo json_encode(array("status" => false, "message" => "Error: " . $this->db->error));
                    }
                } else {
                    // The user has not liked the video, insert the like
                    $query = "INSERT INTO likes (user_id, video_id, like_date) VALUES (?, ?, NOW())";
                    $stmt = $this->db->prepare($query);
                    $stmt->bind_param('ii', $userId, $videoId);
                    if ($stmt->execute()) {
                        echo json_encode(array("status" => true, "message" => "Liked successfully!", 'type'=>0));
                    } else {
                        echo json_encode(array("status" => false, "message" => "Error:" . $this->db->error));
                    }
                }
        
                // Close the database connection
                $this->db->close();
            } else {
                echo json_encode(array("status" => false, "message" => "Can't read data, data is empty!"));
            }
        }
    
        public function changePass() {
            ob_end_clean();
            $putData = file_get_contents('php://input');
            parse_str($putData, $putParams);
            if(isset($putParams['user_id']) && isset($putParams['new_pass']) && isset($putParams['new_confirm_pass']) && isset($putParams['old_pass'])) {
                $user_id = $putParams['user_id'];
                $new_pass = $putParams['new_pass'];
                $old_pass = $putParams['old_pass'];
                $new_confirm_pass = $putParams['new_confirm_pass'];
                
                // check password change 
                $query = "SELECT * FROM user WHERE user_id = '$user_id'";
                $res = $this->db->query($query);
                if(!$res || mysqli_num_rows($res) == 0) {
                    echo json_encode(array('status' => false, 'message' => 'User not found!!'));
                    return;
                } else {
                    $row = mysqli_fetch_assoc($res);
                    $current_password = $row['password'];
                    if( !password_verify($old_pass,$current_password)) {
                        echo json_encode(array('status' => false, 'message' => 'Old password is incorrect!!'));
                        return;
                    } else if($new_pass != $new_confirm_pass) {
                        echo json_encode(array('status' => false, 'message' => 'New passwords do not match!!'));
                        return;
                    } else {
                        $new_pass  = password_hash($new_pass, PASSWORD_DEFAULT);
                        $update_query = "UPDATE user SET password='$new_pass' WHERE user_id='$user_id'";
                        $update_res = $this->db->query($update_query);
                        if($update_res) {
                            echo json_encode(array('status' => true, 'message' => 'Password changed successfully!!'));
                            return;
                        } else {
                            echo json_encode(array('status' => false, 'message' => 'Failed to change password!!'));
                            return;
                        }
                    }
                }
            } else {
                echo json_encode(array('status' => false, 'message' => 'Please fill all fields!!'));
            }
        }

        public function getUsers() {
            ob_end_clean();
            if(isset($_GET['limit'])) {
                $limit = $_GET['limit']??'';
                $query = "SELECT distinct  user.*, user_details.*
                FROM user, user_details
                WHERE user.user_id = user_details.user_id and user.deleted = 0  and is_admin = 0
                limit $limit, 16
                ";
                $res = $this->db->query($query);
                if($res && mysqli_num_rows($res) > 0 ) {
                    echo json_encode(array('status'=>true, 'message'=>'Load user success!!', 'data'=> json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC))));
                    return;
                } else {
                    echo json_encode(array('status' => false, 'message' => 'Get users err '));
                    return [];
                }
            }
            return [];
            echo json_encode(array('status' => false, 'message' => 'Please enter user'));
        }

        public function countUserBlocked() {
            ob_end_clean();
            $query = "SELECT COUNT(DISTINCT user.user_id) as number_block FROM user WHERE blocked = 1;
            ";
            $res = $this->db->query($query);
            if($res && mysqli_num_rows($res) > 0 ) {
                echo json_encode(array('status'=>true, 'message'=>'Count number user blocked!!', 'data'=> json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC))));
                return;
            } else {
                echo json_encode(array('status' => false, 'message' => 'Count number user blocked fail!!'));
                return [];
            }
        }
        public function countUserDeleted() {
            ob_end_clean();
            $query = "SELECT COUNT(DISTINCT user.user_id) as number_delete FROM user WHERE deleted = 1;";
            $res = $this->db->query($query);
            if($res && mysqli_num_rows($res) > 0 ) {
                echo json_encode(array('status'=>true, 'message'=>'Count number user blocked!!', 'data'=> json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC))));
                return;
            } else {
                echo json_encode(array('status' => false, 'message' => 'Count number user blocked fail!!'));
                return [];
            }
        }
        public function blockUser() {
            ob_end_clean();
            if(isset($_POST['user_id']) ) {
                $user_id = $_POST['user_id'] ?? '';
                $query = "UPDATE user set blocked = 1 where user_id = $user_id ";
                $res = $this->db->query($query);
                if($res) {
                    $this->countUserBlocked();
                    return;
                } else {
                    echo json_encode(array('status' => false, 'message' => 'Block user fail!!'));
                    return [];
                }
            }
        }
        public function removeSoftUser() {
            ob_end_clean();
            if(isset($_POST['user_id']) ) {
                $user_id = $_POST['user_id'] ?? '';
                $query = "UPDATE user set deleted = 1 where user_id = $user_id ";
                $res = $this->db->query($query);
                if($res) {
                    $this->countUserDeleted();
                    return;
                } else {
                    echo json_encode(array('status' => false, 'message' => 'Delete user fail!!'));
                    return [];
                }
            }
        }
        
        public function destroyUser() {
            ob_end_clean();
            if(isset($_POST['user_id']) ) {
                $user_id = $_POST['user_id'] ?? '';
                $query = "DELETE from user_details where user_id = $user_id ";
                $res = $this->db->query($query);
                if($res) {
                    $query = "DELETE from user where user_id = $user_id ";
                    $res = $this->db->query($query);
                    if($res ) {
                        $this->countUserDeleted();
                    }else {
                        echo json_encode(array('status' => false, 'message' => 'Destroy user fail!!'));
                        return;
                    }
                } else {
                    echo json_encode(array('status' => false, 'message' => 'Destroy user fail!!', 'type'=>'Video of user available'));
                    return [];
                }
            }
        }

        public function getUsersBlock() {
            ob_end_clean();
            if(isset($_GET['limit'])) {
                $limit = $_GET['limit']??'';
                $query = "SELECT distinct  user.*, user_details.*
                FROM user, user_details
                WHERE user.user_id = user_details.user_id and user.blocked = 1 and user.is_admin = 0
                limit $limit, 16
                ";
                $res = $this->db->query($query);
                if($res && mysqli_num_rows($res) > 0 ) {
                    echo json_encode(array('status'=>true, 'message'=>'Load more user blocked success!!', 'data'=> json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC))));
                    return;
                } else {
                    echo json_encode(array('status' => false, 'message' => 'Get users err '));
                    return [];
                }
            }
            return [];
            echo json_encode(array('status' => false, 'message' => 'Please enter user'));
        }
        public function unlockUser() {
            ob_end_clean();
            if(isset($_POST['user_id']) ) {
                $user_id = $_POST['user_id'] ?? '';
                $query = "UPDATE user set blocked = 0 where user_id = $user_id ";
                $res = $this->db->query($query);
                if($res) {
                    $this->countUserBlocked($user_id);
                    return;
                } else {
                    echo json_encode(array('status' => false, 'message' => 'Unlock user fail!!'));
                    return [];
                }
            }
        }
        public function restoreUser() {
            ob_end_clean();
            if(isset($_POST['user_id']) ) {
                $user_id = $_POST['user_id'] ?? '';
                $query = "UPDATE user set deleted = 0 where user_id = $user_id ";
                $res = $this->db->query($query);
                if($res) {
                    $this->countUserDeleted($user_id);
                    return;
                } else {
                    echo json_encode(array('status' => false, 'message' => 'Delete user fail!!'));
                    return [];
                }
            }
        }

        public function getUserDeleted() {
            ob_end_clean();
            if(isset($_GET['limit'])) {
                $limit = $_GET['limit']??'';
                $query = "SELECT distinct  user.*, user_details.*
                FROM user, user_details
                WHERE user.user_id = user_details.user_id and user.deleted = 1 and user.is_admin = 0
                limit $limit, 16
                ";
                $res = $this->db->query($query);
                if($res && mysqli_num_rows($res) > 0 ) {
                    echo json_encode(array('status'=>true, 'message'=>'Load user deleted success!!', 'data'=> json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC))));
                    return;
                } else {
                    echo json_encode(array('status' => false, 'message' => 'Get users err '));
                    return [];
                }
            }
            return [];
            echo json_encode(array('status' => false, 'message' => 'Please enter user'));
        }
    }

?>