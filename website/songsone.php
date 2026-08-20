<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] == 2) {
    $page = 'songs';
    include "header.php";
    include "config.php";
?>

    <!-- PAGE HERO -->
    <section class="page-hero" id="hero">
        <span class="section-eyebrow page-eyebrow"><span class="eyebrow-dot"></span> The Library</span>
        <h1>Songs <span class="grad-text">Collection</span></h1>
        <p>Handpicked premium tracks — feel the mark. Press play and let the waveform move.</p>
    </section>

    <!-- SONGS GRID -->
    <section class="section" style="padding-top:10px;">
        <div class="container">
            <div class="row g-4">
                <?php
                $qry = "SELECT song.*, genre.genre_name, artist.artist_name FROM song
                        JOIN genre ON genre.id = song.genre_id
                        JOIN artist ON artist.Artist_id = song.Artists_id";
                $res = mysqli_query($conn, $qry);
                $rank = 1;
                while ($data = mysqli_fetch_assoc($res)) {
                    ?>
                    <div class="col-6 col-md-4 col-lg-3" data-reveal>
                        <article class="song-card hoverable">
                            <span class="rank-badge">#<em><?php echo str_pad($rank, 2, '0', STR_PAD_LEFT); ?></em></span>
                            <div class="song-art">
                                <img src="<?php echo htmlspecialchars($data["song_image"]); ?>"
                                     onerror="this.onerror=null;this.src='images/img.jpg';"
                                     alt="<?php echo htmlspecialchars($data["song_name"]); ?> album art">
                                <div class="song-art-shade"></div>
                                <div class="song-wave"><i></i><i></i><i></i><i></i><i></i></div>
                                <button class="song-play" data-audio="<?php echo htmlspecialchars($data["song_file"]); ?>" aria-label="Play <?php echo htmlspecialchars($data["song_name"]); ?>">
                                    <svg class="ic-play" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                    <svg class="ic-pause" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                </button>
                            </div>
                            <div class="song-meta">
                                <h3 class="song-name"><?php echo htmlspecialchars($data["song_name"]); ?></h3>
                                <span class="song-artist"><?php echo htmlspecialchars($data["artist_name"]); ?></span>
                                <div class="meta-row">
                                    <span class="song-genre"><?php echo htmlspecialchars($data["genre_name"]); ?></span>
                                    <span class="song-year"><?php echo htmlspecialchars($data["years"]); ?></span>
                                </div>
                            </div>
                        </article>
                    </div>
                    <?php
                    $rank++;
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
