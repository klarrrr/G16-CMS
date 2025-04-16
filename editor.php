<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="editor.php" method="post">
        <div>
            <!-- Input for First Title -->
            <label for="first_title">First Title: </label>
            <input type="text" name="first_title" id="">
        </div>
        <div>
            <!-- Input for Second Title -->
            <label for="Second_title">Second Title: </label>
            <input type="text" name="second_title" id="">
        </div>
        <div>
            <!-- Input for Third Title -->
            <label for="Third_title">Third Title: </label>
            <input type="text" name="third_title" id="">
        </div>
        <input type="submit" value="Submit" name="update_btn">
    </form>
    <?php

    include 'connect.php';

    if (isset($_POST["update_btn"])) {
        $first_title = $_POST["first_title"];
        $sql = "UPDATE elements SET content = '$first_title' WHERE element_id = '1' AND element_name = 'Title Text' ";
        mysqli_query($conn, $sql);

        $second_title = $_POST["second_title"];
        $sql = "UPDATE elements SET content = '$second_title' WHERE element_id = '2' AND element_name = 'Title Text' ";
        mysqli_query($conn, $sql);

        $third_title = $_POST["third_title"];
        $sql = "UPDATE elements SET content = '$third_title' WHERE element_id = '3' AND element_name = 'Title Text' ";
        mysqli_query($conn, $sql);
    }

    ?>
</body>

</html>