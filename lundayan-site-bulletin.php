<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lundayan : Bulletin</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
</head>

<body>
    <?php include 'lundayan-site-nav.php'; ?>
    <main>
        <section class="hero">
            <h1>BULLETIN</h1>
            <p>Posted news and events</p>
        </section>
        <div class="news-banner">
            <div class="scrolling-text">
                <span> | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | </span>
            </div>
        </div>

        <section class="sub-header">
            <h3>Search for article</h3>
            <div class="search">
                <input type="text" name='search-bar' id='search-bar' placeholder="Search for an existing article">
            </div>
            <div class="filters">
                <div class="filter-group">
                    <h3>Sort by category</h3>
                    <div class="filter-tags">
                        <button class="tag">PLP</button>
                        <button class="tag">Faculty</button>
                        <button class="tag">BSN</button>
                        <button class="tag selected">BSIT</button>
                        <button class="tag">BSA</button>
                        <button class="tag">BSCS</button>
                        <button class="tag">Library</button>
                        <button class="tag">Staff</button>
                        <button class="tag">Motivation</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="news-cards">

            <div class="bulletin-card-news-container">
                <div class="bulletin-news-card">
                    <img src="pics/sample1.jpg" alt="">
                    <div class="card-text-container">
                        <h2>Celebration of the Literary Month</h2>
                        <p class="time-posted">Posted <small>●</small> April 25, 2025</p>
                        <p>Spearheaded by The English Society (TES), the seminar titled "Mastering the Art of Writing:
                            Techniques and Strategies for Effective Writing" aims...</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="bulletin-news-card">
                    <img src="pics/plp-outside.jpg" alt="">
                    <div class="card-text-container">
                        <h2>𝟱𝟭% 𝗼𝗳 𝗙𝗶𝗹𝗶𝗽𝗶𝗻𝗼 𝗔𝗱𝘂𝗹𝘁𝘀 𝗦𝘁𝗿𝘂𝗴𝗴𝗹𝗲 𝘁𝗼 𝗜𝗱𝗲𝗻𝘁𝗶𝗳𝘆 𝗙𝗮𝗸𝗲
                            𝗡𝗲𝘄𝘀</h2>
                        <p class="time-posted">Posted <small>●</small> April 25, 2025</p>
                        <p>this is one of the issues tackled in the seminar titled “Democracy in Action: A Code to
                            Abide, Vote with Pride." It was held today at the PLP...</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="bulletin-news-card">
                    <img src="pics/sample3.jpg" alt="">
                    <div class="card-text-container">
                        <h2>"Help Me Help You: Mastering Peer Facilitation"</h2>
                        <p class="time-posted">Posted <small>●</small> April 25, 2025</p>
                        <p>The event, held at the PLP Function Hall, gathered members from various colleges. Resource
                            speaker, Mr. Mark M. Francisco emphasized the...</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="bulletin-news-card">
                    <img src="pics/sample4.jpg" alt="">
                    <div class="card-text-container">
                        <h2>Buwan ng Panitikan 2025</h2>
                        <p class="time-posted">Posted <small>●</small> April 25, 2025</p>
                        <p>Sa temang “Sikad Panitikan: Kultura at Panitikan ng Kaunlaran,” binigyang-diin ng palihan ang
                            mahalagang papel ng panitikan at kultura sa pagbubuo...</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="bulletin-news-card">
                    <img src="pics/sample5.jpg" alt="">
                    <div class="card-text-container">
                        <h2>Evaluation and Regional Quality Assessment Team (RQAT) On-Site Inspection</h2>
                        <p class="time-posted">Posted <small>●</small> April 25, 2025</p>
                        <p>Led by CHED officials, Mr. Sharn Rosmer Baluyot, CHED NCR Education Supervisor II, Dr. John
                            Mark S. Distor, and Dr. Sheila Marie G. Hocson, CHED...</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="bulletin-news-card">
                    <img src="pics/sample6.jpg" alt="">
                    <div class="card-text-container">
                        <h2>PLPians perform bayanihan in a clean-up drive today</h2>
                        <p class="time-posted">Posted <small>●</small> April 25, 2025</p>
                        <p>"Minsan lang po tayo mabisita, so it's nice to have the opportunity to contribute something
                            for PLP sa maliit na paraan," one student said.</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'lundayan-site-footer.php' ?>
</body>

</html>