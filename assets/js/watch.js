$(document).ready(function () {
  activeNavbar();
  $(".show-action-relative").click(function (e) {
    e.stopPropagation();
    activeItem($(".main-content-modal"));
  });
  $(".icon-close-modal").click(function () {
    $(".main-content-modal").addClass("hidden");
    $(".wrapper-modal").addClass("hidden");
  });
  $(".main-content-modal").click((e) => {
    e.stopPropagation();
  });
  $(window).click(function () {
    $(".main-content-modal").addClass("hidden");
  });
  $(".add-playlist").click(function () {
    let newModalAddPlayList = $(
      "<div class='wrapper-modal'><div class='main-content-modal p-4 br-primary' ></div></div>"
    );
  });

  // hadnle add paly list
  $(".modal-save-into-play-list").click(function (e) {
    e.stopPropagation();
  });

  $("#create-new-playlist").click(function (e) {
    $(this).addClass("hidden");
    $(".action-add-cancel-playlist").removeClass("hidden");
    $("#input-name-play-list").removeClass("hidden");
  });
  // hidden when cancel add playlist
  $("#cancel-add-play-list").click(function () {
    $(".action-add-cancel-playlist").addClass("hidden");
    $("#input-name-play-list").addClass("hidden");
    $("#create-new-playlist").removeClass("hidden");
  });

  $("#save-into-play-list").click(function () {
    let namePlaylist = $("#input-name-play-list").children("input").val();
    $("#input-name-play-list").children("input").val("");
    let userId = $(this).attr("us-id");
    let videoId = $(this).attr("vi-id");
    if (namePlaylist === "") {
      addNotification("Please enter name play list!!!", "err");
      return;
    }
    $(".wrapper-modal").addClass("hidden");
    let data = {
      user_id: userId,
      video_id: videoId,
      name_playlist: namePlaylist,
    };
    addPlayListAndVideoToPlayList(data);
  });

  // /handle checkbox name playList
  $(document).on("change", ".name-playlist", function (e) {
    // $(this).prop("checked", !$(this).prop("checked"));
    let userId = $("#your-playlist").attr("us-id");
    let videoId = $("#your-playlist").attr("vi-id");
    let data = {
      user_id: userId,
      video_id: videoId,
      name_playlist: $(this).val(),
    };
    if ($(this).prop("checked")) {
      addIntoPlayList(data);
    } else {
      removeFromPlaylist(data);
    }
  });
});
let isLoadPlayList = 0;
function handleOpenModalAddPlayList(userId, video_id) {
  $(".wrapper-modal").removeClass("hidden");
  $(".main-content-modal").addClass("hidden");
  if (isLoadPlayList === 0) {
    getPlaylists(userId);
  }
  isLoadPlayList = 1;
}
function addIntoPlayList(data) {
  $.ajax({
    url: getBaseURL() + "?action=add-video-to-playlists",
    method: "POST",
    data: data,
    dataType: "json",
    success: function (response) {
      if (response.status == true) {
        addNotification(response.message, "success");
      } else {
        addNotification(response.message, "err");
      }
    },
  });
}
function removeFromPlaylist(data) {
  $.ajax({
    url: getBaseURL() + "?action=remove-video-from-playlists",
    method: "POST",
    data: data,
    dataType: "json",
    success: function (response) {
      if (response.status == true) {
        addNotification(response.message, "warn");
      } else {
        addNotification(response.message, "err");
      }
    },
  });
}

function addPlayListAndVideoToPlayList(data) {
  $.ajax({
    url: getBaseURL() + "?action=cerate-add-into-playlist",
    method: "POST",
    data: data,
    dataType: "json",
    success: function (response) {
      if (response.status == true) {
        $(".action-add-cancel-playlist").addClass("hidden");
        $("#input-name-play-list").addClass("hidden");
        $("#create-new-playlist").removeClass("hidden");
        addNotification(response.message, "success");
        let namePlaylist = response.data;
        addNewPlaylist(namePlaylist);
      } else {
        addNotification(response.message, "err");
      }
    },
  });
}

function getPlaylists(userID) {
  $.ajax({
    url: getBaseURL() + "?action=get-playlists",
    method: "GET",
    data: {
      id: userID,
    },
    dataType: "json",
    success: function (response) {
      console.log(response);
      if (response.status == true) {
        if (response.data) {
          loadPlayList(JSON.parse(response.data));
        }
      } else {
        addNotification(response.message, "err");
      }
    },
  });
}
function loadPlayList(data) {
  let yourPlaylist = $("#your-playlist");
  console.log(data);
  data.map((namePlaylist, index) => {
    let newPlaylist = $(`
        <div class=' w-100   d-flex justify-content-start align-items-center h-40px mb-3 pb-5 '> 
          <div class="checkbox-wrapper-12">
              <div class="cbx">
                  <input class="cbx-12 name-playlist" value='${namePlaylist}' name='name-playlist' type="checkbox">
                  <label for="cbx-12"></label>
                  <svg width="15" height="14" viewBox="0 0 15 14" fill="none">
                  <path d="M2 8.36364L6.23077 12L13 2"></path>
                  </svg>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
                  <defs>
                  <filter id="goo-12">
                      <feGaussianBlur in="SourceGraphic" stdDeviation="4" result="blur"></feGaussianBlur>
                      <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" result="goo-12"></feColorMatrix>
                      <feBlend in="SourceGraphic" in2="goo-12"></feBlend>
                  </filter>
                  </defs>
              </svg>
          </div>
          <div class='ml-2 fs-16 cl'>${namePlaylist}</div>
          <div>
        </div>
        </div> 
  `);
    yourPlaylist.append(newPlaylist);
  });
}

