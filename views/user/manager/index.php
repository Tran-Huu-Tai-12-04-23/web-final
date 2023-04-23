<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Video</title>
    <?php
        include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/common.php';
        $Middleware->checkLogin($isLogin);
        $res = $Middleware->checkIsChannel($userId);
        // $isCheckUserChannel = $userId === $_GET['id']??'';
    ?>

    <script src="<?php echo BASE_URL.'assets/js/userManager/index.js'?>">
    </script>
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'assets/style/user/manager.css';?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'assets/style/upload_video/style.css';?>" />
    
</head>
<body> 
<div class='notification-list'>

</div>
    <div class="dark-theme">
        <div class=" wrapper-my-video d-flex justify-content-center cl">
            <div class="container-fluid p-0">
                <div class="row flex-wrap p-0" style='overflow: hidden'>
                    <div class="col-3 p-4 " style='background-color: #1b2a47; height: 100vh' >
                        <?php include 'sideBar.php'?>
                    </div>
                    <div class="col-9 p-4" style='height: 100vh; overflow: scroll; '>
                        <?php include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/user/manager/switch/main.php';?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        <?php if(isset($_GET['active'])) {?>
            switchSidebar("<?php print $_GET['active']?>");
        <?php }?>
        <?php if(isset($_GET['active']) and isset($_GET['id']) ) {?>
            <?php if($_GET['active'] == 'content') {?>
                editVideo(<?php print $_GET['id']?>);
            <?php }?>
        <?php }?>
        loadInformationOnChannel(<?php print $userId?>);
        getVideoUploadByUser(<?php print $userId?>);
        $("#menu-sidebar-admin").click(function (e) {
            e.stopPropagation();
            activeItem(getChildren("menu", $(this)));
        });
        $('#open-menu').click(function(e) {
            e.stopPropagation();
            activeItem($('#menu'));
        })

        $(window).click( function () {
            $('#menu').addClass('hidden');
        })
        $('#main-modal-edit-video').click(function (e) {
            e.stopPropagation();
        })
        $('#icon-close-modal-edit-video').click( function (e) {
            $('#modal-edit-video').addClass('hidden');
        })
        $("#modal-edit-video").click( function (e) {
            $('#modal-edit-video').addClass('hidden');
        })

        $(window).click(function () {
            $('#option-edit-video').addClass('hidden');
            $('#option-edit-thumbnail').addClass('hidden');
        })
        // video
        $('#btn-edit-video').click(function (e) {
            e.stopPropagation();
            $('#option-edit-video').removeClass('hidden');
        })
        $('#option-edit-video').mouseleave(function () {
            $(this).addClass('hidden');
        })
        $('#btn-show-enter-url-video').click(function (e) {
            $('#option-edit-video').addClass('hidden');
            $('#enter-url-video').removeClass('hidden');
        })
        $('#btn-cancel-show-enter-url-video').click(function (e) {
            $('#enter-url-video').addClass('hidden');
        })

        $('#btn-save-enter-video-url').click(function (e) {
            let videoUrl = $('#video-url').val();
            $('#preview-video').prop('src',fixLinkYoutube(videoUrl));
            $('#thumbnail-url').val(getThumbnailYoutube(videoUrl, 'max'));
            $('#preview-thumbnail').prop('src',getThumbnailYoutube(videoUrl, 'max'));
            $('#enter-url-video').addClass('hidden');
            $('#file-video').val(null);
        })

        $('#btn-get-file-video').click(function (e) {
            $('#option-edit-video').addClass('hidden');
            $('#file-video').click();
        })
        $('#file-video').change(function (e) {
            let file = e.target.files[0];
            let videoUrl = URL.createObjectURL(file);
            $('#preview-video').prop('src',(videoUrl));
            $('#video-url').val('');
        })

        // thumbnails
        $('#btn-edit-thumbnail').click(function (e) {
            e.stopPropagation();
            $('#option-edit-thumbnail').removeClass('hidden');
        })
        $('#option-edit-thumbnail').mouseleave(function () {
            $(this).addClass('hidden');
        })
        $('#btn-show-enter-url-thumbnail').click(function (e) {
            $('#option-edit-thumbnail').addClass('hidden');
            $('#enter-url-thumbnail').removeClass('hidden');
        })
        $('#btn-cancel-show-enter-url-thumbnail').click(function (e) {
            $('#enter-url-thumbnail').addClass('hidden');
        })

        $('#btn-save-enter-thumbnail-url').click(function (e) {
            let thumbnailUrl = $('#thumbnail-url').val();
            $('#preview-thumbnail').prop('src',fixLinkYoutube(thumbnailUrl));
            $('#enter-url-thumbnail').addClass('hidden');
            $('#file-thumbnail').val(null);
        })

        $('#btn-get-file-thumbnail').click(function (e) {
            $('#option-edit-thumbnail').addClass('hidden');
            $('#file-thumbnail').click();
        })
        $('#file-thumbnail').change(function (e) {
            let file = e.target.files[0];
            let thumbnailUrl = URL.createObjectURL(file);
            $('#preview-thumbnail').prop('src',(thumbnailUrl));
            $('#thumbnail-url').val('');
        })

        // handle save video url 
        $('#btn-save-edit-video').click(function (e) {
            let videoId = $(this).attr('vd-id');
            let title = $('#title').val();
            let description = $('#description').val();
            let fileVideo = $('#file-video')[0].files[0];
            let fileThumbnail = $('#file-thumbnail')[0].files[0];
            let videoUrl = $('#video-url').val();
            let thumbnailUrl = $('#thumbnail-url').val();
            let mode = $('#mode').val();

            let isCheck = true;
            if( !videoId ) {
                addNotification('Video id is not available!!', 'err');
                isCheck = false;
            }else if(title === '' ) {
                addNotification('Video title cannot be empty', 'err');
                isCheck = false;
            }else if( description === '' ) {
                addNotification('Video title cannot be empty', 'err');
                isCheck = false;
            }

            if(isCheck) {
                let formData = new FormData();
                formData.append("title", title);
                formData.append("description", description);
                formData.append("file_video", fileVideo);
                formData.append("file_thumbnail", fileThumbnail);
                formData.append("video_url", videoUrl);
                formData.append("thumbnail_url", thumbnailUrl);
                formData.append("mode", mode);
                formData.append("video_id", videoId);
                saveDataVideoEdit(formData);
            }
        })

    })
  
    </script> 
           <!-- handle edit channel -->
