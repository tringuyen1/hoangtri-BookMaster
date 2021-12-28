// clear textbox
$(document).ready(function () {
  $(".btn-clear").click(function () {
    $("#formBook")[0].reset();
  });
});

function upperMe() {
  document.getElementById("form_bookId").value = document
    .getElementById("bookId")
    .value.toUpperCase();
}