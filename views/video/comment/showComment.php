<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/common.php';
    ?>
    <?php
       $data = isset($_GET['data']) ? $_GET['data'] : '';
       $Comment = new Comment();
       $comment = $Comment->getAllComment($data);
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL.'assets/style/watch/style.css';?>" />
    <style>
    body {
        background-color: transparent !important;
        color: inherit !important;
    }
    </style>

</head>

<body>
    <?php 
    if( $comment ) {
    while($com = $comment->fetch_assoc()) {
    ?>
    <div class="w-100 comment mt-5 dark-theme cl fs-18">
        <div class="w-100 d-flex justify-content-start align-items-center  flex-wrap">
            <div class=" d-flex justify-content-start align-items-start w-100">
                <div class='button_primary p-2 mb-2 w-40px mr-3 parent-suggest'>
                    <img src="<?php echo $com['profile_picture']?>" />
                    <div class='child-suggest' style=''>
                        <span class='mr-2 cl fs-18 '><?php echo $com['username']?></span>
                        <span style='color:#ccc'>3 days ago</span>
                    </div>
                </div>
                <div class='d-flex justify-content-start align-items-start flex-column l-5' style=''>
                    <div class=' cl br-primary mb-3 mt-3' style='width: unset'>
                        <span class='cl fs-18'><?php echo $com['comment_text']?></span>
                    </div>
                    <div class='d-flex justify-content-start align-items-center'>
                        <i class='icon-heart bx bx-heart fs-14 mr-4  hover_close cl' id='icon-heart'></i>
                        <div id="" class='br-primary p-3 pl-4 pr-4 hover-bg hover-bg cl fs-14' style='width: unset'>
                            Reply
                        </div>

                        <div id=""
                            class='hover-bg ml-2  fs-14 p-3 pl-4 pr-4 br-primary hover-bg d-flex justify-content-center align-items-center watch-reply'
                            style='width: unset'>
                            <span class='cl fs-14'>Watch reply</span>
                            <i class='bx bx-chevron-down fs-14 ml-2 cl'></i>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div id="reply-comment" class='reply-comment hidden p-5  br-primary cl' style='margin-left: 1rem'>
            <ul>
                <?php 
                    for( $i = 0; $i < 5 ; $i ++ ) {
                ?>
                <li class='d-flex justify-content-start align-items-center mb-4'>
                    <div class="button_primary p-2 mb-2 w-40px mr-3 parent-suggest">
                        <img src="<?php echo $avatar?>" />
                        <div class='child-suggest' style=''>
                            <span class='mr-2 cl'>Huu Tai</span>
                            <span style='color:#ccc'>3 days ago</span>
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-start align-items-center">
                        <div class='mr-5 cl br-primary ' style='width: unset'>
                            <span class='cl'>2023 rồi có ai còn nghe không điểm danh điiii</span>
                        </div>
                        <i class='bx bx-heart fs-24 mr-4 hover_close icon-heart ' id='icon-heart'></i>
                        <div id="" class='br-primary p-3 pl-4 pr-4 hover-bg hover-bg fs-14' style='width: unset'>
                            Reply
                        </div>
                    </div>
                </li>
                <?php 
                    }
                ?>
            </ul>
        </div>
    </div>
    <?php
        }
    }
    ?>

    <script>
    $(document).ready(function() {
        let watchReply = document.querySelectorAll('.watch-reply');

        function getParentComment(item, className) {
            if (item.parentElement.classList.contains(className)) {
                return item.parentElement;
            }
            return getParentComment(item.parentElement, className);
        }

        for (let btnWatchReply of watchReply) {
            btnWatchReply.onclick = function(e) {
                let comment = getParentComment(e.target, 'comment');
                let replyComment = comment.querySelector('.reply-comment');
                if (replyComment.classList.contains('hidden')) {
                    btnWatchReply.innerHTML = `
                        <span class='cl fs-14'>Close reply</span>
                        <i class='cl bx bx-chevron-up fs-14 ml-2'></i>
            `;
                    replyComment.classList.remove('hidden');
                } else {
                    btnWatchReply.innerHTML = `
                        <span class='cl fs-14'>Watch reply</span>
            <i class='bx bx-chevron-down fs-14 ml-2 cl'></i>
            `;
                    replyComment.classList.add('hidden');
                }
            }
        }
    })
    </script>
</body>

</html>