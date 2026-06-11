<?php

$pageTitle = "Contact | Help A Stray";
require_once '../includes/header.php';

?>

<h1>Contact Us</h1>

<div class="card">

    <h2>Rescue Centre Information</h2>

    <p><strong>Email:</strong> info@helpastray.org</p>

    <p><strong>Phone:</strong> +44 1234 567890</p>

    <p><strong>Address:</strong> Coventry, United Kingdom</p>

</div>

<div class="card">

    <h2>Opening Hours</h2>

    <p>Monday - Friday: 09:00 - 18:00</p>

    <p>Saturday: 10:00 - 16:00</p>

    <p>Sunday: Closed</p>

</div>

<div class="card">

    <h2>Contact Form</h2>

    <form>

        <label>Name:</label>
        <input type="text">

        <br><br>

        <label>Email:</label>
        <input type="email">

        <br><br>

        <label>Message:</label>

        <textarea></textarea>

        <br><br>

        <button type="submit">Send Message</button>

    </form>

</div>

<?php require_once '../includes/footer.php'; ?>