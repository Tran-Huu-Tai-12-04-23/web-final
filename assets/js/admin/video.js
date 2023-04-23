function loadVideoDeleted(limit, index = 0) {
  $.ajax({
    type: "get",
    url: getBaseURL() + "?action=get-video-deleted",
    data: {
      limit: limit,
    },
    dataType: "json",
    success: function (response) {
      if (response.status) {
        loadVideoIntoTrashTable(response.data, limit, index);
      } else {
        let tableManagerVideos = $("#table-manager-videos-trash");
        let newNoti = $(
          "<div class='fs-24 cl p-4' colspan='5'>Trash is empty</div>"
        ).appendTo(tableManagerVideos);
        // addNotification("No user has been blocked yet", "success");
      }
    },
  });
}
function loadVideoIntoTrashTable(data, limit, index) {
  let tableManagerVideos = $("#table-manager-videos-trash");
  data.forEach((video, i) => {
    let newRows = $(`
          <tr  class='row-video-trash' id='row-video-${video.video_id}' >
            <td>
            <div class="checkbox-wrapper-12 ml-2 select-show hidden" style='  vertical-align: middle !important; width: unset!important; height: unset'>
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
              <div class='bt-primary w-60px mr-2 mb-2 hover_close   bg-transparent br-primary fs-14 user' onclick="handleDestroyVideo(${video.video_id})" style='color: #000'>Destroy</div>
              <div class='bt-primary w-60px mr-2 mb-2  cl  br-primary fs-14 ' onclick="handleRestoreVideo(${video.video_id})" style='color: #000'>Restore</div>
            </td>
          </tr>
        `);
    if (i == 24) {
      let btnMore = $(
        '<div colspan="2" class="bt-primary w-100 br-primary bg-transparent center fs-16"  style="width: 200px!important">Show More</div>'
      );
      btnMore.click(function () {
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
function handleDestroyVideo(videoId, type = "single") {
  $(".wrapper-modal-admin-destroy-video").removeClass("hidden");
  $("#btn-destroy-video").attr("vd-id", videoId);
}
function desTroyVideo(videoId, type = "single") {
  $.ajax({
    type: "POST",
    url: getBaseURL() + "?action=destroy-video",
    data: {
      video_id: videoId,
    },
    dataType: "json",
    success: function (response) {
      if (response.status == true) {
        let data = JSON.parse(response.data);
        $("#number-video-delete").text(data[0].number_delete);
        $(`#row-video-${videoId}`).remove();
        handleWhenTableEmpty();
        if (type == "single") {
          addNotification("Destroy video successfully!!", "success");
        } else {
          return true;
        }
      } else {
        addNotification("Destroy video fail!!", "err");
        return false;
      }
    },
  });
}
let arrVideoIdDestroySelected = [];

function acceptDestroyVideo() {
  $(".wrapper-modal-admin-destroy-video").addClass("hidden");
  let videoId = $("#btn-destroy-video").attr("vd-id");
  if (videoId != undefined) {
    desTroyVideo(videoId);
    $("#btn-destroy-video").null;
  } else {
    let res = [];
    arrVideoIdDestroySelected.map((videoId) => {
      let respons = desTroyVideo(videoId, "all");
      res.push(respons);
    });
    if (res.includes(false)) {
      addNotification("Destroy videos fail!!", "err");
    } else {
      addNotification("Destroy videos successfully!!", "success");
    }
  }
}

function handleRestoreVideo(videoId, type = "single") {
  $.ajax({
    type: "POST",
    url: getBaseURL() + "?action=restore-video",
    data: {
      video_id: videoId,
    },
    dataType: "json",
    success: function (response) {
      if (response.status == true) {
        let data = JSON.parse(response.data);
        $("#number-video-delete").text(data[0].number_delete);
        $(`#row-video-${videoId}`).remove();
        handleWhenTableEmpty();
        if (type == "single") {
          addNotification("Restore video successfully!!", "success");
        } else {
          return true;
        }
      } else {
        addNotification("Restore video fail!!", "err");
        return false;
      }
    },
  });
}

function handleRestoreVideoSelected() {
  let values = $('input[name="video-select"]:checked')
    .map(function () {
      return $(this).val();
    })
    .get();
  let res = [];
  values.map((videoId) => {
    let respons = handleRestoreVideo(videoId, "all");
    res.push(respons);
  });
  if (res.includes(false)) {
    addNotification("Restore video fail!!", "err");
  } else {
    addNotification("Restore video successfully!!", "success");
    $(".user-select").prop("checked", false);
  }
  $('input[name="video-select"]:checked').prop("checked", false);
  $(".select-all-trash-video").addClass("hidden");
  $("#select-all-videos").prop("checked", false);
}
function handleDestroyVideoSelected() {
  $(".wrapper-modal-admin-destroy-video").removeClass("hidden");
  arrVideoIdDestroySelected = $('input[name="video-select"]:checked')
    .map(function () {
      return $(this).val();
    })
    .get();
}
