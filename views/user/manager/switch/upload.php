<div class="p-primary justify-content-center align-items-center d-flex flex-wrap">
            <div class='process-upload-video w-100 h-150px flex-wrap hidden'>
                <div class="w-100 center" style='transform: translateY(2rem)'>
                    <div class="name-step">Upload</div>
                    <div class="name-step">Fill Information</div>
                    <div class="name-step">Done</div>
                </div>
                <div class="w-100 center">
                    <div class="step">1</div>
                    <div class="step">2</div>
                    <div class="step">3</div>
                </div>
            </div>
            <div class="container cl w-100 ">
                <div class=" row d-fex justify-content-center align-items-center ">
                    <div class=" col-6  d-flex justify-content-center " >
                        <form action="<?php echo BASE_URL.'?action=upload';?>" method="POST"
                            enctype="multipart/form-data" class='w-100 br-primary' id='form-upload-video'>
                            <div class="input_file cl h-40vh w-100 center position-relative parent-hover d-flex
                             justify-content-center align-items-center border box-shadow"
                                id='show-modal-upload' style='transform: translateY(50%); width: 10%; min-width: 15rem; cursor: pointer;border:none'>
                                <input type='hidden' value='<?php print $userId?>' name='user_id'/>
                                <i class='bx bxs-video fs-32 cl'></i>
                                <div class='d-flex justify-content-around align-items-center position-absolute ' 
                                style='bottom:10%;left:50%; transform:translateX(-50%)'>
                                    <div style='min-width: 40rem'class=" d-flex justify-content-between align-items-center">
                                        <label class='bt-primary br-primary center'for='video' style='min-width: 15rem'>
                                            <i class='bx bx-upload m-2 fs-24'></i>
                                            Browers File
                                            <input id="video" type="file" name='video' accept="video/*" />
                                            <input cl type='hidden' name='video-url' id='video-url-upload'/>
                                        </label>
                                        <button  style='min-width: 15rem' type='button'class='bt-primary center  br-primary btl-URL-file'>
                                            <i class='bx bx-link-alt fs-24 mr-5' ></i>    
                                            URL
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class='timeline-upload hidden'></div> -->
                            
                            <div class="modal-loading-video position-fixed center modal-loading-video hidden" style='background-color: rgba(0,0,0,.4);backdrop-filter: blur(2rem);top:0;left:0;right:0;bottom:0; z-index: 10000000000'>
                                <div class="loading-video">
                                </div>
                            </div>

                            <div class="container-fluid">
                                <div class="row border gx-2 br-primary p-4 fill-info hidden justify-content-between">
                                    <div class="col-lg-6 col-xl-6 col-md-12 col-12 h-150px  fill-info hidden" >
                                        <iframe class='  w-100 h-150px  p-4' id='preview-video-upload' src=""
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-md-12 col-12  fill-info hidden">
                                        <div class=" d-flex justify-content-center align-items-center w-100">
                                            <div class=" mr-5 d-flex justify-content-center align-items-center"
                                            >
                                            <label for="thumbnail">
                                                <i class='bx bx-camera cl fs-32' ></i>
                                            </label>
                                            <input id="thumbnail" type="file" name='thumbnail' class='hidden'
                                                    accept='image/*' />
                                            <input type='hidden' name='thumbnail-url' id='thumbnail-url-upload'/>
                                            </div>
                                            <div class="w-50 w-100">
                                                <img src='https://climate.onep.go.th/wp-content/uploads/2020/01/default-image.jpg'
                                                    style='min-width:10rem; min-height:10rem; border-radius: 1rem; border: 1px solid dodgerblue;'
                                                    class='image w-100 h-150px' id='preview-thumbnail-upload' src="#" alt="Preview Image" rule='required'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fill-info text-field w-100 mt-5 mb-5 hidden">
                                <input autocomplete="off" class='cl fs-14' type="text" name='title'
                                    placeholder="Enter your video title" rule="required-min:10" id='title-upload'/>
                                <label for="title" class='bg-primary-custom  cl fs-14'>Title
                                </label>
                                <div class="show__validation  error h-20px mt-2">
                                </div>
                            </div>

                            <div class="fill-info text-field w-100 mt-5 mb-5 hidden">
                                <textarea autocomplete="off" class='cl fs-14 w-100' type="text" name='description'
                                    placeholder="Enter your video description" rules="required-min:10" id='description-upload'></textarea>
                                <label for="description" class='bg-primary-custom  cl fs-14'>Description
                                </label>
                                <div class="show__validation  error h-20px mt-2">
                                </div>
                            </div>
                            <div class="fill-info text-field w-100 mt-5 mb-5 hidden">
                                <select value='public'
                                    class='h-30px br-primary bg-transparent bd-primary cl fs-14 pl-5 pr-5'
                                    id='select-mode' name='mode_private'>
                                    <option value="public" class='bg-third br-primary hover-scale'>Public</option>
                                    <option value="private" class='br-primary bg-third hover-scale'>Private</option>
                                </select>
                            </div>

                            <div class="fill-info btn-upload-video bt-primary fs-16 w-100px center hidden">
                                Upload
                            </div>

                            <div class="done-step hidden d-flex justify-content-center align-items-center flex-column mb-5">
                                <div class=" h-60px w-60px rounded-circle center" style='background: #539165;
                                animation: showModal 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
                                '>
                                    <i class='bx bx-check' style='font-size:64px;
                                    animation: showModal 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
                                    '></i>
                                </div>
                                <div class="noti fs-24" style='color: dodgerblue'>
                                    Upload video successfully!!
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>