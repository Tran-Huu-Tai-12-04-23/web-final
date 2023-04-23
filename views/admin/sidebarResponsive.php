<div style='top: 0; left: 0;right: 0;height: 5rem' class="bg-second position-fixed">
        <div style='height: 5rem' class="d-flex justify-content-between m-0 p-0 align-items-center">
            <div class="pl-4">
                <i class='bx bx-menu fs-32 cl hover' id='open-menu-side-res'></i>
            </div>
            <div class="" style='width: 30rem ; height: 100%'>
                    <div class="avatar-admin d-flex justify-content-between align-items-center hover-bg p-2 br-primary position-relative mb-5" id='menu-sidebar-admin-2'>
                    <div class='start'>
                        <div class='w-40px d-flex justify-content-center align-items-center p-3 br-primary fs-18' style='background-color: #fccf04' >A</div>
                        <h5 class='fs-14 cl ml-2 mr-4'>My workspace</h5>
                    </div>
                    <div class="end">
                        <i class='bx bx-expand-vertical fs-24 cl-second' ></i>
                        <i class='bx bx-chevron-left fs-24 cl-second icon-arrow'  ></i>
                    </div>

                    <div class="menu position-fixed p-2  br-primary hidden" id='menu-responsive'style='min-width: 20rem;top: 1rem; right: 50remm; background-color: #3e5163;backdrop-filter:blur(2rem);animation: fadeLeft 0.5s cubic-bezier(0.11, 1.1, 0.74, 1.11) forwards;z-index:400; '>
                        <div class="bt-primary br-primary w-150px start fs-16" style='background: transparent' onclick='redirectLink("home")'>
                                <i class='bx bx-home-alt-2  mr-2' ></i>
                                <span>
                                    Home
                                </span>
                    </div>    
                    <div class="bt-primary br-primary w-150px start fs-16" style='background: transparent' onclick='switchActive("dashboard")'>
                        <i class='bx bx-home-alt-2  mr-2' ></i>
                        <span>
                            Dashboard
                        </span>
                    </div>
                    <div class="w-75 center border-top" style=''> </div>
                    <div class="bt-primary br-primary w-150px start fs-16" onclick='redirectLink("logout")' style='background: transparent'>
                        <i class='bx bx-log-out mr-2' ></i>
                        <span>
                            Log Out
                        </span>
                    </div>
                </div>
                </div>
            </div>
    </div>
</div>