
<div class="container center">
    <div class="row  w-75">
        <div class="col-12 p-4">
            <form id='form-update-new-channel' class='center flex-wrap pt-4 mt-5'>
            <div class="text-field w-100 mt-2 mb-5 ">
                <input autocomplete="off" class='cl fs-14 h-50px' type="text"  id='channel-name-edit'
                    placeholder="Enter your name channel" rules=""
                    value="" />
                <label for="email" class='  cl fs-14' >Name channel</label>
            </div>
            <div class="text-field w-100 mt-2 mb-5 ">
                <textarea class='cl fs-14' id='channel-description-edit'
                    placeholder="Enter your channel description" rules="" >
                </textarea>
                <label for="" class=' cl fs-14'>Channel descriptions</label>
            </div>
            <div class="w-100 mb-4">
                <img style='width:100%; max-height:30rem; border-radius: 1rem; border: 1px solid #039be5; object-fit: fill'
                                class='image' id='preview-background-channel-edit' alt="Preview Image" src=''>
                <span class='cl-second fs-14 pt-3 start w-100 '> Default background channel</span>
            </div>
            <div class="w-100 mb-5 d-flex justify-content-start align-items-center">
                <div class="input_file mr-5" style='width: 10%; min-width: 15rem'>
                    <label for="background-channel-edit" class='cl bd-color'>
                        <span>
                        Change
                        </span> <br />
                        <i class="fa fa-2x fa-camera"></i>
                        <input id="background-channel-edit" class='' type="file" name='background-channel' accept='image/*' />
                        <br />
                        <span id=""></span>
                    </label>
                </div>
                
            </div>
            <div class="w-100 center">
                <div class="bt-primary br-primary hover_bg " id='btn-update-channel' style='background-color: rgba(26, 129, 220, .8)'>Save</div>
            </div>
        </form>
        </div>
    </div>
  </div>
 