<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lundayan : Team</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
        #team-body {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .team-main-content {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        .team-profile {
            height: 100%;
            box-sizing: border-box;
            overflow: hidden;
            padding-bottom: 10rem;
            width: 100vw;
            display: grid;
            grid-template-columns: 5% 90% 5%;
            /* Space so content isn't hidden under carousel */
        }

        .team-main {
            padding: 4vh 12vw;
        }

        .breadcrumb {
            font-size: 0.9rem;
            color: #f4f4f4;
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .profile-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .profile-info {
            flex: 1;
            align-self: center;
            margin-bottom: 30vh;
        }

        .profile-info h1 {
            font-size: 2.5rem;
            margin: 0;
        }

        .profile-info h3 {
            font-size: 1.25rem;
            color: #666;
            margin-top: 0.25rem;
        }

        .profile-info p {
            margin-top: 1rem;
            line-height: 1.6;
            color: #c3c3c3;
        }

        .arrow-left,
        .arrow-right {
            font-size: 3rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #f4f4f4;
        }

        .arrow-left {
            margin-left: 2rem;
        }

        .arrow-right {
            margin-right: 2rem;
        }

        .profile-photo {
            width: 500px;
            max-width: 700px;
            height: 100%;
            /* border: 1px solid #fcb404; */
            /* overflow: hidden; */
            display: flex;
            justify-content: center;
        }

        .profile-photo img {
            height: 100vh;
            z-index: -1;
        }

        .team-carousel {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            display: flex;
            flex-direction: row;
            overflow-x: auto;

            gap: 1rem;
            overflow-x: visible;
            padding: 2vh 12vw;
            border-top: 1px solid #eee;
            -webkit-backdrop-filter: blur(15px);
            backdrop-filter: blur(15px);
            background: rgba(24, 58, 44, 0.55);
            z-index: 10;
            justify-content: center;
        }

        .team-member {
            text-align: center;
            min-width: 120px;
        }

        .team-member img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        .team-member strong {
            display: block;
            margin-top: 0.5rem;
            font-size: 0.8rem;
        }

        .team-member span {
            font-size: 0.7rem;
            color: #666;
        }
    </style>
</head>

<body id='team-body' style='background-image: linear-gradient(180deg, hsla(155, 41%, 16%, 1) 0%, rgba(29, 47, 41, 0.88) 100%), url(pics/plp-outside.jpg);'>
    <?php include 'lundayan-site-upper-nav.php' ?>
    <?php include 'lundayan-site-nav.php'; ?>

    <main class="team-main-content">
        <section class="team-profile">
            <button class="arrow-left">&larr;</button>
            <div class="team-main">
                <div class="breadcrumb">
                    <p style='color: #f4f4f4; font-weight: bolder;'>G-16</p>
                    <p style='color: #f4f4f4; font-weight: bolder;'>BSIT-2C</p>
                </div>

                <div class="profile-container">
                    <div class="profile-info">
                        <h1>Sydney Sweeney</h1>
                        <h3>Chairman & CEO</h3>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut pariatur fugit sed cupiditate temporibus vel, quidem odit! Corrupti sequi delectus enim tempore ipsa consectetur eius nobis voluptatum, ipsam tempora placeat? Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vel quam maxime ab. Voluptatibus non officia, perferendis fugiat dignissimos eligendi commodi quibusdam soluta nostrum consequatur maiores nesciunt dolorum libero ipsam laborum. Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore iure, error similique, eum ex eveniet in enim pariatur accusantium temporibus fuga commodi tempora hic voluptates deleniti. Veniam sint voluptatem aut.
                        </p>
                    </div>
                    <div class="profile-photo">
                        <img src="pics/Sydney-Sweeney-Jumpsuit-Half-Body-Buddy-Cutout_158f0d7b-cde9-4a63-a131-d010cbc4e3f8.dd61fa9b72e4f5837911ec00c8df7283.webp" alt="Chang Qiu Sheng" />
                    </div>
                </div>
            </div>
            <button class="arrow-right">&rarr;</button>
        </section>

        <div class="team-carousel">
            <div class="team-member">
                <img src="chang-qiu-sheng.jpg" alt="BERMUDEZ, MIGUEL CARLOS R." />
                <strong>MIGUEL CARLOS R. BERMUDEZ</strong>
                <span>CEO</span>
            </div>
            <div class="team-member">
                <img src="vicky-tsui.jpg" alt="CASTRO, CHARL JOVEN V." />
                <strong>CHARL JOVEN V. CASTRO</strong>
                <span>VP of Marketing</span>
            </div>
            <div class="team-member">
                <img src="pics/90477869_583028765758138_5089600927967477760_n.jpg" alt="DE PADUA, CHARLES JERAMY C." />
                <strong>CHARLES JERAMY C. DE PADUA</strong>
                <span>VP of Flight Operation</span>
            </div>
            <div class="team-member">
                <img src="bob-li.jpg" alt="FRANCISCO, PAUL JUSTIN D." />
                <strong>PAUL JUSTIN D. FRANCISCO</strong>
                <span>VP of Operations</span>
            </div>
            <div class="team-member">
                <img src="david-du.jpg" alt="GALLARDO, MARVIN D." />
                <strong>MARVIN D. GALLARDO</strong>
                <span>Executive VP</span>
            </div>
            <div class="team-member">
                <img src="zoe-zhao.jpg" alt="GARCIA, SEAN PAUL F." />
                <strong>SEAN PAUL F. GARCIA</strong>
                <span>VP of Finance</span>
            </div>
            <div class="team-member">
                <img src="nicole-chen.jpg" alt="JUMAO-AS, SAMANTHA O." />
                <strong>SAMANTHA O. JUMAO-AS</strong>
                <span>VP of HR</span>
            </div>
            <div class="team-member">
                <img src="nicole-chen.jpg" alt="MANRIQUE, KLARENZ COBIE O." />
                <strong>KLARENZ COBIE O. MANRIQUE</strong>
                <span>VP of HR</span>
            </div>
            <div class="team-member">
                <img src="nicole-chen.jpg" alt="MEDRANO, GRACI AL DEI R." />
                <strong>GRACI AL DEI R. MEDRANO</strong>
                <span>VP of HR</span>
            </div>
            <div class="team-member">
                <img src="nicole-chen.jpg" alt="MODANCIA, JOHN CHESTER Q." />
                <strong>JOHN CHESTER Q. MODANCIA</strong>
                <span>VP of HR</span>
            </div>
        </div>

    </main>

    <?php include 'lundayan-site-footer.php' ?>

</body>

</html>