<script> 
    $(document).ready(function() {
        $('#form-update-new-channel').submit(function(e) {
            e.preventDefault();
        })

        $('#btn-cancel-update-channel').click(function(e) {
            window.location.href = getBaseURL();
        })
        $('#background-channel-edit').change(function(e) {
            let selectedFile = $(this).prop('files')[0];
            let reader = new FileReader();
            reader.onload = () => {
                let imgElement = $('#preview-background-channel-edit').get(0);
                imgElement.src = reader.result ;
            };
            reader.readAsDataURL(selectedFile);
        })
        $('#btn-update-channel').click(function(e) {
            let nameChannel = $('#channel-name-edit').val();
            let descriptionsChannel = $('#channel-description-edit').val();
            let backgroundChannelUrl = $('#preview-background-channel-edit').prop('src');
            let backgroundChannel = $('#background-channel-edit').prop('files')[0];
            let userId = <?php print $userId?>;
            let formData = new FormData();
            formData.append('name_channel', nameChannel);
            formData.append('descriptions_channel', descriptionsChannel);
            formData.append('background_channel', backgroundChannel);
            formData.append('user_id', userId);

            if( nameChannel == '' ) {
                addNotification('Name channel can not be empty', 'err');
            }else if(descriptionsChannel == '') {
                addNotification('Descriptions channel can not be empty', 'err');
            }else {
                if(backgroundChannelUrl.includes('localhost') ) {
                    backgroundChannelUrl = 'default';
                    formData.append('background_channel_url', backgroundChannelUrl);
                }
                updateChannel(formData);
            }
        })

    });
    function updateChannel(formData) {
        $.ajax({
        url: getBaseURL() + '?action=update-edit-channel',
        type: "POST",
        headers: {
            "Accept": "application/json"
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
        response = JSON.parse(response);
           if(response.status === true ) {
                addNotification("Update new channel successfully!!", 'success');
                $('.modal-loading-video').removeClass('hidden');
                setTimeout(() => {
                    window.location.href = getBaseURL() + "user/channel/";
                }, 1000);
                return;
           }else {
                addNotification("There was a problem with update new channel", 'err');
                return;
           }
        },
        error: function(xhr, status, error) {
            addNotification("There was a problem with the AJAX request:", 'err');
        }
        });

    }
</script> 

