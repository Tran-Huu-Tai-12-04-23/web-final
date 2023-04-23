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
        $User = new User();
        $userId = $_GET['id']??'';
        $data = $User->getUserDetail($userId);
        if( !$data ) {
            $data = '';
        }
    ?>
     <script src="<?php echo BASE_URL.'assets/js/admin/admin.js'?>"></script>
     <script src="<?php echo BASE_URL.'assets/js/admin/user.js'?>">
    </script>
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
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/toTop.php';?>
    
    <div class="dark-theme ">
        <div class="container-fluid p-0 m-0">
            <div class="row g-0 d-flex justify-content-between">
                   <div class="col-2">
                        <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/admin/sidebar.php';?>
                    </div>
                    <div class="col-10 p-5 overflow-scroll center" style='height:90vh'>
                    <form action="<?php echo BASE_URL.'?action=save-edit-user&data='.$userId;?>" method="POST"
                            enctype="multipart/form-data" id="form-submit-edit-user">
                            <div class="container ">
                                <div class="row justify-content-center">
                                    <div class="text-field w-100 mt-2 mb-5 ">
                                        <input autocomplete="off" class=' cl fs-14' type="text" name='username'
                                            placeholder="" rules="required|min:6"
                                            value='<?php print $data['username']?>' id='username-input'/>
                                        <label for="username" class='bg-primary-custom  cl fs-14'>Username</label>
                                        <div class="show__validation  error h-20px mt-2">
                                        </div>
                                    </div>
                                    <div class="text-field w-100 mt-2 mb-5 ">
                                        <input autocomplete="off" class=' cl fs-14' type="text" name='full_name'
                                            placeholder="Enter your full Name" rules="required|min:6"
                                            value='<?php print $data['full_name']?>' id='full-name-input'/>
                                        <label for="full_name" class='bg-primary-custom  cl fs-14'>Full Name</label>
                                        <div class="show__validation  error h-20px mt-2">
                                        </div>
                                    </div>
                                    <div class="text-field w-25 mt-2 mb-5 ">
                                        <input autocomplete="off" class='cl fs-14 h-50px' type="date"
                                            name='date_of_birth' rules="required"
                                            value="<?php print $data['date_of_birth']?>" id='day-of-birth-input'/>
                                        <label for="date_of_birth" class='bg-primary-custom  cl fs-14'>Day Off
                                            Birth</label>
                                        <div class="show__validation  error h-20px mt-2">
                                        </div>
                                    </div>
                                    <div class="text-field w-75 mt-2 mb-5 ">
                                        <input autocomplete="off" class='cl fs-14 h-50px' type="email" name='email'
                                            placeholder="Enter your email" rules="required|email"
                                            value="<?php print $data['email']?>" id='email-input'/>
                                        <label for="email" class='bg-primary-custom  cl fs-14'>Email address</label>
                                        <div id="emailHelp" class="form-text">We' ll never share your email with anyone
                                            else.</div>
                                        <div class="show__validation  error h-20px mt-2">
                                        </div>
                                    </div>
                                    <div class="text-field w-25 mt-2 mb-5 ">
                                        <input autocomplete="off" class='cl fs-14' type="text" name='phone_number'
                                            placeholder="Enter your phone number" rules="required|phone"
                                            value="<?php print $data['phone_number']?>" id='phone-number-input'/>
                                        <label for=" phone_number" class='bg-primary-custom  cl fs-14'>Phone
                                            Number</label>
                                        <div class="show__validation  error h-20px mt-2">
                                        </div>
                                    </div>
                                    <div class="text-field w-75 mt-2 mb-5 ">
                                        <input autocomplete="off" class='cl fs-14' type="text" name='address'
                                            placeholder="Enter your address" rules="require"
                                            value="<?php print $data['address']?>" id='address-input'/>
                                        <label for=" address" class='bg-primary-custom  cl fs-14'>Address
                                        </label>
                                        <div class="show__validation  error h-20px mt-2">
                                        </div>
                                    </div>
                                    <div class="w-100 mb-5 d-flex justify-content-start align-items-center">

                                        <div class="end fs-16 cl w-100" style='float: right'>
                                            <h1 class='mr-2 fs-18 '>Status : </h1>
                                            <?php if($data['blocked'] == 1) {?>
                                                <h1  class='fs-16 active'>Blocked</h1>
                                            <?php }?>
                                            <?php if($data['deleted'] == 1) {?>
                                                <h1 class='fs-16 active'>On Trash</h1>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <div class="w-25 center">
                                        <button type='submit' id='btn-save-edit-user'
                                            class="bt-primary mr-2 hover-border w-25 center">
                                            Save
                                        </button>
                                    </div> .
                                </div>
                            </div>
                        </form>
                   </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        $('.item-sidebar-admin').removeClass('active-navbar');
        let userNamePre = $('#username-input').val();
        let fullNamePre = $('#full-name-input').val();
        let dayOfBirthPre = $('#day-of-birth-input').val();
        let emailPre = $('#email-input').val();
        let addressPre = $('#address-input').val();

        $(document).ready(function(e) {
            $('#form-submit-edit-user').submit(function(e) {
                let userName = $('#username-input').val();
                let fullName = $('#full-name-input').val();
                let dayOfBirth = $('#day-of-birth-input').val();
                let email = $('#email-input').val();
                let address = $('#address-input').val();
                let check = false;
                if(userName === '') {
                    addNotification('Username can not be empty', 'err');
                    check = true;
                }else if(fullName === '') {
                    addNotification('Full name can not be empty', 'err');
                    check = true;
                }else if(dayOfBirth === '') {
                    addNotification('Day of birth can not be empty', 'err');
                    check = true;
                }else if(email === '') {
                    addNotification('Email can not be empty', 'err');
                    check = true;
                }else if( address === '') {
                    addNotification('Address can not be empty', 'err');
                    check = true;
                }
                if( check === true ) {
                    e.preventDefault();
                }
            })
        })
    </script>
</body>

</html>