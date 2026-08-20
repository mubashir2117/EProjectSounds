<?php
session_start();
include("config.php");

if (isset($_POST['submit'])) {

    $c_name  = mysqli_real_escape_string($conn, $_POST['c_name']);
    $c_email = mysqli_real_escape_string($conn, $_POST['c_email']);
    $reviews = mysqli_real_escape_string($conn, isset($_POST['c_subject']) ? $_POST['c_subject'] : (isset($_POST['reviews']) ? $_POST['reviews'] : ''));
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO contact(c_name, c_email, reviews, message)
              VALUES('$c_name','$c_email','$reviews','$message')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: contact.php?status=ok&msg=" . urlencode("Message sent successfully!"));
        exit;
    } else {
        header("Location: contact.php?status=err&msg=" . urlencode("Something went wrong. Please try again."));
        exit;
    }
}

$page = 'contact';
include "header.php";
?>

<!-- PAGE HERO -->
<section class="page-hero" id="hero">
    <span class="section-eyebrow page-eyebrow"><span class="eyebrow-dot"></span> Get In Touch</span>
    <h1>Let's <span class="grad-text">Connect</span></h1>
    <p>Collaborations, feedback, bookings — or just to say the music moved you. We read every message.</p>
</section>

<!-- CONTACT -->
<section class="section contact">
    <div class="contact-glow" aria-hidden="true"></div>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5" data-reveal>
                <div class="contact-card">
                    <h3 style="font-size:22px;margin-bottom:8px;">Talk to the studio</h3>
                    <p style="color:var(--muted);font-weight:300;font-size:15px;margin-bottom:14px;">We usually reply within 24 hours.</p>

                    <div class="info-item">
                        <div class="info-ic">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="m22 6-10 7L2 6"/></svg>
                        </div>
                        <div>
                            <div class="info-label">Email</div>
                            <div class="info-value">hello@yourvoiceonthemark.com</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-ic">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div>
                            <div class="info-label">Studio</div>
                            <div class="info-value">The Mark Studio, NN, Karachi</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-ic">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        </div>
                        <div>
                            <div class="info-label">Response Time</div>
                            <div class="info-value">Within 24 hours, every day</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7" data-reveal>
                <form class="contact-card" id="contactForm" action="contact.php" method="POST" novalidate>
                    <div class="form-row cols-2">
                        <div class="field">
                            <label for="c_name">Name <em>*</em></label>
                            <input type="text" id="c_name" name="c_name" placeholder="Your full name" data-validate="name">
                            <span class="err-msg">Please enter your name (min 2 characters).</span>
                        </div>
                        <div class="field">
                            <label for="c_email">Email <em>*</em></label>
                            <input type="email" id="c_email" name="c_email" placeholder="you@email.com" data-validate="email">
                            <span class="err-msg">Please enter a valid email address.</span>
                        </div>
                    </div>

                    <div class="field" style="margin-top:20px;">
                        <label for="c_subject">Subject <em>*</em></label>
                        <input type="text" id="c_subject" name="c_subject" placeholder="What is this about?" data-validate="subject">
                        <span class="err-msg">Please add a short subject (min 3 characters).</span>
                    </div>

                    <div class="field" style="margin-top:20px;">
                        <label for="c_message">Message <em>*</em></label>
                        <textarea id="c_message" name="message" rows="5" placeholder="Tell us about your collaboration, feedback or story..." data-validate="message"></textarea>
                        <span class="err-msg">Please write a message (min 10 characters).</span>
                    </div>

                    <button type="submit" class="submit-btn magnetic" name="submit">
                        Send Message
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

</main>
<?php include "footer.php"; ?>