<!-- handle upload vidoe  -->
<Script>
    $(document).ready(function() {
        
        
        // re code 
        $('.btl-URL-file').click(function(e) {
            let modalUrl = $(
                `
                    <div class='wrapper-modal'>
                        <div class='modal-custom w-25 h-unset p-4 '>
                            <div class='input-text label-up cl mt-5 mb-4 parent-hover fs-16'>
                                <input type='text' class='cl' name='password' placeholder=' ' rule='required-min:6' id='input-url' style='color: #fff'/>
                                <label class='cl-second'>URL</label>
                            </div>
                            <button class='bt-primary btn-save-url fs-16 mt-2'>Save</button>
                            <i class='bx bx-x position-absolute fs-32 hover_close close-modal' style='top:1rem;right:1rem'></i>
                        </div>
                    </div>
                `
            );
            $('body').append(modalUrl);
        })
        $(document).on('click','.close-modal', function() {
            let wrapperModal = getParent('wrapper-modal', $(this));
            wrapperModal.remove();
        })
        $(document).on('click', '.modal-custom', function(e) {
            e.stopPropagation();
        })

        // handle change video 
        $('#video').change(function(e) {
            $('.modal-loading-video').removeClass('hidden');
            const file = e.target.files[0];
            if (file.type.startsWith('video/')) {
                startLoading(null, file);
            } else {
                alert('Please select a video!!!');
            }
        })

        $('#thumbnail').change(function(e) {
            let urlImage = URL.createObjectURL(e.target.files[0]);
            urlImage.onload = function() {
                URL.revokeObjectURL(urlImage) // free memory
            }
            $('#preview-thumbnail-upload').attr('src', urlImage);
        })
        function saveUrlVideo(item) {
            $('.modal-loading-video').removeClass('hidden');
            let url = $('#input-url').val();
            if(url) {
                startLoading(url);
                $('#thumbnail-url-upload').attr('src', url);
                $('#video-url-upload').val(url);
            }
            getParent('wrapper-modal', item).remove();
        }
        $(document).on('keypress', '.modal-custom', function(e) {
            if (e.which == 13) {
                saveUrlVideo($(this));
            }
        })
        $(document).on('click', '.btn-save-url', function(e) {
            saveUrlVideo($(this));
        })

        $('.btn-upload-video').click(function() {
            let err = false;
            if($('#description-upload').val() === '' && $('#title-upload').val() === ''   ) {
                err = true;
                addNotification("Description and title is not empty!!", "warn");
                return;
            }
            if($('#description-upload').val() === '' || !$('#description-upload').val()) {
                err = true;
                addNotification("Please fill description", "warn");
                return;
            }
            if($('#title-upload').val() === '' || !$('#title-upload').val()) {
                err = true;
                addNotification("Please fill description", "warn");
                return;
            }
            if( err === false ) {
                $('.fill-info').addClass('hidden');
                $('.done-step').removeClass('hidden');
                let processUploadVideo = $('.process-upload-video');
                let step = getChildren('step', processUploadVideo);
                $(step[2]).addClass('active-step');
                setTimeout(() => {
                    $('#form-upload-video').submit();
                }, 1000);
            }
        })
        function startLoading(url = null, file = null) {
            if (url) {
                let thumbnail = getThumbnailYoutube(url, 'max');
                $('#preview-thumbnail-upload').attr('src', thumbnail);
                $('#thumbnail-url-upload').val(thumbnail);
                nextStep2(fixLinkYoutube(url));
            }
            else {
                let videoURL = url ? url : URL.createObjectURL(file);
                nextStep2(videoURL);
            }
        }
        function nextStep2(url) {
            if( url ) {
                setTimeout(() => {
                    let processUploadVideo = $('.process-upload-video');
                    processUploadVideo.removeClass('hidden');
                    let step = getChildren('step', processUploadVideo);
                    $(step[1]).addClass('active-step');
                    $('.input_file').addClass('hidden');
                    $('.modal-loading-video').addClass('hidden');
                    $('.fill-info').removeClass('hidden');
                    $('#preview-video-upload').attr('src',url);
                }, 2000);
            }
        }

        $('#preview-thumbnail-upload').click(function() {
            $('#thumbnail').click();
        })
      
    });
    </Script>
<!-- handle manager comment -->

