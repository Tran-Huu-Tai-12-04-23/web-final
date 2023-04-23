<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faster Video</title>
    <?php
        include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/common.php';
    ?>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'assets/style/home/style.css';?>" />

    <?php
        $video = new Video();
        $videos = $video->getAllVideoPublic();
        $Language = new Language();
        $LG = $Language->getData();
    ?>
    <script src="<?php echo BASE_URL.'assets/js/home.js'?>">
    </script>
</head>

<body>
    <div class='notification-list'>

    </div>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/loader.php';?>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/toTop.php';?>
    
    <div class="dark-theme ">
        <div class="container-fluid p-0 m-0">
            <div class="row  d-flex justify-content-between">
            
                <?php include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/includes/NavbarHome.php' ?>
                <div class="col-12">
                    <?php
                        include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/header.php'
                    ?>
                    <div class='m-5 center' >
                        <button class="box">
                            <span class="button-tag">How Are you today?</span>
                        </button>
                    </div>
                    <?php include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/home/discovery.php' ?>
                    <?php  include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/home/mostWatched.php'?>
                    <?php  include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/home/listVideos.php'?>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            activeNavbar("home");
            getMainVideo(0);
            loadingVideoTrending();
            getVideoDiscovery();
        })
    </script>
</body>

</html>