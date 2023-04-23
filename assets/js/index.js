const rootLink = window.location.origin;
const baseURLWeb = rootLink + "/";
function getBaseURL() {
  return baseURLWeb;
}
function activeNavbar(classActive) {
  $(".item-navbar").removeClass("active-navbar");
  $(".icon-close-nav").removeClass("hidden");
  $(".wrapper_navbar").addClass("position-fixed");
  $(".wrapper-navbar-fixed").removeClass("position-fixed");
  $(".wrapper-navbar-fixed").css("width", "unset");
  $(".icon-close-nav").click(function (e) {
    $(".wrapper_navbar").addClass("translateLeft");
  });
  $(".icon-open-nav").click(function (e) {
    e.stopPropagation();
    $(".wrapper_navbar").removeClass("translateLeft");
  });
  $(".wrapper_navbar").click(function (e) {
    e.stopPropagation();
  });
  $(window).click(function () {
    $(".wrapper_navbar").addClass("translateLeft");
  });

  switch (classActive) {
    case "history": {
      $(".item-navbar").removeClass("active-navbar");
      $(".item-navbar-history").addClass("active-navbar");
      break;
    }
    case "liked": {
      $(".item-navbar").removeClass("active-navbar");
      $(".item-navbar-liked").addClass("active-navbar");
      break;
    }
    case "playlist": {
      console.log($(".item-navbar"));
      $(".item-navbar").removeClass("active-navbar");
      $(".navbar-playlist").addClass("active-navbar");
      break;
    }
  }
}

window.onload = () => {
  const loader = document.getElementById("loader");
  if (loader) {
    loader.classList.add("hidden");
  }
};
$(document).ready(function () {
  $(window).scroll(function () {
    handleNavBarWhenScrollMain();
  });

  $(window).scroll(function () {
    var scrollPosition = $(this).scrollTop();
    if (scrollPosition > 400) {
      $("#to-top").removeClass("hidden");
    } else {
      $("#to-top").addClass("hidden");
    }
  });
  $("#to-top").click(function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
    $(this).addClass("hidden");
  });

  const search = $("#search");
  const subMenu = $("#sub-menu");
  const openSubMenu = $("#open-sub-menu");
  const subMenuSearch = $("#sub-menu-search");

  // handle loading website

  const handleSubMenu = (e) => {
    e.stopPropagation();
    if (subMenu.hasClass("hidden")) {
      subMenu.removeClass("hidden");
    } else {
      subMenu.addClass("hidden");
    }
  };
  const handleMenuSearch = (e) => {
    e.stopPropagation();
    search.css("border-color", "#1f8a70");
    if (subMenuSearch.hasClass("hidden")) {
      subMenuSearch.removeClass("hidden");
    }
  };

  openSubMenu.click(handleSubMenu);
  search.click(handleMenuSearch);
  window.addEventListener("click", (e) => {
    $("#sub-menu").addClass("hidden");
    $("#sub-menu-search").addClass("hidden");
    $("#search").css("border-color", "transparent");
  });

  // handle close modal
  $(document).on("click", ".wrapper-modal", function () {
    $(this).addClass("hidden");
  });

  $(document).on("click", ".modal-custom-notification", function (e) {
    e.stopPropagation();
  });
  $(document).on("click", ".modal-custom", function (e) {
    e.stopPropagation();
  });
});
function redirectLink(link) {
  switch (link.trim()) {
    case "home":
      window.location.href = baseURLWeb + "";
      break;
    case "login":
      window.location.href = baseURLWeb + "login";
      break;
    case "register":
      window.location.href = baseURLWeb + "register";
      break;
    case "logout":
      window.location.href = baseURLWeb + "?action=logout";
      break;
    default:
      window.location.href = baseURLWeb + link;
  }
}

function copyToClipboard(text) {
  const tempInput = document.createElement("input");
  tempInput.value = text;
  document.body.appendChild(tempInput);
  tempInput.select();
  document.execCommand("copy");
  document.body.removeChild(tempInput);
}
function resizeIframe(obj) {
  obj.style.height =
    obj.contentWindow.document.documentElement.scrollHeight + "px";
}

function getAvatar(avatar) {
  if (!avatar)
    return "https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-portrait-176256935.jpg";
  if (avatar.includes("http")) return avatar;
  return getBaseURL() + avatar;
}

