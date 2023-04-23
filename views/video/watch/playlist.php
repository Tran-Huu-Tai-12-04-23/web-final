<div  class='position-relative bg-second br-primary border mb-4 w-100 wrapper-playlist-video overflow-hidden' style='transition: .4s;height: 60rem'>
    <div class='w-100 p-4 h-40px  border-bottom' >
        <h1 class='fs-18 cl name-playlist'>
            Name playlist
        </h1>
        <i class='bx bx-x position-absolute hover_close fs-32 icon-hidden-play-list' onclick='handleClosePlayList()' style='top:.5rem; right: .5rem'></i>
        <i class='bx bx-chevron-down position-absolute hover_close fs-32 hidden icon-show-play-list' onclick='handleShowPlaylist()' style='top:.5rem; right: .5rem'></i>
    </div>
    <div id="wrapper-playlist" class='column p-4 hidden-scroll w-100' style='height: calc(60rem - 40px);overflow: scroll'>
    </div>
</div>



