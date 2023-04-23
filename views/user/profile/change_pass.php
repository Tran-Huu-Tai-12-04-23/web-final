<form action='' method='POST' class="form-change-pass w-25 p-5 h-100  d-flex justify-content-center align-items-center flex-column" style='min-width:40rem;'>
    <div class="text-field w-100 mt-2 mb-5 ">
        <input autocomplete="off" class=' cl fs-14' type="hidden" name='ol'
        placeholder="Enter your full Name" rules="required|min:6"
        id='full-name'
         />
        <!-- <label for="full_name" class=' cl fs-14'>Password old</label> -->
    </div>
    <div class="text-field w-100 mt-2 mb-5 position-relative">
        <input autocomplete="off" class='input cl fs-14' type="password" name='new-password'
        placeholder="Enter your Password" rules="required|min:6"
        id='new-password'
        value='' />
        <label for="new-password" class=' cl fs-14'>New Password</label>
        <i class='bx bx-lock-alt   fs-24 cl position-absolute hover icon-unlock' style='top:50%;right:1rem; transform:translateY(-50%)'></i>
        <i class='bx bx-lock-open-alt hidden fs-24 cl position-absolute hover icon-lock' style='top:50%;right:1rem; transform:translateY(-50%)'></i>
    </div>
    <div class="text-field w-100 mt-2 mb-5 position-relative">
        <input autocomplete="off" class='input cl fs-14' type="password" name='confirm-new-password' id='confirm-new-password'
        placeholder="Enter your Confirm Password" rules="required|min:6"
        value='']?>' />
        <label for="confirm-new-password" class=' cl fs-14'>Confirm New Password</label>
        <i class='bx bx-lock-alt  fs-24 cl position-absolute hover icon-unlock' style='top:20%;right:1rem; transform:translateY(-50%)'></i>
        <i class='bx bx-lock-open-alt hidden fs-24 cl position-absolute hover icon-lock' style='top:20%;right:1rem; transform:translateY(-50%)'></i>
    </fo>

    <div class="w-50 center pt-5">
        <div class="bt-primary br-primary center w-25 bt-verify-new-pass center">
            Save
        </div>
    </div>

    <div class="wrapper-modal hidden">
        <div class="modal-custom center flex-column p-5">
            <i class='bx bx-x icon-close hover_close cl position-absolute'></i>
            <h1 class='fs-18 cl fw-bold mb-5 mt-3' > Please enter your old password to change new password!!</h1>
            <div class="text-field w-100 mt-5 mb-5 ">
                <input autocomplete="off" class=' cl fs-14' type="password" name='old-pass'
                placeholder="Enter your old password" rules="required|min:6"
                value='' id='old-password' />
                <label for="old-pass" class=' cl fs-14'>Your old password</label>
            </div>
            <div class="w-50 center">
                <div id='bt-save-change-pass'class="br-primary bt-primary w-25 h-40px " data-id='<?php print $userId;?>'>
                    Save
                </div>
            </div>
        </div>
    </div>
</div>