function getThumbnails(thumbnails) {
  if (!thumbnails)
    return "https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png";
  if (thumbnails.includes("http")) return thumbnails;
  return getBaseURL() + thumbnails;
}
function getDefaultBackground(link) {
  if (!link) return getBaseURL() + "assets/images/background-default.png";
  if (link.includes("http")) return link;
  return getBaseURL() + link;
}
function getVideoUrl(url) {
  if (!url)
    return "https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png";
  if (url.includes("http")) return url;
  return getBaseURL() + url;
}

const getParent = (className, item) => {
  if (item.parent().hasClass(className)) {
    return item.parent("." + className);
  }
  return getParent(className, item.parent());
};
const getChildren = (className, item) => {
  if (item.children().hasClass(className)) {
    return item.children("." + className);
  }
  return getChildren(className, item.children());
};

const activeItem = (item) => {
  if (item.hasClass("hidden")) {
    item.removeClass("hidden");
  } else {
    item.addClass("hidden");
  }
};
const activeHover = (item) => {
  if (item.hasClass("child-hover")) {
    item.removeClass("child-hover");
  } else {
    item.addClass("child-hover");
  }
};

function addNotificationBeforeSwitchRoute(message, type) {
  window.addEventListener("beforeunload", function (event) {
    // Cancel the event as stated by the standard.
    event.preventDefault();
    // Chrome requires returnValue to be set.
    addNotification(message, type);
    // Display a confirmation message.
    this.setTimeout(() => {
      event.returnValue = "YES";
    }, 2000);
  });
}

function addNotification(text, type = "err") {
  let newNotification = $("");
  switch (type) {
    case "err":
      newNotification =
        $(`<div class="notification cl fs-18 d-flex justify-content-between align-items-center" style='--tag-cl: #E21818'>
      <i class='bx bx-error fs-18 mr-2' style='color:#E21818'></i>
      <span>${text}</span>
      <i class='bx bx-x icon-close fs-18 ml-4 hover_close'></i>
  </div>`);
      break;
    case "warn":
      newNotification =
        $(`<div class="notification cl fs-18 d-flex justify-content-between align-items-center" style='--tag-cl: #EBB02D'>
          <i class='bx bx-error fs-18 mr-2' style='color:#EBB02D'></i>
          <span>${text}</span>
          <i class='bx bx-x icon-close fs-18 ml-4 hover_close'></i>
       </div>`);
      break;
    case "success":
      newNotification =
        $(`<div class="notification cl fs-18 d-flex justify-content-between align-items-center" style='--tag-cl: #58e886'>
          <i class='bx bx-check  fs-18 mr-2' style='color:#58e886'></i>
          <span>${text}</span>
          <i class='bx bx-x icon-close fs-18 ml-4 hover_close'></i>
       </div>`);
      break;
  }
  $(".notification-list").append(newNotification);
  $(document).on("click", ".icon-close", function () {
    newNotification.css("transform", "translateX(200%)");
    newNotification.css("animation-name", "hiddenNotification");
    setTimeout(function () {
      newNotification.remove();
    }, 1000);
  });
  setTimeout(function () {
    newNotification.css("transform", "translateX(0)");
  }, 500);
  setTimeout(() => {
    newNotification.css("animation-name", "hiddenNotification");
    newNotification.css("transform", "translateX(200%)");
    setTimeout(function () {
      newNotification.remove();
    }, 1000);
  }, 3500);
}
function formatTime(timeStr) {
  const now = new Date();
  const time = new Date(timeStr);

  const diff = (now.getTime() - time.getTime()) / 1000; // convert to seconds

  if (diff < 60) {
    return `${Math.floor(diff)} seconds ago`;
  } else if (diff < 3600) {
    return `${Math.floor(diff / 60)} minutes ago`;
  } else if (diff < 86400) {
    return `${Math.floor(diff / 3600)} hours ago`;
  } else {
    return `${Math.floor(diff / 86400)} days ago`;
  }
}

$(document).ready(function () {
  $("#search-header").keypress(function (event) {
    if (event.keyCode === 13) {
      let text = $(this).val();
      $(this).val("");
      if (text !== "") {
        window.location.href = baseURLWeb + "search?data=" + text;
      } else {
        addNotification("Please enter text to search", "warn");
      }
    }
  });
  $("#search-icon").click(function () {
    let text = $("#search-header").val();
    $("#search-header").val("");
    if (text !== "") {
      window.location.href = baseURLWeb + "search?data=" + text;
    } else {
      addNotification("Please enter text to search", "warn");
    }
  });
});

