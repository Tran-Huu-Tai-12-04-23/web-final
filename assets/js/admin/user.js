// load user into manager users
function loadUserBlocked(limit, index = 0) {
  $.ajax({
    type: "get",
    url: getBaseURL() + "?action=get-user-blocked",
    data: {
      limit: limit,
    },
    dataType: "json",
    success: function (response) {
      if (response.status) {
        loadUserBlockedIntoTable(response.data, limit, index);
      } else {
        let tableManagerUsers = $("#table-manager-users-blocked");
        let newNoti = $(
          "<div class='fs-24 cl p-4' colspan='5'>No user blocked</div>"
        ).appendTo(tableManagerUsers);
        // addNotification("No user has been blocked yet", "success");
      }
    },
  });
}
function loadUserBlockedIntoTable(data, limit, index) {
  data = JSON.parse(data);
  let tableManagerUsers = $("#table-manager-users-blocked");
  data.forEach((user, i) => {
    let newRows = $(`
        <tr  class='' id='row-user-block-${user.user_id}' >
          <td>
          <div class="checkbox-wrapper-12 ml-2 select-show hidden" style='  vertical-align: middle !important; width: unset!important; height: unset'>
              <div class="cbx" style='width: 1rem; height: .5rem'>
                  <input class="cbx-12 user-select" value="${
                    user.user_id
                  }" name='user-select' type="checkbox">
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
          <td><img src='${getAvatar(user.profile_picture)}'></img></td>
          <td>${user.username}</td>
          <td>${user.email}</td>
          <td>${user.phone_number}</td>
          <td class='d-flex justify-content-center align-items-center'>
            <div class='bt-primary w-60px mr-2 cl  br-primary fs-14 bt-block-user user-block-${
              user.user_id
            }' onclick="handleUnlockBlockUser('${user.user_id}',${
      user.user_id
    })" style='color: #000'>Unblock</div>
      `);
    if (i == 15) {
      let btnMore = $(
        '<div colspan="4" class="bt-primary  w-100 br-primary bg-transparent center fs-16">Show More</div>'
      );
      btnMore.click(function () {
        loadUserBlocked(limit + 15, index);
        $(this).remove();
      });
      tableManagerUsers.append(btnMore);
    } else {
      tableManagerUsers.append(newRows);
      index++;
    }
  });
}

// load user into trash table
function loadUserDelete(limit, index = 0) {
  $.ajax({
    type: "get",
    url: getBaseURL() + "?action=get-user-deleted",
    data: {
      limit: limit,
    },
    dataType: "json",
    success: function (response) {
      if (response.status) {
        loadUserDeleteIntoTableTrash(response.data, limit, index);
      } else {
        let tableManagerUsers = $("#table-manager-users-trash");
        $(
          "<div class='fs-24 cl p-4' colspan='5'>Trash is empty</div>"
        ).appendTo(tableManagerUsers);
        // addNotification("No user has been blocked yet", "success");
      }
    },
  });
}
function loadUserDeleteIntoTableTrash(data, limit, index) {
  data = JSON.parse(data);
  let tableManagerUsers = $("#table-manager-users-trash");
  data.forEach((user, i) => {
    let newRows = $(`
        <tr  class='row-user-trash' id='row-user-trash-${user.user_id}' >
          <td>
          <div class="checkbox-wrapper-12 ml-2 select-show hidden" style='  vertical-align: middle !important; width: unset!important; height: unset'>
              <div class="cbx" style='width: 1rem; height: .5rem'>
                  <input class="cbx-12 user-select" value="${
                    user.user_id
                  }" name='user-select' type="checkbox">
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
          <td><img src='${getAvatar(user.profile_picture)}'></img></td>
          <td>${user.username}</td>
          <td>${user.email}</td>
          <td>${user.phone_number}</td>
          <td class='d-flex justify-content-center align-items-center'>
            <div class='bt-primary w-60px mr-2 hover_close bg-transparent br-primary fs-14 bt-destroy-user'  onclick="handleDestroyUser(${
              user.user_id
            })" style='color: #000'>Destroy</div>
            <div class='bt-primary w-60px mr-2 cl  br-primary fs-14 bt-restore-user '
             onclick="handleRestoreUser(${
               user.user_id
             })" style='color: #000'>Restore</div>
          </td>
      `);
    if (i == 15) {
      let btnMore = $(
        '<div colspan="2" class="bt-primary  w-100 br-primary bg-transparent center fs-16">Show More</div>'
      );
      btnMore.click(function () {
        loadUserDelete(limit + 15, index);
        $(this).remove();
      });
      tableManagerUsers.append(btnMore);
    } else {
      tableManagerUsers.append(newRows);
      index++;
    }
  });
}

