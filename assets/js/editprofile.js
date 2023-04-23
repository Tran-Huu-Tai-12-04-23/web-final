$(document).ready(function () {
  activeNavbar();
  const fileInput = document.getElementById("inputTag");
  const previewImage = document.getElementById("previewImage");

  // fileInput.addEventListener("change", function () {
  //   const file = this.files[0];

  //   if (file) {
  //     const reader = new FileReader();

  //     reader.addEventListener("load", function () {
  //       previewImage.setAttribute("src", this.result);
  //     });

  //     reader.readAsDataURL(file);
  //   }
  // });

  // handle change password user
  function handleChangePassword(data) {
    $.ajax({
      url: "?action=change-pass-user",
      method: "PUT",
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.status == true) {
          addNotification(response.message, "success");
          //  profile is active
          $(".control-edit").addClass("hidden");
          $(".profile").removeClass("hidden");
          $(".sub-control").removeClass("active");
          $(".sub-control-profile").addClass("active");
          $("#new-password").val("");
          $("#confirm-new-password").val("");
          $("#old-password").val("");
        } else {
          addNotification(response.message, "err");
        }
      },
    });
  }

  $("#bt-save-change-pass").click(function () {
    let userId = $(this).attr("data-id");
    let newPass = $("#new-password").val();
    let newConfirmPass = $("#confirm-new-password").val();
    let oldPass = $("#old-password").val();
    let data = {
      user_id: userId,
      new_pass: newPass,
      new_confirm_pass: newConfirmPass,
      old_pass: oldPass,
    };
    if (oldPass === "") {
      addNotification("Please enter old password!!", "err");
    } else {
      handleChangePassword(data);
      getParent("wrapper-modal", $(this)).addClass("hidden");
    }
  });
});
