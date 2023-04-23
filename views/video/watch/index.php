<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch</title>
    <meta property="og:url" content="https://example.com/page.html" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Trang web của tôi" />
    <meta property="og:description" content="Mô tả trang web của tôi" />
    <meta property="og:image" content="https://example.com/image.jpg" />

    <?php
        include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/common.php';
    ?>
    <?php
        $video = new Video();
        $user = new User();
        $data = isset($_GET['data']) ? $_GET['data'] : '';
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $videoWatch = $video->getVideo($data);
        $Comment = new Comment();
        $comment = $Comment->getAllComment($data);
        $Language = new Language();
        $LG = $Language->getData();
        $Util = new Utils();
        if( $data  && $action === '' && $isLogin ) {
            $video->increaseViews($userId, $data);
        }
        else if($data  && $action === ''){
            $video->increaseViews(0, $data);
        }
        $checkUserLike = 0;
        if( $isLogin ) {
            $checkUserLike =  $user->checkUserLikeVideo($videoWatch["video_id"], $userId);
        }
        
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'assets/style/watch/style.css';?>" />
    <script src="<?php echo BASE_URL.'assets/js/watch.js'?>">
        
    </script>

</head>

<body>
    <div class='notification-list'>

    </div>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/loader.php';?>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/toTop.php';?>

    <div class="dark-theme main">
        <?php include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/includes/NavbarHome.php' ?>
        <?php
        include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/header.php'
        ?>
        
        <div class="wrapper-watch cl fs-18 ">
            <div class="container-fluid">
                <div class="row  align-item-start justify-content-between pt-5 pr-5 pl-5">
                    <div class="col-xl-9 col-lg-9 pb-2 p-l-2 pr-2 " style='border-radius: 3rem'>

                        <iframe src="<?php echo $videoWatch['url']?>?modestbranding=1&rel=0&iv_load_policy=3"
                            height="600" title="hello" width='auto' frameborder="0" class='w-100  '
                            style='border-radius: 3rem;border:2px solid #000' allowfullscreen allow="autoplay;encrypted-media"
                            onload="this.contentWindow.postMessage('play', '*')" 
                            ></iframe>
                        <div class="w-100 mt-4 fs-16 d-flex justify-content-between align-items-center">
                            <span class='fs cl-second fs-14 title'><?php print $videoWatch['title']?></span>
                            <div class='d-flex justify-content-end align-items-center mr-2'>
                                <div class='center pr-4 ' onclick='<?php if($isLogin){?>handleUserLikeVideo( <?php print $userId?>, <?php print $data?>)<?php }else{?>addNotification("Login to like video", "warn")<?php }?>'>
                                    <?php 
                                        if($checkUserLike == 1){
                                    ?>   
                                        <i class='bx bxs-heart mr-2 icon-like active-like'></i>
                                    <?php }else {?>
                                        <i class='bx bxs-heart mr-2 icon-like' ></i>
                                    <?php }?>
                                
                                    <span class='number-like'><?php print $videoWatch['like_count']?> likes</span>
                                </div>
                                <div class='center'>
                                    <i class='bx bx-show mr-2'></i>
                                    <span><?php print $videoWatch['view_count'] + 1 ?> views</span>
                                </div>
                                <button class="button-share ml-2 d-flex justify-content-around align-items-center">
                                    <div class="icon w-100px">
                                        <svg class="shere mr-2" viewBox="0 0 1024 1024" style='color: #039be5' version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                                        <path d="M767.99994 585.142857q75.995429 0 129.462857 53.394286t53.394286 129.462857-53.394286 129.462857-129.462857 53.394286-129.462857-53.394286-53.394286-129.462857q0-6.875429 1.170286-19.456l-205.677714-102.838857q-52.589714 49.152-124.562286 49.152-75.995429 0-129.462857-53.394286t-53.394286-129.462857 53.394286-129.462857 129.462857-53.394286q71.972571 0 124.562286 49.152l205.677714-102.838857q-1.170286-12.580571-1.170286-19.456 0-75.995429 53.394286-129.462857t129.462857-53.394286 129.462857 53.394286 53.394286 129.462857-53.394286 129.462857-129.462857 53.394286q-71.972571 0-124.562286-49.152l-205.677714 102.838857q1.170286 12.580571 1.170286 19.456t-1.170286 19.456l205.677714 102.838857q52.589714-49.152 124.562286-49.152z" fill="#f2295b"></path>
                                        </svg>
                                        <svg onclick='shareOnFacebook()'class="bi bi-facebook icon-shere ml-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#3b5998" d="M21.7 0H2.3C1.04 0 0 1.04 0 2.3V21.7C0 22.96 1.04 24 2.3 24H12.92V14.71H9.89V11.14H12.92V8.54C12.92 5.66 14.63 4.14 17.15 4.14C18.46 4.14 19.58 4.26 19.58 4.26V7.25L17.91 7.26C16.25 7.26 15.82 8.28 15.82 9.37V11.14H19.4L18.95 14.71H15.82V24H21.7C22.96 24 24 22.96 24 21.7V2.3C24 1.04 22.96 0 21.7 0z"/></svg>
                                        <svg onclick='shareOnInstagram()'viewBox="0 0 16 16" class="bi bi-instagram icon-shere" fill="currentColor" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
                                        </svg>
                                    </div>
                                    <p>Share</p>
                                </button>
                                <i class='bx bx-dots-vertical-rounded fs-32 cl ml-2 mr-2 bubble hover-cl-success show-action-relative position-relative' >
                                    <div class='p-4 position-absolute br-primary z-index center main-content-modal hidden d-flex justify-content-start align-items-center flex-column ' style='width: 20rem; background: #000;top: -100%;right:1rem'>
                                        <i class='bx bx-x fs-32 cl position-absolute hover_close icon-close-modal' style='top: .2rem;right:.2rem' ></i>
                                        <div class='bt-primary br-primary h-30 bg-transparent hover-bg mt-3 '
                                        id='add-playlist' style='max-width: 15rem ' onclick='<?php if($isLogin){?>handleOpenModalAddPlayList( <?php print $userId?>, <?php print $data?>)<?php }else{?>addNotification("Login to add video to your playlist", "warn")<?php }?>'>
                                            <h1 class='fs-16 mr-2'>
                                            Add Playlist
                                            </h1>
                                            <i class='bx bx-list-plus fs-32'></i>
                                        </div>   
                                        <div class='bt-primary br-primary h-30 bg-transparent hover-bg mt-3' style='max-width: 15rem ' >
                                            <h1 class='fs-16 mr-2'>
                                                Report
                                            </h1>
                                            <i class='bx bx-flag-alt fs-32'></i>
                                        </div>      
                                    </div>
                                </i>
                            </div>
                        </div>
                        <div class="w-100 fs-18 mt-5"><?php print $Util->formatTime($videoWatch['upload_date'])?></div>
                        <div class="w-100 mt-5 d-flex justify-content-between ">
                            <div class='d-flex align-items-center justify-content-start ' >
                                <div id='watch-channel-user-video'class="h-40px w-40px p-2 br-primary hover_close"  style='background:linear-gradient(288deg, rgba(34,72,195,1) 0%, rgba(45,213,253,1) 100%);
                            '
                            >
                                    <img class='w-100 h-100 br-primary'
                                        src='<?php print $videoWatch['profile_picture']?>'>
                                    </img>
                                </div>
                                <div class="h-40 d-flex justify-content-center align-items-start ml-2 flex-column ">
                                    <span class='fs-16 cl mb-2' style=''><?php print $videoWatch['username']?></span>
                                    <span class='fs-16 cl-second follow-number'><?php  print $videoWatch['follow_count']?> <?php print $LG['followed']?></span>
                                </div>
                                
                            </div>
                            <?php 
                                if($isLogin) {
                                    $checkFollow =  $user->checkFollowUser($videoWatch["user_id"], $userId);
                                }else {
                                    $checkFollow = 0;
                                }
                            ?>
                                <div
                                    class="bt-primary d-flex <?php echo $checkFollow  ? 'hidden' : '' ?> align-items-center justify-content-center bg-button-primary fs-16 btn-un-follow-user" onclick='handleUnFollowUser()'
                                    style='background:#2f3246'
                                    >
                                    <?php print $LG['Cancel Subscribe']?>
                                </div>
                                <div
                                    class="bt-primary <?php echo !$checkFollow  ? 'hidden' : '' ?> d-flex align-items-center justify-content-center bg-button-primary fs-16 btn-follow-user" onclick="followUser(<?php print $videoWatch['user_id']?>, <?php print $userId?>);">
                                    <?php print $LG['follow']?>
                                </div>
                            
                        </div>
                        <div class="w-100 br-primary mt-5 bg-primary-main p-4 " style='min-height:100px'>
                            <div id='description' class='overflow-hidden ' style='max-height:2.6rem;line-height:24px'>
                                <h1>
                                    <?php print $videoWatch['description']?>
                                </h1>
                            </div>
                            <div class='bg-transparent p-4 h-40px w-60px br-primary fs-18 cl mt-4 hidden'
                                id='button-more-description' style='font-weight:bold; cursor:pointer'>
                                More
                            </div>
                        </div>
                        <?php include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/video/comment/index.php' ?>
                    </div>
                    <div class="col-xl-3 col-lg-3 ">
                                    <?php
                        include 'playlist.php'
                        ?>
                        <div class="container-fluid hidden-scroll" style=''>
                            <div class="row justify-content-end g-4 " id='slider-videos'>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper-modal hidden" style='max-height: 40rem: overflow: hidden'>
            <div class=" p-4 modal-save-into-play-list br-primary position-relative flex-wrap" style='width:20rem;background-color:#000'>
                <i class='bx bx-x fs-32 cl  hover_close icon-close-modal position-absolute' style='top: .2rem;right:.2rem' ></i>
                <h1 class='fs-16 cl mt-4'>Save into...</h1>
                <div class="w-100 center flex-wrap border-bottom pt-5" id='your-playlist' us-id='<?php print $userId?>' vi-id='<?php print $videoWatch['video_id']?>'>
                </div>
                <div id='create-new-playlist' class='bt-primary br-primary h-40px bg-transparent hover-bg mt-3 w-100' >
                    <h1 class='fs-16 mr-2 cl'>
                        Create New
                    </h1>
                    <i class='bx bx-list-plus fs-32'></i>
                </div> 
                <div class="text-field w-100 mt-5 mb-2 hidden" id='input-name-play-list'>
                    <input autocomplete="off" class=' cl fs-14' type="text" name='full_name'
                        placeholder="Enter your name play list" rules="required|min:6"
                        value='' />
                    <label for="name-play-list" class=' cl fs-14'>Name play list</label>
                    <div class="show__validation  error h-20px mt-2">
                    </div>
                </div>
                <div class='d-flex justify-content-between align-items-center action-add-cancel-playlist hidden'>
                    <button class='reset br-primary  hover_close hover_bg cl fs-14 m-3 bg-transparent btn-' id='cancel-add-play-list'>Cancel</button>
                    <button class='reset bg-primary-menu-custom br-primary p-3 cl fs-14 m-3' id='save-into-play-list' us-id='<?php print $userId?>' vi-id='<?php print $videoWatch['video_id']?>'>Create&Add</button>
                </div>
            </div>

        </div>
        <form id="form-to-channel-user" type='submit' class='hidden' action="<?php print BASE_URL.'me/channel/'?>" method="post">
            <input value='<?php print $videoWatch['user_id']?>' name='id'/>
        </form>
        <script>
            <?php if(isset($_GET['playlist_id']) ) { ?>
                loadVideoPlayList(<?php print $_GET['playlist_id']?>);
            <?php }else {?>
                $('.wrapper-playlist-video').addClass('hidden');
                <?php }?>
        function handleUnFollowUser() {
            <?php if(!$isLogin) {?>
                addNotification("Login to subcribe chanel", "warn");
            <?php }else{?>
                let modalAcceptUser = $(`
                <div class='position-fixed' id='modal-accept-unfollow' style=' z-index: 1000000000;top:0;left: 0;right: 0; top:0;bottom:0;background:rgba(0,0,0,.5)'>
                    <div class='bg-second br-primary center position-absolute' style='top: 10rem; left: 50%; transform: translateX(-50%);width: 30rem;'>
                        <div class=' cl p-4 br-primary flex-wrap' style=''>
                            <h1 class='cl fs-24 pb-4 ' style='color: #fff'>Cancel Subscribe <?php print $videoWatch['username']?></h1>
                            <div class='w-100 end'>
                            <div class='bt-primary br-primary bg-transparent mr-3'>Cancel</div>
                            <div class='bt-primary br-primary ' id='btn-accept-unfollow'>Accept</div>
                            </div>
                        </div>
                    </div>
                </div>
                `)
                $('body').append(modalAcceptUser);

            <?php }?>
        }

        function handleClosePlayList() {
            $('.wrapper-playlist-video').css('height', '4rem');
            $('.icon-hidden-play-list').addClass('hidden');
            $('.icon-show-play-list').removeClass('hidden');
        }
        function handleShowPlaylist() {
            $('.wrapper-playlist-video').css('height', '60rem');
            $('.icon-hidden-play-list').removeClass('hidden');
            $('.icon-show-play-list').addClass('hidden');
        }
        $(document).ready(function() {
            // /
            $('#watch-channel-user-video').click(function(){
                $('#form-to-channel-user').submit();
            })  
            $('#form-to-channel-user').submit( function(e) {
                e.stopPropagation();
            });
            $(document).on('click','#modal-accept-unfollow', function(e) {
                $(this).remove();
            })
            $(document).on('click','#btn-accept-unfollow', function(e) {
                followUser(<?php print $videoWatch['user_id']?>, <?php print $userId?>);
            })
            // load slider video
            loadSliderVideo();
            function loadSliderVideo() {
                $.ajax({
                    type: "get",
                    url: getBaseURL()+"?action=get-video-slider&id=<?php print $videoWatch['video_id']?>",
                    dataType: "json",
                    success: function (response) {
                    if (response.status) {
                        loadVideo(response.data);
                    } else {
                        alert("Get slide video failed!!!");
                    }
                    },
                });
                function loadVideo(data) {
                    data.map((item, index) => {
                    let newItem = $(`
                    <div class="col-xl-11 col-lg-11 br-primary " onclick='redirectLink("watch?data=${
                        item.video_id
                    }")'>
                        <div class="h-100 item-slider-watch br-primary overflow-hidden " style=''>
                            <img class='' src='${item.thumbnails}'/>
                            <div class="item-most-watched-content">
                                <h1 class='fs-16 cl mt-2 title-card'>${item.title}></h1>
                                <div class='mt-2'>
                                    <span class='fs-12-2 cl'>${item.username}</span>
                                    <h5 class='fs-12 pt-2 cl-second'>${formatTime(item.upload_date)}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    `);
                    $("#slider-videos").append(newItem);
                    // $('#wrapper-playlist').append(newItem);
                    });
                }
            }


            let numberComment = 0;
            $(document).on('submit', 'form', function(e) {
                if ($(this).attr('type') !== 'submit') {
                    e.preventDefault();
                }
            })
            const checkComment = (userId, userIDComment) => {
                return +userId === +userIDComment ? 'child-hover' : 'hidden'
            }
            $(document).on('click', ".button-reply",
                function() {
                    let commentWrap = getParent('parent-reply-comment', $(this));
                    let fillTextReply = getChildren('text-field', commentWrap);
                    if (fillTextReply.hasClass('hidden')) {
                        fillTextReply.removeClass('hidden');
                    } else {
                        fillTextReply.addClass('hidden');
                    }
                    getChildren('action-reply-comment', commentWrap).addClass(
                        'hidden');
                });

            $(document).on('focus', '.reply-comment-form', function() {
                let commentWrap = getParent('parent-reply-comment', $(this));
                getChildren('action-reply-comment', commentWrap).removeClass(
                    'hidden');
            });

            $(document).on('click', '.btn-cancel-reply-comment', function() {
                let commentWrap = getParent('parent-reply-comment', $(this));
                getChildren(
                    'action-reply-comment', commentWrap).addClass(
                    'hidden');
                getChildren('reply-comment-form', commentWrap).val('');
                getChildren('text-field', commentWrap);
                let fillTextReply = getChildren('text-field', commentWrap);
                if (fillTextReply.hasClass('hidden')) {
                    fillTextReply.removeClass('hidden');
                } else {
                    fillTextReply.addClass('hidden');
                }
            })

            $('#comment').focus(function() {
                $('#action-comment').removeClass('hidden');
            })
            $('#btn-cancel-comment').click(function() {
                getParent('action-comment', $(this)).addClass('hidden');
            })
            const addComment = (data) => {
                if ($("#comment").val() == "") return;
                $.ajax({
                    type: "POST",
                    data: data,
                    url: getBaseURL()+"?action=comment",
                    dataType: "json",
                    success: function(response) {
                        let comment = $(
                            `
                        <div class='w-100 item-comment parent-hover position-relative br-primary p-4'>
                            <div class="w-100 d-flex justify-content-start align-items-center">
                                <img class='w-40px h-40px br-primary'
                                    src='${response[0].profile_picture}' />
                                <span class="fs-14 pl-4  fw-bold br-primary comment-text">${response[0].comment_text}</span>
                                <form id='edit-comment' class='edit-comment-form hidden w-100 ml-2'>
                                    <input name='user_id' value='<?php echo $userId;?>' class='hidden' />
                                    <input name='video_id' value='<?php echo $videoWatch['video_id'];?>' class='hidden' />
                                    <div class="text-field w-100 mt-5 mb-5 cl center">
                                        <input autocomplete="off" class='input-comment cl fs-14' type="text" name='comment'
                                            value='${response[0].comment_text}' rules="required"
                                            style='border: none;border-bottom:1px solid #1d90f5' id='comment' />
                                        <div class='center'>
                                            <div data-id='${response[0].comment_id}'class='cancel-edit-comment bt-primary bg-transparent br-primary mt-2 w-100px center h-30px hover_close' ><?php print $LG['cancel']?></div>
                                            <div data-id='${response[0].comment_id}'class='save-edit-comment bt-primary w-100px br-primary center h-30px'><?php print $LG['save']?></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class='mt-2 '>
                                <span class='fs-14 cl'>${response[0].username}</span>
                                <span class='fs-12 cl-second'>${formatTime(response[0].comment_date)}</span>
                                <i data-id='${response[0].comment_id}'
                                user-id='${response[0].user_id}'  class='bx bx-message ml-4 fs-24 pt-2 hover-cl-success reply-comment'></i>
                            </div>
                            <i class='p-4 bx bx-dots-vertical-rounded menu-edit-comment ${checkComment(response[0].user_id, <?php print $userId?>)} fs-32 position-absolute  hover_primary'>
                            </i>
                            <div class='menu-edit hidden p-4 bg-primary-main br-primary'>
                                <div class='bt-primary w-100px br-primary center h-30px edit-comment'><?php print $LG['edit']?></div>
                                <div class='p-2'></div>
                                <div data-id='${response[0].comment_id}'class='delete-comment bt-primary bg-transparent br-primary mt-2 w-100px center h-30px hover_close' ><?php print $LG['remove']?></div>
                            </div>
                            <div class='hidden wrapper-reply-${response[0].comment_id} wrapper-reply-comment mt-2 pl-5 h-unset br-primary w-100'>
                            </div>
                        </div>
                        `
                        )
                        $('.render-comment').prepend(comment);
                        ++numberComment;
                        $('.number-comment').text(numberComment + ' comments');
                    }
                });
            };
            const handleComment = () => {
                let data = $('#upload-comment').serialize();
                addComment(data);
                $('#comment').val('');
            }
            $('#comment').keypress(function(event) {
                if (event.keyCode === 13) {
                    handleComment()
                }
            });

            $('#btn-comment').click(function() {
                handleComment()
            })

            $(document).on('click', '.more-comment', function(e) {
                $(this).remove();
                renderComment(restComment, 10);
            })

            function loadComment() {
                $.ajax({
                    type: "GET",
                    data: {
                        data: <?php print $videoWatch['video_id']?>
                    },
                    url: getBaseURL()+"?action=get-comment",
                    dataType: "json",
                    success: function(response) {
                        renderComment(response, 10);
                        $('.number-comment').text(response.length + ' comments');
                        numberComment = response.length;
                    }
                });
            }
            loadComment();
            const deleteComment = (id) => {
                $.ajax({
                    type: "POST",
                    data: {
                        comment_id: id
                    },
                    url: getBaseURL()+"?action=delete-comment",
                    dataType: "json",
                    success: function(response) {

                    }
                })
            }
            $(document).on('click', '.delete-comment', function(e) {
                let idComment = $(this).attr('data-id');
                getParent('item-comment', $(this)).remove();
                deleteComment(idComment);
                renderComment(restComment, 10);
                $('.more-comment').remove();
                --numberComment;
                $('.number-comment').text(numberComment + ' comments');
            })

            $(document).on('click', '.menu-edit-comment', function(e) {
                let itemComment = getParent('item-comment', $(this));
                activeItem(getChildren('menu-edit', itemComment))
            });
            $(document).on('click', '.menu-edit-reply-comment', function(e) {
                let itemComment = getParent('sub-reply-comment-item', $(this));
                activeItem(getChildren('menu-edit', itemComment))
            });
            $(document).on('mouseleave', '.menu-edit', function(e) {
                $(this).addClass('hidden');
            });

            $(document).on('click', '.edit-comment', function(e) {
                let itemComment = getParent('item-comment', $(this));
                let menuEdit = getParent('menu-edit', $(this));
                let commentText = getChildren('comment-text', itemComment);
                let editCommentForm = getChildren('edit-comment-form', itemComment);
                let menuEditComment = getChildren('menu-edit-comment', itemComment);
                activeItem(commentText);
                activeItem(editCommentForm);
                activeItem(menuEditComment);
                menuEditComment.removeClass('child-hover');
                menuEdit.addClass('hidden');
            });
            const activeModeEditComment = (itemComment) => {
                let editCommentForm = getChildren('edit-comment-form', itemComment);
                let menuEditComment = getChildren('menu-edit-comment', itemComment);
                activeItem(editCommentForm);
                activeItem(menuEditComment);
                if (menuEditComment.hasClass('child-hover')) {
                    menuEditComment.removeClass('child-hover');
                } else {
                    menuEditComment.addClass('child-hover');
                }
            }
            $(document).on('click', '.cancel-edit-comment', function(e) {
                let itemComment = getParent('item-comment', $(this));
                let inputComment = getChildren('input-comment', itemComment);
                let commentText = getChildren('comment-text', itemComment);
                activeModeEditComment(itemComment);
                activeItem(commentText);
                inputComment.val(commentText.text());
            });
            const editComment = (comment, idComment) => {
                $.ajax({
                    type: "POST",
                    data: {
                        comment_id: idComment,
                        comment_text: comment
                    },
                    url: getBaseURL()+"?action=save-edit-comment",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                    }
                })
            }
            $(document).on('click', '.save-edit-comment', function(e) {
                let itemComment = getParent('item-comment', $(this));
                let inputComment = getChildren('input-comment', itemComment);
                let commentText = getChildren('comment-text', itemComment);
                let idComment = $(this).attr('data-id');
                activeModeEditComment(itemComment);
                activeItem(commentText);
                editComment(inputComment.val(), idComment)
                commentText.text(inputComment.val())
            })

            $(document).on('keypress', '.input-comment', function() {
                if (event.keyCode === 13) {
                    let itemComment = getParent('item-comment', $(this));
                    let commentText = getChildren('comment-text', itemComment);
                    let idComment = itemComment.attr('data-id');
                    editComment($(this).val(), idComment)
                    activeModeEditComment(itemComment);
                    activeItem(commentText);
                    editComment($(this).val(), idComment)
                    commentText.text($(this).val())
                }
            });
            let restReplyComment = [];
            const renderReplyComment = (response) => {
                response.map((res, index) => {
                    let newReplyComment = '';
                    if (index < 4) {
                        newReplyComment = $(
                            `<div class='position-relative sub-reply-comment-item mt-5' style='animation-delay:${index*0.1}s'>
                            <div class="w-100 d-flex justify-content-start align-items-center">
                            <img class='w-40px h-40px br-primary'
                                src='${res.profile_picture}' />
                                <span class="fs-14 pl-4  fw-bold br-primary reply-comment-text">${res.reply_comment_text}</span>
                                <form id='edit-reply-comment' class='edit-reply-comment-form hidden w-100 ml-2'>
                                    <div class="text-field w-100 mt-5 mb-5 cl center">
                                        <input autocomplete="off" class='input-edit-reply-comment cl fs-14' type="text" name='reply_comment_text'
                                            value='${res.reply_comment_text}' rules="required"
                                            style='border: none;border-bottom:1px solid #1d90f5' id='comment' />
                                            <input type='hidden' value='${res.reply_comment_id}' name='reply_comment_id'/>
                                        <div class='center'>
                                            <div class='cancel-edit-reply-comment bt-primary bg-transparent br-primary mt-2 w-100px center h-30px hover_close' ><?php print $LG['cancel']?></div>
                                            <div class='save-edit-reply-comment bt-primary w-100px br-primary center h-30px'><?php print $LG['save']?></div>
                                        </div>
                                    </div>
                                </form>
                             </div>
                            <div class='mt-2'>
                                <span class='fs-14 cl'>${res.username}</span>
                                <span class='fs-12 cl-second'>${formatTime(res.comment_date)}</span>
                            </div>
                            
                            <div class='menu-edit hidden p-4 bg-primary-main br-primary'>
                                <div class='bt-primary w-100px br-primary center h-30px edit-reply-comment'><?php print $LG['edit']?></div>
                                <div class='p-2'></div>
                                <div data-id='${res.reply_comment_id}'class='delete-reply-comment bt-primary bg-transparent br-primary mt-2 w-100px center h-30px hover_close' ><?php print $LG['remove']?></div>
                            </div>
                        <div>`
                        );
                        let newMenuEdit = $(`
                            <i class='bx bx-dots-vertical-rounded hidden menu-edit-reply-comment ${checkComment(res.user_id, <?php print $userId?>)} fs-32 position-absolute hover_primary'>
                            </i>
                        `);
                        newReplyComment.hover(function() {
                            if (getChildren('edit-reply-comment-form', $(this)).hasClass(
                                    'hidden')) {
                                newMenuEdit.insertBefore($(this).children('.menu-edit'));
                            }
                        }, function() {
                            newMenuEdit.remove();
                        });
                        $(`.wrapper-reply-${res.comment_id}`).prepend(newReplyComment);
                    } else {
                        restReplyComment.push(res);
                    }
                    if (index === 4) {
                        newReplyComment = $(
                            '<div id="more" class="more-reply-comment pb-5 pt-5 center fs-16"><button class=" bt-primary bg-transparent ">More</button></div>'
                        );
                        newReplyComment.click(function() {
                            $(this).remove();
                            renderReplyComment(response.filter((cmt, index) => index > 4));
                        })
                        $(`.wrapper-reply-${res.comment_id}`).append(newReplyComment);
                    }
                })
            }
            loadReplyComment = (idComment) => {
                $.ajax({
                    type: "GET",
                    data: {
                        data: idComment
                    },
                    url: getBaseURL()+"?action=get-reply-comment",
                    dataType: "json",
                    success: function(response) {
                        let checkHasButtonWatch = false;
                        response.map(cmt => {
                            if (response.length > 0 &&
                                $(`.wrapper-reply-${cmt.comment_id}`).children(
                                    '.button-watch-reply').length === 0) {
                                let buttonWatchReply = $(
                                    '<button class="mt-4 bt-second button-watch-reply"><?php print $LG['watch-reply-comment']?></button>'
                                )
                                buttonWatchReply.click(function() {
                                    activeItem($(
                                        `.wrapper-reply-${cmt.comment_id}`
                                    ));
                                    if ($(this).text() ===
                                        '<?php print $LG['watch-reply-comment']?>'
                                    ) {
                                        $(this).text(
                                            '<?php print $LG['close-reply-comment']?>'
                                        );
                                    } else {
                                        $(this).text(
                                            '<?php print $LG['watch-reply-comment']?>'
                                        );
                                    }
                                });
                                let wrapperReplyComment = $(
                                    `.wrapper-reply-${cmt.comment_id}`);
                                if (!checkHasButtonWatch) {
                                    buttonWatchReply.insertBefore(wrapperReplyComment);
                                    checkHasButtonWatch = true;
                                }
                                return;
                            }
                        });
                        renderReplyComment(response);
                    }
                });
            }
            let restComment = [];
            const renderComment = (comments, number) => {
                let cmt = [];
                comments.map((comment, index) => {
                    let item;
                    if (index == number) {
                        item =
                            '<div id="more" class="more-comment pb-5 pt-5 center fs-16"><button class=" bt-primary bg-button-primary ">More</button></div>';
                    }
                    if (index < number) {
                        loadReplyComment(comment.comment_id);
                        item = `
                        <div class='w-100 item-comment parent-hover position-relative br-primary p-4'>
                            <div class="w-100 d-flex justify-content-start align-items-center">
                                <img class='w-40px h-40px br-primary'
                                    src='${comment.profile_picture}' />
                                <span class="fs-14 pl-4  fw-bold br-primary comment-text">${comment.comment_text}</span>
                                <form id='edit-comment' class='edit-comment-form hidden w-100 ml-2'>
                                    <div class="text-field w-100 mt-5 mb-5 cl center">
                                        <input autocomplete="off" class='input-comment cl fs-14' type="text" name='comment'
                                            value='${comment.comment_text}' rules="required"
                                            style='border: none;border-bottom:1px solid #1d90f5' id='comment' />
                                        <div class='center'>
                                            <div data-id='${comment.comment_id}'class='cancel-edit-comment bt-primary bg-transparent br-primary mt-2 w-100px center h-30px hover_close' ><?php print $LG['cancel']?></div>
                                            <div  data-id='${comment.comment_id}' class='save-edit-comment bt-primary w-100px br-primary center h-30px'><?php print $LG['save']?></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class='mt-2 '>
                                <span class='fs-14 cl'>${comment.username}</span>
                                <span class='fs-12 cl-second'>${formatTime(comment.comment_date)}</span>
                                <i data-id='${comment.comment_id}'
                                user-id='${comment.user_id}' class='bx bx-message reply-comment ml-4 fs-24 pt-2 hover-cl-success'></i>
                            </div>
                            <i class='p-4 bx bx-dots-vertical-rounded menu-edit-comment ${checkComment(comment.user_id, <?php print $userId?>)} fs-32 position-absolute  hover_primary'>
                            </i>
                            <div class='menu-edit hidden p-4 bg-primary-main br-primary'>
                            <div class='bt-primary w-100px br-primary center h-30px edit-comment'><?php print $LG['edit']?></div>
                            <div class='p-2'></div>
                            <div data-id='${comment.comment_id}'class='delete-comment bt-primary bg-transparent br-primary mt-2 w-100px center h-30px hover_close' ><?php print $LG['remove']?></div>
                            </div>
                            <div class='hidden wrapper-reply-${comment.comment_id} wrapper-reply-comment mt-2 pl-5 br-primary w-100 h-unset'>
                            </div>
                        </div>
                        `
                    } else {
                        cmt.push(comment);
                    }
                    $('.render-comment').append(item);
                })
                restComment = [...cmt];
            }
            $(document).on('click', '.reply-comment', function() {
                let commentId = $(this).attr('data-id');
                let userId = $(this).attr('user-id');
                let newInputReplComment = $(
                    `
                    <div class="text-field reply-comment-item">
                        <form id='form-reply-comment' class='w-100 mt-5 pt-5 mb-5 cl center '>
                            <input autocomplete="off" class='input-reply-comment cl fs-14' type="text" name='comment_text'
                                value='' rules="required" style='border: none;border-bottom:1px solid #1d90f5' />
                                <input type='hidden' name='user_id' value='${userId}'/>
                                <input type='hidden' name='comment_id' value='${commentId}'/>
                                <div class='center'>
                                    <div class='cancel-reply-comment bt-primary bg-transparent br-primary mt-2 w-100px center h-30px hover_close' ><?php print $LG['cancel']?></div>
                                <div comment-id='${commentId}' user-id='${userId}' class='save-reply-comment bt-primary w-100px br-primary center h-30px'><?php print $LG['save']?></div>
                        </form>
                    </div>
                    </div>
                    `
                )
                let itemComment = getParent('item-comment', $(this));
                let wrapperReplyComment = getChildren('wrapper-reply-comment', itemComment);
                let checkOldHasEdit = itemComment.find('.reply-comment-item').length;
                $(
                    '.reply-comment-item').remove();
                if (checkOldHasEdit === 0) {
                    if (itemComment.children('.button-watch-reply').length !== 0) {
                        newInputReplComment.insertBefore(itemComment.children(
                            '.button-watch-reply'));
                    } else {
                        newInputReplComment.insertBefore(wrapperReplyComment);
                    }

                } else {
                    $('.reply-comment-item').remove();
                }
            })

            $(document).on('click', '.cancel-reply-comment', function() {
                let itemComment = getParent('item-comment', $(this));
                let inputComment = getChildren('input-comment', itemComment);
                let replyCommentItem = getChildren('reply-comment-item', itemComment);
                replyCommentItem.remove();
            });
            const addReplyComment = (res, index) => {
                let wrapperReplyComment = $(`.wrapper-reply-${res.comment_id}`);
                let itemComment = getParent('item-comment', wrapperReplyComment);
                let newReplyComment = $(
                    `<div class='position-relative sub-reply-comment-item mt-5' style='animation-delay:${index*0.1}s'>
                            <div class="w-100 d-flex justify-content-start align-items-center">
                            <img class='w-40px h-40px br-primary'
                                src='${res.profile_picture}' />
                            <span class="fs-14 pl-4  fw-bold br-primary reply-comment-text">${res.reply_comment_text}</span>
                                <form id='edit-reply-comment' class='edit-reply-comment-form hidden w-100 ml-2'>
                                    <div class="text-field w-100 mt-5 mb-5 cl center">
                                    <input autocomplete="off" class='input-edit-reply-comment cl fs-14' type="text" name='reply_comment_text'
                                            value='${res.reply_comment_text}' rules="required"
                                            style='border: none;border-bottom:1px solid #1d90f5' id='comment' />
                                            <input type='hidden' value='${res.reply_comment_id}' name='reply_comment_id'/>
                                        <div class='center'>
                                            <div class='cancel-edit-reply-comment bt-primary bg-transparent br-primary mt-2 w-100px center h-30px hover_close' ><?php print $LG['cancel']?></div>
                                            <div class='save-edit-reply-comment bt-primary w-100px br-primary center h-30px'><?php print $LG['save']?></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class='mt-2'>
                                <span class='fs-14 cl'>${res.username}</span>
                                <span class='fs-12 cl-second'>${formatTime(res.comment_date)}</span>
                            </div>
                            <div class='menu-edit hidden p-4 bg-primary-main br-primary'>
                                <div class='bt-primary w-100px br-primary center h-30px edit-reply-comment'><?php print $LG['edit']?></div>
                                <div class='p-2'></div>
                                <div data-id='${res.reply_comment_id}'class='delete-reply-comment bt-primary bg-transparent br-primary mt-2 w-100px center h-30px hover_close' ><?php print $LG['remove']?></div>
                            </div>
                        <div>`
                );
                let newMenuEdit = $(`
                            <i class='bx bx-dots-vertical-rounded hidden menu-edit-reply-comment ${checkComment(res.user_id, <?php print $userId?>)} fs-32 position-absolute hover_primary'>
                            </i>
                        `);
                newReplyComment.hover(function() {
                    newMenuEdit.insertBefore($(this).children('.menu-edit'));
                }, function() {
                    newMenuEdit.remove();
                })
                if (itemComment.children('.button-watch-reply').length === 0) {
                    let buttonWatchReply = $(
                        '<button class="mt-4 bt-second button-watch-reply"><?php print $LG['close-reply-comment']?></button>'
                    );
                    buttonWatchReply.click(function() {
                        activeItem($(`.wrapper-reply-${res.comment_id}`));
                        if ($(this).text() ===
                            '<?php print $LG['watch-reply-comment']?>'
                        ) {
                            $(this).text(
                                '<?php print $LG['close-reply-comment']?>'
                            );
                        } else {
                            $(this).text(
                                '<?php print $LG['watch-reply-comment']?>'
                            );
                        }
                    });
                    buttonWatchReply.insertBefore(wrapperReplyComment);
                } else {
                    itemComment.children('.button-watch-reply').text(
                        '<?php print $LG['close-reply-comment']?>');
                }
                $(`.wrapper-reply-${res.comment_id}`).removeClass('hidden');
                wrapperReplyComment.prepend(newReplyComment);
            }
            const saveReplyComment = (data) => {
                $.ajax({
                    type: "POST",
                    data: data,
                    url: getBaseURL()+"?action=reply-comment",
                    dataType: "json",
                    success: function(response) {
                        addReplyComment(response, 0);
                    }
                })
            }
            const replyComment = (item) => {
                let data = $('#form-reply-comment').serialize();
                saveReplyComment(data);
                let itemComment = getParent('item-comment', item);
                let replyCommentItem = getChildren('reply-comment-item', itemComment);
                // replyCommentItem.remove();
                let inputReplyComment = getChildren('input-reply-comment', $(
                    '#form-reply-comment')).val('');

            }
            const removeReplyComment = (id) => {
                $.ajax({
                    type: "POST",
                    data: {
                        reply_comment_id: id
                    },
                    url: getBaseURL()+"?action=remove-reply-comment",
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                    }
                })
            }
            $(document).on('click', '.delete-reply-comment', function() {
                let replyCommentId = $(this).attr('data-id');
                removeReplyComment(replyCommentId);
                let wrapperReplyComment = getParent('wrapper-reply-comment', $(this));
                let itemComment = getParent('item-comment', wrapperReplyComment);
                getParent('sub-reply-comment-item', $(this)).remove();
                if (wrapperReplyComment.children('.sub-reply-comment-item').length == 0) {
                    getChildren('button-watch-reply', itemComment).remove();
                }

            });

            $(document).on('click', '.save-reply-comment', function() {
                replyComment($(this))
            });

            $(document).on('click', '.edit-reply-comment', function() {
                let subReplyCommentItem = getParent('sub-reply-comment-item', $(this));
                let menuEdit = getParent('menu-edit', $(this));
                let replyCommentText = getChildren('reply-comment-text', subReplyCommentItem);
                let editCommentForm = getChildren('edit-reply-comment-form', subReplyCommentItem);
                let menuEditComment = getChildren('menu-edit-reply-comment', subReplyCommentItem);
                menuEditComment.remove();
                activeItem(replyCommentText);
                activeItem(editCommentForm);
                menuEdit.addClass('hidden');
            })

            $(document).on('click', '.cancel-edit-reply-comment', function() {
                let subReplyCommentItem = getParent('sub-reply-comment-item', item);
                let replyCommentText = getChildren('reply-comment-text', subReplyCommentItem);
                let editCommentForm = getChildren('edit-reply-comment-form', subReplyCommentItem);
                let inputEditReplyComment = getChildren('input-edit-reply-comment', editCommentForm);
                inputEditReplyComment.val(replyCommentText.text());
                activeItem(replyCommentText);
                activeItem(editCommentForm);
            })
            const editReplyComment = (item) => {
                let subReplyCommentItem = getParent('sub-reply-comment-item', item);
                let replyCommentText = getChildren('reply-comment-text', subReplyCommentItem);
                let editCommentForm = getChildren('edit-reply-comment-form', subReplyCommentItem);
                let inputEditReplyComment = getChildren('input-edit-reply-comment', editCommentForm);
                let valueEdit = inputEditReplyComment.val();
                replyCommentText.text(valueEdit)
                activeItem(replyCommentText);
                activeItem(editCommentForm);
                let data = editCommentForm.serialize();
                saveEditReplyComment(data);
            }
            const saveEditReplyComment = (data) => {
                $.ajax({
                    type: "POST",
                    data: data,
                    url: getBaseURL()+"?action=save-edit-reply-comment",
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                    }
                })
            }
            $(document).on('click', '.save-edit-reply-comment', function() {
                editReplyComment($(this));
            });

            $(document).on('keypress', '.input-edit-reply-comment', function() {
                if (event.keyCode === 13) {
                    editReplyComment($(this));
                }

            });

            $(document).on('keypress', '.input-reply-comment', function() {
                if (event.keyCode === 13) {
                    replyComment($(this))
                }

            });


        });
        </script>

</body>

</html>


