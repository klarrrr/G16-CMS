<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample Template 1</title>
    <style>
        nav {
            display: flex;
            flex-direction: row;
            background-color: pink;
        }

        nav ul {
            display: flex;
            flex-direction: row;
            gap: 10px;
        }

        nav ul li {
            text-decoration: none;
            list-style: none;
        }
    </style>
</head>

<body>
    <nav>
        <!-- Dito ilalagay yung  -->
        <p>BRAND AREA</p>
        <ul>
            <li>Home</li>
            <li>Services</li>
            <li>Contact</li>
            <li>About</li>
        </ul>
    </nav>
    <div class="">
        <h1>Welcome to Title Card</h1>
        <p>This is where your creativity begins!</p>
    </div>
    <section>
        <?php

        include 'connect.php';

        $sql = "SELECT content FROM elements WHERE section_owner = '1' AND element_name = 'Title Text' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        echo "<h1>" . $row[0] . "</h1>";

        $sql = "SELECT content FROM elements WHERE section_owner = '1' AND element_name = 'Paragraph Text' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        echo "<p>" . $row[0] . "</p>";

        ?>
    </section>
    <section>
        <?php

        $sql = "SELECT content FROM elements WHERE section_owner = '2' AND element_name = 'Title Text' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        echo "<h1>" . $row[0] . "</h1>";

        $sql = "SELECT content FROM elements WHERE section_owner = '2' AND element_name = 'Paragraph Text' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        echo "<p>" . $row[0] . "</p>";

        ?>
    </section>
    <section>
        <?php

        $sql = "SELECT content FROM elements WHERE section_owner = '3' AND element_name = 'Title Text' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        echo "<h1>" . $row[0] . "</h1>";

        $sql = "SELECT content FROM elements WHERE section_owner = '3' AND element_name = 'Paragraph Text' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        echo "<p>" . $row[0] . "</p>";

        ?>
    </section>
</body>

</html>