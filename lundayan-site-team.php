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
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;

            p {
                font-size: 0.9rem;
                color: #f4f4f4;
                letter-spacing: 0.5rem;
                font-weight: bold;
            }
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
            color: #c6c6c6;
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
                    <p>G-16</p>
                    <p>BSIT-2C</p>
                </div>

                <div class="profile-container">
                    <div class="profile-info">
                        <h1>Marvin Gallardo</h1>
                        <h3>G1 Secretary</h3>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut pariatur fugit sed cupiditate temporibus vel, quidem odit! Corrupti sequi delectus enim tempore ipsa consectetur eius nobis voluptatum, ipsam tempora placeat? Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vel quam maxime ab. Voluptatibus non officia, perferendis fugiat dignissimos eligendi commodi quibusdam soluta nostrum consequatur maiores nesciunt dolorum libero ipsam laborum. Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore iure, error similique, eum ex eveniet in enim pariatur accusantium temporibus fuga commodi tempora hic voluptates deleniti. Veniam sint voluptatem aut.
                        </p>
                    </div>
                    <div class="profile-photo">
                        <img src="pics/486323055_9429894183798307_5671286570096958651_n-removebg-preview.png" alt="Chang Qiu Sheng" />
                    </div>
                </div>
            </div>
            <button class="arrow-right">&rarr;</button>
        </section>

        <div class="team-carousel">

            <div class="team-member">
                <a href="https://www.facebook.com/Micoish" target="_blank" rel="noopener noreferrer">
                    <img src="pics/bermudez.jpg" alt="BERMUDEZ, MIGUEL CARLOS R." />
                </a>
                <strong>MIGUEL CARLOS R. BERMUDEZ</strong>
                <span>G6 Member</span>
            </div>
            <div class="team-member">
                <a href="https://www.facebook.com/castrogaming0509" target="_blank" rel="noopener noreferrer">
                    <img src="pics/cj_pogi.jpg" alt="CASTRO, CHARL JOVEN V." />
                </a>
                <strong>CHARL JOVEN V. CASTRO</strong>
                <span>G1 Member</span>
            </div>
            <div class="team-member">
                <a href="https://www.facebook.com/RattanNaJumboXL" target="_blank" rel="noopener noreferrer">
                    <img src="pics/90477869_583028765758138_5089600927967477760_n.jpg" alt="DE PADUA, CHARLES JERAMY C." />
                </a>
                <strong>CHARLES JERAMY C. DE PADUA</strong>
                <span>G1 Member</span>
            </div>
            <div class="team-member">
                <a href="https://www.facebook.com/paul.justin.francisco" target="_blank" rel="noopener noreferrer">
                    <img src="pics/paul.jpg" alt="FRANCISCO, PAUL JUSTIN D." />
                </a>
                <strong>PAUL JUSTIN D. FRANCISCO</strong>
                <span>G6 Leader</span>
            </div>
            <div class="team-member">
                <a href="https://www.facebook.com/Vingallardo21" target="_blank" rel="noopener noreferrer">
                    <img src="pics/vin.jpg" alt="GALLARDO, MARVIN D." />
                </a>
                <strong>MARVIN D. GALLARDO</strong>
                <span>G1 Secretary</span>
            </div>
            <div class="team-member">
                <a href="https://www.facebook.com/snplgrc28" target="_blank" rel="noopener noreferrer">
                    <img src="pics/garcia.jpg" alt="GARCIA, SEAN PAUL F." />
                </a>
                <strong>SEAN PAUL F. GARCIA</strong>
                <span>G6 Member</span>
            </div>
            <div class="team-member">
                <a href="https://www.facebook.com/samjzz24" target="_blank" rel="noopener noreferrer">
                    <img src="pics/sam.jpg" alt="JUMAO-AS, SAMANTHA O." />
                </a>
                <strong>SAMANTHA O. JUMAO-AS</strong>
                <span>G1 Member</span>
            </div>
            <div class="team-member">
                <a href="https://www.facebook.com/klarenz.cobie" target="_blank" rel="noopener noreferrer">
                    <img src="pics/klarenz.jpg" alt="MANRIQUE, KLARENZ COBIE O." />
                </a>
                <strong>KLARENZ COBIE O. MANRIQUE</strong>
                <span>G1 Leader</span>
            </div>
            <div class="team-member">
                <a href="https://www.facebook.com/gracialdei.medrano" target="_blank" rel="noopener noreferrer">
                    <img src="pics/graci.jpg" alt="MEDRANO, GRACI AL DEI R." />
                </a>
                <strong>GRACI AL DEI R. MEDRANO</strong>
                <span>G1 Member</span>
            </div>
            <div class="team-member">
                <a href="https://www.facebook.com/johnchesterquitalig.modancia" target="_blank" rel="noopener noreferrer">
                    <img src="pics/modancia.jpg" alt="MODANCIA, JOHN CHESTER Q." />
                </a>
                <strong>JOHN CHESTER Q. MODANCIA</strong>
                <span>G1 Member</span>
            </div>
        </div>

    </main>

    <?php include 'lundayan-site-footer.php' ?>
    <script>
        const profiles = [{
                name: "MIGUEL CARLOS R. BERMUDEZ",
                role: "G6 Member",
                desc: "Pain is temporary. Quitting lasts forever.",
                img: "pics/bermudez_stand.png"
            },
            {
                name: "CHARL JOVEN V. CASTRO",
                role: "G1 Member",
                desc: "The only easy day was yesterday.",
                img: "pics/cj_stand.png"
            },
            {
                name: "CHARLES JERAMY C. DE PADUA",
                role: "G1 Member",
                desc: "Lalalalava Chichichichiken, Steve's lava chicken yeah it's tasty as hell.",
                img: "pics/matigas.png"
            },
            {
                name: "PAUL JUSTIN D. FRANCISCO",
                role: "G6 Leader",
                desc: "Discipline is choosing between what you want now and what you want most.",
                img: "pics/paul_stand.png"
            },
            {
                name: "MARVIN D. GALLARDO",
                role: "G1 Secretary",
                desc: "Sweat saves blood. Blood saves lives. And brains save both.",
                img: "pics/vin_stand.png"
            },
            {
                name: "SEAN PAUL F. GARCIA",
                role: "G6 Member",
                desc: "The harder you work, the harder it is to surrender.",
                img: "pics/garcia_stand.png"
            },
            {
                name: "SAMANTHA O. JUMAO-AS",
                role: "G1 Member",
                desc: "You don’t get what you wish for. You get what you work for.",
                img: "pics/sam_stand.png"
            },
            {
                name: "KLARENZ COBIE O. MANRIQUE",
                role: "G1 Leader",
                desc: "Ako ay may lobo lumipad sa langit di ko na nakita pumutok na pala sayang lang pera ko pambili ng lobo sa pagkain sana nabusog pa ako.",
                img: "pics/IMG_20240604_113030_221.png"
            },
            {
                name: "GRACI AL DEI R. MEDRANO",
                role: "G1 Member",
                desc: "Excuses sound best to the person making them.",
                img: "pics/graci_stand.png"
            },
            {
                name: "JOHN CHESTER Q. MODANCIA",
                role: "G1 Member",
                desc: "The only limit is the one you set yourself.",
                img: "pics/modancia_stand.png"
            }
        ];

        let currentIndex = 7;

        const nameEl = document.querySelector(".profile-info h1");
        const roleEl = document.querySelector(".profile-info h3");
        const descEl = document.querySelector(".profile-info p");
        const imgEl = document.querySelector(".profile-photo img");

        function updateProfile(index) {
            const profile = profiles[index];
            nameEl.textContent = profile.name;
            roleEl.textContent = profile.role;
            descEl.textContent = profile.desc;
            imgEl.src = profile.img;
            imgEl.alt = profile.name;
        }

        updateProfile(currentIndex);

        document.querySelector(".arrow-left").addEventListener("click", () => {
            currentIndex = (currentIndex - 1 + profiles.length) % profiles.length;
            updateProfile(currentIndex);
        });

        document.querySelector(".arrow-right").addEventListener("click", () => {
            currentIndex = (currentIndex + 1) % profiles.length;
            updateProfile(currentIndex);
        });
    </script>

</body>

</html>