// clear textbox
$(document).ready(function () {
  $(".btn-clear").click(function () {
    $("#formBook")[0].reset();
  });
  if ($(".issetAlert")[0]) {
    $(".alert").addClass("show");
    $(".alert").removeClass("hide");
    $(".alert").addClass("showAlert");
    setTimeout(function () {
      $(".alert").removeClass("show");
      $(".alert").addClass("hide");
    }, 3000);
  }
  $(".close-btn").click(function () {
    $(".alert").removeClass("show");
    $(".alert").addClass("hide");
  });
});



function upperMe() {
  document.getElementById("form_bookId").value = document
    .getElementById("bookId")
    .value.toUpperCase();
}
