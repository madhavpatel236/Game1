$(document).ready(function () {
  let isValidate;


  function nameValidation() {
    var name = $("#name").val().trim();
    if (name === "") {
      $("#name_error").text("name is require for this form.");
      return false;
    } else {
      $("#name_error").text("");
      return true;
    }
  }
  function passswordValidation() {
    var password = $("#password").val().trim();
    if (password === "") {
      $("#password_error").text("password is require for this form.");
      return false;
    } else {
      $("#name_error").text("");
      return true;
    }
  }

  function emailValidation() {
    var email = $("#email").val().trim();
    if (email == "") {
      $("#email_error").text("Email is require for this form.");
      return false;
    } else if (!isValidEmail(email)) {
      $("#email_error").text("Please enter a valid email address!!");
      return false;
    } else {
      $("#email_error").text("");
      return true;
    }
  }

  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  $("#email").on("input", emailValidation);
  $("#password").on("input", passswordValidation);
  $("#name").on("input", nameValidation);

  // console.log(isValidate);
  $("#loginForm").submit(function (e) {
    isValidate = passswordValidation() || emailValidation();
    if (!isValidate) {
      e.preventDefault();
    }
  });

  $("#registerForm").submit(function (e) {
    isValidate = nameValidation() || passswordValidation() || emailValidation();
    if (!isValidate) {
      e.preventDefault();
    }
  });
});