function saveSearchHisLocalStorage(text) {
  const searchHis = localStorage.getItem("search-history");
  if (searchHis) {
    const arrNew = JSON.parse(searchHis);
    if (!arrNew.includes(text) && text !== "") {
      arrNew.push(text);
      localStorage.setItem("search-history", JSON.stringify(arrNew));
    } else {
      let index = arrNew.indexOf(text);
      if (index !== -1) {
        arrNew.splice(index, 1);
      }
      arrNew.push(text);
      localStorage.setItem("search-history", JSON.stringify(arrNew));
    }
  } else {
    let data = [text];
    localStorage.setItem("search-history", JSON.stringify(data));
  }
}

function renderSubMenuSearchHistory() {
  const searchHis = localStorage.getItem("search-history");
  const arrNew = JSON.parse(searchHis);
  if (searchHis != null && arrNew) {
    if (arrNew.length > 0) {
      for (let index of arrNew) {
        let newSubMenuSearchHistory = $(`
          <li class="br-primary hover-bg p-4 d-flex justify-content-between align-items-center item-search-history">
              <label class="d-flex justify-content-center align-items-center">
                <i class="mr-4 bx bx-history fs-24"></i>
              ${index}</label>
              <i class="bx bx-x hover_close fs-24 remove-search-history hover-scale position-relative" style='z-index:1000000000000000'onclick='removeSearchHistory("${index}")'></i>
            </li>
        `);
        newSubMenuSearchHistory.click(function () {
          saveSearchHisLocalStorage(index);
          window.location.href = "search?data=" + index;
        });
        $("#sub-menu-search").prepend(newSubMenuSearchHistory);
      }
    } else {
      $("#sub-menu-search").remove();
    }
  } else {
    $("#sub-menu-search").remove();
  }
}

function removeSearchHistory(text) {
  const currentTarget = event.currentTarget;
  event.stopPropagation();
  getParent("item-search-history", $(currentTarget)).remove();
  const searchHis = localStorage.getItem("search-history");
  if (searchHis) {
    const arrNew = JSON.parse(searchHis);
    if (arrNew.includes(text)) {
      let index = arrNew.indexOf(text);
      if (index !== -1) {
        arrNew.splice(index, 1);
      }
      localStorage.setItem("search-history", JSON.stringify(arrNew));
      if (arrNew.length == 0) {
        $("#sub-menu-search").remove();
      }
    }
  }
}

function handleNavBarWhenScrollMain() {
  let screenHeight = window.screen.height;
  if ($(window).scrollTop() > 80) {
    $("#header-fixed").addClass("header-fixed");
    $("#header-fixed").removeClass("header-not-fixed");
  }
  if ($(window).scrollTop() < 80) {
    $("#header-fixed").removeClass("header-fixed");
    $("#header-fixed").addClass("header-not-fixed");
  }
}

function fixLinkYoutube(link) {
  if (link.includes("watch?v=")) {
    let start = link.indexOf("watch?v=") + "watch?v=".length;
    let res = link.substring(start, link.length);
    return `https://www.youtube.com/embed/${res}`;
  } else {
    return link;
  }
}

function getThumbnailYoutube(url, quality) {
  if (url) {
    var video_id, thumbnail, result;
    if ((result = url.match(/youtube\.com.*(\?v=|\/embed\/)(.{11})/))) {
      video_id = result.pop();
    } else if ((result = url.match(/youtu.be\/(.{11})/))) {
      video_id = result.pop();
    }

    if (video_id) {
      if (typeof quality == "undefined") {
        quality = "high";
      }

      var quality_key = "maxresdefault"; // Max quality
      if (quality == "low") {
        quality_key = "sddefault";
      } else if (quality == "medium") {
        quality_key = "mqdefault";
      } else if (quality == "high") {
        quality_key = "hqdefault";
      }

      var thumbnail =
        "http://img.youtube.com/vi/" + video_id + "/" + quality_key + ".jpg";
      return thumbnail;
    }
  }
  return false;
}
