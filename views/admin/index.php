<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faster Video</title>
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'assets/style/admin/style.css';?>" />
    <?php
        include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/common.php';
    ?>
    <?php
        $Language = new Language();
        $LG = $Language->getData();
        $middleWare = new MiddleWare();
        $middleWare->checkLogin($isLogin);
        $middleWare->checkIsAdmin($_SESSION['is_admin']??'');
    ?>
     <script src="<?php echo BASE_URL.'assets/js/admin/admin.js'?>">
    </script>
    <script src="<?php echo BASE_URL.'assets/js/admin/manager.js'?>">
    </script>
    <script>
        $(document).ready(function() {
            <?php 
            $active = 'home';
            if(isset($_GET['active']))
                $active = $_GET['active'] ?? '';
            ?>
            activeNavbar(<?php print $active?>);
        })
    </script>

</head>

<body>
    <div class='notification-list'>

    </div>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/loader.php';?>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/toTop.php';?>
    
    <div class="dark-theme ">
        <div class="container-fluid p-0 m-0">
            <div class="row g-0 d-flex justify-content-between">
                   <div class="col-2 d-xl-block d-xl-block d-md-none d-none" id='menu-hidden-mobile'>
                        <?php  include  'sidebar.php';?>
                    </div>
                    <div class="col-12 p-0 m-0 d-xl-none d-xl-none d-md-block d-block m-5" >
                        <?php  include  'sidebarResponsive.php';?>
                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-12 col-xs-12 col-12 p-5 overflow-scroll item-switch  dashboard" style='height:90vh'>
                       <?php  include  'dashboard.php';?>
                   </div>
                    <div class="col-xl-10 col-lg-10 col-md-12 col-xs-12 col-12  p-5 overflow-scroll item-switch  hidden manager-user" style='height:90vh'>
                       <?php  include  'users.php';?>
                   </div>
                   <div class="col-xl-10 col-lg-10 col-md-12 col-xs-12 col-12 p-5 overflow-scroll item-switch  hidden manager-video" style='height:90vh'>
                       <?php  include  'video.php';?>
                   </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function(){
            $('#menu-sidebar-admin-2').click(function(e){
                e.stopPropagation();
                $('#menu-responsive').removeClass('hidden')
            })
            $('#open-menu-side-res').click(function(e) {
                e.stopPropagation();
                $('#menu-hidden-mobile').addClass('show');
            })
            $(window).click(function() {
                $('#menu-hidden-mobile').removeClass('show');
            })
            $(document).on('change', '.user-select', function() {
                let values = $('input[name="user-select"]:checked')
                    .map(function () {
                    return $(this).prop('checked');
                    })
                    .get();
                if (values.includes(true)) {
                    $("#action-all-user").removeClass("hidden");
                } else {
                    $("#action-all-user").addClass("hidden");
                }
            });
        })
    </script>
</body>

</html>