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
    ?>
     <script src="<?php echo BASE_URL.'assets/js/admin/admin.js'?>">
    </script>
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
                        <?php    include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/admin/sidebar.php';?>
                    </div>
                    <div class="col-10 p-4">
                    <div class="w-100 start justify-content-between">
                    <h1 class='cl fs-32 '>Manager Users Deleted</h1>
                    <div class="w75 end">
                        <div class="bt-primary br-primary bg-second center " id='btn-select-users-trash'>
                            <i class='bx bx-check fs-24 cl mr-2' ></i>	
                            <span>
                            Select Users
                            </span>	
                        </div>
                        <div class="bt-primary br-primary bg-second center hidden " id='btn-cancel-select'>
                            <i class='bx bx-x fs-24 cl mr-2' ></i>	
                            <span>
                            Cancel Select
                            </span>	
                        </div>
                        <div class=" end hidden ml-4" id='action-all-user'>
                            <div class='bt-primary cl mr-4 hover_close bg-second br-primary fs-14  bt-destroy-all-user ' onclick='handleDestroyUserSelected()' style='color: #000'><i class='bx bx-block mr-2 fs-24 ' ></i>Destroy Items Selected</div>
                            <div class='bt-primary cl mr-4 hover_close bg-second br-primary fs-14  bt-restore-all-user '  onclick='handleRestoreUserSelected()' style='color: #000'><i class='bx bx-trash-alt fs-24 mr-2' ></i>Restore Items Selected</div>
                        </div>
                    </div>
                    </div>

                    <div class="w-100 mt-5 ">
                    <div class="header_fixed br-primary bg-second fs-16">
                        <table >
                            <thead >
                                    <tr>
                                        <th class=''>
                                        <div class="checkbox-wrapper-12 mr-2 select-show hidden parent-suggest"  style='float:left;  vertical-align: middle !important; width: unset!important; height: unset'>
                                            <div class="cbx" style='width: 1rem; height: .5rem'>
                                                        <input class="cbx-12 " value='' id='select-all-users-destroy' name='user-all-select' type="checkbox">
                                                        <label for="cbx-12"></label>
                                                        <svg width="15" height="14" viewBox="0 0 15 14" fill="none">
                                                        <path d="M2 8.36364L6.23077 12L13 2"></path>
                                                        </svg>
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
                                                        <defs>
                                                        <filter id="goo-12">
                                                            <feGaussianBlur in="SourceGraphic" stdDeviation="4" result="blur"></feGaussianBlur>
                                                            <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" result="goo-12"></feColorMatrix>
                                                            <feBlend in="SourceGraphic" in2="goo-12"></feBlend>
                                                        </filter>
                                                        </defs>
                                                    </svg>
                                                    <div class="child-suggest fs-12" style='top: -.8rem'>
                                                    Select all users
                                                    </div>
                                                    </div>
                                            S No.
                                        </th>
                                        <th>Avatar</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id='table-manager-users-trash' style='margin-top: 2rem'>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="wrapper-modal-admin-destroy-user position-fixed hidden" style='top:0; left: 0; bottom: 0;right: 0;
                    background-color: rgba(0,0,0,.3); z-index: 1000000000'>
                        <div class="modal-block-user position-absolute br-primary p-4 box-shadow" style='color: #000;background-color: #252c48;backdrop-filter: 2rem; top: 2rem; left: 50%; transform:translateX(-50%); min-width: 40rem; z-index: 1000000000'>
                            <h1 class='fs-18 cl'>
                                Please , Confirmation form!!
                            </h1>
                            <div class="mt-4" style='border-top: 1px solid #ccc'>
                            </div>
                            <h5 class='fs-16 cl mt-4'>
                                Are you sure destroy this user  <span id='name-user-block'></span>
                            </h5>
                            <div class=" mt-4 mb-4" style='border-top: 1px solid #ccc'>
                            </div>
                            <div class="w-100 end mt-4">
                                <div class="bt-primary  bg-transparent br-primary hover_close fs-16 h-30px " id='btn-destroy' onclick='acceptDestroy()'>Destroy</div>
                                <div class="bt-primary ml-3 br-primary bg-second  fs-16 h-30px btn-cancel">Cancel</div>
                            </div>
                                </div>
                            </div>

                        </div>
                 </div>
                                    
            </div>
        </div>
    </div>
    <script>
        $('.item-sidebar-admin').removeClass('active-navbar');
        $(document).ready(function() {
            activeNavbar(<?php print $_GET['active']??''?>)
            loadUserDelete(0);

            $('#btn-destroy').click(function() {
                cancelAction();
                let useId = $(this).attr('us-id');
                destroyUser(useId);
            })

            $('#btn-select-users-trash').click(function() {
                $('.select-show').removeClass('hidden');
            })

            $('#select-all-users-destroy').change(function() {
                if ($(this).prop("checked") == true) {
                    $(".user-select").prop("checked", true);
                    $("#action-all-user").removeClass("hidden");
                } else {
                    $(".user-select").prop("checked", false);
                    $("#action-all-user").addClass("hidden");
                }
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