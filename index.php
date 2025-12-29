<?php
require_once "config/db.php";

/* About */
$about = $conn->query("SELECT * FROM about LIMIT 1")->fetch_assoc();

/* Events */
$events = $conn->query(
    "SELECT * FROM events ORDER BY event_date ASC LIMIT 6"
);

/* Team */
$teamResult = $conn->query(
    "SELECT * FROM team ORDER BY category, name"
);
$teams = [];
while ($m = $teamResult->fetch_assoc()) {
    $teams[$m['category']][] = $m;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Code Vimarsh | MSU Baroda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- User CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- ================= HEADER ================= -->
<header class="header">
    <div class="nav-container">
        <div class="logo">
            <img src="assets/images/logos/logo.webp" alt="Code Vimarsh">
            <span>Code Vimarsh</span>
        </div>

        <nav class="nav-links" id="navLinks">
            <a href="#home">Home</a>
            <a href="#events">Events</a>
            <a href="#team">Team</a>
        </nav>

        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</header>

<!-- ================= HOME / ABOUT ================= -->
<section id="home" class="section hero">
    <div class="hero-inner">
        <h1><?= htmlspecialchars($about['heading']) ?></h1>
        <p><?= nl2br(htmlspecialchars($about['description'])) ?></p>

        <a href="<?= htmlspecialchars($about['join_link']) ?>"
           target="_blank"
           class="primary-btn">
            Join the Community
        </a>
    </div>
</section>

<!-- ================= EVENTS ================= -->
<section id="events" class="section">
    <h2 class="section-title">Events</h2>

    <div class="events-grid">
        <?php while ($e = $events->fetch_assoc()) : ?>
            <a href="event.php?id=<?= $e['id'] ?>" class="event-link">
                <div class="event-card">
                    <img src="assets/images/events/<?= $e['image'] ?>" alt="Event">

                    <div class="event-body">
                        <h3><?= htmlspecialchars($e['title']) ?></h3>
                        <p><?= $e['event_date'] ?> · <?= $e['event_time'] ?></p>
                    </div>
                </div>
            </a>
        <?php endwhile; ?>

    </div>
</section>

<!-- ================= TEAM ================= -->
<section id="team" class="section light">
    <h2 class="section-title">Meet the Team</h2>

    <?php foreach ($teams as $category => $members) : ?>
        <h3 class="team-heading"><?= ucwords($category) ?></h3>

        <div class="team-grid">
            <?php foreach ($members as $m) : ?>
                <a href="<?= htmlspecialchars($m['linkedin_url']) ?>"
                   target="_blank"
                   class="team-card">
                    <img src="assets/images/team/<?= $m['image'] ?>" alt="Member">
                    <h4><?= htmlspecialchars($m['name']) ?></h4>
                    <span><?= htmlspecialchars($m['role']) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</section>

<!-- ================= FOOTER ================= -->

<footer class="footer">

    <div class="footer-logos">
        <img src="assets/images/logos/logo.webp" alt="Code Vimarsh" class="footer-logo">
        <img src="assets/images/logos/msu.png" alt="MSU" class="footer-logo">
    </div>

    <p class="footer-text">
        Code Vimarsh | Empowering Innovation at Maharaja Sayajirao University
    </p>

    <div class="footer-social">
        <?php
        $socials = $conn->query("SELECT * FROM social_links");
        while ($s = $socials->fetch_assoc()) :
        ?>
            <a href="<?= htmlspecialchars($s['link']) ?>" target="_blank">
                <img src="assets/images/logos/<?= $s['icon'] ?>" alt="social">
            </a>
        <?php endwhile; ?>
    </div>

    <a href="mailto:codevimarsh@msubaroda.ac.in" class="chat-link">
        Chat with us
    </a>

    <p class="copyright">
        © <?= date("Y") ?> Code Vimarsh
    </p>

</footer>



<script>
const sections = document.querySelectorAll("section[id]");
const navLinks = document.querySelectorAll(".nav-links a");
const headerOffset = 90; // height of fixed header

function setActiveNav() {
    let currentSection = "";

    sections.forEach(section => {
        const sectionTop = section.offsetTop - headerOffset;
        const sectionHeight = section.offsetHeight;

        if (window.scrollY >= sectionTop &&
            window.scrollY < sectionTop + sectionHeight) {
            currentSection = section.getAttribute("id");
        }
    });

    navLinks.forEach(link => {
        link.classList.remove("active");
        if (link.getAttribute("href") === `#${currentSection}`) {
            link.classList.add("active");
        }
    });
}

// Run on scroll
window.addEventListener("scroll", setActiveNav);

// Run once on load
setActiveNav();

// Mobile menu toggle (keep this)
function toggleMenu() {
    document.getElementById("navLinks").classList.toggle("active");
}
</script>


</body>
</html>
