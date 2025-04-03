$(document).ready(function () {
  // var user_number = $(".user_number0").val().trim();
  // var points = $(".points0").val().trim();
  var isValidate = true;

  function onlyNnumbers() {
    var value = $(".user_number0").val().trim();
    var value2 = $(".points0").val().trim();
    if (value < 0) {
      $("#common_error").text("Only positive numbers are allowed.");
      // $("#question3").val("");
    }
  }

  $("#user_number0").on("input", onlyNnumbers);
  $("#points0").on("input", onlyNnumbers);

});
