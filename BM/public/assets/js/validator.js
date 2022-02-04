var arrMessage = {
  MSG001: "Vui lòng nhập id của sách",
  MSG002: "Hãy nhập Book ID bằng chữ số 1 byte",
  MSG003: "Sách đã được tìm thấy",
  MSG004: "Không thể tìm thấy Book ID****",
  MSG005: "Đã phát sinh ngoại lệ bằng xử lý server",
  MSG006: "Hãy nhập Book title",
  MSG007: "Hãy nhập tên tác giả",
  MSG008: "Hãy nhập nhà xuất bản",
  MSG009: "Hãy nhập ngày xuất bản",
  MSG0010: "Hãy nhập ngày xuất bản bằng chữ số 1 byte",
  MSG0011: "Book ID****đã được đăng ký. Hãy nhập ID khác",
  MSG0012: "Đã đăng ký sách",
  MSG0013: "Đã update sách",
  MSG0014: "Book ID****không được tìm thấy",
  MSG0015: "Đã xóa Book ID****",
  MSG0016: "Ngày xuất bản không hợp lệ",
};

function Validator(options) {
  function getParent(element, selector) {
    while (element.parentElement) {
      if (element.parentElement.matches(selector)) {
        return element.parentElement;
      }
      element = element.parentElement;
    }
  }

  var selectorRules = {};

  // Hàm thực hiện validate
  function validate(inputElement, rule) {
    var errorElement = getParent(
      inputElement,
      options.formGroupSelector
    ).querySelector(options.errorSelector);
    var errorMessage;

    // Lấy ra các rules của selector
    var rules = selectorRules[rule.selector];

    // Lặp qua từng rule & kiểm tra
    // Nếu có lỗi thì dừng việc kiểm
    for (var i = 0; i < rules.length; ++i) {
      errorMessage = rules[i](inputElement.value);

      if (errorMessage) break;
    }

    if (errorMessage) {
      errorElement.innerText = errorMessage;
      getParent(inputElement, options.formGroupSelector).classList.add(
        "invalid"
      );
    } else {
      errorElement.innerText = "";
      getParent(inputElement, options.formGroupSelector).classList.remove(
        "invalid"
      );
    }

    return !errorMessage;
  }

  // Lấy element của form cần validate
  var formElement = document.querySelector(options.form);
  if (formElement) {
    // Khi submit form
    formElement.onsubmit = function (e) {
      var isFormValid = true;

      // Lặp qua từng rules và validate
      options.rules.forEach(function (rule) {
        var inputElement = formElement.querySelector(rule.selector);
        var isValid = validate(inputElement, rule);
        if (!isValid) {
          isFormValid = false;
        }
      });

      if (isFormValid) {
        // change action
        if (document.pressed == "追加") {
          document.myForm.action = "add";
        } else if (document.pressed == "更新") {
          document.myForm.action = "update";
        } else if (document.pressed == "検索") {
          document.myFormSearch.action = "search";
        } else if (document.pressed == "削除") {
          document.myForm.action = "delete";
        }
        formElement.submit();
      } else {
        e.preventDefault();
      }
    };

    // Lặp qua mỗi rule và xử lý (lắng nghe sự kiện blur, input, ...)
    options.rules.forEach(function (rule) {
      // Lưu lại các rules cho mỗi input
      if (Array.isArray(selectorRules[rule.selector])) {
        selectorRules[rule.selector].push(rule.test);
      } else {
        selectorRules[rule.selector] = [rule.test];
      }

      var inputElements = formElement.querySelectorAll(rule.selector);

      Array.from(inputElements).forEach(function (inputElement) {
        // Xử lý trường hợp blur khỏi input
        inputElement.onblur = function () {
          validate(inputElement, rule);
        };

        // Xử lý mỗi khi người dùng nhập vào input
        inputElement.oninput = function () {
          var errorElement = getParent(
            inputElement,
            options.formGroupSelector
          ).querySelector(options.errorSelector);
          errorElement.innerText = "";
          getParent(inputElement, options.formGroupSelector).classList.remove(
            "invalid"
          );
        };
      });
    });
  }
}
// Định nghĩa rules
// Nguyên tắc của các rules:
// 1. Khi có lỗi => Trả ra message lỗi
// 2. Khi hợp lệ => Không trả ra cái gì cả (undefined)
Validator.isRequired = function (selector, message) {
  return {
    selector: selector,
    test: function (value) {
      return value ? undefined : message;
    },
  };
};

Validator.minLength = function (selector, min, message) {
  return {
    selector: selector,
    test: function (value) {
      return value.length >= min ? undefined : message;
    },
  };
};

Validator.maxLength = function (selector, max) {
  return {
    selector: selector,
    test: function (value) {
      return value.length <= max
        ? undefined
        : `Vui lòng nhập tối thiểu ${max} kí tự`;
    },
  };
};

Validator.maxNumber = function (selector, max, message) {
  return {
    selector: selector,
    test: function (value) {
      return value <= max ? undefined : message;
    },
  };
};

Validator.isBookId = function (selector, message) {
  return {
    selector: selector,
    test: function (value) {
      var regex = /^[A-Za-z0-9]+[a-zA-Z0-9]+[a-zA-Z0-9]+[a-zA-Z0-9]$/;
      return regex.test(value) ? undefined : message;
    },
  };
};

Validator.isYear = function (selector, message) {
  return {
    selector: selector,
    test: function (value) {
      var regex = /^(20)?[0-9]{2}$/;
      return regex.test(value) ? undefined : message;
    },
  };
};
Validator.isMonth = function (selector, message) {
  return {
    selector: selector,
    test: function (value) {
      var regex = /^(0?[1-9]|1[012])$/;
      return regex.test(value) ? undefined : message;
    },
  };
};
Validator.isDay = function (selector, message) {
  return {
    selector: selector,
    test: function (value) {
      var regex = /^(0?[1-9]|[12][0-9]|3[01])$/;
      return regex.test(value) ? undefined : message;
    },
  };
};
