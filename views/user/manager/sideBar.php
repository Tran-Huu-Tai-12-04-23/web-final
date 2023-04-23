<div class="w-100 ">
<div class="avatar-admin d-flex justify-content-between align-items-center hover-bg p-2 br-primary position-relative mb-5 w-100" id='open-menu'>
        <div class='start w-100' >
            <div class='w-40px d-flex justify-content-center align-items-center p-3 br-primary fs-18' style='background-color: #fccf04' >A</div>
            <h5 class='fs-14 cl ml-2 mr-4'>My workspace</h5>
        </div>
        
        <div class="end">
            <i class='bx bx-expand-vertical fs-24 cl-second' ></i>
            <i class='bx bx-chevron-left fs-24 cl-second icon-arrow'  ></i>
        </div>

        <div id='menu' class=" position-absolute p-2  br-primary hidden" style='min-width: 20rem;top: 5rem; left: 0%; background-color: #3e5163;backdrop-filter:blur(2rem);animation: fadeLeft 0.5s cubic-bezier(0.11, 1.1, 0.74, 1.11) forwards;z-index:20000000000000000; '>
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

<div class="border-bottom mt-4  mb4 w-100"></div>


<div class="w-100">
    <ul class='sidebar-wrapper'>
        <li class='start  active-sidebar item-sidebar item-sidebar-overview' onclick='switchSidebar("overview")'><i class='bx fs-32  mr-2 bxl-stack-overflow'></i><span>Overview</span></li>
        <li class='start item-sidebar item-sidebar-content' onclick='switchSidebar("content")'><i class='bx fs-32  mr-2 bx-book-content' ></i><span>Content</span></li>
        <li class='start item-sidebar item-sidebar-statistical'onclick='switchSidebar("statistical")'><i class='bx fs-32  mr-2  bxl-deezer' ></i><span>Statistical</span></li>
        <li class='start item-sidebar item-sidebar-comment' onclick='switchSidebar("comment")'><i class='bx fs-32  mr-2  bx-comment' ></i><span>Comment</span></li>
        <li class='start item-sidebar item-sidebar-upload' onclick='switchSidebar("upload")'>
            <i class='bx bx-upload  fs-32  mr-2' ></i>
            <span>Upload</span>
        </li>
        <li class='start item-sidebar item-sidebar-edit' onclick='switchSidebar("edit")'>
            <i class='bx bx-edit-alt  fs-32  mr-2' ></i>
            <span>Edit</span>
        </li>
    </ul>
</div>