<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Video</title>
    <?php
        include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/common.php';
        $Middleware->checkLogin($isLogin);
        $isCheckUserChannel = true;
        if(isset($_POST['id'])) {
            $isCheckUserChannel = $userId === $_POST['id']??'';
            // $res = $Middleware->checkIsChannel($userId);
            if( $_POST['id'] === $userId ) {
            }
        }else {
            $res = $Middleware->checkIsChannel($userId);
        }
        
    ?>
    <script src="<?php echo BASE_URL.'assets/js/channel/index.js'?>">
    </script>
    <style>
        .header-fixed-channel {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #1b2a47;
            z-index: 10;
            border-bottom: 1px solid #0a76ff;
            animation: showHeaderFixChannel 0.4s ease !important;
        }
        .header-not-fixed-channel {
            animation: showHeaderFixToBottomChannel 0.4s ease;
        }
        @keyframes showHeaderFixChannel{
            from {
                top: 10rem;
            }
            to {
                top: 0rem;
            }
        }
        @keyframes showHeaderFixToBottomChannel {
            from {
                transform: translateY(10rem);
            }
            to {
                transform: translateY(0);
            }
        }

    </style>
    <script>
        $(document).ready(function() {
            <?php if(isset($_GET['active'])){ ?>
                switchNavbar('<?php print $_GET['active']?>');
                if( '<?php print $_GET['active']?>' ===  'playlist') {
                    $('.navbar-playlist').addClass('active-navbar');
                }
            <?php }?>
        })
    </script>
</head>

<body>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/loader.php';?>
    <div class="dark-theme">
        <?php include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/includes/NavbarHome.php' ?>
        <?php
            include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/header.php'
        ?>
        <div class=" wrapper-my-video d-flex justify-content-center cl p-4">
            <div class="container-fluid p-4">
                <div class="row flex-wrap p-4">
                    <div id='thumbnail-my-video'class="w-100 thumbnail-my-video p-5 background-img mb-4 position-relative" style='height: 30rem'>
                    </div>
                   <div class="w-100 header-not-fixed-channel"  id='header-fixed-channel' style=''>
                        <?php include 'navbar.php'?>
                   </div>
                    <?php include 'mainVideo.php'?>
                    <?php include 'playList.php'?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo BASE_URL.'assets/js/validate.js'?>">
    </script>
    
    <script> 
 
    $(document).ready(function() {
        <?php 
            if(isset($_GET['active'])) {
            ?>
            activeNavbar('<?php print$_GET['active']?>');
        <?php }else {?>
            activeNavbar('');
        <?php }?>

        var isLoadPlaylist = false;
        if(isLoadPlaylist == false ) {
            getPlaylistOnUser(0, <?php if(isset($_POST['id']) ) { print $_POST['id'] ; } else { print $userId ;}?>);
            isLoadPlaylist == true;
        }
        let loadVideoPlayList = false;
        $('#header-fixed').removeAttr('id');
        $(window).scroll(function() {
            handleNavBarWhenScrollChannel();
        })
        loadChannelInformation(<?php 
        if(isset($_POST['id'])) {
            print $_POST['id'];
        }else{
            print $userId;
        }
        ?>);
        getVideoOnUserChannel(0, <?php 
        if(isset($_POST['id'])) {
            print $_POST['id'];
        }else{
            print $userId;
        }
        ?>);
    });
    
    </script> 
</body>

</html>