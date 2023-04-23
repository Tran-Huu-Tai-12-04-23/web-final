<div class="w-75  d-flex justify-content-center align-items-center  center p-5">
    <div class="card-profile p-5">
        <div class="infos">
            <div class="image wrapper-avatar " style='width: unset' id='wrapper-avatar'>
                <img class="avatar_profile" src='<?php print  $Util->getAvatar($avatar) ?>' id='avatar-user'>
                </img>
                <i class='bx bx-edit-alt icon-edit-avatar cl' id='icon-edit-avatar'></i>
            </div>
            <div id='button-save-avatar' class='hidden h-100 d-flex align-items-end' style='cursor:pointer'>
                <i class='bx bx-save fs-24 cl parent-suggest icon-save hover-bg p-2 br-primary hover-cl-success'>
                    <div class='child-suggest'>Save</div>
                </i>
            </div>
            <div class="info fs-18">
                <h1 class="fs-18 cl center">
                    <?php print $data['full_name']?>
                </h1>
                <div class="stats p-4 cl">
                        <p class=" fs-16 flex flex-col">
                            Videos
                            <span class=" mt-3 state-value fs-14">
                                34
                            </span>
                        </p>
                        <p class="flex fs-16 ">
                            Followers
                            <span class="fs-14 mt-3 state-value">
                                455
                            </span>
                        </p>
                </div>
            </div>
        </div>
        <div class="w-100 user-information cl fs-14 mt-5 mb-5">
            <ul>
                <li>
                    <div>
                        <i class='bx bx-user-circle'></i>
                        <span>Full Name</span>
                    </div>
                    <h1><?php print $data['full_name']?></h1>
                </li>
                <li>
                    <div>
                        <i class='bx bx-envelope'></i>
                        <span>Email</span>
                    </div>
                    <h1><?php print $data['email']?></h1>
                </li>
                <li>
                    <div>
                        <i class='bx bx-phone'></i>
                        <span>Phone Number</span>
                    </div>
                    <h1><?php print $data['phone_number']?></h1>
                </li>
                <li>
                    <div>
                        <i class='bx bx-home-alt'></i>
                        <span>Address</span>
                    </div>
                    <h1><?php print $data['address']?></h1>
                </li>
            </ul>
        </div>
        <div class="w-50 center">
            <button class="br-primary bt-primary h-40px center w-25 btn-edit-profile fs-16" type="button">
                    Edit Profile
            </button>
        </div>
    </div>

</div>

