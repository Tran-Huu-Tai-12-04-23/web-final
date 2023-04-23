<div class=" w-100 bg-second p-4 cl " style='height: 100vh; min-width: 20rem;position:relative; z-index:1000' >
    <div class="avatar-admin d-flex justify-content-between align-items-center hover-bg p-2 br-primary position-relative mb-5" id='menu-sidebar-admin'>
        <div class='start'>
            <div class='w-40px d-flex justify-content-center align-items-center p-3 br-primary fs-18' style='background-color: #fccf04' >A</div>
            <h5 class='fs-14 cl ml-2 mr-4'>My workspace</h5>
        </div>
        <div class="end">
            <i class='bx bx-expand-vertical fs-24 cl-second' ></i>
            <i class='bx bx-chevron-left fs-24 cl-second icon-arrow'  ></i>
        </div>

        <div class="menu position-absolute p-2  br-primary hidden" style='min-width: 20rem;top: 1rem; left: 0%; background-color: #3e5163;backdrop-filter:blur(2rem);animation: fadeLeft 0.5s cubic-bezier(0.11, 1.1, 0.74, 1.11) forwards;z-index:20000000000000000;transform:translateX(-100px) '>
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
    <?php include 'search.php'?>
    <div class="w-100 column mt-5 border-top p-4">
        <div class="w-100 start br-primary bt-primary bg-transparent active-navbar item-sidebar-admin item-sidebar-admin-dashboard" onclick='switchActive("dashboard")'>
            <i class='bx bx-home-alt-2 fs-24 cl ' ></i>
            <span class='fs-16 cl ml-2 mt-2'>Dashboard</span>
        </div>
        <div class="w-100 start br-primary mt-3 bt-primary bg-transparent item-sidebar-admin item-sidebar-admin-user" onclick='switchActive("user")'>
            <i class='bx bx-user fs-24 cl ' ></i>
            <span class='fs-16 cl ml-2 mt-2'>Users</span>
        </div>
        <div class="w-100 start br-primary  mt-3 bt-primary bg-transparent item-sidebar-admin item-sidebar-admin-video" onclick='switchActive("video")'>
            <i class='bx bx-video fs-24 cl ' ></i>
            <span class='fs-16 cl ml-2 mt-2'>Videos</span>
        </div>
        <div class="w-100 border-top mt-4 mb-4" ></div>
        <div class="w-100  start br-primary bt-primary mt-3  bg-transparent item-sidebar-admin  position-relative item-sidebar-admin-user-block" onclick='switchActiveSidebarMultiPage("user-block")'>
            <i class='bx bx-block fs-24 cl ' ></i>
            <span class='fs-16 cl ml-2 mt-2'>Users blocked</span>
            <div id='number-user-block' class="fs-12 position-absolute rounded-circle p-2 center" style='background-color:#f97924; top: 0rem; left: 0rem; width: 2rem; height: 2rem'>
            </div>
        </div>
        <div class="w-100  start br-primary bt-primary mt-3  bg-transparent item-sidebar-admin position-relative item-sidebar-admin-user-trash" onclick='switchActiveSidebarMultiPage("user-trash")'>
            <i class='bx bx-trash-alt fs-24 cl ' ></i>
            <span class='fs-16 cl ml-2 mt-2'>Users trash</span>
            <div id='number-user-delete' class="fs-12 number-user-deleted position-absolute rounded-circle p-2 center" style='background-color:#f97924; top: 0rem; left: 0rem; width: 2rem; height: 2rem'>
            </div>
        </div>
        <div class="w-100  start br-primary bt-primary mt-3  bg-transparent item-sidebar-admin  position-relative item-sidebar-admin-video-trash" onclick='switchActiveSidebarMultiPage("video-trash")'>
            <i class='bx bx-trash-alt fs-24 cl ' ></i>
            <span class='fs-16 cl ml-2 mt-2'>Videos trash</span>
            <div id='number-video-delete'class="fs-12 position-absolute rounded-circle p-2 center" style='background-color:#f97924; top: 0rem; left: 0rem; width: 2rem; height: 2rem'>
            </div>
        </div>
    </div>
</div>