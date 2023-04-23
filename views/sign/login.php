<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/includes/common.php';
        $Language = new Language();
        $LG = $Language->getData();
        $Middleware->checkLogin(!$isLogin);
    ?>
    <link rel="stylesheet" href="<?php echo BASE_URL.'assets/style/sign/style.css';?>" type="text/css" />
    <script>
        $(document).ready(function() {
            <?php if(isset($_GET['m']) and isset($_GET['type'])) {?>
                addNotification("<?php print $_GET['m']??''?>", "<?php print $_GET['type']??''?>");
            <?php }?>
        })
    </script>
</head>

<body>
    <div class='notification-list'>

    </div>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/loader.php';?>
    <div class="main dark-theme overflow-hidden">
        <div class="container h-100">
            <div class="row h-100">
                <div
                    class=" p-2 header-sign w-100 cl-second fs-16 height-header d-flex justify-content-start align-item-center">
                    <img class='w-60px h-40px' src='<?php echo BASE_URL.'/assets/images/logo.png';?>' />
                    <ul class='d-flex justify-content-start align-items-center ml-4'>
                        <li class='mr-4 p-2 fw-bold hover_line m-w-100 center' onclick="redirectLink('home')">
                            <?php print $LG['home']?>
                        </li>
                        <li class='mr-4 p-2 fw-bold hover_line m-w-100 center'><?php print $LG['join']?></li>
                    </ul>
                </div>
                <div class="w-100 d-flex justify-content-center align-items-start">
                    <form action='?action=login' method='POST' id="form-login" class='form-login w-25 br-primary p-4'
                        style='min-width: 40rem; min-height: 30rem ; box-shadow: 0px 0px 4px 0px #1d90f5;'>
                        <h1 class='fs-24 cl mb-4'><?php print $LG['login']?></h1>
                        <div class='h-40px d-flex justify-content-start align-items-start mb-4'>
                            <h5 class='fs-14 cl-second  mr-2 '><?php print $LG['no-account']?>?</h5>
                            <div class='fs-14 hover_line cl-primary-custom ' onclick='redirectLink("register")'>Register
                            </div>
                        </div>
                        <div class='input-text label-up cl mt-4 mb-5 fs-16'>
                            <input type='text' name='username' placeholder=' ' rule='required-min:5' />
                            <label class='cl-second '>
                                <?php print $LG['username']?></label>
                        </div>

                        <div class='input-text label-up cl mt-5 mb-5 parent-hover fs-16'>
                            <input type='password' name='password' placeholder=' ' rule='required-min:6' />
                            <label class='cl-second '>
                                <?php print $LG['password']?></label>
                            <div class='action-pass hidden child-hover'>
                                <i class='bx bx-lock-alt lock hover-cl-success '></i>
                                <i class='bx hidden bx-lock-open-alt unlock hover-cl-success'></i>
                            </div>
                        </div>
                        <button class='bt-primary center fs-16 submit'><?php print $LG['login']?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo BASE_URL.'assets/js/validate.js'?>">
    </script>
    <script>
    $(document).ready(function() {
        validation("#form-login");
    });
    </script>
    <script>
    $(document).ready(function() {
        $('.lock').click(function() {
            let inputText = getParent('input-text', $(this));
            let unlock = getChildren('unlock', inputText);
            let input = inputText.children('input[type=password]');
            activeItem($(this));
            activeItem(unlock);
            input.prop('type',
                'text')
        })
        $('.unlock').click(function() {
            let inputText = getParent('input-text', $(this));
            let lock = getChildren('lock', inputText);
            let input = inputText.children('input[type=password]');
            activeItem($(this));
            activeItem(lock);
            input.prop('type',
                'password')
        })
    });
    </script>
</body>

</html>