<script>

   $(document).ready(function() {
        getCommentOnUser(<?php print $userId?>)
        $(window).click(function() {
            $('.child-menu').addClass('hidden');
        })
        $(document).on('click', '.parent-menu', function(e) {
            e.stopPropagation();
            activeItem(getChildren('child-menu', $(this)));
        })
   })

   function getCommentOnUser(userId, limit = 0, index = 0) {
        $.ajax({
        type: "get",
        url: getBaseURL() + "?action=get-comment-channel",
        data: {
            id: userId,
            limit: limit
        },
        dataType: "json",
        success: function (response) {
        if (response.status) {
            let data = (response.data);
            loadComment(data, index, limit , userId )
        } else {
            let notification = $(`<div>
            <h1 class='fs-16 cl mt-4 ' style='color: #bf3358!important'>No comment on channel</h1>
            </div>`);
            $('#wrapper-show-comment').append(notification);
        }
        },
    });

    //hadne form detail comment 
   
    $('#modal-detail-comment').click(function() {
        $(this).addClass('hidden');
    })
    $('#btn-reply-comment').click(function() {
        $('#form-reply-comment-text').removeClass('hidden');
        $('#action-with-comment').addClass('hidden');   
    })
    $('#btn-cancel-reply-comment-detail').click(function() {
        $('#form-reply-comment-text').addClass('hidden');
        $('#action-with-comment').removeClass('hidden');
    })
    $('.btn-remove-comment').click(function() {
        $('#modal-accept-remove-comment').removeClass('hidden');
    })
    $('#modal-accept-remove-comment').click(function() {
        $(this).addClass('hidden'); 
    })
    $('#main-content-detail-comment').click(function(e) {
        e.stopPropagation()
    })
    $(document).on('click','.btn-show-detail-comment', function(e) {
        e.stopPropagation();
        $('#modal-detail-comment').removeClass('hidden');
        let commentId = $(this).attr('com-id');
        $('#btn-save-reply-comment-text').attr('com-id', commentId);
        $('#btn-accept-remove-comment').attr('com-id', commentId);
        loadDetailComment(commentId);
    })
    $('#btn-save-reply-comment-text').click(function(e) {
        let text = $('#reply-comment-text').val();
        let commentId = $(this).attr('com-id');
        if(text == '') {
            addNotification('Please enter a comment before submitting', 'warn');
        }else{
            replyComment(text,commentId, <?php print $userId?> );
        }
    })
    $('#btn-accept-remove-comment').click(function(e) {
        let commentId = $(this).attr('com-id');
        removeComment(commentId);
    })
   } 

   function loadDetailComment(commentId) {
        $.ajax({
            type: "get",
            url: getBaseURL() + "?action=get-detail-comment",
            data: {
                comment_id: commentId,
            },
            dataType: "json",
            success: function (response) {
            if (response.status) {
                let data = (response.data)[0];
                $('#comment-detail-text').text(data.comment_text);
                $('#comment-detail-upload-date').text(formatTime(data.upload_date));
                $('#thumbnail-comment-detail').prop('src',getThumbnails( data.thumbnails));
            } else {
                console.log("server is errr");
            }
            },
        });
   }
   function removeComment(commentId) {
        $.ajax({
            type: "POST",
            data: {
                comment_id: commentId
            },
            url: "?action=delete-comment",
            dataType: "json",
            success: function(response) {
                if(response.status == true ) {
                    addNotification('Remove comment successfully!!', 'success');
                    $(`#comment-${commentId}`).remove();
                    $('#modal-detail-comment').addClass('hidden');
                    $('#form-reply-comment-text').addClass('hidden');
                    $('#action-with-comment').removeClass('hidden');
                }else {
                    addNotification('Remove comment failed!!', 'err');
                }
            }
        })
   }
   function replyComment(text, commentId, userId) {
        $.ajax({
            type: "POST",
            url: getBaseURL() + "?action=reply-comment",
            data: {
                comment_text: text,
                user_id: userId,
                comment_id: commentId,
            },
            dataType: "json",
            success: function (response) {
                addNotification('Reply comment successfully posted', 'success');
                $('#modal-detail-comment').addClass('hidden');
                $('#form-reply-comment-text').addClass('hidden');
                $('#action-with-comment').removeClass('hidden');
            },
        });
   }
   function loadComment(data, index, limit, userId) {
    let wrapperShowComment =  $('#wrapper-show-comment');
    data.map( comment => {
        let commentUser = $(`
            <div id='comment-${comment.comment_id}'class="w-100 d-flex position-relative justify-content-between align-items-center br-primary hover-bg p-4 " style='overflow:unset'>
                    <div class="start ">
                        <img  src='${comment.profile_picture}' class='h-40px w-40px rounded-circle mr-3 avatar-user-comment'/>
                        <h5 class='mr-3'>${comment.comment_text}</h5>
                        <span class='mr-3 ml-5 cl-second fs-14'>${formatTime(comment.comment_date)}</span>
                    </div>
                    <div style='float: right' class='parent-menu'>
                            <div class="bt-primary btn-show-detail-comment" com-id='${comment.comment_id}'>
                                Detail
                            </div>
                    </div>
                </div>
        `);

        if(index == 15 ) {
            let btnMore = $(
                '<div class="bt-primary  w-100 br-primary bg-transparent center fs-16">Show More</div>'
            );
            btnMore.click(function () {
                getCommentOnUser(userId, limit + 15 , index);
                $(this).remove();
            });
            wrapperShowComment.append(btnMore);
        }else {
            wrapperShowComment.append(commentUser);
        }
        index ++;

    })
   }
</script>

</body>

</html>