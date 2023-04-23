function loaderMainVideo(response, limit, type = "normal") {
  let mainVideo = $(".main-video");
  if (!response) return;
  response.map((data, index) => {
    let newItem = `
    <div class="col-xl-2  col-lg-4 col-md-4 col-6" onclick='redirectLink("watch?data=${
      data.video_id
    }")'>
          <div class="item-most-watched mb-4 br-primary overflow-hidden
              style='animation-delay:${index * 0.1}s'
              ">
                  <img class='' src='${data.thumbnails}'/>
                  <div class="item-most-watched-content">
                      <img class='avatar-user-item box-shadow' src='${
                        data.profile_picture
                      }'/>
                      <span class='fs-12 cl-second'>${data.username}</span>
                      <h1 class='fs-16 cl mt-2 mb-2 title-card'>${
                        data.title
                      }</h1>
                      <h5 class='fs-12 cl-second'>${formatTime(
                        data.upload_date
                      )}</h5>
                  </div>
              </div>
          </div>
          `;
    if (index == 24) {
      newItem = $(
        '<div id="more-main-video" class="more pb-5 pt-5 center fs-16"><button class=" bt-primary bg-button-primary">More</button></div>'
      );
      newItem.click(function () {
        let loadMore = $('<div class="load-more mt-4 p-4"></div>');
        mainVideo.append(loadMore);
        $(this).remove();
        setTimeout(() => {
          getMainVideo("not-normal", limit + 24);
          loadMore.remove();
        }, 1000);
      });
      mainVideo.append(newItem);
    }
    if (index < 24) {
      mainVideo.append(newItem);
    } else {
      if (type != "normal") {
        // window.scrollTo({
        //   top: document.body.scrollHeight,
        //   behavior: "smooth",
        // });
      }
    }
  });
}

function getMainVideo(type = "normal", limit = 0) {
  $.ajax({
    type: "get",
    url: "?action=get-video",
    data: {
      limit: limit,
    },
    dataType: "json",
    success: function (response) {
      loaderMainVideo(response, limit, type);
    },
  });
}

//
function loadingVideoTrending() {
  $.ajax({
    type: "get",
    url: "?action=get-trending-video",
    dataType: "json",
    success: function (response) {
      if (response.status) {
        loadTrendingVideo(response.data);
      } else {
        console.log("Get discovery video failed!!!");
      }
    },
  });
}
function loadTrendingVideo(data) {
  restTrending = [];
  data.map((item, index) => {
    let itemTrending = $(`
    <div class="col-xl-2 col-lg-4 col-md-4 col-6" onclick='redirectLink("watch?data=${
      item.video_id
    }")'>
    <div class="item-most-watched mb-4 br-primary overflow-hidden ">
        <img class='${item.title}' src='${item.thumbnails}'/>
        <div class="item-most-watched-content">
            <img class='avatar-user-item box-shadow'src="${
              item.profile_picture
            }" />
            <span class='fs-12 cl-second'>${item.username}</span>
            <h1 class='fs-16 cl mt-2 mb-2 title-card'>${item.title}</h1>
            <h5 class='fs-12 cl-second'>${formatTime(item.upload_date)}</h5>
        </div>
      </div>
  </div>
  `);
    if (index == 12) {
      newBtnMore = $(
        '<div id="more-trending-videos" class="more pb-5 pt-5 center fs-16"><button class=" bt-primary bg-button-primary">More</button></div>'
      );
      restTrending.push(item);
      $("#wrapper-item-most-watched").append(newBtnMore);
      newBtnMore.click(function () {
        loadTrendingVideo(restTrending);
        $(this).remove();
      });
    } else if (index > 12) {
      restTrending.push(item);
    } else {
      $("#wrapper-item-most-watched").append(itemTrending);
    }
  });
}

function getVideoDiscovery() {
  $.ajax({
    type: "get",
    url: "?action=get-top-video-discovery",
    dataType: "json",
    success: function (response) {
      if (response.status) {
        loadVideoDiscovery(response.data);
        loadStep(response.data.length);
      } else {
        console.log("Get discovery video failed!!!");
      }
    },
  });
}

