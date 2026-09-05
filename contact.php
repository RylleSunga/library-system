<?php
$sent = $_SERVER['REQUEST_METHOD'] === 'POST';
?>
<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Contact Library System</title><link rel="stylesheet" href="assets/css/style.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></head>
<body class="contact-page">
<header class="contact-header"><a href="dashboard.php" class="contact-brand">Library System</a><a href="dashboard.php" class="contact-back"><i class="fa-solid fa-arrow-left"></i> Back to dashboard</a></header>
<main class="contact-main">
<section class="contact-hero"><p class="panel-kicker">We are here to help</p><h1>Contact the library team</h1><p>Questions about your account, book details, or the collection? Send us a message or reach us through the details below.</p></section>
<section class="contact-layout">
<div class="contact-info"><div class="contact-detail"><i class="fa-solid fa-phone"></i><div><strong>Phone</strong><a href="tel:+639171234567">+63 917 123 4567</a></div></div><div class="contact-detail"><i class="fa-solid fa-envelope"></i><div><strong>Email</strong><a href="mailto:library@localhost">library@localhost</a></div></div><div class="contact-detail"><i class="fa-solid fa-clock"></i><div><strong>Library hours</strong><span>Monday - Saturday, 8:00 AM - 6:00 PM</span></div></div><div class="contact-detail"><i class="fa-solid fa-location-dot"></i><div><strong>Visit us</strong><span>Learning Commons, Main Campus</span></div></div></div>
<div class="contact-form-panel"><?php if ($sent): ?><div class="flash-message success" role="status">Thanks! Your message has been received by the library team.</div><?php endif; ?><form method="post"><label for="contact-name">Your name</label><input id="contact-name" name="name" required placeholder="Enter your name"><label for="contact-email">Email address</label><input id="contact-email" name="email" type="email" required placeholder="you@example.com"><label for="contact-message">Message</label><textarea id="contact-message" name="message" rows="5" required placeholder="How can we help?"></textarea><button type="submit">Send message <i class="fa-solid fa-paper-plane"></i></button></form></div>
</section>
</main>
</body>
</html>
