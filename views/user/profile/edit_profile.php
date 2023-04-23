<div class="wrapper_edit-profile d-flex justify-content-center align-items-center  p-5 h-100 w-75">
            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <form action="<?php echo BASE_URL.'?action=update-profile&data='.$userId;?>" method="POST"
                            enctype="multipart/form-data" id="form__update_profile__validate">
                            <div class="container w-100">
                                <div class="row justify-content-center w-100">
                                    <div class="text-field w-100 mt-2 mb-5 ">
                                        <input autocomplete="off" class=' cl fs-14' type="text" name='full_name'
                                            placeholder="Enter your full Name" rules="required|min:6"
                                            value='<?php print $data['full_name']?>' />
                                        <label for="full_name" class=' cl fs-14'>Full Name</label>
                                        <div class="show__validation  error h-20px mt-2">
                                        </div>
                                    </div>
                                    <div class="text-field w-25 mt-2 mb-5 ">
                                        <input autocomplete="off" class='cl fs-14 h-50px' type="date"
                                            name='date_of_birth' rules="required"
                                            value="<?php print $data['date_of_birth']?>" />
                                        <label for="date_of_birth" class='  cl fs-14'>Day Off
                                            Birth</label>
                                        <div class="show__validation  error h-20px mt-2">
                                        </div>
                                    </div>
                                    <div class="text-field w-75 mt-2 mb-5 ">
                                        <input autocomplete="off" class='cl fs-14 h-50px' type="email" name='email'
                                            placeholder="Enter your email" rules="required|email"
                                            value="<?php print $data['email']?>" />
                                        <label for="email" class='  cl fs-14'>Email address</label>
                                        <div id="emailHelp" class="form-text">We' ll never share your email with anyone
                                            else.</div>
                                        <div class="show__validation  error h-20px mt-2">
                                        </div>
                                    </div>
                                    <div class="text-field w-25 mt-2 mb-5 ">
                                        <input autocomplete="off" class='cl fs-14' type="text" name='phone_number'
                                            placeholder="Enter your phone number" rules="required|phone"
                                            value="<?php print $data['phone_number']?>" />
                                        <label for=" phone_number" class=' cl fs-14'>Phone
                                            Number</label>
                                        <div class="show__validation  error h-20px mt-2">
                                        </div>
                                    </div>
                                    <div class="text-field w-75 mt-2 mb-5 ">
                                        <input autocomplete="off" class='cl fs-14' type="text" name='address'
                                            placeholder="Enter your address" rules="require"
                                            value="<?php print $data['address']?>" />
                                        <label for=" address" class='  cl fs-14'>Address
                                        </label>
                                        <div class="show__validation  error h-20px mt-2">
                                        </div>
                                    </div>
                                    
                                    <div class="w-50 center">
                                        <button type='submit'
                                            class="bt-primary  br-primary mr-2 hover-border w-25 center">
                                            <span class="fs-18 mr-2">Save</span>
                                            <i class=' bx bx-right-arrow-alt'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>