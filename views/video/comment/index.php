<div class="wrapper-comment bg-transparent dark-theme cl fs-14">
    <div class="col-12 mb-5 flex-wrap" style='min-height: 20rem'>
        <?php 
    if($isLogin) {        
    ?>
        <div class="w-100 mt-5 cl main-comment">
            <div class="text-field w-100 mt-5 mb-5 cl">
                <form action="<?php print "http://localhost/".BASE_URL.'?action=comment'?>" method="POST"
                    id='upload-comment'>
                    <input autocomplete="off" class=' cl fs-14' type="text" name='comment'
                        placeholder="Enter your comment" rules="required"
                        style='border: none;border-bottom:1px solid #1d90f5' id='comment' />
                    <input name='user_id' value='<?php echo $userId;?>' class='hidden' />
                    <input name='video_id' value='<?php echo $videoWatch['video_id'];?>' class='hidden' />
                </form>
            </div>
            <div class="w-100 d-flex justify-content-end hidden action-comment" id='action-comment'>
                <button class='reset cl mr-5 hover-bg hover_close p-4 br-primary' id='btn-cancel-comment'>
                    Cancel
                </button>
                <button class='bt-primary cl' id='btn-comment'>
                    Comment
                </button>
            </div>
        </div>
        <?php }else {?>
        <div class="w-100 center justify-content-start p-5">
            <div class="bt-primary w-25 fs-16 " onclick='redirectLink("login")'><?php print $LG['login-to-comment']?>
            </div>
        </div>
        <?php }?>
        <div class='w-100 d-flex justify-content-start align-items-center cl'>
            <h5 class='mr-5 border-bottom number-comment'></h5>
        </div>
        <div class="render-comment mt-4 hidden-scroll pb-4">
        </div>
    </div>
</div>


<!-- form reply comment -->