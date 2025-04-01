<?php

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
        <input name="user_number" id="user_number" class="user_number" type="number" />
        <input name="poits" id="poits" class="poits" type="number" />
        <button>Add</button>
        <button class="add_fields_btn" id="add_fields_btn" name="add_fields_btn"> + </button>
    </div> <br/>
    <div class="add_div"></div>
</body>

<script>
    var field = `
            <div >
                <input  type="number" />
                <input  type="number" />
                <button>Add</button>

            </div> <br/>
`;
    $('#add_fields_btn').click(function() {
        $('.add_div').append(field);
    })
</script>

</html>