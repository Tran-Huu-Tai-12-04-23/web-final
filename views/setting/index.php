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
    ?>
    <script src="<?php echo BASE_URL.'assets/js/home.js'?>">
    </script>
</head>

<body>
    <?php include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/includes/NavbarHome.php' ?>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/loader.php';?>
    <div class="dark-theme overflow-hidden ">
        <?php
        include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/header.php'
        ?>
        <!-- end navbar -->
        <div class="bg-transparent w-100 position-relative  pb-5 p-primary" style='min-height:100vh'>
            <div class="container-fluid h-100 ml-5">
                <div class="row cl p-5">
                    <div class="col-12 fs-32 mt-5 p-5 bg-header br-primary w-25">
                        <ul>
                            <li class='d-flex justify-content-start align-items-center  pr-2 pb-3 pt-3 br-priamry'>
                                <i class='bx bx-toggle-left mr-4'></i>
                                <span class='fs-16'><?php print $LG['language']?></span>
                                <i class='bx bx-chevron-down' style='float:right'></i>
                            </li>
                            <li class='d-flex justify-content-start align-items-center  pr-2 pb-3 pt-3  br-priamry'>
                                <i class='bx bx-moon mr-4' ></i>
                                <span class='fs-16'><?php print $LG['theme']?></span>
                                <i class='bx bx-chevron-down' ></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    <!-- end main content -->

    </div>

    <script>
    
    </script>
</body>

</html>