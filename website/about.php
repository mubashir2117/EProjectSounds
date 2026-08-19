<?php
$page = 'about';
include "header.php";
?>

<!-- PAGE HERO -->
<section class="page-hero" id="hero">
    <span class="section-eyebrow page-eyebrow"><span class="eyebrow-dot"></span> Who We Are</span>
    <h1>About <span class="grad-text">The Mark</span></h1>
    <p>Every artist deserves a stage to make their mark. We built one worth listening to.</p>
</section>

<!-- STORY -->
<section class="section about" id="about" style="padding-top:20px;">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-reveal>
                <div class="about-panel">
                    <img src="images/about-img.jpg" alt="Inside the studio">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-story" data-reveal>
                    <p>Hi there — we're glad you found us. <strong>YOUR VOICE ON THE MARK</strong> is a premium streaming platform built for artists who believe music is not a one-way street.</p>
                    <p>On this page you can find out what we have been up to lately — and maybe a little about where we are going. For us, the greatest thing about being around music is being in a position to inspire other people. We take such pleasure in hearing that artists have been motivated to create after listening to the voices we champion.</p>
                    <p>Music is a conversation where the listener's role is as important as the artist's. We handpick every track and every visual so the sound you press play on feels intentional, cinematic and true.</p>
                    <blockquote class="about-quote">"Your voice is your superpower. <span>Put it on the mark.</span>"</blockquote>
                </div>
            </div>
        </div>

        <div class="counters row g-4">
            <div class="col-6 col-lg-3" data-reveal>
                <div class="stat">
                    <div class="stat-num" data-count="1200" data-suffix="+">0</div>
                    <div class="stat-label">Tracks Curated</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-reveal>
                <div class="stat">
                    <div class="stat-num" data-count="340" data-suffix="+">0</div>
                    <div class="stat-label">Video Drops</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-reveal>
                <div class="stat">
                    <div class="stat-num" data-count="50" data-suffix="+">0</div>
                    <div class="stat-label">Featured Artists</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-reveal>
                <div class="stat">
                    <div class="stat-num" data-count="100" data-suffix="K+">0</div>
                    <div class="stat-label">Listeners Worldwide</div>
                </div>
            </div>
        </div>
    </div>
</section>

</main>
<?php include "footer.php"; ?>
