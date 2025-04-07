<?php
require('../constant.php');
include  __APPPATH__ . '/controller/adminController.php';
// var_dump($GLOBALS);

if ($_SESSION['isLogin'] != true) {
    header("Location: ../index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="../assets/adminAuth.js"></script>
</head>

<body>
    <form method="post">
        <button type="submit" class="logout_btn" name="logout_btn"> Logout </button>
    </form>
    <div class="div1">
        <span class="heading1" style="padding-right: 100px;"> Users Number </span>
        <span class="heading2"> Points </span>
    </div>
    <div class="div2">
        <input id="edit_id" type="hidden" />
        <input name="user_number0" id="user_number0" class="user_number0" type="number" />
        <input name="points0" id="points0" class="points0" type="number" />
        <button class="add_fields_btn" id="add_fields_btn" name="add_fields_btn"> + </button>
        <div id="common_error"></div>
    </div> <br />

    <div class="add_div"></div>

    <button name="submit_rule" id="submit_rule" class="submit_rule">Add</button>
    <button id="update_rule" name="update_rule" style="display:none;">Update</button>
    <div class='common_error'></div>

    <table style="display: none;" class="list_rules" border=2>
        <tr>
            <th>No.</th>
            <th> Number of Players </th>
            <th> Points </th>
            <th></th>
        </tr>
        <tbody id="data_body"></tbody>
    </table>

    <button name="show_leaderbord" id="show_leaderbord" class="show_leaderbord"> Show Leaderbord </button>
    <button name="hide_leaderbord" id="hide_leaderbord" class="hide_leaderbord" style="display: none;"> Hide Leaderbord</button>
    <h4 style="display: none;" class="leaderbordEmpty_message"> No user completed the test </h4>
    <table id="leaderboard" border=1 style="display: none;">
        <tr>
            <th>Rank</th>
            <th>Name</th>
            <th>Points</th>
        </tr>
        <tbody id="leaderboardData">
        </tbody>
    </table>
</body>

<script>
    readRules();

    var count = 0;
    var userNumberArray = [];
    var pointsArray = [];

    $('#add_fields_btn').click(function() {
        count += 1;
        if (count >= 1) {
            var field = `
            <div class='new_added_div${count}'  id='${count}'>
                <div>
                    <input class='user_number' id = 'user_number${count}' type="number" />
                    <input class='points' id='points${count}' type="number" />
                    <input class='field_id' id='${count}' hidden />
                    <button onclick='removeFieldData(${count})'  class="remove_btn" id = '${count}'> - </button>
            </div> <br/> </div>`;
            $('.add_div').append(field)
        };
    })

    $('.submit_rule').click(function() {
        for (let i = 0; i <= count; i++) {
            let userNumber = $(`#user_number${i}`).val();
            let addPoints = $(`#points${i}`).val();
            userNumberArray[i] = userNumber;
            pointsArray[i] = addPoints;
        }

        $.ajax({
            url: '../controller/adminController.php',
            type: "POST",
            data: {
                action: "create",
                UserNumber: userNumberArray,
                Points: pointsArray,
            },
            success: function(response) {
                $('.user_number0').val("");
                $('input').val("");
                for (let i = 1; i <= count + 1; i++) {
                    $(`.new_added_div${i}`).remove();
                }
                readRules();
            }
        })
    })

    $('#update_rule').click(function() {
        var NumberOfPlayers = $('#user_number0').val();
        var Points = $('#points0').val();
        var Id = $('#edit_id').val();
        $.ajax({
            url: '../controller/adminController.php',
            type: 'POST',
            data: {
                action: "update",
                id: Id,
                numberOfPlayers: NumberOfPlayers,
                points: Points
            },
            success: function(response) {
                // alert(response);
                // console.log(response);
                $('#user_number0').val('');
                $('#points0').val('');
                $('#update_rule').hide();
                $('#submit_rule').show();
                readRules();
            }
        })
    })

    $('#show_leaderbord').click(function() {
        $.ajax({
            url: '../controller/adminController.php',
            type: "POST",
            data: {
                action: "getLeaderBord",
            },
            success: function(response) {
                var user = JSON.parse(response);
                var values = '';

                if (user.length > 0) {
                    $('#leaderboard').show();
                    for (let i = 0; i < user.length; i++) {
                        values += '<tr>';
                        values += "<td>" + user[i].Rank + "</td> ";
                        values += "<td>" + user[i].Name + "</td> ";
                        values += "<td>" + user[i].Points + "</td> ";
                        values += '</tr>';
                        $('#leaderboardData').html(values);
                        $('#hide_leaderbord').show();
                        $('#show_leaderbord').hide();
                    }
                } else {
                    $('.leaderbordEmpty_message').show();
                    $('#hide_leaderbord').show();
                    $('#show_leaderbord').hide();
                    $('#submit_rule').show();
                }

            }
        })
    })

    $('#hide_leaderbord').click(function() {
        $('#leaderboard').hide();
        $('.leaderbordEmpty_message').hide();
        $('#hide_leaderbord').hide()
        $('#show_leaderbord').show()
    })

    function readRules() {
        $.ajax({
            url: '../controller/adminController.php',
            type: 'POST',
            data: {
                action: "read",
            },
            success: function(response) {
                var user = JSON.parse(response);
                var values = "";
                if (user.length > 0) {
                    $('.list_rules').show();
                    for (let i = 0; i <= user.length - 1; i++) {
                        // $(`#user_number${i}`).val(user[i].PlayerNumber);
                        // $(`#points${i}`).val(user[i].Points);
                        values += "<tr " + " " + 'class =' + user[i].Id + ">";
                        values += "<input  " + " " + 'id =' + user[i].Id + " " + 'type=hidden' + " /> ";
                        values += "<td>" + (i + 1) + "</td>";
                        values += "<td>" + user[i].PlayerNumber + "</td>";
                        values += "<td>" + user[i].Points + "</td>";
                        values += "<td><button" + ' ' + 'class=' + 'edit_btn' + ' ' + 'onclick=' + 'editRule(' + user[i].Id + ')' + ' ' + user[i].Id + "> Edit </button> <button" + ' ' + 'class=' + 'delete_btn' + ' ' + 'onclick=' + 'deleteRule(' + user[i].Id + ')' + "> Delete </button> </td >";
                        values += "</tr>";
                        $('#data_body').html(values);
                    }
                }
            }
        })
    }

    function deleteRule(id) {
        $.ajax({
            url: '../controller/adminController.php',
            type: "POST",
            data: {
                action: 'delete',
                Id: id
            },
            success: function(response) {
                // alert(response);
                readRules();
                $(`.${id}`).hide();
            }
        })
    }

    function editRule(id) {
        $.ajax({
            url: '../controller/adminController.php',
            type: 'POST',
            data: {
                action: "edit",
                Id: id
            },
            success: function(response) {
                var user = JSON.parse(response);
                // console.log(user[0]);
                $('#user_number0').val(user[0].NumberOfPlayers);
                $('#points0').val(user[0].Points);
                $('#edit_id').val(user[0].Id);
                $('#update_rule').show();
                $('.submit_rule').hide();
                $('#add_fields_btn').hide();

            }
        })
    }

    function removeFieldData(id) {
        $(`.new_added_div${id}`).remove();
    }
</script>

</html>