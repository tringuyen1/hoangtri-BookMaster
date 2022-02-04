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

function checkValidateFormSearch() {
  Validator({
    form: "#formBookSearch",
    formGroupSelector: ".form-group",
    errorSelector: ".form-message",
    rules: [
      Validator.isRequired("#bookId", arrMessage.MSG001),
      Validator.maxLength("#bookId", 4),
      Validator.isBookId("#bookId", arrMessage.MSG002),
    ],
  });
}

function checkValidateFormBook() {
  Validator({
    form: "#formBook",
    formGroupSelector: ".form-group",
    errorSelector: ".form-message",
    rules: [
      Validator.isRequired("#bookTitle", arrMessage.MSG006),
      Validator.maxLength("#bookTitle", 40),

      Validator.isRequired("#authorName", arrMessage.MSG007),
      Validator.maxLength("#authorName", 40),

      Validator.isRequired("#publisher", arrMessage.MSG008),
      Validator.maxLength("#publisher", 40),

      Validator.isRequired("#year", arrMessage.MSG009),
      Validator.maxNumber("#year", 2021, arrMessage.MSG0016),
      Validator.isYear("#year", arrMessage.MSG0010),

      Validator.isRequired("#month", arrMessage.MSG009),
      Validator.maxNumber("#month", 12, arrMessage.MSG0016),
      Validator.isMonth("#month", arrMessage.MSG0010),

      Validator.isRequired("#day", arrMessage.MSG009),
      Validator.maxNumber("#day", 31, arrMessage.MSG0016),
      Validator.isDay("#day", arrMessage.MSG0010),
    ],
  });
}

function upperMe() {
  document.getElementById("form_bookId").value = document
    .getElementById("bookId")
    .value.toUpperCase();
}
