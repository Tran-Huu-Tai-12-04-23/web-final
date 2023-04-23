<?php 
require_once './config/index.php';
require_once 'Controller.php';
class VideoController extends Controller{
    private $db;
    
    public function __construct() {
        $database = new DB();
        $this->db = $database->getInstance();
    }
    public function getEmbeddedLink($link) {
        if (strpos($link, 'watch?v=') !== false) {
            $start = strpos($link, 'watch?v=') + strlen('watch?v=');
            $res = substr($link, $start);
            return 'https://www.youtube.com/embed/' . $res;
        } else {
            return $link;
        }
    }
    public function uploadVideo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            if (empty($title) || empty($description)) {
                parent::reject('Title and description are required.');
                return;
            }
            $videoUrl = '';
            $thumbnailUrl = '';
            $modePrivate = 0;
            $user_id = $_POST['user_id'] ?? '';
            if (isset($_POST['mode_private']) && $_POST['mode_private'] == 'private') {
                $modePrivate = 1;
            }
            if (isset($_POST['video-url']) && !empty($_POST['video-url'])) {
                $videoUrl = $this->getEmbeddedLink($_POST['video-url']);
            } elseif (isset($_FILES['video']) && !empty($_FILES['video']['name'])) {
                $videoUrl = $this->saveVideoIntoFolder($_FILES['video']);
            } else {
                // handle error - neither 'video' file nor 'video-url' parameter was found
            }
            if (isset($_FILES['thumbnail']) && !empty($_FILES['thumbnail']['name'])) {
                $thumbnailUrl = $this->saveThumbnailIntoFolder($_FILES['thumbnail']);
            } elseif (isset($_POST['thumbnail-url']) && !empty($_POST['thumbnail-url'])) {
                $thumbnailUrl = $_POST['thumbnail-url'];
            } else {
                // handle error - neither 'thumbnail' file nor 'thumbnail-url' parameter was found
            }
            // add video into table video 
            $res = $this->addVideoToTable($title, $description, $videoUrl, $thumbnailUrl, $modePrivate, $user_id);
            if ($res) {
                parent::reject('user/channel');
            } else {
                // parent::reject('user/channel');
            }
        }
    }
    
    public function addVideoToTable($title, $description, $videoUrl, $thumbnailUrl, $modePrivate, $user_id) {
        $sql = "INSERT INTO video (user_id,title, description, url, thumbnails, mode_private) VALUES ('$user_id','$title', '$description', '$videoUrl', '$thumbnailUrl', '$modePrivate')";
        if( $this->db->query($sql)) {
            return true;
        }else {
            return false;
        }
    }

    public function saveVideoIntoFolder($video) {
        $uploads_dir =  "./assets/upload_video/"; 
        $filename = $video['name']; 
        $file_ext = pathinfo($filename,PATHINFO_EXTENSION);
        $video_name = $uploads_dir .uniqid() . '.' . $file_ext;
        if( move_uploaded_file($video['tmp_name'],  $video_name) ){
            return $video_name;
        }
        else {
            return $video_name;
        }
    }
    public function saveThumbnailIntoFolder($thumbnail) {
        $uploads_dir = './assets/upload_img/';
        $tmp_name = $thumbnail['tmp_name'];
        $file_name = basename($thumbnail['name']);
        $file_path = $uploads_dir . $file_name;
        if(move_uploaded_file($tmp_name, $file_path)  ) {
            return $file_path;
        }else {
            return null;
        }
    }
    public function comment() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $videoID = $_POST['video_id'];
            $userID = $_POST['user_id'];
            $comment = $_POST['comment'];
            $query = "INSERT INTO comment (user_id, video_id,comment_text) values('$userID', '$videoID', '$comment')";
            $res = $this->db->query($query);
            $query = "SELECT comment.*, user.* FROM comment, user where comment.user_id = user.user_id and comment.video_id = $videoID and comment.user_id = $userID order by comment_date desc limit 1";
            $res = $this->db->query($query);
            echo json_encode( $res->fetch_assoc());
        }
    }

    public function getAllVideoPublic() {   
        ob_end_clean();
        $limit = $_GET['limit']??0;
        $query = "SELECT video.*, user.* FROM video, user where video.user_id = user.user_id and mode_private = 0  and video.deleted = 0 order by upload_date desc limit $limit, 25; ";
        $res = $this->db->query($query); 
        if(!$res) return null;
        if(  mysqli_num_rows($res) == 0) {
            return [];
        }
        if(  mysqli_num_rows($res) > 0 ) {
            echo json_encode($res->fetch_all(MYSQLI_ASSOC));
        }
        $this->db->close();
        return  [];
    }
    public function getAllVideoForSlide() {
        ob_end_clean();
        if(isset($_GET['id'])) {
            $id = $_GET['id']??'';
            $query = "SELECT video.*, user.* FROM video, user where video.user_id = user.user_id and video.video_id != $id and mode_private = 0  and video.deleted = 0 order by upload_date desc limit 40";
            $res = $this->db->query($query); 
            if(!$res) return null;
            if(  mysqli_num_rows($res) == 0) {
                return [];
            }
            if(  mysqli_num_rows($res) > 0 ) {
                echo json_encode(array("status" => true, 'message' => "get the most video successfully!!!", 'data' => $res->fetch_all(MYSQLI_ASSOC)));
            }
            $this->db->close();
            return;
        }
        return  [];
    }
    public function get20VideoHaveTheMostViews() {
        ob_end_clean();
        $query = "SELECT video.*, user.* FROM video, user where video.user_id = user.user_id and video.mode_private = 0 and video.deleted = 0  order by video.video_id desc limit 20 ";
        $res = $this->db->query($query); 
        if(!$res) return null;
        if(  mysqli_num_rows($res) == 0) {
            return [];
        }
        if(  mysqli_num_rows($res) > 0 ) {
            echo json_encode(array("status" => true, 'message' => "get the most video successfully!!!", 'data' => $res->fetch_all(MYSQLI_ASSOC)));
        }
        $this->db->close();
        return  [];
    }
    public function getTopVideoDiscovery() {
        ob_end_clean();
        $query = "SELECT video.*, user.* FROM video, user where video.user_id = user.user_id and video.mode_private = 0  and video.deleted = 0 order by video.upload_date limit 10 ";
        $res = $this->db->query($query); 
        if(!$res) return null;
        if(  mysqli_num_rows($res) == 0) {
            return [];
        }
        if(  mysqli_num_rows($res) > 0 ) {
            echo json_encode(array("status" => true, 'message' => "get the most video successfully!!!", 'data' => $res->fetch_all(MYSQLI_ASSOC)));
        }
        $this->db->close();
        return  [];
    }

    public function getVideoLiked() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'GET' ) {
            $id = $_GET['id']??'';
            $limit = $_GET['limit']??0;
            if(!isset($id) ) {
                echo json_encode(array("status" => false, 'message' => "id not available"));
                return;
            }
            $query = "SELECT Video.*, User.*
            FROM Video
            JOIN User ON Video.user_id = User.user_id
            JOIN likes ON Video.video_id = likes.video_id
            WHERE likes.user_id = '$id' and Video.deleted = 0 order by likes.like_date DESC limit $limit, 25";
            $res = $this->db->query($query); 
            if(!$res) return null;
            if(  mysqli_num_rows($res) == 0) {
                return [];
            }
            if(  mysqli_num_rows($res) > 0 ) {
                echo json_encode(array("status" => true, 'message' => "get the video liked successfully!!!", 'data' => $res->fetch_all(MYSQLI_ASSOC)));
            }
            $this->db->close();
        }else {
            echo json_encode(array("status" =>false, 'message' => "Method not found!!!"));
        }
        
    }
    public function getVideoWatched() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'GET' ) {
            $id = $_GET['id']??'';
            $limit = $_GET['limit']??0;
            if(!isset($id) ) {
                echo json_encode(array("status" => false, 'message' => "id not available"));
                return;
            }
            $query = "SELECT distinct v.*, u.*
            FROM Video v
            JOIN View w ON v.video_id = w.video_id
            JOIN User u ON u.user_id = v.user_id
            WHERE w.user_id = '$id' and v.deleted = 0 
            ORDER BY w.view_date DESC limit $limit , 25;
            ";
            $res = $this->db->query($query); 
            if(!$res) return null;
            if(  mysqli_num_rows($res) == 0) {
                return [];
            }
            if(  mysqli_num_rows($res) > 0 ) {
                echo json_encode(array("status" => true, 'message' => "get the video liked successfully!!!", 'data' => $res->fetch_all(MYSQLI_ASSOC)));
            }
            $this->db->close();
        }else {
            echo json_encode(array("status" =>false, 'message' => "Method not found!!!"));
        }
        
    }

    public function createAddToPlaylist() {
        ob_end_clean();
        if(isset($_POST['name_playlist']) and isset($_POST['user_id']) and $_POST['video_id']) {
            $resAddNewPlayList = $this->createNewPlayList($_POST['name_playlist'], $_POST['user_id']);
            $statusAddNewPlayList = $resAddNewPlayList['status'];
            if($statusAddNewPlayList) {
                $this->addVideoToPlayList($_POST['name_playlist'], $_POST['video_id'], $_POST['user_id']);
                return;
            }else {
                $this->addVideoToPlayList($_POST['name_playlist'], $_POST['video_id'], $_POST['user_id']);
                return;
            }
        }
        echo json_encode(array('status' => false, 'message' => 'Please enter name playlist!!!'));

    }
    public function createNewPlayList($name_playlist, $user_id) {
        $query = "SELECT * from playlist WHERE playlist_name = '$name_playlist' and user_id = '$user_id'";
        $res = $this->db->query($query);
        if ($res && mysqli_num_rows($res) > 0) {
            return array('status' => false, 'message' => 'Playlist has already!!!');
        } else {
            $query = "INSERT into playlist(playlist_name, playlist_description, user_id) values('$name_playlist', '', '$user_id')";
            $res = $this->db->query($query);
            if ($res) {
                return array('status' => true, 'message' => 'Add new playlist successfully!!!');
            }else {
                return array('status' => false, 'message' => 'Add new playlist fail!!!');
            }
        }
    }

    public function addVideoToPlayList($name_playlist, $video_id, $user_id) {
        $query = "SELECT * from playlist WHERE playlist_name= '$name_playlist' and user_id= '$user_id'";
        $res = $this->db->query($query);
        if( $res && mysqli_num_rows($res) > 0 ) {
            $playlist_id = mysqli_fetch_array($res)['playlist_id'];
            // check video have added yet 
            $query = "SELECT * FROM playlist_video WHERE playlist_id = '$playlist_id' and video_id = '$video_id'";
            $res = $this->db->query($query);
            if ($res && mysqli_num_rows($res) > 0) {
                echo json_encode(array('status' => false, 'message' => 'Your playlist has video!!!'));
                return;
            }

            // if no , add it to playlist
            $query = "INSERT INTO playlist_video(playlist_id, video_id) values('$playlist_id', '$video_id')";
            $res = $this->db->query($query);
            if ($res) {
                $this->addThumbnailToPlaylist($video_id, $playlist_id);
                echo json_encode(array('status' => true, 'message' => 'Add new playlist '.$name_playlist, 'data' => $name_playlist));
                return;
            }else {
                echo json_encode(array('status' => false, 'message' => 'Add new playlist fail!!!'));
                return;
            }
        }else {
            echo json_encode(array('status' => false, 'message' => 'Add video into playlist fail!!!'));
            return;
        }

    }

    public function addThumbnailToPlaylist($video_id, $playlist_id) {
        $query = "SELECT thumbnails from video where video_id = '$video_id'";
        $res = $this->db->query($query);
        if (!$res) {
            echo "Error: " . $this->db->error;
            exit();
        }
        $thumbnails = $res->fetch_assoc()["thumbnails"];
        if (!$thumbnails) {
            echo "Error: No thumbnails found for video ID $video_id";
            exit();
        }
        $query = "UPDATE playlist SET thumbnails_playlist = '$thumbnails' WHERE playlist_id = '$playlist_id'";
        $res = $this->db->query($query);
        if (!$res) {
            echo "Error: " . $this->db->error;
            exit();
        }
        return;
    }
    

    public function getNamePlayListUsers() {
        ob_end_clean();
        if(isset($_GET['id'])) {
            $user_id = $_GET['id'];
            $query = "SELECT playlist_name FROM playlist where user_id = $user_id";
            $res = $this->db->query($query);
            if( $res &&  mysqli_num_rows($res) > 0 ) {
                $data = mysqli_fetch_all($res);
                echo json_encode(array('status' => true, 'message' => 'Get playlist successfully!!', 'data' => json_encode($data)));
                return;
            }else {
                echo json_encode(array('status' => false, 'message' => 'Playlist is empty!!!'));
                return;
            }
        }
        echo json_encode(array('status' => false, 'message' => 'User is empty!!!'));
    }

    public function insertVideoToPlayList() {
        ob_end_clean();
        if(isset($_POST['user_id']) && isset($_POST['video_id']) && isset($_POST['name_playlist'])) {
            $name_playlist = $_POST['name_playlist'];
            $user_id = $_POST['user_id'];
            $video_id = $_POST['video_id'];
            $this->addVideoToPlayList($name_playlist, $video_id, $user_id);
            return;
        }
        echo json_encode(array('status' => false, 'message' => 'Playlist is empty!!!'));
    }
    public function removeVideoFromPlayList() {
        ob_end_clean();
        if(isset($_POST['user_id']) && isset($_POST['video_id']) && isset($_POST['name_playlist'])) {
            $name_playlist = $_POST['name_playlist'];
            $user_id = $_POST['user_id'];
            $video_id = $_POST['video_id'];
            $query = "SELECT * from playlist WHERE playlist_name= '$name_playlist' and user_id= '$user_id'";
            $res = $this->db->query($query);
            if( $res && mysqli_num_rows($res) > 0 ) {
                $playlist_id = mysqli_fetch_array($res)['playlist_id'];
                $query = "DELETE from playlist_video where video_id = '$video_id'";
                $res = $this->db->query($query);
                if( $res)  {
                    echo json_encode(array('status' => true, 'message' => 'Remove video from '.$name_playlist));
                    return;
                }else {
                    echo json_encode(array('status' => false, 'message' => 'Remove video from playlist fail!!!'));
                    return;
                }
            }else {
                echo json_encode(array('status' => false, 'message' => 'Add video into playlist fail!!!'));
                return;
            }
        }
        echo json_encode(array('status' => false, 'message' => 'Playlist is empty!!!'));
    }

    public function loadMoreVideoBySearch() {
        ob_end_clean();
        if(isset($_GET['data'])) {
            $nameSearch = $_GET['data']??'';
            $limitStart = $_GET['limit_start']??'';
            $query = "SELECT distinct video.*, user.user_id, user.username, user.profile_picture
            FROM video, user
            WHERE (title LIKE '%$nameSearch%' OR description LIKE '%$nameSearch%' or user.username like '%$nameSearch%') and video.user_id = user.user_id and video.deleted = 0
            limit $limitStart, 18 
            ";
            $res = $this->db->query($query);
            if($res && mysqli_num_rows($res) > 0 ) {
                echo json_encode(array('status'=>true, 'message'=>'Load more video success!!', 'data'=> json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC))));
                return;
            } else {
                echo json_encode(array('status' => false, 'message' => 'Not found video for '.$nameSearch));
                return [];
            }
        }
        return [];
        echo json_encode(array('status' => false, 'message' => 'Please enter search video'));
    }
    public function countVideoDeleted() {
        ob_end_clean();
        $query = "SELECT COUNT(DISTINCT video.video_id) as number_delete FROM video WHERE deleted = 1;";
        $res = $this->db->query($query);
        if($res && mysqli_num_rows($res) > 0 ) {
            echo json_encode(array('status'=>true, 'message'=>'Count number user blocked!!', 'data'=> json_encode(mysqli_fetch_all($res, MYSQLI_ASSOC))));
            return;
        } else {
            echo json_encode(array('status' => false, 'message' => 'Count number user blocked fail!!'));
            return [];
        }
    }
    public function removeSoftVideo() {
        ob_end_clean();
        if(isset($_POST['video_id']) ) {
            $video_id = $_POST['video_id'] ?? '';
            $query = "UPDATE video set deleted = 1 where video_id = $video_id ";
            $res = $this->db->query($query);
            if($res) {
                $this->countVideoDeleted($video_id);
                return;
            } else {
                echo json_encode(array('status' => false, 'message' => 'Delete video fail!!'));
                return [];
            }
        }
    }

    public function getVideoDeleted() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'GET' ) {
            $limit = $_GET['limit']??0;
            $query = "SELECT video.* from  video where video.mode_private =  0 and video.deleted = 1 limit $limit, 25 ";
            $res = $this->db->query($query); 
            if(!$res) {
                echo json_encode(array("status" => false, 'message' => "get the video deleted fail!!!"));
                return;
            }
            if(  mysqli_num_rows($res) == 0) {
                echo json_encode(array("status" => false, 'message' => "No videos have been deleted yet!!"));
                return [];
            }
            if(  mysqli_num_rows($res) > 0 ) {
                echo json_encode(array("status" => true, 'message' => "get the video deleted successfully!!!", 'data' => $res->fetch_all(MYSQLI_ASSOC)));
            }else {
                echo json_encode(array("status" => false, 'message' => "get the video deleted failed!!!"));
                return;
            }
            $this->db->close();
        }else {
            echo json_encode(array("status" =>false, 'message' => "Method not found!!!"));
        }
    }


    public function destroyVideo() {
        ob_end_clean();
        if(isset($_POST['video_id']) ) {
            $video_id = $_POST['video_id'] ?? '';
            $query = "DELETE from video where video_id = $video_id ";
            $res = $this->db->query($query);
            if($res) {
                $this->countVideoDeleted($video_id);
                return;
            } else {
                echo json_encode(array('status' => false, 'message' => 'Delete video fail!!'));
                return [];
            }
        }
    }

    public function restoreVideo() {
        ob_end_clean();
        if(isset($_POST['video_id']) ) {
            $video_id = $_POST['video_id'] ?? '';
            $query = "UPDATE video set deleted = 0 where video_id = $video_id ";
            $res = $this->db->query($query);
            if($res) {
                $this->countVideoDeleted($video_id);
                return;
            } else {
                echo json_encode(array('status' => false, 'message' => 'Restore video fail!!'));
                return [];
            }
        }
    }

    public function getVideoOnUser() {
        ob_end_clean();
        if(isset($_POST['id'])) {
            $user_id = $_POST['id']??'';
            $limit = $_POST['limit']??0;
            $query = "SELECT video.*, user.* FROM video, user where video.user_id = user.user_id  and video.deleted = 0  and video.user_id = $user_id order by upload_date desc limit $limit, 25; ";
            $res = $this->db->query($query); 
            if(!$res) return null;
            if(  mysqli_num_rows($res) == 0) {
                echo json_encode(array('status'=> false , 'message'=>'Video channel is not exist '));
                return ;
            }
            if(  mysqli_num_rows($res) > 0 ) {
                echo json_encode(array('status'=> true , 'message'=>'Get user on channel successfully ', 'data'=> json_encode($res->fetch_all(MYSQLI_ASSOC))));
                return;
            }
            $this->db->close();
            echo json_encode(array('status'=> false , 'message'=>'Server err!!'));
        }   
    }

    public function getPlayListOnUser() {
        ob_end_clean();
        if(isset($_POST['id'])) {
            $user_id = $_POST['id'];
            $limit = $_POST['limit'] ?? 0;
            
            // Use parameterized queries to prevent SQL injection attacks
            $query = "SELECT p.playlist_id, 
                             p.playlist_name, 
                             p.playlist_description, 
                             p.thumbnails_playlist, 
                             COUNT(pv.video_id) AS num_videos 
                      FROM Playlist p 
                      JOIN playlist_video pv ON p.playlist_id = pv.playlist_id 
                      WHERE p.user_id = ? 
                      GROUP BY p.playlist_id 
                      LIMIT ?, 7";
    
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $user_id, $limit);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if(!$res) {
                echo json_encode(array('status' => false , 'message' => 'Server Error'));
                return ;
            } 
            if(mysqli_num_rows($res) == 0) {
                echo json_encode(array('status' => false , 'message' => 'Playlist video channel does not exist '));
                return ;
            }
            if(mysqli_num_rows($res) > 0) {
                $playlist = array();
                while ($row = $res->fetch_assoc()) {
                    $playlist[] = $row;
                }
    
                // Use a separate query to get the first video_id for the user's playlist
                $query = "SELECT video_id 
                          FROM playlist_video 
                          WHERE playlist_id = (SELECT playlist_id FROM Playlist WHERE user_id = ? LIMIT 1) 
                          LIMIT 1";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
    
                if($result && mysqli_num_rows($result) > 0) {
                    $video_id = $result->fetch_assoc()['video_id'];
                    echo json_encode(array('status' => true , 'message' => 'Get playlist video on channel successfully ', 'video_id' => $video_id, 'data' => $playlist));
                    return;
                } else {
                    echo json_encode(array('status' => true , 'message' => 'Get playlist video on channel failed '));
                    return;
                }
            }
            $this->db->close();
            echo json_encode(array('status' => false , 'message' => 'Server error!!'));
        }   
    }
    
    public function getVideoOnPlayList() {
        ob_end_clean();
        if(isset($_GET['playlist_id']) ) {
            $playlist_id = $_GET['playlist_id']??'';
            $query = "SELECT video.*, playlist.* from video, playlist, playlist_video where playlist.playlist_id = '$playlist_id' and video.video_id = playlist_video.video_id and playlist_video.playlist_id = '$playlist_id'";
            $res = $this->db->query($query);
            if($res and mysqli_num_rows($res) > 0 ) {
                echo json_encode(array('status'=> true, 'message'=> 'Get playlist video successfully!!', 'data'=> json_encode($res->fetch_all( MYSQLI_ASSOC))));
                return;
            }else{
                echo json_encode(array('status'=> false, 'message'=> 'Get playlist video failed!!'));
            }
        }
    }
    public function getVideoUploadByUser(){
        ob_end_clean();
        if(isset($_GET['id']) and isset($_GET['limit']) ){
            $user_id = $_GET['id'];
            $limit = $_GET['limit'];
            $query = "SELECT v.*, 
            (SELECT COUNT(*) FROM likes WHERE video_id = v.video_id) AS num_likes,
            (SELECT COUNT(*) FROM Comment WHERE video_id = v.video_id) AS num_comments
        FROM Video v
        WHERE v.user_id = '$user_id' limit $limit , 17 ";
            $res = $this->db->query($query);
            if($res and mysqli_num_rows($res) > 0 ) {
                echo json_encode(array('status'=> true, 'message'=> 'Get video upload by user successfully!!', 'data'=> json_encode($res->fetch_all( MYSQLI_ASSOC))));
                return;
            }else{
                echo json_encode(array('status'=> false, 'message'=> 'Get video upload by user failed!!'));
            }
        }
    }
    public function getVideoById(){
        ob_end_clean();
        if(isset($_POST['video_id'])  ){
            $video_id = $_POST['video_id'];
            $query = "SELECT video.* from video WHERE video_id = $video_id";
            $res = $this->db->query($query);
            if($res and mysqli_num_rows($res) > 0 ) {
                echo json_encode(array('status'=> true, 'message'=> 'Get video  by id successfully!!', 'data'=> json_encode($res->fetch_assoc())));
                return;
            }else{
                echo json_encode(array('status'=> false, 'message'=> 'Get video  by id failed!!'));
            }
        }
    }

    public function saveEditVideo() {
        ob_end_clean();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $videoUrl = '';
            $thumbnailUrl = '';
            $modePrivate = $_POST['mode'] ?? 0;
            $video_id = $_POST['video_id'] ?? 0;
            if ($title && $description && $video_id) {
                if (isset($_FILES['file_video'])) {
                    $videoUrl = $this->saveVideoIntoFolder($_FILES['file_video']);
                } elseif (isset($_POST['video_url'])) {
                    $videoUrl = $this->getEmbeddedLink($_POST['video_url']);
                }
                if (isset($_FILES['file_thumbnail'])) {
                    $thumbnailUrl = $this->saveThumbnailIntoFolder($_FILES['file_thumbnail']);
                } elseif (isset($_POST['thumbnail_url'])) {
                    $thumbnailUrl = $_POST['thumbnail_url'];
                }
                $res = $this->updateVideoOnTable($title, $description, $videoUrl, $thumbnailUrl, $modePrivate, $video_id);
                if ($res) {
                    echo json_encode(array('status'=> true , 'message'=>'Save edit video successfully!!'));
                } else {
                    echo json_encode(array('status' => false, 'message' => 'Update video failed!!'));
                }
            } else {
                echo json_encode(array('status' => false, 'message' => 'Please enter full information!!'));
            }
        }
    }
    
    public function updateVideoOnTable($title, $description, $videoUrl, $thumbnailUrl, $modePrivate, $video_id) {
        $sql = "";
        if( $videoUrl == '' and $thumbnailUrl == '') {
            $sql = "UPDATE video SET title = '$title', description = '$description',  mode_private = '$modePrivate' WHERE  video_id= '$video_id'";
        }else if( $videoUrl == '' ) {
            $sql = "UPDATE video SET title = '$title', description = '$description', thumbnails = '$thumbnailUrl',  mode_private = '$modePrivate' WHERE  video_id= '$video_id'";
        }else if( $thumbnailUrl == '') {
            $sql = "UPDATE video SET title = '$title', description = '$description', thumbnails = '$thumbnailUrl',  mode_private = '$modePrivate' WHERE  video_id= '$video_id'";
        }else {
            $sql = "UPDATE video SET title = '$title', description = '$description', url = '$videoUrl', thumbnails = '$thumbnailUrl', mode_private = '$modePrivate' WHERE  video_id= '$video_id'";
        }
        if ($this->db->query($sql)) {
            return true;
        } else {
            return false;
        }
    }



}


?>