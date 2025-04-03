$(document).ready(function () {
  let isValidate;

  function onlyNnumbers() {
    var answer3 = $("#question3").val().trim();
    console.log(answer3 < 0); 
    if (answer3 < 0) {
      $("#answer3_error").text("Only positive numbers are allowed.");
      // $("#question3").val("");
    }
  }

  function answerValidation() {
    var answer1 = $("#question1").val().trim();
    var answer2 = $("#question2").val().trim();
    var answer3 = $("#question3").val().trim();
    var answer4 = $("#question4").val().trim();
    var answer5 = $("#question5").val().trim();
    if (
      answer1 == "" ||
      answer2 == "" ||
      answer3 == "" ||
      answer4 == "" ||
      answer5 == ""
    ) {
      $("#question_error").text("*All the answers is require for this Quize.");
      return false;
    } else {
      $("#question_error").text("");
      return true;
    }
  }

  $("#question1").on("input", answerValidation);
  $("#question2").on("input", answerValidation);
  $("#question3").on("input", answerValidation);
  $("#question3").on("input", onlyNnumbers);
  $("#question4").on("input", answerValidation);
  $("#question5").on("input", answerValidation);

  $("#quizeForm").submit(function (e) {
    isValidate = answerValidation();
    if (!isValidate) {
      e.preventDefault();
    }
  });
});
