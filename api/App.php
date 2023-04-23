<?php 
    require_once './controller/UserController.php';
    require_once './controller/VideoController.php';
    require_once './controller/Controller.php';
    require_once './controller/CommentController.php';
    require_once './controller/ChannelController.php';
    class App{
        protected $view = 'home/index.php';
        protected $action = 'index';
        protected $model = '';
        protected $params = [];
        protected $Controller ='';

        public function __construct()
        {   
            $this->Controller = new Controller();
        }

        public function setController($controller){
            $this->controller = $controller;
        }
        public function setView($view){
            $this->view = $view;
        }

        public function setModel($modelName){
            $this->model = $modelName;
        }

        public function run() {
            $this->Controller->model($this->model);
            $this->Controller->view($this->view, []);
        }
        
        public function action($action, $data = null, $prevUrl = null) {
            $controlUser = new UserController();
            $controlVideo = new VideoController();
            $controlComment = new CommentController();
            $controlChannel = new ChannelController();
            switch($action) {
                case 'login':{
                    $controlUser->login($prevUrl);  
                    break;             
                }
                case 'register':{
                    $res = $controlUser->register($prevUrl);  
                    break;             
                }
                case 'logout': {
                    $res = $controlUser->logout($prevUrl);  
                    break;             
                }
                case 'update-profile': {
                    $res = $controlUser->updateProfile($data);  
                    break;             
                }
                case 'save-edit-user': {
                    $res = $controlUser->saveEditUser($data);  
                    break;             
                }
                case 'upload': {
                    $res = $controlVideo->uploadVideo($data);  
                    break;             
                }case 'update_avatar': {
                    $res = $controlUser->updateAvatar($data);  
                    break;  
                }case 'comment': {
                    $res = $controlComment->comment();  
                    break;  
                }
                case 'delete-comment': {
                    $res = $controlComment->removeComment();  
                    break;  
                }
                case 'reply-comment': {
                    $res = $controlComment->replyComment();  
                    break;  
                }
                case 'get-reply-comment': {
                    $res = $controlComment->getReplyComment($data);  
                    break;  
                }
                case 'get-comment': {
                    $res = $controlComment->getComment($data);  
                    break;  
                }
                case 'save-edit-comment': {
                    $res = $controlComment->saveEditComment();  
                    break;  
                }
                case 'save-edit-reply-comment': {
                    $res = $controlComment->saveEditReplyComment();  
                    break;  
                }
                case 'get-video': {
                    $res = $controlVideo->getAllVideoPublic();  
                    break;  
                }
                case 'search': {
                    $res = $controlVideo->getSearchVideo($data);
                    break;   
                }
                case 'remove-reply-comment': {
                    $res = $controlComment->removeReplyComment(); 
                    break;  
                }
                case 'get-trending-video':{
                    $res = $controlVideo->get20VideoHaveTheMostViews();  
                    break; 
                }
                case 'get-top-video-discovery':{
                    $res = $controlVideo->getTopVideoDiscovery();  
                    break; 
                }
                case 'get-video-slider':{
                    $res = $controlVideo->getAllVideoForSlide();  
                    break; 
                }
                case 'follow-user':{
                    $res = $controlUser->followUser();  
                    break; 
                }
                case 'like-video': {
                    $res = $controlUser->likeVideo();
                    break;
                }
                case 'change-pass-user': {
                    $res = $controlUser->changePass();
                    break;
                }
                case 'get-video-user-liked' : {
                    $res = $controlVideo->getVideoLiked();
                    break;
                }
                case 'get-video-watched' : {
                    $res = $controlVideo->getVideoWatched();
                    break;
                }
                case 'cerate-add-into-playlist' : {
                    $res = $controlVideo->createAddToPlaylist();
                    break;
                }
                case 'get-playlists' : {
                    $res = $controlVideo->getNamePlayListUsers();
                    break;
                }
                case 'add-video-to-playlists' : {
                    $res = $controlVideo->insertVideoToPlayList();
                    break;
                }
                case 'remove-video-from-playlists' : {
                    $res = $controlVideo->removeVideoFromPlayList();
                    break;
                }
                case 'search-video' : {
                    $res = $controlVideo->searchVideo();
                    break;
                }
                case 'load-more-video-by-search':{
                    $res = $controlVideo->loadMoreVideoBySearch();
                    break;
                }
                case 'get-users':{
                    $res = $controlUser->getUsers();
                    break;
                }
                case 'count-user-blocked':{
                    $res = $controlUser->countUserBlocked();
                    break;
                }
                case 'count-user-deleted':{
                    $res = $controlUser->countUserDeleted();
                    break;
                }
                case 'block-user':{
                    $res = $controlUser->blockUser();
                    break;
                }
                case 'remove-soft-user':{
                    $res = $controlUser->removeSoftUser();
                    break;
                }
                case 'remove-soft-video':{
                    $res = $controlVideo->removeSoftVideo();
                    break;
                }
                case 'count-video-deleted':{
                    $res = $controlVideo->countVideoDeleted();
                    break;
                }
                case 'get-user-blocked': {
                    $res = $controlUser->getUsersBlock();
                    break;
                }
                case 'restore-user': {
                    $res = $controlUser->restoreUser();
                    break;
                }
                case 'unlock-user': {
                    $res = $controlUser->unlockUser();
                    break;
                }
                case 'get-user-deleted': {
                    $res = $controlUser->getUserDeleted();
                    break;
                }
                case 'destroy-user': {
                    $res = $controlUser->destroyUser();
                    break;
                }
                case 'get-video-deleted': {
                    $res = $controlVideo->getVideoDeleted();
                    break;
                }
                case 'destroy-video': {
                    $res = $controlVideo->destroyVideo();
                    break;
                }
                case 'restore-video': {
                    $res = $controlVideo->restoreVideo();
                    break;
                }
                case 'create-new-channel': {
                    $res = $controlChannel->createNewChannel();
                    break;
                }
                case 'get-information-channel': {
                    $res = $controlChannel->getInformationOfChannel();
                    break;
                }
                case 'get-video-on-user': {
                    $res = $controlVideo->getVideoOnUser();
                    break;
                }
                case 'get-playlist-on-user': {
                    $res = $controlVideo->getPlayListOnUser();
                    break;
                }
                case 'get-video-on-playlist': {
                    $res = $controlVideo->getVideoOnPlayList();
                    break;
                }
                case 'get-video-upload-by-user': {
                    $res = $controlVideo->getVideoUploadByUser();
                    break;
                }
                case 'get-video-by-id': {
                    $res = $controlVideo->getVideoById();
                    break;
                }
                case 'save-video-edit': {
                    $res = $controlVideo->saveEditVideo();
                    break;
                }
                case 'update-edit-channel': {
                    $res = $controlChannel->updateChannel();
                    break;
                }
                case 'get-comment-channel': {
                    $res = $controlComment->getCommentOnChannel();
                    break;
                }
                case 'get-detail-comment': {
                    $res = $controlComment->getDetailComment();
                    break;
                }
                // default : {
                //     $res = $this->Controller->addNotAvailable();
                //     break;
                // };
            }
        }
    }
        

?>