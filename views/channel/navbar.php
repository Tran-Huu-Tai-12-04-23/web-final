<div class=' br-primary p-4 d-flex justify-content-between align-items-center' >
                        <div class='start'>
                            <img id='avatar-user-channel' class='w-100px h-100px br-primary mr-2'  />
                            <div class="info-user p-2 ">
                                <h1 class='mt-2 mb-2 fs-18' id='channel-name'></h1>
                                <span class='fs-18 w-100 d-flex pb-4' id='follower-channel'></span>
                                <span class='fs-14 cl-second mt-4' id='descriptions-channel'></span>
                            </div>
                        </div>
                       <div class="end">
                           <?php if( $isCheckUserChannel ){ ?>
                            <div class="bt-primary bg-transparent mr-3 br-primary p-2 " onclick='redirectLink("user/channel/?active=edit")' style='width: 200px; z-index: 1000000000;'>
                                        <i class='bx bx-edit-alt fs-32 mr-3'></i>
                                        <span>Edit channel</span>
                                </div>
                                <div class="bt-primary  br-primary " onclick='redirectLink("user/channel?active=upload")' style='width: 200px; z-index: 1000000000;'>
                                    <i class='bx bx-upload fs-32 mr-3'></i>
                                    <span>Upload New Video</span>
                                </div>
                             <?php }else{?>
                                <div class="bt-primary mr-3 br-primary" id='btn-subscribe-channel' style=' z-index: 1000000000;'>
                                    Subscribe
                                </div>
                            <?php }?>
                       </div>
                    </div>
<div class="col-12">
    <div class="container-fluid">
        <div class="row align-item-start">
            <div onclick='switchNavbar("video")' class="button_primary video-item-navbar item-navbar  active-line bg-transparent pr-5 pl-5 hover_line " style='border-radius: 0'>
                Video                
            </div>
            <div onclick='switchNavbar("playlist")' class="button_primary playlist-item-navbar item-navbar bg-transparent pr-5 pl-5 hover_line " style='border-radius: 0'>
                Playlist                
            </div>

        </div>
    </div>
</div>