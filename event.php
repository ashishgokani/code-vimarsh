<?php
require_once "config/db.php";

/* Validate event ID */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$event_id = (int) $_GET['id'];

/* Fetch event */
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: index.php");
    exit();
}

$event = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($event['title']) ?> | Code Vimarsh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- User CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- ================= HEADER (REUSE SAME HEADER) ================= -->
<header class="header">
    <div class="nav-container">
        <div class="logo">
            <img src="assets/images/logos/logo.webp" alt="Code Vimarsh">
            <span>Code Vimarsh</span>
        </div>

        <nav class="nav-links" id="navLinks">
            <a href="index.php#home">Home</a>
            <a href="index.php#events">Events</a>
            <a href="index.php#team">Team</a>
        </nav>

        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</header>

<!-- ================= EVENT DETAILS ================= -->
<section class="section event-detail">

    <div class="event-detail-container">

        <img src="assets/images/events/<?= $event['image'] ?>"
             alt="Event Image"
             class="event-detail-image">

        <h1><?= htmlspecialchars($event['title']) ?></h1>

        <p class="event-detail-meta">
            📅 <?= htmlspecialchars($event['event_date']) ?>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            ⏰ <?= htmlspecialchars($event['event_time']) ?>
        </p>

        <div class="event-detail-description">
            <?= nl2br(htmlspecialchars($event['description'])) ?>
        </div>

        <a href="index.php#events" class="back-link">
            ← Back to Events
        </a>

    </div>

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
function toggleMenu() {
    document.getElementById("navLinks").classList.toggle("active");
}
</script>

</body>
</html>
