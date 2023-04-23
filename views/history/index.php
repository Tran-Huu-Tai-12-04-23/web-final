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
    <?php
        $Language = new Language();
        $LG = $Language->getData();
        $middleWare = new MiddleWare();
        $middleWare->checkLogin($isLogin);
    ?>
    <script src="<?php echo BASE_URL.'assets/js/history.js'?>">
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
                <?php
                        include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/header.php'
                    ?>
                   <div class=" pl-5 wrapper-most-watched ">
                    <h1 class='fs-32 p-2  cl high-light ml-5' >History</h1>
                    <div class="container-fluid p-5">
                        <div id='wrapper-history' class="g-0 row ">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        activeNavbar('history');
        <?php if($userId !== '') {?>
            loadsVideoWatched(<?php print $userId;?>, 0)
        <?php  }?>
    </script>
</body>

</html>