function loadVideoDiscovery(data) {
  data.map((item, index) => {
    let itemDiscovery = $(`
    <div class="item-slider width-md-100 col-xl-5 col-lg-5 col-md-12 col-12" data-id='${index}' onclick='redirectLink("watch?data=${item.video_id}")'>
        <img class='br-primary'src="${item.thumbnails}" alt="">
        <div class="content-slider cl d-flex justify-content-center align-items-center p-4">
          <div class=" mr-2 ml-2 avatar-slider ">
            <img src="${item.profile_picture}" />
          </div>
          <div class="d-flex flex-column justify-content-center mt-4">
            <h1 class='title fs-16 mb-2'>${item.title}</h1>
            <span class='des fs-14 mt-2 mb-4'>${item.description}</span>
            </div>
          </div>
    </div>
  `);
    $("#slider").append(itemDiscovery);
  });
}

var translate = 0;
function loadStep(steps) {
  // load step
  let sliderItem = $(".item-slider");
  let stepSlider = $("#step-slider");
  for (let i = 0; i < steps - 1; i++) {
    let step = $('<div class="step"></div>');
    if (i == 0) {
      step = $(`<div class="step active"></div>`);
    }
    step.click(function () {
      let item = sliderItem[i];
      translate = i * $(item).width();
      if (i === steps - 2) {
        translate = i * $(item).width() - $(item).width() * 0.2;
      }
      $("#slider").css("transform", `translateX(${-translate}px)`);
      $(".step").removeClass("active");
      $(this).addClass("active");
      if (i > 0) {
        $(".icon-prev-slider").removeClass("hidden");
      } else {
        $(".icon-next-slider").removeClass("hidden");
        $(".icon-prev-slider").addClass("hidden");
      }
    });
    stepSlider.append(step);
  }
}
$(document).ready(function () {
  // $(".wrapper_navbar").removeClass("translateLeft");
  // $(".icon-menu-header").addClass("hidden");

  // end load items
  // loading videos trending

  // endload video trending
  // load viideo discovery

  // end load video discovery
  // $(".icon-open-nav").click(function () {
  //   $(this).addClass("hidden");
  //   $(".icon-close-nav").removeClass("hidden");
  //   $(".open").removeClass("hidden");
  //   $(".wrapper_navbar").removeClass("w-90px");
  //   $(".wrapper-main").css("width", "80%");
  //   $(".wrapper-navbar-fixed").css("width", "18.5%");
  // });
  // $(".icon-close-nav").click(function () {
  //   $(".icon-open-nav").removeClass("hidden");
  //   $(this).addClass("hidden");
  //   $(".open").addClass("hidden");
  //   $(".wrapper_navbar").addClass("w-90px");
  //   $(".wrapper-main").css("width", "calc(100% - 9rem)");
  //   $(".wrapper-navbar-fixed").css("width", "9rem");
  // });
  $(".icon-next-slider").click(function () {
    let slider = $("#slider");
    let listItem = slider.children(".item-slider");
    let lengthList = $(listItem[0]).width() * listItem.length;
    let lengthItem = $(listItem[0]).width();
    translate = parseInt(slider.css("transform").split(",")[4]);
    if (!translate) {
      translate = 0;
    }
    $(".icon-prev-slider").removeClass("hidden");
    if (translate > -lengthList + 3.5 * lengthItem) {
      translate -= lengthItem;
    } else if (translate > -lengthList + 2.5 * lengthItem) {
      translate = -lengthList + 2.2 * lengthItem;
    } else {
      translate = 0;
      $(".icon-prev-slider").addClass("hidden");
    }
    translateStep(translate, lengthItem, lengthList);
  });
  $(".icon-prev-slider").click(function () {
    let slider = $("#slider");
    let listItem = slider.children(".item-slider");
    let lengthItem = $(listItem[0]).width();
    translate = parseInt(slider.css("transform").split(",")[4]);
    if (!translate) {
      translate = 0;
    }
    if (translate <= -lengthItem * 2) {
      translate += lengthItem;
    } else {
      translate = 0;
      $(this).addClass("hidden");
    }
    slider.css("transform", `translateX(${translate}px)`);
    translateStep(translate, lengthItem, lengthList);
  });

  function translateStep(translate, lengthItem, lengthList) {
    let indexItem = translate / lengthItem;
    if (indexItem < 0) {
      indexItem = -indexItem;
    }
    indexItem = Math.round(indexItem);

    $(".step").removeClass("active");
    $($(".step")[indexItem]).addClass("active");
    if (translate > -lengthList + lengthItem + 10) {
      $(".icon-next-slider").removeClass("hidden");
    }
    $("#slider").css("transform", `translateX(${translate}px)`);
  }
});