function addNewPlaylist(namePlaylist) {
  let yourPlaylist = $("#your-playlist");
  let newPlaylist = $(`
        <div class=' w-100   d-flex justify-content-start align-items-center h-40px mb-3 pb-5 '> 
          <div class="checkbox-wrapper-12">
              <div class="cbx">
                  <input class="cbx-12 name-playlist"value='${namePlaylist}' name='name-playlist' type="checkbox">
                  <label for="cbx-12"></label>
                  <svg width="15" height="14" viewBox="0 0 15 14" fill="none">
                  <path d="M2 8.36364L6.23077 12L13 2"></path>
                  </svg>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
                  <defs>
                  <filter id="goo-12">
                      <feGaussianBlur in="SourceGraphic" stdDeviation="4" result="blur"></feGaussianBlur>
                      <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" result="goo-12"></feColorMatrix>
                      <feBlend in="SourceGraphic" in2="goo-12"></feBlend>
                  </filter>
                  </defs>
              </svg>
          </div>
          <div class='ml-2 fs-16 cl'>${namePlaylist}</div>
          <div>
        </div>
        </div> 
  `);
  yourPlaylist.append(newPlaylist);
}
function followUser(userId, userIdGuest) {
  $.ajax({
    url: getBaseURL() + "?action=follow-user",
    method: "POST",
    data: {
      user_id: userId,
      guest_id: userIdGuest,
    },
    dataType: "json",
    success: function (response) {
      if (response.status == true) {
        if (response.type == 0) {
          increaseFollowerCount(1);
        } else {
          increaseFollowerCount(-1);
        }
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

function increaseFollowerCount(number) {
  let numberFollowerCount = +$(".follow-number").text().split(" ")[0];
  $(".follow-number").text(numberFollowerCount + number + " followers");
  let btnFollow = $(".btn-follow-user");
  if (number < 1) {
    $(".btn-un-follow-user").removeClass("hidden");
    $(".btn-follow-user").addClass("hidden");
  } else {
    $(".btn-un-follow-user").addClass("hidden");
    $(".btn-follow-user").removeClass("hidden");
  }
}

function handleUserLikeVideo(userId, videoId) {
  $.ajax({
    url: getBaseURL() + "?action=like-video",
    method: "PUT",
    data: {
      user_id: userId,
      video_id: videoId,
    },
    dataType: "json",
    success: function (response) {
      if (response.status == true) {
        if (response.type == 0) {
          likeVideo(1);
        } else {
          unLikeVideo(-1);
        }
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

function likeVideo(count) {
  $(".icon-like ").addClass("active-like");
  updateLike(count);
}
function unLikeVideo(count) {
  $(".icon-like ").removeClass("active-like");
  updateLike(count);
}

function updateLike(count) {
  let numberLike = +$(".number-like").text().split(" ")[0] + count + " likes";
  $(".number-like").text(numberLike);
}

function shareOnFacebook() {
  let currentUrl = window.location.href;
  var url = "https://www.facebook.com/sharer/sharer.php?u=" + currentUrl;
  if (currentUrl.includes("localhost")) {
    addNotification(
      "Link website run on localhost since You can't share this on facebook",
      "err"
    );
  } else {
    window.open(url, "_blank");
  }
}

function shareOnInstagram() {
  let currentUrl = window.location.href;
  // var url = "https://www.instagram.com/yourpage";
  // window.open(url, "_blank");
}

// /laod video play list
function loadVideoPlayList(playListId) {
  $.ajax({
    type: "get",
    url: getBaseURL() + "?action=get-video-on-playlist",
    dataType: "json",
    data: {
      playlist_id: playListId,
    },
    success: function (response) {
      if (response.status) {
        loadVideoToPlayList(JSON.parse(response.data), playListId);
      } else {
        alert("Get slide video failed!!!");
      }
    },
  });
  function loadVideoToPlayList(data) {
    if (data.length > 0) {
      $(".name-playlist").text(data[0].playlist_name);
    }
    data.map((item, index) => {
      let newItem = $(`
      <div class="col-xl-11 mb-4 col-lg-11 br-primary item-slider-watch overflow-hidden" onclick='redirectLink("watch?data=${
        item.video_id
      }&playlist_id=${playListId}")'>
          <div class=" mb-4 br-primary d-flex justify-content-start" style=''>
              <img class='' src='${item.thumbnails}'/>
              <div class="item-most-watched-content">
                  <h1 class='fs-16 cl mt-2 title-card'>${item.title}></h1>
                  <div class='mt-2'>
                      <span class='fs-12-2 cl'>${item.username}</span>
                      <h5 class='fs-12 pt-2 cl-second'>${formatTime(
                        item.upload_date
                      )}</h5>
                  </div>
              </div>
          </div>
      </div>
      `);
      $("#wrapper-playlist").append(newItem);
    });
  }
}
