<div class='wrapper_navbar translateLeft' >
    <div class="position-fixed wrapper-navbar-fixed d-flex justify-content-start flex-column p-4" style='height: 100vh;width:18.5%'>
        <div class="d-flex justify-content-between mb-3 align-items-start">
            <img src="<?php print BASE_URL.'assets/images/logo.png' ?>" class="h-60px  mr-4 open"
            onclick="redirectLink('')" style='cursor: pointer; ' 
            />
        </div>
        <i class='bx bx-horizontal-left hidden fs-32 cl hover_close icon-close-nav'></i>
        <h1 class='mt-4 mb-2 fs-14 cl-second left open' >MENU</h1>
        <div onclick="redirectLink('')" class="mt-2 item-navbar d-flex justify-content-start align-items-center active-navbar">
            <i class='bx bx-home-alt fs-32 cl  p-2' ></i>
            <div class="fs-14 cl ml-4 mt-2 open" >Home</div>
        </div>
        <div class='mt-4 mb-3 line w-100 border-bottom '></div>
        <?php if($isLogin){?>
            <h1 class='fs-14 mt-4 mb-4 cl-second left open' >CATEGORY</h1>
            <div class="mt-2 item-navbar mb-2 d-flex justify-content-start align-items-center item-navbar-history" onclick="redirectLink('history')">
                <div class='p-1 d-flex justify-content-center align-items-center ' >
                    <i class='bx bx-history fs-32  ml-1 cl'></i>
                </div>
                <div class="fs-14 cl ml-4 mt-2 open" >History</div>
            </div>
            <div class="mt-2 item-navbar mb-2 d-flex justify-content-start align-items-center item-navbar-liked" onclick="redirectLink('video-liked')">
                <i class='bx bx-heart fs-32 cl p-2' ></i>
                <div class="fs-14 cl ml-4 mt-2 open">Liked</div>
            </div>
            <div onclick="redirectLink('me/channel/?id=<?php print $userId?>&active=playlist')" class="mt-2 item-navbar navbar-playlist d-flex justify-content-start align-items-center">
                <i class='bx bxs-playlist fs-32 cl  p-2' ></i>
                <div class="fs-14 cl ml-4 mt-2 open">Playlist</div>
            </div>
            <div class='mt-4 mb-3 line w-100 border-bottom '></div>
            <div class="mt-4 mb-2 d-flex justify-content-start align-items-center" onclick="redirectLink('logout')">
                <i class='bx bx-log-out fs-32 cl p-2' ></i>
                <div class="fs-14 cl ml-4 mt-2 open">Log Out</div>
            </div>
        <?php }else {?>
            <div class="h-100 d-flex justify-content-end align-item-center flex-column">
            <div onclick="redirectLink('login')" class="bt-primary center mt-5 bg-transparent bold" style='margin-top: auto'>
                Log In
            </div>
            </div>
        <?php }?>
        
    </div>
</div>