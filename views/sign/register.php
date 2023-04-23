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
</head>

<body>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/loader.php';?>
    <div class='notification-list'>

    </div>
    <div class="main dark-theme ">
        <div class="container h-100">
            <div class="row h-100">
                <div
                    class="mb-2 p-2 header-sign w-100 cl-second fs-16 height-header d-flex justify-content-start align-item-center">
                    <img class='w-60px h-40px' src='<?php echo BASE_URL.'/assets/images/logo.png';?>' />
                    <ul class='d-flex justify-content-start align-items-center ml-4'>
                        <li class='mr-4 p-2 fw-bold hover_line m-w-100 center' onclick="redirectLink('home')">
                            <?php print $LG['home']?>
                        </li>
                        <li class='mr-4 p-2 fw-bold hover_line m-w-100 center'><?php print $LG['join']?></li>
                    </ul>
                </div>
                <div class="wrapper-form w-100 h-100  zIndex d-flex justify-content-between align-items-center">
                    <div class="col-lg-6 col-xl-6">
                        <h5 class='fs-24 cl-second mb-4'><?php print $LG['start']?>?</h5>
                        <div class='d-flex justify-content-start align-items-end mb-4'>
                            <h1 class='fs-32 fw-bold mr-2 cl'><?php print $LG['create-new-account']?>
                            </h1>
                            <div class='fs-32 button-primary-custom-color br-primary'
                                style='height: 1rem ; width: 1rem'>
                            </div>
                        </div>
                        <div class="d-flex flex-justify-content-start align-items-center mb-4">
                            <h5 class='fs-16 cl-second mr-2'><?php print $LG['already-member']?>?</h5>
                            <h5 class='fs-16 cl-primary-custom hover_line' onclick='redirectLink("login")'>
                                <?php print $LG['login']?></h5>
                        </div>
                        <form action="?action=register" id='form-register' method='POST'
                            class='w-75 pb-4 pt-4 mt-4 cl br-primary  fs-16'>
                            <div class='input-text label-up cl mt-4 mb-5'>
                                <input type='text' name='username' placeholder=' ' rule='required-min:6' />
                                <label class='cl-second '>
                                    <?php print $LG['username']?></label>
                            </div>
                            <div class='input-text label-up cl mt-5 mb-5'>
                                <input type='email' name='email' placeholder=' ' rule='required-email' />
                                <label class='cl-second '>
                                    <?php print $LG['email']?></label>
                            </div>
                            <div class='input-text label-up cl mt-5 mb-5 parent-hover '>
                                <input type='password' name='password' placeholder=' ' class='required-pass'
                                    rule='required-min:6-pass' />
                                <label class='cl-second '>
                                    <?php print $LG['password']?></label>
                                <div class='action-pass hidden child-hover'>
                                    <i class='bx bx-lock-alt lock hover-cl-success '></i>
                                    <i class='bx hidden bx-lock-open-alt unlock hover-cl-success'></i>
                                </div>
                            </div>
                            <div class='input-text label-up cl mt-5 mb-5 parent-hover '>
                                <input type='password' name='confirm_password' placeholder=' ' rule='required-pass'
                                    class='required-pass' />
                                <label class='cl-second '>
                                    <?php print $LG['confirm-password']?></label>
                                <div class='action-pass hidden child-hover'>
                                    <i class='bx bx-lock-alt lock hover-cl-success '></i>
                                    <i class='bx hidden bx-lock-open-alt unlock hover-cl-success'></i>
                                </div>
                            </div>
                            <button class='bt-primary submit'><?php print $LG['create']?></button>
                        </form>
                    </div>
                    <div class="col-xl-5 col-lg-5" style="">
                        <div class='center rounded-circle image-register' src="" alt=" register" style='' />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo BASE_URL.'assets/js/validate.js'?>">
    </script>
    <script>
    $(document).ready(function() {
        validation("#form-register");
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
            let input = inputText.children('input[type=text]');
            activeItem($(this));
            activeItem(lock);
            input.prop('type',
                'password')
        })
    });
    </script>
</body>

</html>