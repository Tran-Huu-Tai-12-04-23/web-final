<section>
  <!--for demo wrap-->
  <div class="tbl-header">
    <table cellpadding="0" cellspacing="0" border="0">
      <thead >
        <tr style='background-color: #1b2a47!important'>
          <th><input type='checkbox' name='video--select-all' class= ' hidden mr-3 w-40px'/>.NO</th>
          <th>Title Video</th>
          <th>Comments</th>
          <th>Likes</th>
          <th>Mode</th>
          <th>Upload date</th>
          <th>Action</th>

        </tr>
      </thead>
    </table>
  </div>
  <div class="tbl-content">
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody id='main-table-video-on-user'>
      </tbody>
    </table>
  </div>
</section>

<div class="full hidden" id='modal-edit-video'>
  <div id="main-modal-edit-video" class='position-absolute bg-second br-primary p-4 hidden-scroll ' style='min-width: 40rem; max-width: 80rem; width: 70vw; max-height: 90vh;  overflow: scroll;top: 50%; left: 50%; transform: translate(-50%, -50%)'>
    <h1 class='fs-18 cl'>Edit video</h1>
    <i class='bx bx-x fs-32 hover_close  position-absolute' id='icon-close-modal-edit-video'style='top: 1rem; right: 1rem'></i>
    <iframe class='w-100 p-4 br-primary ' id='preview-video' src="" height=400
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen>
    </iframe>
    <div class="w-100 end pr-4 pl-4  flex-wrap " id=''>
          <div class="w-100 start hidden " id='enter-url-video'>
            <div class="fill-info text-field  mt-5 mb-5 mr-3" style='width: 70%'>
                  <input autocomplete="off" class='cl fs-14' type="text" name='title'
                        placeholder="Enter your video title" rule="required-min:10" id='video-url'/>
                  <label for="title" class='bg-primary-custom  cl fs-14'>Video Url
                  </label>
              </div>
              <div class="end" style='width: 30%'>
                <div id='btn-cancel-show-enter-url-video' class="bt-primary mr-4 " style='background-color: rgba(0,0,0, .4)'>
                    Cancel
                  </div>
                <div class="bt-primary "id='btn-save-enter-video-url' >
                  Save
                </div>
              </div>
          </div>
      <div class="h-40xp w-140px br-primary p-4  position-relative" style='overflow: unset; background-color: rgba(0,0,0, .4)' id='btn-edit-video'>
        <div id='option-edit-video' style='width: 15rem ; top: 0; left: -15rem; z-index: 1000000000000;background-color: rgba(0,0,0,.8)'  class='hidden option-edit-video p-4 position-absolute br-primary center flex-wrap'>
                  <div class='bt-primary bg-transparent w-100 mb-3' id='btn-get-file-video' >Browser</div>
                  <div class='bt-primary bg-transparent w-100' id='btn-show-enter-url-video'>Url</div>
              </div>
      Edit video</div>
    </div>
    <h5 class='mt-5'>Thumbnail</h5>
    <img src='' class=" p-4 br-primary w-100" id='preview-thumbnail'></img>
    <div class="w-100 pl-4 pr-4">
      <div class="w-100 start hidden" id='enter-url-thumbnail'>
              <div class="fill-info text-field  mt-5 mb-5 mr-3" style='width: 70%'>
                    <input autocomplete="off" class='cl fs-14' type="text" name='title'
                          placeholder="Enter your thumbnail" rule="required-min:10" id='thumbnail-url'/>
                    <label for="title" class='bg-primary-custom  cl fs-14'>Thumbnails Url
                    </label>
                </div>
                <div class="end" style='width: 30%'>
                  <div id='btn-cancel-show-enter-url-thumbnail' class="bt-primary mr-4 " style='background-color: rgba(0,0,0, .4)'>
                      Cancel
                    </div>
                  <div class="bt-primary "id='btn-save-enter-thumbnail-url' >
                    Save
                  </div>
                </div>
          </div>
    </div>
    <div class="w-100 end pr-4">
      <div class="h-40xp w-140px br-primary p-4  position-relative" style='overflow: unset; background-color: rgba(0,0,0, .4)' id='btn-edit-thumbnail'>
        <div id='option-edit-thumbnail' style='width: 15rem ; top: 0; left: -15rem; z-index: 1000000000000;background-color: rgba(0,0,0,.8)'  class='hidden option-edit-thumbnail p-4 position-absolute br-primary center flex-wrap'>
                  <div class='bt-primary bg-transparent w-100 mb-3' id='btn-get-file-thumbnail' >Browser</div>
                  <div class='bt-primary bg-transparent w-100' id='btn-show-enter-url-thumbnail'>Url</div>
              </div>
      Edit thumbnail</div>
    </div>
    
    <div class="fill-info text-field w-100 mt-5 mb-5 ">
          <input autocomplete="off" class='cl fs-14' type="text" name='title'
                placeholder="Enter your video title" rule="required-min:10" id='title'/>
          <label for="title" class='bg-primary-custom  cl fs-14'>Title
          </label>
      </div>

      <div class="fill-info text-field w-100 mt-5 mb-5 ">
          <textarea autocomplete="off" class='cl fs-14 w-100' type="text" name='description'
              placeholder="Enter your video description" rules="required-min:10" id='description'></textarea>
          <label for="description" class='bg-primary-custom  cl fs-14'>Description
          </label>
      </div>
      <div class="fill-info text-field w-100 mt-5 mb-5 ">
          <select value='0'
              class='h-30px br-primary bg-transparent bd-primary cl fs-14 pl-5 pr-5'
              id='mode' >
              <option value="0" class='bg-third br-primary hover-scale'>Public</option>
              <option value="1" class='br-primary bg-third hover-scale'>Private</option>
          </select>
      </div>
      <div class="fill-info btn-upload-video bt-primary fs-16 w-100px center" id='btn-save-edit-video'>
           Save
      </div>    
  </div>
</div>

<input class='hidden' type='file' accept='video/*' id='file-video'/>
<input class='hidden' type='file' accept='image/*' id='file-thumbnail'/>
