function cancelAction() {
  $(".wrapper-modal-admin").addClass("hidden");
  $(".wrapper-modal-admin-remove").addClass("hidden");
  $(".wrapper-modal-admin-remove-video").addClass("hidden");
  $(".wrapper-modal-admin-destroy-user").addClass("hidden");
}
function handleWhenTableEmpty() {
  if ($(".row-user-trash").length == 0) {
    let tableManagerUsersBlock = $("#table-manager-users-blocked");
    $("<div class='fs-24 cl p-4' colspan='5'>Table is empty</div>").appendTo(
      tableManagerUsersBlock
    );
    let tableManagerUsersDeleted = $("#table-manager-users-trash");
    $("<div class='fs-24 cl p-4' colspan='5'>Table is empty</div>").appendTo(
      tableManagerUsersDeleted
    );
  }
  if ($(".row-video-trash").length == 0) {
    let tableManagerUsersBlock = $("#table-manager-videos-trash");
    $("<div class='fs-24 cl p-4' colspan='5'>Table is empty</div>").appendTo(
      tableManagerUsersBlock
    );
  }
}

$(document).ready(function () {
  // handle manager user
  $(".main-modal-block-user").click(function (e) {
    e.stopPropagation();
  });
  console.log($(".btn-cancel"));
  $(".btn-cancel").click(function (e) {
    e.stopPropagation();
    cancelAction();
  });
  // loadnumber user deleted
  loadCountUserBlock();
  function loadCountUserBlock() {
    $.ajax({
      type: "GET",
      url: getBaseURL() + "?action=count-user-blocked",
      dataType: "json",
      success: function (response) {
        if (response.status) {
          let data = JSON.parse(response.data);
          $("#number-user-block").text(data[0].number_block);
        } else {
          alert("Get users failed!!!");
        }
      },
    });
  }
  loadCountUserDelete();
  function loadCountUserDelete() {
    $.ajax({
      type: "GET",
      url: getBaseURL() + "?action=count-user-deleted",
      dataType: "json",
      success: function (response) {
        if (response.status) {
          let data = JSON.parse(response.data);
          $("#number-user-delete").text(data[0].number_delete);
        } else {
          alert("Get users failed!!!");
        }
      },
    });
  }
  loadCountVideoDelete();
  function loadCountVideoDelete() {
    $.ajax({
      type: "GET",
      url: getBaseURL() + "?action=count-video-deleted",
      dataType: "json",
      success: function (response) {
        if (response.status) {
          let data = JSON.parse(response.data);
          $("#number-video-delete").text(data[0].number_delete);
        } else {
          alert("Get video failed!!!");
        }
      },
    });
  }
  $("#menu-sidebar-admin").click(function (e) {
    e.stopPropagation();
    activeItem(getChildren("menu", $(this)));
  });
  $(".menu").click(function (e) {
    e.stopPropagation();
  });
  $(window).click(function () {
    $(".menu").addClass("hidden");
  });

  $("#icon-search-admin").click(function (e) {
    e.stopPropagation();
    activeItem($(".modal-custom-admin"));
    $("#input-search-admin").focus();
  });
  $(".modal-search-admin").click(function (e) {
    e.stopPropagation();
  });
  $(".modal-custom-admin").click(function (e) {
    activeItem($(this));
  });
  $(".icon-close-modal-search").click(function (e) {
    getParent("modal-custom-admin", $(this)).addClass("hidden");
  });

  $(document).on("keydown", function (event) {
    if (event.ctrlKey && event.key === "f") {
      event.preventDefault();
      activeItem($(".modal-custom-admin"));
      $("#input-search-admin").focus();
    }
  });
});

function switchActive(route) {
  const currentUrl = window.location.href;
  if (currentUrl.includes("user") || currentUrl.includes("video")) {
    switchActiveSidebarMultiPage(route);
  } else {
    switchActiveSidebarSinglePage(route);
  }
}
function switchActiveSidebarSinglePage(route) {
  switch (route) {
    case "user": {
      $(".item-switch").addClass("hidden");
      $(".manager-user").removeClass("hidden");
      $(".item-sidebar-admin").removeClass("active-navbar");
      $(".item-sidebar-admin-user").addClass("active-navbar");
      break;
    }
    case "dashboard": {
      $(".item-switch").addClass("hidden");
      $(".dashboard").removeClass("hidden");
      $(".item-sidebar-admin").removeClass("active-navbar");
      $(".item-sidebar-admin-dashboard").addClass("active-navbar");
      break;
    }
    case "video": {
      $(".item-switch").addClass("hidden");
      $(".manager-video").removeClass("hidden");
      $(".item-sidebar-admin").removeClass("active-navbar");
      $(".item-sidebar-admin-video").addClass("active-navbar");
      break;
    }
    case "report": {
      $(".item-switch").addClass("hidden");
      $(".manager-report").removeClass("hidden");
      $(".item-sidebar-admin").removeClass("active-navbar");
      $(".item-sidebar-admin-report").addClass("active-navbar");
      break;
    }
    case "user-block": {
      $(".item-switch").addClass("hidden");
      $(".manager-user-block").removeClass("hidden");
      $(".item-sidebar-admin").removeClass("active-navbar");
      $(".item-sidebar-admin-user-block").addClass("active-navbar");
      break;
    }
  }
}
function switchActiveSidebarMultiPage(route) {
  switch (route) {
    case "user": {
      window.location.href = getBaseURL() + "admin?active='user'";
      break;
    }
    case "dashboard": {
      window.location.href = getBaseURL() + "admin";
      break;
    }
    case "user-block": {
      window.location.href =
        getBaseURL() + "admin/user/blocked?active='user-block'";
      break;
    }
    case "user-trash": {
      window.location.href =
        getBaseURL() + "admin/user/trash?active='user-trash'";
      break;
    }
    case "video-trash": {
      window.location.href =
        getBaseURL() + "admin/video/trash?active='video-trash'";
      break;
    }
    case "video": {
      window.location.href = getBaseURL() + "admin?active='video'";
      break;
    }
    case "report": {
      window.location.href = getBaseURL() + "admin?active=report";
      break;
    }
  }
}
function handleEditUser(userId) {
  window.location.href = getBaseURL() + "admin/user/edit?id=" + userId;
}

function activeNavbar(active) {
  $(".item-sidebar-admin").removeClass("active-navbar");
  switch (active) {
    case "user": {
      switchActiveSidebarSinglePage("user");
      break;
    }
    case "video": {
      switchActiveSidebarSinglePage("video");
      break;
    }
    case "user-block": {
      $(".item-sidebar-admin-user-block").addClass("active-navbar");
      break;
    }
    case "user-trash": {
      $(".item-sidebar-admin-user-trash").addClass("active-navbar");
      break;
    }
    case "video-trash": {
      $(".item-sidebar-admin-video-trash").addClass("active-navbar");
      break;
    }
  }
}
