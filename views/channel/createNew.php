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
    ?>
    <script>
        $(document).ready(function() {
            <?php if(isset($_GET['m']) and isset($_GET['t'])) {
            ?>
                addNotification("<?php print $_GET['m']??''?>", "<?php print $_GET['t']??''?>");
            <?php }?>
        })
    </script>
</head>

<body>
    <div class='notification-list'>

    </div>
    <?php  include  $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/loader.php';?>
    <div class="dark-theme">
        <?php include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/includes/NavbarHome.php' ?>
        <?php
            include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'/views/includes/header.php'
        ?>
         <div class="modal-loading-video position-fixed center modal-loading-video hidden" style='background-color: rgba(0,0,0,.4);backdrop-filter: blur(2rem);top:0;left:0;right:0;bottom:0; z-index: 10000000000'>
            <div class="loading-video">
            </div>
        </div>
        <div class=" wrapper-my-video d-flex justify-content-center cl p-4">
            <div class="container p-4">
                <div class="row flex-wrap p-4">
                    <h1 class='fs-32 mt-2 cl  high-light ml-2'  >Start with your channel?</h1>
                    <h5 class='cl-second fs-14 ml-2 mb-5 mt-1'  style='line-height: 1.5em'>Build archive video to share everyone that you want?</h5>
                    <!-- <h5 class='mb-5 cl-second fs-14 ml-2' style='line-height: 1.5rem'>Save moment happy with your friend, your family..?</h5> -->
                    <form id='form-create-new-channel' class='center flex-wrap pt-4 mt-5'>
                        <div class="text-field w-100 mt-2 mb-5 ">
                            <input autocomplete="off" class='cl fs-14 h-50px' type="text"  id='name-channel'
                                placeholder="Enter your name channel" rules=""
                                value="" />
                            <label for="email" class='  cl fs-14'>Name channel</label>
                        </div>
                        <div class="text-field w-100 mt-2 mb-5 ">
                            <textarea class='cl fs-14' id='descriptions-channel'
                                placeholder="Enter your channel description" rules="" >
                            </textarea>
                            <label for="" class=' cl fs-14'>Channel descriptions</label>
                        </div>
                        <div class="w-100 mb-4">
                            <img style='width:100%; border-radius: 1rem; border: 1px solid #039be5; object-fit: fill'
                                            class='image' id='preview-background-channel' alt="Preview Image" src='<?php print BASE_URL."assets/images/background-default.png"?>'>
                            <span class='cl-second fs-14 pt-3 start w-100 '> Default background channel</span>
                        </div>
                        <div class="w-100 mb-5 d-flex justify-content-start align-items-center">
                            <div class="input_file mr-5" style='width: 10%; min-width: 15rem'>
                                <label for="background-channel" class='cl bd-color'>
                                    <span>
                                    Change
                                    </span> <br />
                                    <i class="fa fa-2x fa-camera"></i>
                                    <input id="background-channel" class='' type="file" name='background-channel' accept='image/*' />
                                    <br />
                                    <span id=""></span>
                                </label>
                            </div>
                            
                        </div>
                        <div class="w-100 end">
                            <div class="bt-primary bg-second br-primary mr-3" id='btn-cancel-create-channel'>Cancel</div>
                            <div class="bt-primary br-primary hover_bg " id='btn-create-channel' style='background-color: rgba(26, 129, 220, .8)'>Create</div>
                        </div>
                    </form>
                </div>  
            </div>
        </div>
    </div>
    <?php
        include $_SERVER["DOCUMENT_ROOT"].BASE_URL.'views/includes/NavbarHome.php';
    ?>
    <script src="<?php echo BASE_URL.'assets/js/validate.js'?>">
    </script>
    
    <script> 
    $(document).ready(function() {
        $('#descriptions-channel').val("");
        activeNavbar('');
        $('#form-create-new-channel').submit(function(e) {
            e.preventDefault();
        })

        $('#btn-cancel-create-channel').click(function(e) {
            window.location.href = getBaseURL();
        })
        $('#background-channel').change(function(e) {
            let selectedFile = $(this).prop('files')[0];
            let reader = new FileReader();
            reader.onload = () => {
                let imgElement = $('#preview-background-channel').get(0);
                imgElement.src = reader.result ;
            };
            reader.readAsDataURL(selectedFile);
        })
        $('#btn-create-channel').click(function(e) {
            let nameChannel = $('#name-channel').val();
            let descriptionsChannel = $('#descriptions-channel').val();
            let backgroundChannelUrl = $('#preview-background-channel').prop('src');
            let backgroundChannel = $('#background-channel').prop('files')[0];
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
                cerateNewChannel(formData);
            }
        })

    });
    function cerateNewChannel(formData) {
        $.ajax({
        url: getBaseURL() + '?action=create-new-channel',
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
                addNotification("Create new channel successfully!!", 'success');
                $('.modal-loading-video').removeClass('hidden');
                setTimeout(() => {
                    window.location.href = getBaseURL() + "me/channel";
                }, 1000);
                return;
           }else {
                addNotification("There was a problem with create new channel", 'err');
                return;
           }
        },
        error: function(xhr, status, error) {
            addNotification("There was a problem with the AJAX request:", 'err');
        }
        });

    }
    </script> 
</body>

</html>