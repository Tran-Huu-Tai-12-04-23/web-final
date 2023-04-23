
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faster Video</title>
    <?php
        include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/common.php';
    ?>
    <?php
       $video = new Video();
       $Language = new Language();
       $LG = $Language->getData();
       $data = $video->searchVideo();
    ?>
    <script src="<?php echo BASE_URL.'assets/js/history.js'?>">
    </script>
</head>

<body>
    <div class='notification-list'>

    </div>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/loader.php';?>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/toTop.php';?>
    
    <div class="dark-theme ">
        <div class="container-fluid p-0 m-0">
            <div class="row  d-flex justify-content-between">
                <?php include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/includes/NavbarHome.php' ?>
                <?php
                        include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/header.php'
                    ?>
                   <div class=" pl-5 wrapper-most-watched ">
                    <div class="container-fluid p-5">
                        <div class="g-4  row ">
                            <h1 class='fs-32 p-2  cl high-light'>Search for <span class='cl-second'style='font-style:italic'>'<?php print $_GET['data']??''?>'<span></h1>
                            <div class="container-fluid p-5" id='wrapper-list-video-search'>
                                <div  class="row flex-wrap g-5 mb-5" id='wrapper-video-by-search'>
                                    <?php 
                                        if(!$data) {
                                    ?>
                                        <div class="w-100 d-flex justify-content-start align-items-center">
                                            <h1 class='fs-18 cl pl-2'>0 results for <?php $_GET['data']??''?></h1>
                                            <i class='bx bx-refresh fs-32 cl '></i>
                                        </div>
                                        <script>
                                            addNotification("No matching results were found", 'warn')
                                        </script>
                                    <?php }?>
                                    <?php 
                                    $count = 0;
                                    foreach($data as $res ) { 
                                        $count = $count + 1;   
                                    ?>
                                        <div class='wrapper-item-most-watched  col-xl-2 col-lg-3 col-md-5 col-xs-12 col-12' onclick='redirectLink("watch?data=<?php print $res["video_id"]?>")'>
                                            <div class=" item-most-watched br-primary overflow-hidden " >
                                            <img class='<?php print $res['title']?>' src='<?php print $res['thumbnails']?>'/>
                                            <div class="item-most-watched-content">
                                                <img class='avatar-user-item box-shadow'src="<?php print $res['profile_picture']?>" />
                                                <span class='fs-12 cl-second'><?php print $res['username']?></span>
                                                <h1 class='fs-16 cl mt-2 mb-2 title-card'><?php print $res['title']?></h1>
                                                <h5 class='fs-12 cl-second'>
                                                   <?php print $Util->formatTime($res['upload_date'])?>
                                                </h5>
                                            </div>
                                            </div>
                                        </div>
                                    <?php }
                                    if($count == 18 ) {
                                    ?>
                                        <div id='btn-more-video-by-search' class="bt-primary w-100px center "  style='transform:translateY(2rem)'>More</div>
                                    <?php 
                                    }
                                    ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
         $(document).ready(function() {
            let limit = 19;
            $('#btn-more-video-by-search').click(function(){
                let loadMore = $('<div class="load-more"></div>');
                $('#wrapper-video-by-search').append(loadMore);
                $(this).remove();
                setTimeout(() => {
                    loadMore.remove();
                    getMoreVideo();
                }, 1000);
            })
            function getMoreVideo() {
                $.ajax({
                url: "?action=load-more-video-by-search", // URL của file PHP để tải thêm dữ liệu video
                type: "GET",
                data: {
                    data : '<?php print $_GET['data']??''?>',
                    limit_start: limit,
                },
                success: function(res){
                    let respons = JSON.parse(res);
                    if(respons.status === true ) {
                        limit = limit + 18;
                        loadVideo(respons.data);
                    }else{
                        addNotification("Load all videos by search", 'warn')
                    }
                }
                });
            }
            function loadVideo(data) {
                let wrapperBySearch = $('#wrapper-video-by-search');
                data = JSON.parse(data);
                console.log(data.length)
                data.forEach(video=> {
                    let newVideo = $(`
                    <div class='col-2' onclick='redirectLink("watch?data=${
                        video.video_id
                    }")'>
                        <div class=" item-most-watched br-primary overflow-hidden " style='height: 25rem!important'>
                        <img class='${video.title}' src='${video.thumbnails}'/>
                        <div class="item-most-watched-content">
                            <img class='avatar-user-item box-shadow'src="${video.profile_picture}" style='top: 50%;'/>
                            <span class='fs-12 cl-second'>${video.username}</span>
                            <h1 class='fs-16 cl mt-2 mb-2 title-card'>${video.title}></h1>
                            <h5 class='fs-12 cl-second'>${formatTime(video.upload_date)}</h5>
                        </div>
                        </div>
                    </div>`);
                    
                    wrapperBySearch.append(newVideo);
                })
                let btnMoreVideo = $(`
                    <div id='btn-more-video-by-search mt-5' class="bt-primary w-100px center">More</div>
                    `);
                btnMoreVideo.click(function() {
                    let loadMore = $('<div class="load-more"></div>');
                    $('#wrapper-video-by-search').append(loadMore);
                    $(this).remove();
                    setTimeout(() => {
                        loadMore.remove();
                        getMoreVideo();
                    }, 1000);
                })
                $('#wrapper-list-video-search').append(btnMoreVideo);
            }
            activeNavbar('search');
            saveSearchHisLocalStorage('<?php print $_GET['data']??''?>');
            renderSubMenuSearchHistory();
        });
    </script>
</body>

</html>