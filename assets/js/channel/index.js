function loadVideoOnChannel(limit, userId, data, index) {
  let mainVideo = $("#main-video-channel");
  data.map((video) => {
    let newItem = $(`
            <div class="col-xl-2 col-lg-3 col-md-4 col-6" onclick='redirectLink("watch?data=${
              video.video_id
            }")'>
            <div class="item-most-watched mb-4 br-primary overflow-hidden ">
                <img class='${video.title}' src='${getThumbnails(
      video.thumbnails
    )}'/>
                <div class="item-most-watched-content">
                    <img class='avatar-user-item box-shadow'src="${
                      video.profile_picture
                    }" />
                    <span class='fs-12 cl-second'>${video.username}</span>
                    <h1 class='fs-16 cl mt-2 mb-2 title-card'>${
                      video.title
                    }</h1>
                    <h5 class='fs-12 cl-second'>${formatTime(
                      video.upload_date
                    )}</h5>
                </div>
              </div>
          </div>
          `);
    if (index == 24) {
      newItem = $(
        '<div id="more-main-video" class="more pb-5 pt-5 center fs-16"><button class=" bt-primary bg-button-primary">More</button></div>'
      );
    } else if (index > 24) {
      newItem.click(function () {
        let loadMore = $('<div class="load-more mt-4 p-4"></div>');
        mainVideo.append(loadMore);
        $(this).remove();
        setTimeout(() => {
          getVideoOnUserChannel(limit + 24, userId, "not-normal");
          loadMore.remove();
        }, 1000);
      });
      mainVideo.append(newItem);
    } else {
      mainVideo.append(newItem);
    }
  });
}
function getVideoOnUserChannel(limit, userId, index = 0) {
  $.ajax({
    type: "POST",
    url: getBaseURL() + "?action=get-video-on-user",
    data: {
      id: userId,
      limit: limit,
    },
    dataType: "json",
    success: function (response) {
      if (response.status === true) {
        loadVideoOnChannel(limit, userId, JSON.parse(response.data), index);
        return;
      } else {
        let notification = $(`<div>
        <h1 class='fs-16 cl mt-4' style='color: #bf3358!important'>No video upload</h1>
      </div>`);
        $("#main-video-channel").append(notification);
        // window.location.href = getBaseURL() + "not-found";
      }
    },
    err: function (response) {
      addNotification("Server is error: ", "error");
    },
  });
}

function loadChannelInformation(userId) {
  getChannelInformation(userId);
}

function getChannelInformation(userId) {
  $.ajax({
    type: "POST",
    url: getBaseURL() + "?action=get-information-channel",
    data: {
      id: userId,
    },
    dataType: "json",
    success: function (response) {
      if (response.status === true) {
        loadDataChannel(response.data);
        return;
      } else {
        // window.location.href = getBaseURL() + "not-found";
      }
    },
    err: function (response) {
      addNotification("Server is error: ", "error");
    },
  });
}
function loadDataChannel(data) {
  data = JSON.parse(data);
  $("#thumbnail-my-video").css(
    "background-image",
    `url(${getDefaultBackground(data.background)})`
  );
  $("#avatar-user-channel").prop("src", getAvatar(data.profile_picture));
  $("#channel-name").text(data.channel_name);
  $("#follower-channel").text(
    data.num_followers == null
      ? 0 + " Followers"
      : data.num_followers + " Followers"
  );
  $("#descriptions-channel").text(data.channel_description);
}

function handleNavBarWhenScrollChannel() {
  let screenHeight = window.screen.height;
  if ($(window).scrollTop() >= screenHeight / 1.8) {
    $("#header-fixed-channel").addClass("header-fixed-channel");
    $("#header-fixed-channel").removeClass("header-not-fixed-channel");
  }
  if ($(window).scrollTop() < screenHeight / 3) {
    $("#header-fixed-channel").removeClass("header-fixed-channel");
    $("#header-fixed-channel").addClass("header-not-fixed-channel");
  }
}

function switchNavbar(nameNavBar = "") {
  switch (nameNavBar) {
    case "video": {
      $(".item-navbar").removeClass("active-line");
      $(".video-item-navbar").addClass("active-line");
      $("#playlist-channel").addClass("hidden");
      $("#video-channel").removeClass("hidden");
      activeNavbar("");
      return;
    }
    case "playlist": {
      $(".item-navbar").removeClass("active-line");
      $(".playlist-item-navbar").addClass("active-line");
      $("#video-channel").addClass("hidden");
      $("#playlist-channel").removeClass("hidden");
      activeNavbar("playlist");
      return;
    }
    default: {
      return;
    }
  }
}

// load play list
function loadPlayList(limit, userId, data, video_id = 0, index) {
  let mainVideo = $("#main-playlist");
  data.map((video) => {
    let newItem = $(`
      <div class="col-xl-2 col-lg-3 col-md-6 col-12 pb-2" style='cursor: pointer' onclick='redirectLink("watch?data=${video_id}&playlist_id=${
      video.playlist_id
    }")'>
        <div class='item-playlist cl overflow-hidden w-100'>
            <img src='${getThumbnails(video.thumbnails_playlist)}'/>
            <div class='name-play-list'>
                ${video.playlist_name}
            </div>
            <div class='number-video-play-list'>
                <span> ${video.num_videos}</span>
                <i class='bx bx-list-ul fs-24' ></i>
            </div>
        </div>
    </div>        
    `);
    if (index == 24) {
      newItem = $(
        '<div id="more-main-video" class="more pb-5 pt-5 center fs-16"><button class=" bt-primary bg-button-primary">More</button></div>'
      );
    } else if (index > 24) {
      newItem.click(function () {
        let loadMore = $('<div class="load-more mt-4 p-4"></div>');
        mainVideo.append(loadMore);
        $(this).remove();
        setTimeout(() => {
          getVideoOnUserChannel(limit + 24, userId, "not-normal");
          loadMore.remove();
        }, 1000);
      });
      mainVideo.append(newItem);
    } else {
      mainVideo.append(newItem);
    }
  });
}
function getPlaylistOnUser(limit, userId, index = 0) {
  $.ajax({
    type: "POST",
    url: getBaseURL() + "?action=get-playlist-on-user",
    data: {
      id: userId,
      limit: limit,
    },
    dataType: "json",
    success: function (response) {
      if (response.status === true) {
        let videoId = response.video_id;
        loadPlayList(limit, userId, response.data, videoId, index);
        return;
      } else {
        let notification = $(`<div>
            <h1 class='fs-16 cl mt-4' style='color: #bf3358!important'>No video playlist</h1>
          </div>`);
        $("#main-playlist").append(notification);
      }
    },
    err: function (response) {
      addNotification("Server is error: ", "error");
    },
  });
}
