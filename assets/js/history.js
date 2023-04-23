// handle show history
function loadVideo(user_id, data, id, limit, type = "normal") {
  let mainContentHistoryLiked = $(`#${id}`);
  data.forEach((video, index) => {
    let newVideo = $(`
      <div class='col-xl-2 col-lg-4 col-md-5 col-xs-12 col-12 ' style='scale: .9; ' onclick='redirectLink("watch?data=${
        video.video_id
      }")'>
        <div class=" item-most-watched br-primary overflow-hidden " style='height: 25rem!important'>
          <img class='${video.title}' src='${video.thumbnails}'/>
          <div class="item-most-watched-content" >
              <img class='avatar-user-item box-shadow'src="${
                video.profile_picture
              }" style='top: 55%;'/>
              <span class='fs-12 cl-second'>${video.username}</span>
              <h1 class='fs-16 cl mt-2 mb-2 title-card'>${video.title}</h1>
              <h5 class='fs-12 cl-second'>${formatTime(video.upload_date)}</h5>
          </div>
        </div>
      </div>
      `);

    if (index > 24) {
      if (type != "normal") {
        window.scrollTo({
          top: document.body.scrollHeight,
          behavior: "smooth",
        });
      }
    } else if (index === 24) {
      let newBtnMore = $(
        '<div  class="more pb-5 pt-5 center fs-16"><button class=" bt-primary bg-button-primary">More</button></div>'
      );
      mainContentHistoryLiked.append(newBtnMore);
      newBtnMore.click(function () {
        $(this).remove();
        let loadMore = $('<div class="load-more mt-4 p-4"></div>');
        mainContentHistoryLiked.append(loadMore);
        setTimeout(() => {
          loadsVideoWatched(user_id, limit + 24, "not-normal");
          loadMore.remove();
        }, 1000);
      });
    } else {
      mainContentHistoryLiked.append(newVideo);
    }
  });
}

function loadsVideoWatched(user_id, limitLoadVideoHistory, type = "normal") {
  $.ajax({
    url: getBaseURL() + "?action=get-video-watched",
    method: "get",
    data: { id: user_id, limit: limitLoadVideoHistory },
    dataType: "json",
    success: function (response) {
      if (response.status == true) {
        if (response.data && response.data.length > 0) {
          loadVideo(
            user_id,
            response.data,
            "wrapper-history",
            limitLoadVideoHistory,
            type
          );
        }
        // addNotification(response.message, "success");
      } else {
        addNotification(response.message, "err");
      }
    },
  });
}

// handle show history video liked
function renderVideoLiked(user_id, data, id, limit, type) {
  let mainContentHistoryLiked = $(`#${id}`);
  data.forEach((video, index) => {
    let newVideo = $(`
      <div class='col-xl-2 col-lg-4 col-md-5 col-xs-12 col-12 pb-4'style='scale: .9' onclick='redirectLink("watch?data=${
        video.video_id
      }")'>
        <div class=" item-most-watched br-primary overflow-hidden " style='height: 25rem!important'>
          <img class='${video.title}' src='${video.thumbnails}'/>
          <div class="item-most-watched-content">
              <img class='avatar-user-item box-shadow'src="${
                video.profile_picture
              }" style='top: 55%;' />
              <span class='fs-12 cl-second'>${video.username}</span>
              <h1 class='fs-16 cl mt-2 mb-2 title-card'>${video.title}</h1>
              <h5 class='fs-12 cl-second'>${formatTime(video.upload_date)}</h5>
          </div>
        </div>
      </div>
      `);

    if (index > 24) {
      console.log("asdasd");
      if (type != "normal") {
        window.scrollTo({
          top: document.body.scrollHeight,
          behavior: "smooth",
        });
      }
    } else if (index === 24) {
      let newBtnMore = $(
        '<div  class="more pb-5 pt-5 center fs-16"><button class=" bt-primary bg-button-primary">More</button></div>'
      );
      mainContentHistoryLiked.append(newBtnMore);
      newBtnMore.click(function () {
        $(this).remove();
        let loadMore = $('<div class="load-more mt-4 p-4"></div>');
        mainContentHistoryLiked.append(loadMore);
        setTimeout(() => {
          loadVideoLiked(
            user_id,
            "wrapper-video-liked",
            limit + 24,
            "not-normal"
          );
          loadMore.remove();
        }, 1000);
      });
    } else {
      mainContentHistoryLiked.append(newVideo);
    }
  });
}
function loadVideoLiked(user_id, idItem, limitLoadVideoLiked, type = "normal") {
  $.ajax({
    url: getBaseURL() + "?action=get-video-user-liked",
    method: "get",
    data: { id: user_id, limit: limitLoadVideoLiked },
    dataType: "json",
    success: function (response) {
      if (response.status == true) {
        renderVideoLiked(
          user_id,
          response.data,
          idItem,
          limitLoadVideoLiked,
          type
        );
        // addNotification(response.message, "success");
      } else {
        addNotification(response.message, "err");
      }
    },
  });
}
