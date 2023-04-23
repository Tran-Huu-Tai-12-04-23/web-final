<?php 
require_once './config/index.php';
require_once 'Controller.php';
class CommentController extends Controller{
    private $db;
    
    public function __construct() {
        $database = new DB();
        $this->db = $database->getInstance();
    }
  
    public function comment() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $videoID = $_POST['video_id'];
            $userID = $_POST['user_id'];
            $comment = $_POST['comment'];
            $query = "INSERT INTO comment (user_id, video_id,comment_text) values('$userID', '$videoID', '$comment')";
            $res = $this->db->query($query);
            $query = "SELECT user.*, comment.* FROM comment, user where comment.user_id = user.user_id and comment.video_id = $videoID order by comment.comment_date desc limit 1";
            $res = $this->db->query($query);
            echo json_encode( mysqli_fetch_all($res, MYSQLI_ASSOC));
        }
    }
    public function getComment($video_id) {
        ob_end_clean();
        $query = "SELECT user.*, comment.* FROM comment, user where comment.user_id = user.user_id and comment.video_id = $video_id order by comment.comment_date desc";
        $res = $this->db->query($query);
        if(!$res) return null;
        echo json_encode( mysqli_fetch_all($res, MYSQLI_ASSOC));
    }
    
    public function removeComment() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $commentID = $_POST['comment_id'];
            $queryDelReply = "DELETE from reply_comment where comment_id = '$commentID'";
            $res2 = $this->db->query($queryDelReply);
            $query = "DELETE from comment where comment_id = '$commentID'";
            $res = $this->db->query($query);
            if( $res && $res2 ) {
                echo json_encode(array('status'=> true, 'message'=> 'Comment removed successfully!'));
            } else {
                echo json_encode(array('status'=> false, 'message'=> 'Failed to remove comment.'));
            }
        }
    }
    
    public function replyComment() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $replyComment = $_POST['comment_text'];
            $userID = $_POST['user_id'];
            $commentID = $_POST['comment_id'];
            $query = "insert into reply_comment(reply_comment_text, user_id, comment_id) values('$replyComment', '$userID', '$commentID') ";
            $res = $this->db->query($query);
            if( !$res ) return null;
            $query = "SELECT reply_comment.*, user.*, comment.* FROM reply_comment, comment, user where reply_comment.user_id = user.user_id and reply_comment.comment_id = '$commentID' and reply_comment.comment_id = comment.comment_id order by reply_comment.reply_comment_date desc limit 1";
            $res = $this->db->query($query);
            if( !$res ) return null ;
            echo json_encode( $res->fetch_assoc());
        }
    }
    public function saveEditComment() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $comment_text = $_POST['comment_text'];
            $commentID = $_POST['comment_id'];
            
            $query = "Update comment set comment_text = '$comment_text' where comment_id = '$commentID'";
            $res = $this->db->query($query);
            if( !$res ) return null ;
            echo json_encode(array('status' => 'true', 'message' =>'edit comment successfully'));
        }
        
    }
    public function saveEditReplyComment() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $replyCommentText = $_POST['reply_comment_text'];
            $replyCommentID = $_POST['reply_comment_id'];
            $query = "Update reply_comment set reply_comment_text = '$replyCommentText' where reply_comment_id = '$replyCommentID'";
            $res = $this->db->query($query);
            if( !$res ) return null ;
            echo json_encode(array('status' => 'true', 'message' =>'edit reply comment successfully'));
        }
        
    }

    public function getReplyComment($comment_id) {
        ob_end_clean();
        $query = "SELECT reply_comment.*, user.*, comment.* FROM reply_comment,comment, user where reply_comment.user_id = user.user_id and reply_comment.comment_id = '$comment_id' and reply_comment.comment_id =  comment.comment_id";
        $res = $this->db->query($query);
        if(!$res) return null;
        echo json_encode( mysqli_fetch_all($res, MYSQLI_ASSOC));
    }
    
    public function removeReplyComment() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $replyCommentID = $_POST['reply_comment_id'];
            $query = "DELETE from reply_comment where reply_comment_id = '$replyCommentID'";
            $res = $this->db->query($query);
            if( !$res ) {
                echo 'fail delete comment ';
            }
            else {
                echo json_encode(array('status'=>'ok', 'mes'=>'Success'));
            }
        }
    }

    public function getCommentOnChannel() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['id'], $_GET['limit'])) {
                $user_id = $this->db->real_escape_string($_GET['id']);
                $limit = $this->db->real_escape_string($_GET['limit']);
                $query = "SELECT Comment.comment_id, Comment.comment_text, Comment.comment_date, User.username, video.video_id, comment.user_id, User.profile_picture
                          FROM Comment 
                          JOIN User ON Comment.user_id = User.user_id 
                          JOIN Video ON Comment.video_id = Video.video_id 
                          WHERE Video.user_id = '{$user_id}' AND Comment.user_id != '{$user_id}' AND Video.deleted = 0 AND User.deleted = 0
                          ORDER BY Comment.comment_date DESC
                          LIMIT {$limit}, 16";
                $res = $this->db->query($query);
                if ($res && mysqli_num_rows($res) > 0) {
                    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
                    echo json_encode(array('status' => true, 'message' => 'Get information comment success', 'data' => $data));
                } else {
                    echo json_encode(array('status' => false, 'message' => 'No comments found for this user'));
                }
            } else {
                echo json_encode(array('status' => false, 'message' => 'Missing parameters'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Method Not Allowed'));
        }
    }
    
    public function getDetailComment() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['comment_id'])) {
                $comment_id = $_GET['comment_id']??'';
                $query = "SELECT distinct c.comment_id, c.comment_text, c.comment_date, u.username, u.email, u.profile_picture, v.title, v.description, v.url, v.upload_date, v.thumbnails
                FROM Comment c
                JOIN User u ON c.user_id = u.user_id
                JOIN Video v ON c.video_id = v.video_id
                WHERE c.comment_id = '$comment_id';
                ";
                $res = $this->db->query($query);
                if($res and mysqli_num_rows($res) > 0 ) {
                    echo json_encode(array('status' => true, 'message'=>'Get detail comment success!!', 'data'=> mysqli_fetch_all($res,MYSQLI_ASSOC )));
                }else {
                    echo json_encode(array('status' => false, 'message'=>'Get detail comment failed!!'));
                }
                $this->db->close();
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Method Not Allowed'));
        }
    }
}


?>