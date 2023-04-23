function getMode(mode) {
  return mode == 1 ? "Private" : "Public";
}
function editVideo(videoId) {
  showModalEditVideo(videoId);
}
function loadDataIntoTableVideoManager(userId, data, index, limit) {
  let tableManagerVideo = $("#main-table-video-on-user");
  data.forEach((video) => {
    let item = $(`
        <tr id='row-video-${video.video_id}'>
        <td><input type='checkbox' name='video-select' class= ' hidden mr-3 w-40px'/>${index}</td>
        <td>${video.title}</td>
        <td>${video.num_comments}</td>
        <td>${video.num_likes}</td>
        <td>${getMode(video.mode_private)}</td>
        <td>${formatTime(video.upload_date)}</td>
        <td class=''>
          <div class='bt-primary bg-transparent br-primary ' onclick='handleRemoveVideo(${
            video.video_id
          })'>
              Remove
          </div>
          <div class="bt-primary ml-3" onclick='showModalEditVideo(${
            video.video_id
          })'>
              Edit
          </div>
        </td>
        </tr>

        `);
    if (index === 16) {
      let btnMore = $(
        `<div colspan='3' class="bt-primary bg-transparent">More</div>`
      );
      btnMore.click(function () {
        getVideoUploadByUser(userId, limit + 16, index);
        $(this).remove();
      });
      tableManagerVideo.append(btnMore);
    } else {
      tableManagerVideo.append(item);
    }
    index++;
  });
}

function getVideoUploadByUser(userId, limit = 0, index = 0) {
  $.ajax({
    type: "get",
    url: getBaseURL() + "?action=get-video-upload-by-user",
    data: {
      id: userId,
      limit: limit,
    },
    dataType: "json",
    success: function (response) {
      if (response.status) {
        loadDataIntoTableVideoManager(
          userId,
          JSON.parse(response.data),
          index,
          limit
        );
      } else {
        let notification = $(`<div>
          <h1 class='fs-16 cl mt-4' style='color: #bf3358!important'>No video uploaded</h1>
        </div>`);
        $("#main-table-video-on-user").append(notification);
        // alert("Get video upload by user failed!!!");
      }
    },
  });
}

function handleRemoveVideo(videoId) {
  let modal = $(`<div class='full' >
    <div class='br-primary p-4 bg-second position-absolute' style='top: 10rem; left: 50%; transform: translateX(-50%);min-width: 40rem'>
        <h1 class='p-4 fs-16'>Are you sure remove?</h1>
        <div class='w-100 border-bottom'></div>
        <div class='w-100 end mt-4'>
            <div class='bt-primary mr-3 bg-transparent'>Cancel</div>
            <div class='bt-primary' onclick='destroyVideo(${videoId})'>Accept</div>
        </div>
    </div>
  </div>`).appendTo($("body"));

  modal.click(function () {
    $(this).remove();
  });
}

function destroyVideo(videoId) {
  $.ajax({
    type: "POST",
    url: getBaseURL() + "?action=destroy-video",
    data: {
      video_id: videoId,
    },
    dataType: "json",
    success: function (response) {
      if (response.status == true) {
        $(`#row-video-${videoId}`).remove();
        addNotification("Remove video successfully!!", "success");
      } else {
        addNotification("Remove video fail!!", "err");
        return false;
      }
    },
  });
}

function showModalEditVideo(videoId) {
  $("#modal-edit-video").removeClass("hidden");
  getVideoEdit(videoId);
}

function getVideoEdit(videoId) {
  $.ajax({
    type: "POST",
    url: getBaseURL() + "?action=get-video-by-id",
    data: {
      video_id: videoId,
    },
    dataType: "json",
    success: function (response) {
      if (response.status == true) {
        loadDataToFormEdit(JSON.parse(response.data));
      } else {
        return false;
      }
    },
  });
}

function loadDataToFormEdit(video) {
  $("#title").val(video.title);
  $("#description").val(video.description);
  $("#preview-thumbnail").prop("src", getThumbnails(video.thumbnails));
  $("#preview-video").prop("src", getVideoUrl(video.url));
  $("#mode").val(video.mode_private);
  $("#btn-save-edit-video").attr("vd-id", video.video_id);
}

function saveDataVideoEdit(formData) {
  $.ajax({
    type: "post",
    url: getBaseURL() + "?action=save-video-edit",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      response = JSON.parse(response);
      if (response.status) {
        addNotification("Update video successfully!!", "success");
        $("#modal-edit-video").addClass("hidden");
        window.location.href = getBaseURL() + "user/channel?active=content";
      } else {
        addNotification("Update video failed!!", "err");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // handle error
    },
  });
}

function loadInformationOnChannel(userId) {
  $.ajax({
    type: "POST",
    url: getBaseURL() + "?action=get-information-channel",
    data: {
      id: userId,
    },
    dataType: "json",
    success: function (response) {
      data = response.data;
      if (response.status) {
        data = JSON.parse(data);
        $("#background-channel").prop("src", getThumbnails(data.background));
        $("#background-channel-edit").prop(
          "src",
          getThumbnails(data.background)
        );
        $("#preview-background-channel").prop(
          "src",
          getThumbnails(data.background)
        );
        $("#preview-background-channel-edit").prop(
          "src",
          getThumbnails(data.background)
        );
        console.log(data.background);
        $("#channel-name").text(data.channel_name);
        $("#channel-name-edit").val(data.channel_name);
        $("#channel-description").text(data.channel_description);
        $("#channel-description-edit").val(data.channel_description);
        $("#number-follow").text(data.num_followers + " followers");
        $("#username-channel").text(data.username);
        $("#username-channel-edit").text(data.username);
        $("#avatar-username").prop("src", getAvatar(data.profile_picture));
      } else {
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // handle error
    },
  });
}

function switchSidebar(name = "overview") {
  $(".item-sidebar").removeClass("active-sidebar");
  $(".switch-manager").addClass("hidden");
  switch (name) {
    case "overview": {
      $(".item-sidebar-overview").addClass("active-sidebar");
      $("#overview").removeClass("hidden");
      break;
    }
    case "content": {
      $(".item-sidebar-content").addClass("active-sidebar");
      $("#content").removeClass("hidden");
      break;
    }
    case "statistical": {
      $(".item-sidebar-statistical").addClass("active-sidebar");
      $("#statistical").removeClass("hidden");
      break;
    }
    case "comment": {
      $("#comment").removeClass("hidden");
      $(".item-sidebar-comment").addClass("active-sidebar");
      break;
    }
    case "edit": {
      $(".item-sidebar-edit").addClass("active-sidebar");
      $("#edit-channel").removeClass("hidden");
      break;
    }
    case "upload": {
      $(".item-sidebar-upload").addClass("active-sidebar");
      $("#upload").removeClass("hidden");
      break;
    }
  }
}

// handle edit channel
