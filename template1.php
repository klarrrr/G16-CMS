<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample Template 1</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffffff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-bottom: 1px solid #eaeaea;
        }

        nav p {
            font-weight: bold;
            font-size: 1.2rem;
            color: #555;
        }

        nav ul {
            display: flex;
            gap: 20px;
        }

        nav ul li {
            list-style: none;
            font-size: 1rem;
            color: #333;
            cursor: pointer;
            transition: color 0.2s;
        }

        nav ul li:hover {
            color: #007bff;
        }

        .hero {
            text-align: center;
            padding: 3rem 1rem;
            background-color: #fff;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            margin-bottom: 2rem;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #222;
        }

        .hero p {
            font-size: 1.1rem;
            color: #555;
        }

        #content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1rem 2rem;
        }

        section {
            background-color: #ffffff;
            padding: 2rem;
            margin-bottom: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        section h1 {
            font-size: 1.8rem;
            color: #222;
            margin-bottom: 1rem;
        }

        section p {
            font-size: 1rem;
            color: #444;
        }

        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
            }

            nav ul {
                flex-direction: column;
                gap: 10px;
                margin-top: 1rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            section h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <nav>
        <p>BRAND AREA</p>
        <ul>
            <li>Home</li>
            <li>Services</li>
            <li>Contact</li>
            <li>About</li>
        </ul>
    </nav>

    <div class="hero">
        <h1>Welcome to Title Card</h1>
        <p>This is where your creativity begins!</p>
    </div>

    <?php
    include 'connect.php';

    $jsonSections = [];

    // Fetch data for three sections
    for ($i = 1; $i <= 3; $i++) {
        $sql = "SELECT content FROM elements WHERE section_owner = '$i'";
        $result = mysqli_query($conn, $sql);
        $content = json_decode(mysqli_fetch_assoc($result)['content'] ?? '{}', true);

        $jsonSections[] = [
            'section' => $i,
            'title' => $content['title'] ?? '',
            'paragraph' => $content['paragraph'] ?? ''
        ];
    }

    echo "<script>const sections = " . json_encode($jsonSections) . ";</script>";
    ?>

    <div id="content"></div>

    <script>
        const container = document.getElementById('content');
        
        sections.forEach(sec => {
            const sectionEl = document.createElement('section');
            sectionEl.innerHTML = `
                <h1>${sec.title}</h1>
                <p>${sec.paragraph}</p>
            `;
            container.appendChild(sectionEl);
        });
    </script>

</body>
</html>
