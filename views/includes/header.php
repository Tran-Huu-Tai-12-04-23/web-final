<div class="wrapper-header cl  pl-5 pr-5" id='header-fixed'>
    <div class="container-fluid w-100 p-0 m-0">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-9 col-lg-7 col-md-6 col-6 d-flex justify-content-start align-items-center">
                 <i class='bx bx-menu fs-32 cl icon-open-nav icon-menu-header mr-5 ml-4' ></i>
                <?php
                    include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/search.php'
                ?>
            </div>
            <div class="col-xl-3 col-lg-5 col-md-6 col-6 d-flex justify-content-end align-items-center position-relative ">
                    
                <i class='bx bx-bell fs-32 cl icon-notification ml-5 mr-5'></i>
                <?php
                    if($isLogin) {
                ?>
                    <div class="h1 fs-16 ml-2 mr-2 mt-2"><?php print $_SESSION['username']??''?></div>
                    <div class="ml-2 pr-3  hover-active br-primary   position-relative" id="open-sub-menu">
                        <img class='rounded-circle w-50px h-50px'src="<?php print $Util->getAvatar($avatar) ?>" style=''/>
                        <i class='bx bx-chevron-down fs-24 position-absolute' style='bottom:-.5rem;right:-.5rem'  ></i>
                    </div>
                    <?php } else {?>
                    <div class=''>
                        <div class="bt-primary center h-40px" onclick='redirectLink("login")'>
                            <i class='bx bx-log-in fs-16 m4-2'></i>
                            <span class='fs-16'><?php print $LG['login']?></span>
                        </div>
                    </div>
                <?php }?>
                <?php
                    if($isLogin) {
                ?>
                <div class="sub-menu hidden animation-rtl" id="sub-menu">
                        <ul class=" ">
                            <?php if($_SESSION['is_admin']??""){?>
                                <li>
                                    <a href="<?php echo BASE_URL.'admin'?> "
                                        class="w-100 h-100 p-4 cl d-flex justify-content-center-start align-items-center">
                                        <i class="bx bxs-user-badge mr-3"></i>
                                        <span>Admin Page</span>
                                    </a>
                                </li>
                            <?php }?>
                            
                                <li>
                                    <a href="<?php echo BASE_URL.'user/channel/?active=upload'?>"
                                        class="w-100 h-100 cl p-4 d-flex justify-content-center-start align-items-center p-2">
                                        <i class="bx bx-upload mr-3"></i>
                                        <span>Upload video</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL.'me/channel/'?>"
                                        class="w-100 h-100 cl p-4 d-flex justify-content-center-start align-items-center">
                                        <i class="bx bx-video-recording mr-3"></i>
                                        <span>My Chanel</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL.'user/channel'?>"
                                        class="w-100 h-100 cl p-4 d-flex justify-content-center-start align-items-center">
                                        <i class="bx bx-terminal mr-3"></i>
                                        <span>Chanel Manager</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL.'me/profile/'?>"
                                        class="w-100 h-100 cl p-4  d-flex justify-content-start align-items-center">
                                        <i class="bx bx-id-card mr-3"></i>
                                        <span>Profile</span>
                                    </a>
                                </li>

                        
                            <div class="border-bottom mt-2 mb-4"></div>
                            <a href="?action=logout" class="mt-3 center bg-second bt-primary cl w-100 h-100">
                                <i class="bx bx-log-out mr-3"></i>
                                <span>Sign Out</span>
                            </a>
                        </ul >
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>