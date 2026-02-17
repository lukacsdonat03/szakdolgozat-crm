let wallPollingInterval;

$(function () {
  $(document).on(
    "change",
    "#ajax-asigned-dropdown, #ajax-status-dropdown",
    function (e) {
      e.preventDefault();

      const status = $("#ajax-status-dropdown").val();
      const asigned = $("#ajax-asigned-dropdown").val();
      const form = $("#task-ajax-form");
      const id = $("#task-id").val();

      $.LoadingOverlay("show");

      $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: {
          status: status,
          asigned: asigned,
          id: id,
          _csrf: $('#task-ajax-form input[name="_csrf"]').val(),
        },
        success: function (response) {
          if (response.success) {
            Swal.fire({
              icon: "success",
              title: "Mentve!",
              text: response.msg,
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
            });

            $("#taskModal").modal("hide");

            if (window.mainCalendar) {
              window.mainCalendar.refetchEvents();
            }
          } else {
            Swal.fire({
              icon: "warning",
              title: "Hiba!",
              text: response.msg,
            });
          }
        },
        error: function (xhr, status, error) {
          let errorMessage = "Ismeretlen hiba történt a mentés során.";

          if (xhr.status === 403) {
            errorMessage = "Nincs jogosultságod a művelethez!";
          } else if (xhr.status === 404) {
            errorMessage = "Az erőforrás nem található.";
          } else if (xhr.status >= 500) {
            errorMessage = "Szerver hiba történt, próbáld újra később.";
          }

          console.error("AJAX Error:", error, xhr.responseText);
          Swal.fire({
            icon: "error",
            title: "Hoppá...",
            text: errorMessage,
            confirmButtonColor: "#d33",
            confirmButtonText: "Értem",
          });
        },
        complete: function () {
          $.LoadingOverlay("hide");
        },
      });

      return false;
    },
  );

  $(document).on("submit", "#message-ajax-form", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    const content = $("#modal-message-content").val().trim();
    const receiverId = $("#receiver-id-dropdown").val();
    const taskId = $("#task-id").val();
    const form = $("#message-ajax-form");

    if (content === "") {
      Swal.fire({
        icon: "warning",
        title: "Hiba",
        text: "Kérlek, írj üzenetet!",
        confirmButtonColor: "#3085d6",
      });
      return;
    }

    $.LoadingOverlay("show");

    $.ajax({
      url: form.attr("action"),
      type: "POST",
      data: {
        task_id: taskId,
        content: content,
        receiver_id: receiverId,
        _csrf: $('#message-ajax-form input[name="_csrf"]').val(),
      },
      success: function (response) {
        if (response.success) {
          $("#modal-message-content").val("");

          $(".task-messages-container").parent().html(response.html);

          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
          });
          Toast.fire({
            icon: "success",
            title: response.msg,
          });

          let container = $(".task-messages-container");
          container.scrollTop(container[0].scrollHeight);
        } else {
          Swal.fire("Hiba!", response.msg, "error");
        }
      },
      error: function () {
        Swal.fire("Hiba!", "Szerver hiba történt.", "error");
      },
      complete: function () {
        $.LoadingOverlay("hide");
      },
    });

    return false;
  });

  $(document).on("click", ".delete-msg", function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const msgElement = $("#msg-" + id);

    Swal.fire({
      title: "Törlés?",
      text: "Biztosan törölni szeretnéd ezt az üzenetet?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Igen, töröld!",
      cancelButtonText: "Mégse",
    }).then((result) => {
      if (result.isConfirmed) {
        let deleteData = { id: id };

        if (
          typeof csrfParam !== "undefined" &&
          typeof csrfToken !== "undefined"
        ) {
          deleteData[csrfParam] = csrfToken;
        } else {
          deleteData[yii.getCsrfParam()] = yii.getCsrfToken();
        }

        $.ajax({
          url:
            typeof deleteMsgUrl !== "undefined"
              ? deleteMsgUrl
              : "/projects/task/delete-message-ajax",
          type: "POST",
          data: deleteData,
          success: function (response) {
            if (response.success) {
              msgElement.fadeOut(400, function () {
                $(this).remove();
                if ($(".message").length === 0) {
                  $("#messages-ajax-wrapper").html(
                    '<p class="text-muted text-center py-3">Még nincsenek üzenetek.</p>',
                  );
                }
              });

              if (typeof mainCalendar !== "undefined") {
                mainCalendar.refetchEvents();
              } else if (window.mainCalendar) {
                window.mainCalendar.refetchEvents();
              }

              Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: response.msg,
                showConfirmButton: false,
                timer: 2000,
              });
            } else {
              Swal.fire("Hiba!", response.msg, "error");
            }
          },
        });
      }
    });
  });
});

$(document).on("submit", "#wall-post-form", function (e) {
  e.preventDefault();
  const $form = $(this);

  $.ajax({
    url: $form.attr("action"),
    type: "POST",
    data: $form.serialize(),
    success: function (response) {
      if (response.success) {
        $("#wall-content").val("");
        $("#reply-to-id").val("");
        $("#reply-to-box").addClass("d-none");
        $.pjax.reload({ container: "#wall-pjax-container", async: false, scrollTo:0 });
      } else {
        Swal.fire("Hiba!", response.msg, "error");
      }
    },
  });
});

$(document).on("click", ".btn-reply", function (e) {
  e.preventDefault();
  const id = $(this).data("id");
  const user = $(this).data("user");

  $("#reply-to-id").val(id);
  $("#reply-to-user").text(user);
  $("#reply-to-box").removeClass("d-none");
  $("#wall-content").focus();
});

$(document).on("click", "#reply-to-box .btn-close", function () {
  $("#reply-to-id").val("");
  $("#reply-to-box").addClass("d-none");
});

$(document).ready(function () {
  var container = $("#wall-pjax-container");
  if (container.length > 0) {
    container.scrollTop(0);
  }
});

function getUrlParameter(sParam) {
  let sPageURL = window.location.search.substring(1);
  let sURLVariables = sPageURL.split("&");
  let sParameterName;
  let i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split("=");
    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined
        ? true
        : decodeURIComponent(sParameterName[1]);
    }
  }
  return false;
}

function startWallPolling() {
    wallPollingInterval = setInterval(function() {
        var page = getUrlParameter('page');
        
        if ($('#wall-pjax-container').length && (!page || page == '1')) {
            $.pjax.reload({
                container: '#wall-pjax-container',
                push: false,
                replace: false,
                scrollTo: false,
                timeout: 5000,
                async: true
            });
        }
    }, 5000);
}

function stopWallPolling() {
    clearInterval(wallPollingInterval);
}

$(document).ready(function() {
    startWallPolling();
});

$(document).on('pjax:start', function() {
    stopWallPolling();
});

$(document).on('pjax:end', function() {
    startWallPolling();
});

