<div class="container">
  <div class="row">
    <div class="col-12">
        <div class="card-container " style='background-color: rgba(0,0,0,.4)'>
    <div class="w-100 d-flex justify-content-between align-items-center ">

    <img style='' class='br-primary 'src='' id='background-channel'/>
    <div class='end'>
    <h1 class='fs-32 p-3'>Welcome</h1>
    <?php include 'loadAnimation.php' ?>
    </div>
    </div>
          <main class="main-content">
            <h1 class='mt-5'><a href="#" class='fw-bold' id='channel-name'></a></h1>
            <p class='mt-3' id='channel-description'></p>
            <div class="flex-row">
              <div class="coin-base">
                <span id='number-follow'></span>
              </div>
              <div class="time-left">
              </div>
            </div>
          </main>
          <div class="card-attribute ">
            <img src="" id='avatar-username'alt="avatar" style='width: 4rem; height: 4rem; border-radius: 50%;'class="small-avatar"/>
            <p>Creation of <span><a href="#" class='fw-bold fs-32 ml-2' style='color: #42a5f5'id='username-channel'></a></span></p>
          </div>
          <div class="w-100 end" >
              <button class='button-animation' onclick='redirectLink("user/channel/?active=edit")'>
                <span></span>
                <span></span>
                <span></span>
                <span></span> Edit channel
              </button>
              </div>
          </div>
    </div>
    </div>
  </div>
</div>