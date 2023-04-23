<div class="container">
    <div class="row">
        <div class="col-12 start">
            <h1 class='high-light fs-18 hover-light'>Comments on the channel </h1>
        </div>
        <div class="col-12 start mt-5">
            <div class="bt-primary bg-transparent active-line mr-1" style='border-radius: 0px'>
                Unread comments
            </div>
        </div>
        <div class="col-12 start mt-5 flex-wrap hidden-scroll" style='' id='wrapper-show-comment'>
        </div>
    </div>
</div>


<div id="modal-detail-comment" class="full hidden">
    <div  id='main-content-detail-comment'class='flex-wrap  position-absolute bg-second center br-primary p-4' style='top: 50%; left: 50%; transform: translate(-50%, -50%)'>
        <img src=''class='w-100' style='max-height: 40rem' id='thumbnail-comment-detail'/>
        
        <div class='w-100 start'>
            <h5 style="text-decoration: line;margin-right: 1rem ">Text comment :     </h5>
            <h1 class='fs-16 cl end mt-4 ' style='' id='comment-detail-text'></h1>
        </div>
        <h1 class='fs-14 cl-second end w-100' id='comment-detail-upload-date'></h1>
        <div class="w-100 hidden" id='form-reply-comment-text'>
            <div class="fill-info text-field w-100 mt-5 mb-5 ">
                <input autocomplete="off" class='cl fs-14' type="text" name=''
                                        placeholder="Enter your video title" rule="required-min:10" id='reply-comment-text'/>
                <label for="title" class='bg-primary-custom  cl fs-14'>Reply text
                </label>
                <div class="show__validation  error h-20px mt-2">
                </div>
            </div>
           <div class="end mb-2 mt-3" >
                <div class="bt-primary bg-transparent" id='btn-cancel-reply-comment-detail'>
                    Cancel
                </div>
                <div class="bt-primary" id='btn-save-reply-comment-text'>
                    Save
                </div>
           </div>
        </div>
        
        <div class='w-100 end' id='action-with-comment'>
            <div class="bt-primary bg-transparent btn-remove-comment" >
                Remove
            </div>
            <div class="bt-primary" id='btn-reply-comment'>
                Reply
            </div>
        </div>
    </div>
</div>

<div class="full hidden " id='modal-accept-remove-comment'>
    <div  class='position-absolute br-primary p-4 bg-second' style='top: 10rem; right: 50%; transform: translateX(50%)'>
        <h1 class='fs-16 mt-4 mb-4'>Are you sure remove this comment?</h1>
        <div class="w-100 border-bottom">

        </div>
        <div class="w-100 mt-4 end">
            <div class="bt-primary bg-transparent">
                Cancel
            </div>
            <div class="bt-primary" id='btn-accept-remove-comment'>
                Accept
            </div>
        </div>
    </div>
</div>