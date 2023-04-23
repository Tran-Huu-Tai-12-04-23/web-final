<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpLoad video</title>
    <?php
        include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/includes/common.php';
    ?>

    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'assets/style/me/style.css';?>" />
    <?php 
        $Middleware->checkLogin($isLogin);
        $User = new User();
        $data = $User->getUserDetail($userId);
        if( !$data ) {
            $data = '';
        }
    ?>
    <script>
        $(document).ready(function() {
            <?php if(isset($_GET['m']) and isset($_GET['t'])) {?>
                addNotification("<?php print $_GET['m']??''?>", "<?php print $_GET['t']??''?>");
            <?php }?>
        })
    </script>
    

</head>

<body>
    <div class='notification-list'>

    </div>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/loader.php';?>
    <div class="dark-theme p-0">
        <?php include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/includes/NavbarHome.php' ?>
        <?php include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/includes/header.php';?>


        <div class="main_profile mt-5 overflow-hidden">
            <div class="container-fluid " style='padding: 5rem'>
                <div class="row bg-header br-primary" style='height: 70vh'>
                    <div class="col-lg-3 col-xl-3 p-0 br-primary cl d-flex justify-content-center">
                        <?php include 'menuControl.php'?>
                    </div>
                    <div class="profile col-lg-9 col-xl-9 d-flex justify-content-center flex-wrap control-edit" >
                        <?php include 'profile.php'?>    
                    </div>
                    <div class="edit-profile hidden col-lg-9 col-xl-9 d-flex justify-content-center flex-wrap h-100 control-edit center"
                   
                    >
                        <?php include 'edit_profile.php'; ?>
                    </div>
                    <div class="change-pass hidden col-lg-9 col-xl-9 d-flex justify-content-center flex-wrap h-100 control-edit center"
                    >
                        <?php include 'change_pass.php'; ?>
                    </div>
                    <div class="setting hidden col-lg-9 col-xl-9 d-flex justify-content-center flex-wrap h-100 control-edit"
                    >
                        <?php include 'setting.php'; ?>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="modal-preview-avatar d-flex justify-content-center align-items-center " id='preview-avatar'>
            <img src='<?php print $Util->getAvatar($avatar) ?>' id='image-avatar'></img>
            <img src='<?php print $Util->getAvatar($avatar) ?>' id='image-zoom'></img>
        </div>
        <div class="modal-edit-avatar d-flex justify-content-center align-items-center  " id='modal-edit-avatar'>
            <div class=" d-flex 
            bg-header justify-content-between align-items-center p-5 br-primary" style='min-width:30rem'
                id='main-modal-edit-avatar'>
                <label for='avatar' class="bd-primary w-100px h-40px cl fs-18 center br-primary hover-bg ">
                    Upload
                </label>
                <div class="bd-primary  w-100px  h-40px cl fs-18 center br-primary hover-bg" id='button-select-url'>
                    Url
                </div>
            </div>
            <div class=" d-flex 
            hidden
            bg-header justify-content-between align-items-center  br-primary flex-wrap pb-4 p-4" style='min-width:30rem'
                id='main-modal-edit-avatar-url'>
                <div class="text-field w-100 mb-2 ">
                    <input autocomplete="off" class='cl fs-14' type="text" placeholder="Enter your full url"
                        rules="required" id='url-avatar-edit' />
                    <label for="full_name" class=' cl fs-18'>Url</label>
                    <div class="show__validation  error h-20px mt-2">
                    </div>
                </div>
                <div class="bd-primary w-100px h-40px cl fs-18 center br-primary hover-bg" id='button-up-url-avatar'>
                    Up
                </div>
            </div>
        </div>
        <form id='form-update-avatar' action=""   class='hidden'>
        </form>
        <form action="<?php echo BASE_URL.'?action=update_avatar&data='.$userId;?>" id='form-update-avatar' method="POST" enctype="multipart/form-data">
            <input class='hidden' name='avatar' id='avatar' type='file' accept='image/*' />
            <input  class = 'hidden'name='avatar_url' id='avatar-url' />
        </form>

    </div>
    
    <?php include
    $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/includes/NavbarHome.php'; ?>


    <script src="<?php echo BASE_URL.'assets/js/validate.js'?>">
    </script>
    <script src="<?php echo BASE_URL.'assets/js/editprofile.js'?>">
    </script>

    <script>
    $(document).ready(function() {
        let wrapperAvatar = document.getElementById('wrapper-avatar');
        let previewAvatar = document.getElementById('preview-avatar');
        let zoomPreview = document.getElementById('image-zoom');
        let imageAvatar = document.getElementById('image-avatar');
        let iconEditAvatar = document.getElementById('icon-edit-avatar');
        let modalEditAvatar = document.getElementById('modal-edit-avatar');
        let mainModalEditAvatar = document.getElementById('main-modal-edit-avatar');
        let avatarForm = document.getElementById('avatar');
        let avatarUser = document.getElementById('avatar-user');
        let mainModalEditAvatarUrl = document.getElementById('main-modal-edit-avatar-url');
        let buttonSelectUrl = document.getElementById('button-select-url');
        let buttonUpUrlAvatar = document.getElementById('button-up-url-avatar');
        let urlAvatarEdit = document.getElementById('url-avatar-edit');
        let avatarUrlForm = document.getElementById('avatar-url');
        let formUpdateAvatar = document.getElementById('form-update-avatar');
        let buttonSaveAvatar = document.getElementById('button-save-avatar');

        function changeImageAvatar(url, up) {
            if (up) {
                previewAvatar.onload = function() {
                    URL.revokeObjectURL(url);
                };
                zoomPreview.onload = function() {
                    URL.revokeObjectURL(url);
                };
                avatarUser.onload = function() {
                    URL.revokeObjectURL(url);
                };
                imageAvatar.onload = function() {
                    URL.revokeObjectURL(url);
                };
            }
            avatarUser.setAttribute("src", url);
            previewAvatar.setAttribute("src", url);
            zoomPreview.setAttribute("src", url);
            imageAvatar.setAttribute("src", url);
        };

        function closeModalEditImage(e) {
            mainModalEditAvatar.classList.remove('hidden');
            mainModalEditAvatarUrl.classList.add('hidden');
            modalEditAvatar.style.scale = 0;
        };

        function uploadAvatarUrl() {
            buttonSaveAvatar.classList.remove('hidden');
            changeImageAvatar(urlAvatarEdit.value);
            avatarUrlForm.value = urlAvatarEdit.value;
            closeModalEditImage();
        }
        wrapperAvatar.onclick = function(e) {
            e.stopPropagation();
            previewAvatar.style.scale = 1;
        };
        imageAvatar.onclick = function(e) {
            e.stopPropagation();
        };
        iconEditAvatar.onclick = function(e) {
            e.stopPropagation();
            modalEditAvatar.style.scale = 1;
        };
        previewAvatar.onclick = function() {
            previewAvatar.style.scale = 0;
        };
        modalEditAvatar.onclick = function(e) {
            closeModalEditImage();
        };
        mainModalEditAvatarUrl.onclick = function(e) {
            e.stopPropagation();
        };
        mainModalEditAvatar.onclick = function(e) {}

        avatarForm.onchange = function(e) {
            modalEditAvatar.style.scale = 0;
            buttonSaveAvatar.classList.remove('hidden');
            const file = this.files[0];
            if (file) {
                const objectUrl = URL.createObjectURL(file);
                changeImageAvatar(objectUrl, 1);
            }
        };
        buttonSelectUrl.onclick = function(e) {
            e.stopPropagation();
            mainModalEditAvatar.classList.add('hidden');
            mainModalEditAvatarUrl.classList.remove('hidden');
        };

        buttonUpUrlAvatar.onclick = function(e) {
            uploadAvatarUrl()
        };


        urlAvatarEdit.onkeypress = function(e) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                uploadAvatarUrl()
            }
        }
        buttonSaveAvatar.onclick = function(e) {
            formUpdateAvatar.submit();
        }

        imageAvatar.onmousemove = function(e) {
            const xItem = ((e.clientX - e.target.parentElement.getBoundingClientRect().left) /
                e.target.parentElement.offsetWidth) * 100 + "%";
            const yItem = ((e.clientY -
                    e.target.parentElement.getBoundingClientRect().top) / e.target.parentElement
                .offsetHeight) * 100 + "%";
            e.target.parentElement.querySelector("#image-zoom").style.setProperty("--x", xItem);
            e.target.parentElement.querySelector("#image-zoom").style.setProperty("--y", yItem);
            e.target.parentElement.querySelector("#image-zoom").style.opacity = 1;
        }
        imageAvatar.onmouseleave = function(e) {
            e.target.parentElement.querySelector("#image-zoom").style.opacity = 0;
        };


        $('.btn-edit-profile').click(function() {
            $('.control-edit').addClass('hidden');
            $('.edit-profile').removeClass('hidden');
            $('.sub-control').removeClass('active');
            $('.sub-control-edit-profile').addClass('active');
        })

        $('.btn-profile').click(function() {
            $('.control-edit').addClass('hidden');
            $('.profile').removeClass('hidden');
            $('.sub-control').removeClass('active');
            $('.sub-control-profile').addClass('active');
        })

        $('.btn-change-pass').click(function() {
            $('.control-edit').addClass('hidden');
            $('.change-pass').removeClass('hidden');
            $('.sub-control').removeClass('active');
            $('.sub-control-change-pass').addClass('active');

        })
        $('.btn-setting').click(function() {
            $('.control-edit').addClass('hidden');
            $('.setting').removeClass('hidden');
            $('.sub-control').removeClass('active');
            $('.sub-control-setting').addClass('active');

        })
        
        // change pass 
        $('.icon-lock').click(function() {
            let input = getParent('text-field', $(this));
            let lockIcon = getChildren('icon-unlock', input);
            lockIcon.removeClass('hidden');
            getChildren('input', input).attr('type', 'password');
            $(this).addClass('hidden');
        });
        $('.icon-unlock').click(function() {
            let input = getParent('text-field', $(this));
            let unlockIcon = getChildren('icon-lock', input);
            unlockIcon.removeClass('hidden');
            getChildren('input', input).attr('type', 'text');
            $(this).addClass('hidden');

        })
        $('.bt-verify-new-pass').click(function() {
            let err = false;
            let newPass = $('#new-password').val();
            let newConfirmPass = $('#confirm-new-password').val();
            if(newPass == ''  ) {
                addNotification("New password isn't empty!", 'err');
                err = true;
            }
            if(newConfirmPass == '' && err != true) {
                addNotification("Please confirm password!", 'err');
                err = true;
            }
            if(newPass != newConfirmPass && err != true) {
                addNotification("Password and confirm password must match!", 'err');
                err = true;
            }
            if(!err) {
                $('.wrapper-modal').removeClass('hidden');
            }
        })

        $('.icon-close').click(function() {
            $('.wrapper-modal').addClass('hidden');
        })
    });
    </script>


</body>

</html>