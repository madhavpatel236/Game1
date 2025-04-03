<?php
require('../constant.php');
include __APPPATH__ . '/controller/userController.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/userAuth.js"></script>
</head>

<body>
    <form id="quizeForm" method="post">
        <h2> Questions </h2>
        <div>
            <h4> Question:1 -> Which is Your favorite IPL team? </h4>
            <input name="question1" id="question1" type="text" />
        </div>

        <div>
            <h4> Question:2 -> Which is your favorite player? </h4>
            <input id="question2" name="question2" type="text" />
        </div>

        <div>
            <h4> Question:3 -> Hom many IPL season was organized so far? </h4>
            <input name="question3" id="question3" type="number" />
            <span id="answer3_error"> </span>
        </div>

        <div>
            <h4> Question:4 -> Which is the highest run scorer in IPL(all seasons)? </h4>
            <input name="question4" id="question4" type="text" />
        </div>

        <div>
            <h4> Question:5 -> When india was won the last icc trophies? </h4>
            <input name="question5" id="question5" type="text" />
        </div> <br />

        <div id="question_error"> </div>
        <button name="submit_btn" class="submit_btn"> Submit </button>
    </form>

    <table name="rankTable" id="rankTable" class="rankTable" border="2">
        <tr id="table_header">
            <th>Rank</th>
            <th>Name</th>
            <th>Points</th>
        </tr>
        <tbody class="tableBody" name="tableBody" id="tableBody">

        </tbody>
    </table>
</body>

<script>
    readUser();

    function readUser() {
        $.ajax({
            url: '../controller/userController.php',
            type: 'POST',
            data: {
                action: 'read'
            },
            success: function(response) {
                // alert(response);
                // alert(user[1]);
                var user = JSON.parse(response);
                var values = '';

                if (user.length > 0) {
                    for (let i = 0; i < user.length ; i++) {
                        values += '<tr>';
                        values += "<td>" + (user[i].Rank) + "</td> ";
                        values += "<td>" + user[i].Name + "</td> ";
                        values += "<td>" + user[i].Points + "</td> ";
                        values += '</tr>';
                        $('#tableBody').html(values);
                    }
                }
            }
        })
    }
</script>

</html>