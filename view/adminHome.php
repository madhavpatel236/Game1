<?php
require('../constant.php');
include  __APPPATH__ . '/controller/adminController.php';
// var_dump($GLOBALS);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <!-- <script src="./assets/auth.js" ></script> -->
</head>

<body>
    <div class="div1">
        <span class="heading1" style="padding-right: 100px;"> Users Number </span>
        <span class="heading2"> Points </span>
    </div>
    <div class="div2">
        <input name="user_number0" id="user_number0" class="user_number0" type="number" />
        <input name="points0" id="points0" class="points0" type="number" />
        <button class="add_fields_btn" id="add_fields_btn" name="add_fields_btn"> + </button>
    </div> <br />

    <div class="add_div"></div>

    <button name="submit_rule" class="submit_rule">Add</button>
    <div class='common_error'></div>
</body>

<script>
    var count = 0;
    var userNumberArray = [];
    var pointsArray = [];

    $('#add_fields_btn').click(function() {
        readRules(); // TODO: add after all the btn click res end.
        count += 1;
        var field = `
                <div>
                    <input class='user_number' id = 'user_number${count}' type="number" />
                    <input class='points' id = 'points${count}' type="number" />
                    <input class='field_id' id='${count}' hidden />
                    <button  class="remove_btn" id = 'remove${count}'> - </button>
            </div> <br/>`;
        $('.add_div').append(field);
    })


    $('.submit_rule').click(function() {
        for (let i = 0; i <= count; i++) {
            let userNumber = $(`#user_number${i}`).val();
            let addPoints = $(`#points${i}`).val();
            userNumberArray[i] = userNumber;
            pointsArray[i] = addPoints;

        }
        // console.log(userNumberArray);
        // console.log(pointsArray);

        $.ajax({
            url: '../controller/adminController.php',
            type: "POST",
            data: {
                action: "create",
                UserNumber: userNumberArray,
                Points: pointsArray,
            },
            success: function(response) {
                // alert(response);
            }
        })
    })

    // $('.remove_btn').click(function() {})

    function readRules() {
        $.ajax({
            url: '../controller/adminController.php',
            type: 'POST',
            data: {
                action: "read"
            },
            success: function(response) {
                console.log(response);
            }
        })
    }

</script>

</html>