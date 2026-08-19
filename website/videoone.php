<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] == 2) {
    $page = 'videos';
    include "header.php";
    include "config.php";
?>

    <!-- PAGE HERO -->
    <section class="page-hero" id="hero">
        <span class="section-eyebrow page-eyebrow"><span class="eyebrow-dot"></span> The Screen</span>
        <h1>Video <span class="grad-text">Showcase</span></h1>
        <p>Premium visuals, cinematic sound. Tap any frame to launch the immersive player.</p>
    </section>

    <!-- VIDEOS GRID -->
    <section class="section" style="padding-top:10px;">
        <div class="container">
            <div class="row g-4">
                <?php
                $qry = "SELECT video.*, genre.genre_name, artist.artist_name FROM video
                        JOIN genre ON genre.id = video.genre_id
                        JOIN artist ON artist.Artist_id = video.Artists_id";
                $res = mysqli_query($conn, $qry);
                while ($data = mysqli_fetch_assoc($res)) {
                    ?>
                    <div class="col-12 col-sm-6 col-lg-3" data-reveal>
                        <article class="video-card hoverable"
                                 data-video="../<?php echo htmlspecialchars($data["video_file"]); ?>"
                                 data-title="<?php echo htmlspecialchars($data["video_name"]); ?>"
                                 data-artist="<?php echo htmlspecialchars($data["artist_name"]); ?>">
                            <video src="../<?php echo htmlspecialchars($data["video_file"]); ?>" muted playsinline preload="metadata"></video>
                            <div class="video-shade"></div>
                            <span class="rank-badge video-top">HD</span>
                            <button class="video-play" aria-label="Play video">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            </button>
                            <div class="video-meta">
                                <div>
                                    <div class="video-name"><?php echo htmlspecialchars($data["video_name"]); ?></div>
                                    <div class="video-artist"><?php echo htmlspecialchars($data["artist_name"]); ?></div>
                                </div>
                                <span class="video-dur">0:00</span>
                            </div>
                        </article>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

</main>
<?php include "footer.php"; ?>

<?php
} else {
    echo "<script>alert('Login First'); window.location.href='login.php';</script>";
}
?>
