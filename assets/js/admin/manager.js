$(document).ready(function () {
  // load user into manager users

  loadUser(0);
  function loadUser(limit, index = 0) {
    $.ajax({
      type: "get",
      url: getBaseURL() + "?action=get-users",
      data: {
        limit: limit,
      },
      dataType: "json",
      success: function (response) {
        if (response.status) {
          loadUserIntoTable(response.data, limit, index);
        } else {
          alert("Get users failed!!!");
        }
      },
    });
  }
  function loadUserIntoTable(data, limit, index) {
    data = JSON.parse(data);
    let tableManagerUsers = $("#table-manager-users");
    data.forEach((user, i) => {
      let className = "";
      let blocked = user.blocked;
      if (blocked == 1) {
        className = "disabled";
      }
      let classNameDeleted = "";
      if (user.deleted == 1) {
        classNameDeleted = "disabled";
      }

      let newRows = $(`
          <tr  class='' id='row-user-${user.user_id}' >
            <td>
            <div class="checkbox-wrapper-12 ml-2 select-show hidden" style='  vertical-align: middle !important; width: unset!important; height: unset'>
                <div class="cbx" style='width: 1rem; height: .5rem'>
                    <input class="cbx-12 user-select" value="${user.user_id}" name='user-select' type="checkbox">
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
                <span style='vertical-align: middle !important;''>${index}</h1>
            
            </td>
            <td><img src='${user.profile_picture}'></img></td>
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td>${user.phone_number}</td>
            <td class='d-flex justify-content-center align-items-center'>
              <div class='bt-primary w-60px mr-2 hover_close bg-transparent br-primary fs-14 ${className} bt-block-user user-block-${user.user_id}' onclick="handleBlockUser('${user.username}',${user.user_id})" style='color: #000'>Block</div>
              <div class='bt-primary w-60px mr-2 hover_close bg-transparent br-primary fs-14 ${classNameDeleted} bt-remove-user ' onclick="handleRemoveUser('${user.username}',${user.user_id})" style='color: #000'>Remove</div>
              <div class='bt-primary w-60px br-primary fs-14 bt-edit-user' onclick='handleEditUser("${user.user_id}")'>Edit</div>
            </td>
          </tr>
        `);
      if (i == 15) {
        let btnMore = $(
          '<div colspan="2" class="bt-primary  w-100 br-primary bg-transparent center fs-16">Show More</div>'
        );
        btnMore.click(function () {
          loadUser(limit + 15, index);
          $(this).remove();
        });
        tableManagerUsers.append(btnMore);
      } else {
        tableManagerUsers.append(newRows);
        index++;
      }
    });
  }

  $("#bt-confirm-block").click(function (e) {
    let userId = $(this).attr("us-id");
    cancelAction();
    blockUser(userId);
  });
  function blockUser(userId, type = "single") {
    $.ajax({
      type: "POST",
      url: getBaseURL() + "?action=block-user",
      data: {
        user_id: userId,
      },
      dataType: "json",
      success: function (response) {
        if (response.status == true) {
          let data = JSON.parse(response.data);
          $("#number-user-block").text(data[0].number_block);
          $(`.user-block-${userId}`).addClass("disabled");
          if (type == "single") {
            addNotification("Block user successfully!!", "success");
          } else {
            return true;
          }
        } else {
          addNotification("Block user fail!!", "err");
          return false;
        }
      },
    });
  }

  $("#btn-confirm-soft-delete").click(function (e) {
    let userId = $(this).attr("us-id");
    cancelAction();
    removeSoftUser(userId);
  });
  function removeSoftUser(userId, type = "single") {
    $.ajax({
      type: "POST",
      url: getBaseURL() + "?action=remove-soft-user",
      data: {
        user_id: userId,
      },
      dataType: "json",
      success: function (response) {
        if (response.status == true) {
          let data = JSON.parse(response.data);
          $("#number-user-delete").text(data[0].number_delete);
          $(`#row-user-${userId}`).remove();
          if (type == "single") {
            addNotification("Delete user successfully!!", "success");
          } else {
            return true;
          }
        } else {
          addNotification("Delete user fail!!", "err");
          return false;
        }
      },
    });
  }

  // handle filter manager user
  $("#btn-select-users").click(function () {
    activeItem($(".select-show"));
    $(this).addClass("hidden");
    $("#btn-cancel-select").removeClass("hidden");
  });
  $("#btn-cancel-select").click(function () {
    activeItem($(".select-show"));
    $(this).addClass("hidden");
    $("#btn-select-users").removeClass("hidden");
    $(".user-select").prop("checked", false);
    $("#action-all-user").addClass("hidden");
  });

  $("#select-all-users").change(function () {
    if ($(this).prop("checked") == true) {
      $(".user-select").prop("checked", true);
      $("#action-all-user").removeClass("hidden");
    } else {
      $(".user-select").prop("checked", false);
      $("#action-all-user").addClass("hidden");
    }
  });
  $(document).on("change", ".user-select", function () {
    $("#action-all-user").removeClass("hidden");
  });

  // hadnle select all item
  $("#bt-block-all-user").click(function () {
    var values = $('input[name="user-select"]:checked')
      .map(function () {
        return $(this).val();
      })
      .get();
    let res = [];
    values.map((userId) => {
      let respons = blockUser(userId, "all");
      res.push(respons);
    });
    if (res.includes(false)) {
      addNotification("Block user fail!!", "err");
    } else {
      addNotification("Block user successfully!!", "success");
      $(".user-select").prop("checked", false);
    }
  });

  $("#bt-remove-all-user").click(function () {
    var values = $('input[name="user-select"]:checked')
      .map(function () {
        return $(this).val();
      })
      .get();
    let res = [];
    values.map((userId) => {
      let respons = removeSoftUser(userId, "all");
      res.push(respons);
    });
    if (res.includes(false)) {
      addNotification("Delete user fail!!", "err");
    } else {
      addNotification("Delete user successfully!!", "success");
      $(".user-select").prop("checked", false);
    }
  });

  loadVideo(0);
  function loadVideo(limit, index = 0) {
    $.ajax({
      type: "get",
      url: getBaseURL() + "?action=get-video",
      data: {
        limit: limit,
      },
      dataType: "json",
      success: function (response) {
        loadVideoIntoTable(response, limit, index);
      },
    });
  }
  function loadVideoIntoTable(data, limit, index) {
    let tableManagerVideos = $("#table-manager-videos");
    data.forEach((video, i) => {
      let newRows = $(`
          <tr  class='' id='row-video-${video.video_id}' >
            <td>
            <div class="checkbox-wrapper-12 ml-2 select-show-video hidden" style='  vertical-align: middle !important; width: unset!important; height: unset'>
                <div class="cbx" style='width: 1rem; height: .5rem'>
                    <input class="cbx-12 video-select" value="${video.video_id}" name='video-select' type="checkbox">
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
                <span style='vertical-align: middle !important;''>${index}</h1>
            
            </td>
            <td><img style='height: 20rem;width: 20rem; border-radius: 1rem'src='${video.thumbnails}'></img></td>
            <td>${video.title}</td>
            <td > <h1 style='max-width: 80%'>${video.description}</h1></td>
            <td>${video.upload_date}</td>
            <td class=''>
              <div class='bt-primary w-60px mr-2 mb-2 hover_close   bg-transparent br-primary fs-14 bt-remove-user ' onclick="handleRemoveVideo('${video.video_id}',${video.video_id})" style='color: #000'>Remove</div>
            </td>
          </tr>
        `);
      if (i == 24) {
        let btnMore = $(
          '<div colspan="2" class="bt-primary w-100 br-primary bg-transparent center fs-16"  style="width: 200px!important">Show More</div>'
        );
        btnMore.click(function () {
          console.log(data.length);
          loadVideo(limit + 24, index);
          $(this).remove();
        });
        tableManagerVideos.append(btnMore);
      } else {
        tableManagerVideos.append(newRows);
        index++;
      }
    });
  }

  $("#btn-select-videos").click(function () {
    $(".select-show-video").removeClass("hidden");
    $(".select-all-show-video").removeClass("hidden");
    $("#btn-cancel-select-videos").removeClass("hidden");
    $(this).addClass("hidden");
  });
  $("#btn-cancel-select-videos").click(function () {
    $(".select-show-video").addClass("hidden");
    $(".select-all-show-video").addClass("hidden");
    $("#btn-select-videos").removeClass("hidden");
    $(this).addClass("hidden");
    $("#action-all-videos").addClass("hidden");
  });

  $(".select-all-show-video").change(function () {});
  $("#select-all-videos").change(function () {
    if ($(this).prop("checked") == true) {
      $(".video-select").prop("checked", true);
      $("#action-all-videos").removeClass("hidden");
    } else {
      $(".video-select").prop("checked", false);
      $("#action-all-videos").addClass("hidden");
    }
  });
  $(document).on("change", ".video-select", function () {
    $("#action-all-videos").removeClass("hidden");
  });
  $("#btn-confirm-soft-delete-video").click(function () {
    let videoId = $(this).attr("vd-id");
    removeSoftVideo(videoId);
    cancelAction();
  });
  function removeSoftVideo(videoId, type = "single") {
    $.ajax({
      type: "POST",
      url: getBaseURL() + "?action=remove-soft-video",
      data: {
        video_id: videoId,
      },
      dataType: "json",
      success: function (response) {
        if (response.status == true) {
          let data = JSON.parse(response.data);
          $("#number-video-delete").text(data[0].number_delete);
          $(`#row-video-${videoId}`).remove();
          if (type == "single") {
            addNotification("Delete video successfully!!", "success");
          } else {
            return true;
          }
        } else {
          addNotification("Delete user fail!!", "err");
          return false;
        }
      },
    });
  }

  $("#bt-remove-all-video").click(function () {
    var values = $('input[name="video-select"]:checked')
      .map(function () {
        return $(this).val();
      })
      .get();
    let res = [];
    values.map((videoId) => {
      let respons = removeSoftVideo(videoId, "all");
      res.push(respons);
    });
    if (res.includes(false)) {
      addNotification("Delete video fail!!", "err");
    } else {
      addNotification("Delete video successfully!!", "success");
    }
  });
});

function handleRemoveVideo(videoId) {
  $(".wrapper-modal-admin-remove-video").removeClass("hidden");
  // removeSoftVideo(videoId);
  $("#btn-confirm-soft-delete-video").attr("vd-id", videoId);
}
function handleBlockUser(username, userID) {
  if (!$(event.target).hasClass("disabled")) {
    $("#name-user-block").text(username);
    $(".wrapper-modal-admin").removeClass("hidden");
    $("#bt-confirm-block").attr("us-id", userID);
  } else {
    addNotification("User already blocked", "warn");
  }
}
function handleRemoveUser(username, userID) {
  if (!$(event.target).hasClass("disabled")) {
    $("#name-user-remove").text(username);
    $(".wrapper-modal-admin-remove").removeClass("hidden");
    $("#btn-confirm-soft-delete").attr("us-id", userID);
  } else {
    addNotification("User already deleted", "warn");
  }
}
