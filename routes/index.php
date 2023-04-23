<?php  
    class Route{
        private $url;
        private $view;
        private $model;

        public function __construct($url, $view, $model) {
            $this->url = $url;
            $this->view = $view;
            $this->model = $model;
        }
        public function getUrl(){
            return  $this->url;
        }
        public function getView(){
            return $this->view;
        }
        public function getModel(){
            return $this->model;
        }
    }
    $routes = [
        // LOCALHOST/Mvc/LOGIN : GET URL =  LOGIN
        'login' => function() {
            return new Route('login', 'sign/login.php', '');
        },
        'register' => function() {
            return new Route('register', 'sign/register.php', '');
        },
        'me/edit-profile' => function() {
            return new Route('edit_profile', 'user/edit_profile/index.php', 'User');
        },
        'me/profile' => function() {
            return new Route('profile', 'user/profile/index.php', 'User');
        },
        'me/channel' => function() {
            return new Route('profile', 'channel/index.php', 'Video');
        },
        'me/create-new-channel' => function() {
            return new Route('profile', 'channel/createNew.php', 'Video');
        },
        'setting' => function() {
            return new Route('setting', 'setting/index.php', '');
        },
        'admin' => function() {
            return new Route('admin', 'admin/index.php', array('Video', 'User'));
        },
        'search' => function() {
            return new Route('search', 'search/index.php', 'video');
        },
        'watch' => function() {
            return new Route('watch', 'video/watch/index.php', array('Video', 'Comment', 'User'));
        },
        'video/comment' => function() {
            return new Route('video/comment', 'video/comment/showComment.php', 'Comment');
        },
        'history' => function() {
            return new Route('history', 'history/index.php', '');
        },
        'video-liked' => function() {
            return new Route('video-liked', 'videoLiked/index.php', '');
        },
        'admin/user/edit' => function() {
            return new Route('admin/user/edit', 'admin/user/edit.php', 'User');
        },
        'admin/user/blocked' => function() {
            return new Route('admin/user/blocked', 'admin/user/userBlocked.php', 'User');
        },
        'admin/user/trash' => function() {
            return new Route('admin/user/trash', 'admin/user/userTrash.php', 'User');
        },
        'admin/video/trash' => function() {
            return new Route('admin/video/trash', 'admin/video/trash.php', 'User');
        },
        'user/channel' => function() {
            return new Route('user/manager', 'user/manager/index.php', '');
        },
        'user/channel/edit' => function() {
            return new Route('user/manager/edit', 'user/manager/editChannel.php', '');
        },
        'not-found' => function() {
            return new Route('not-found', 'notfound/index.php', '');
        }
        ,'' => function() {
            return new Route('', 'home/index.php', 'Video');
        },
        
    ];
?>