function handleUnlockBlockUser(userId, type = "normal") {
  $.ajax({
    type: "post",
    url: getBaseURL() + "?action=unlock-user",
    data: {
      user_id: userId,
    },
    dataType: "json",
    success: function (response) {
      if (response.status) {
        let data = JSON.parse(response.data);
        console.log(data[0].number_block);
        $("#number-user-block").text(data[0].number_block);
        $(`#row-user-block-${userId}`).remove();
        // handleWhenTableEmpty();
        if (type == "normal") {
          addNotification("Successfully unlock", "success");
        } else {
          return true;
        }
      } else {
        if (type == "normal") {
          addNotification("Unlock user fail!!!", "err");
        } else {
          return false;
        }
      }
    },
  });
}

// out jquery
function handleRestoreUser(userId, type = "normal") {
  $.ajax({
    type: "post",
    url: getBaseURL() + "?action=restore-user",
    data: {
      user_id: userId,
    },
    dataType: "json",
    success: function (response) {
      if (response.status) {
        let data = JSON.parse(response.data);
        console.log(data[0].number_delete);
        $("#number-user-delete").text(data[0].number_delete);
        $(`#row-user-trash-${userId}`).remove();
        handleWhenTableEmpty();
        if (type == "normal") {
          addNotification("Restore user successfully", "success");
        } else {
          return true;
        }
      } else {
        if (type == "normal") {
          addNotification("Restore user fail!!!", "err");
        } else {
          return false;
        }
      }
    },
  });
}
let listArrUserDestroy = [];
function handleDestroyUser(value, type = "normal") {
  $(".wrapper-modal-admin-destroy-user").removeClass("hidden");
  if (type === "normal") {
    $("#btn-destroy").attr("us-id", value);
  } else {
    listArrUserDestroy = value;
  }
}

function destroyUser(userId, type = "normal") {
  $.ajax({
    type: "post",
    url: getBaseURL() + "?action=destroy-user",
    data: {
      user_id: userId,
    },
    dataType: "json",
    success: function (response) {
      if (response.status) {
        let data = JSON.parse(response.data);
        console.log(data[0].number_delete);
        $("#number-user-delete").text(data[0].number_delete);
        $(`#row-user-trash-${userId}`).remove();
        handleWhenTableEmpty();
        if (type === "normal") {
          addNotification("Destroy user successfully", "success");
        } else {
          return true;
        }
      } else {
        if (type === "normal") {
          addNotification("Destroy user fail!!!", "err");
        } else {
          return false;
        }
      }
    },
  });
}

function handleUnlockUserSelected() {
  var values = $('input[name="user-select"]:checked')
    .map(function () {
      return $(this).val();
    })
    .get();
  let res = [];
  values.map((userId) => {
    let respons = handleUnlockBlockUser(userId, "all");
    res.push(respons);
  });
  if (res.includes(false)) {
    addNotification("Block user fail!!", "err");
  } else {
    addNotification("Block user successfully!!", "success");
    $(".user-select").addClass("hidden");
    $(".select-show").addClass("hidden");
  }
}

function handleDestroyUserSelected() {
  var values = $('input[name="user-select"]:checked')
    .map(function () {
      return $(this).val();
    })
    .get();
  handleDestroyUser(values, "not-normal");
}

function acceptDestroy() {
  let res = [];
  listArrUserDestroy.map((userId) => {
    let respons = destroyUser(userId, "not-normal");
    res.push(respons);
  });
  if (res.includes(false)) {
    addNotification("Destroy user fail!!", "err");
  } else {
    addNotification("Destroy user successfully!!", "success");
    $(".user-select").addClass("hidden");
    $(".select-show").addClass("hidden");
  }
}

function handleRestoreUserSelected() {
  var values = $('input[name="user-select"]:checked')
    .map(function () {
      return $(this).val();
    })
    .get();
  let res = [];
  values.map((userId) => {
    let respons = handleRestoreUser(userId, "not-normal");
    res.push(respons);
  });
  if (res.includes(false)) {
    addNotification("Restore user fail!!", "err");
  } else {
    addNotification("Restore user successfully!!", "success");
    $(".user-select").addClass("hidden");
    $(".select-show").addClass("hidden");
  }
}
