<?php $page = 'home'; include "header.php"; ?>

<!-- ============ HERO ============ -->
<section class="hero" id="hero">
    <div class="hero-stars" id="heroStars" aria-hidden="true"></div>

    <div class="hero-inner">
        <div class="hero-eyebrow"><span class="eyebrow-dot"></span> Premium music &amp; video streaming</div>
        <h1 class="hero-title">
            Your Voice.<br>
            <span class="grad-text">On The Mark.</span>
        </h1>
        <p class="hero-sub">
            Stream cinematic sound &amp; visuals built for artists and loved by listeners.
            Discover <strong>premium tracks</strong>, watch <strong>stunning visuals</strong> and let your voice leave a mark on the world.
        </p>
        <div class="hero-cta">
            <a href="#featured" class="btn btn-glow magnetic">
                Explore Latest
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
            <a href="#showcase" class="btn btn-ghost magnetic">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                Watch Videos
            </a>
        </div>
    </div>

    <div class="hero-equalizer" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span></div>

    <a href="#featured" class="hero-scroll hoverable">
        Scroll
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
    </a>
</section>

<!-- ============ TICKER ============ -->
<div class="ticker" aria-hidden="true">
    <div class="ticker-track">
        <span class="ticker-item strong">New Drops Weekly <span class="tk-dot"></span></span>
        <span class="ticker-item">Stream In HD <span class="tk-dot"></span></span>
        <span class="ticker-item strong">Artist Spotlight <span class="tk-dot"></span></span>
        <span class="ticker-item">Trending Now <span class="tk-dot"></span></span>
        <span class="ticker-item strong">Premium Sound <span class="tk-dot"></span></span>
        <span class="ticker-item">Music For Every Mood <span class="tk-dot"></span></span>
        <span class="ticker-item strong">New Drops Weekly <span class="tk-dot"></span></span>
        <span class="ticker-item">Stream In HD <span class="tk-dot"></span></span>
        <span class="ticker-item strong">Artist Spotlight <span class="tk-dot"></span></span>
        <span class="ticker-item">Trending Now <span class="tk-dot"></span></span>
        <span class="ticker-item strong">Premium Sound <span class="tk-dot"></span></span>
        <span class="ticker-item">Music For Every Mood <span class="tk-dot"></span></span>
    </div>
</div>

<!-- ============ FEATURED SONGS ============ -->
<section class="section featured" id="featured">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="section-eyebrow">Trending Now</span>
            <h2 class="section-title">Featured <span class="grad-text">Songs</span></h2>
            <p class="section-sub">Handpicked premium tracks from artists making their mark. Hover a card, press play, and feel the wave.</p>
            <a href="songsone.php" class="section-more magnetic">
                View all
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>

        <div class="row g-4">

            <div class="col-6 col-md-4 col-lg-3" data-reveal>
                <article class="song-card hoverable">
                    <span class="rank-badge">#<em>01</em></span>
                    <div class="song-art">
                        <img src="../images/mjht.jpg" alt="Mujhe Pyar Hua Tha album art">
                        <div class="song-art-shade"></div>
                        <div class="song-wave"><i></i><i></i><i></i><i></i><i></i></div>
                        <button class="song-play" data-audio="../audio/Mujhe Pyaar Hua Tha Song Kaifi Khalil.mp3" aria-label="Play Mujhe Pyar Hua Tha">
                            <svg class="ic-play" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            <svg class="ic-pause" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                        </button>
                    </div>
                    <div class="song-meta">
                        <h3 class="song-name">Mujhe Pyar Hua Tha</h3>
                        <span class="song-artist">Kaifi Khalil</span>
                        <div class="meta-row">
                            <span class="song-genre">Pop</span>
                            <span class="song-year">2022</span>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-6 col-md-4 col-lg-3" data-reveal>
                <article class="song-card hoverable">
                    <span class="rank-badge">#<em>02</em></span>
                    <div class="song-art">
                        <img src="../images/tu hi kahan.jpg" alt="Tu Hai Kahan album art">
                        <div class="song-art-shade"></div>
                        <div class="song-wave"><i></i><i></i><i></i><i></i><i></i></div>
                        <button class="song-play" data-audio="../audio/Tu-Hai-Kahan.mp3" aria-label="Play Tu Hai Kahan">
                            <svg class="ic-play" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            <svg class="ic-pause" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                        </button>
                    </div>
                    <div class="song-meta">
                        <h3 class="song-name">Tu Hai Kahan</h3>
                        <span class="song-artist">Boys</span>
                        <div class="meta-row">
                            <span class="song-genre">Pop</span>
                            <span class="song-year">2023</span>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-6 col-md-4 col-lg-3" data-reveal>
                <article class="song-card hoverable">
                    <span class="rank-badge">#<em>03</em></span>
                    <div class="song-art">
                        <img src="../images/habibi.jpg" alt="Habibi album art">
                        <div class="song-art-shade"></div>
                        <div class="song-wave"><i></i><i></i><i></i><i></i><i></i></div>
                        <button class="song-play" data-audio="../audio/Habibi.mp3" aria-label="Play Habibi">
                            <svg class="ic-play" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            <svg class="ic-pause" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                        </button>
                    </div>
                    <div class="song-meta">
                        <h3 class="song-name">Habibi</h3>
                        <span class="song-artist">Asim Azhar</span>
                        <div class="meta-row">
                            <span class="song-genre">Pop</span>
                            <span class="song-year">2022</span>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-6 col-md-4 col-lg-3" data-reveal>
                <article class="song-card hoverable">
                    <span class="rank-badge">#<em>04</em></span>
                    <div class="song-art">
                        <img src="../images/jhoom.jpg" alt="Jhoom album art">
                        <div class="song-art-shade"></div>
                        <div class="song-wave"><i></i><i></i><i></i><i></i><i></i></div>
                        <button class="song-play" data-audio="../audio/Jhoom (Remix) Song Ali Zafar.mp3" aria-label="Play Jhoom">
                            <svg class="ic-play" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            <svg class="ic-pause" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                        </button>
                    </div>
                    <div class="song-meta">
                        <h3 class="song-name">Jhoom</h3>
                        <span class="song-artist">Ali Zafar</span>
                        <div class="meta-row">
                            <span class="song-genre">Pop</span>
                            <span class="song-year">2011</span>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-6 col-md-4 col-lg-3" data-reveal>
                <article class="song-card hoverable">
                    <span class="rank-badge">#<em>05</em></span>
                    <div class="song-art">
                        <img src="../images/tera hawale.jpg" alt="Tere Hawaale album art">
                        <div class="song-art-shade"></div>
                        <div class="song-wave"><i></i><i></i><i></i><i></i><i></i></div>
                        <button class="song-play" data-audio="../audio/Tere Hawaale.mp3" aria-label="Play Tere Hawaale">
                            <svg class="ic-play" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            <svg class="ic-pause" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                        </button>
                    </div>
                    <div class="song-meta">
                        <h3 class="song-name">Tere Hawaale</h3>
                        <span class="song-artist">Arijit Singh</span>
                        <div class="meta-row">
                            <span class="song-genre">Bollywood</span>
                            <span class="song-year">2022</span>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-6 col-md-4 col-lg-3" data-reveal>
                <article class="song-card hoverable">
                    <span class="rank-badge">#<em>06</em></span>
                    <div class="song-art">
                        <img src="../images/kesariya.jpg" alt="Kesariya album art">
                        <div class="song-art-shade"></div>
                        <div class="song-wave"><i></i><i></i><i></i><i></i><i></i></div>
                        <button class="song-play" data-audio="../audio/Kesariya.mp3" aria-label="Play Kesariya">
                            <svg class="ic-play" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            <svg class="ic-pause" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                        </button>
                    </div>
                    <div class="song-meta">
                        <h3 class="song-name">Kesariya</h3>
                        <span class="song-artist">Arijit Singh</span>
                        <div class="meta-row">
                            <span class="song-genre">Bollywood</span>
                            <span class="song-year">2023</span>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-6 col-md-4 col-lg-3" data-reveal>
                <article class="song-card hoverable">
                    <span class="rank-badge">#<em>07</em></span>
                    <div class="song-art">
                        <img src="../images/zindagi.jpg" alt="Zindagi album art">
                        <div class="song-art-shade"></div>
                        <div class="song-wave"><i></i><i></i><i></i><i></i><i></i></div>
                        <button class="song-play" data-audio="../audio/Zindagi Atif Aslam 2023 Qateel Shifai.mp3" aria-label="Play Zindagi">
                            <svg class="ic-play" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            <svg class="ic-pause" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                        </button>
                    </div>
                    <div class="song-meta">
                        <h3 class="song-name">Zindagi</h3>
                        <span class="song-artist">Atif Aslam</span>
                        <div class="meta-row">
                            <span class="song-genre">Pop</span>
                            <span class="song-year">2023</span>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-6 col-md-4 col-lg-3" data-reveal>
                <article class="song-card hoverable">
                    <span class="rank-badge">#<em>08</em></span>
                    <div class="song-art">
                        <img src="../images/jo tu na mila.jpg" alt="Jo Tu Na Mila album art">
                        <div class="song-art-shade"></div>
                        <div class="song-wave"><i></i><i></i><i></i><i></i><i></i></div>
                        <button class="song-play" data-audio="../audio/Jo tu na Mila 20 Song By Asim Azhar.mp3" aria-label="Play Jo Tu Na Mila">
                            <svg class="ic-play" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            <svg class="ic-pause" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                        </button>
                    </div>
                    <div class="song-meta">
                        <h3 class="song-name">Jo Tu Na Mila</h3>
                        <span class="song-artist">Asim Azhar</span>
                        <div class="meta-row">
                            <span class="song-genre">Pop</span>
                            <span class="song-year">2018</span>
                        </div>
                    </div>
                </article>
            </div>

        </div>
    </div>
</section>

<!-- ============ VIDEO SHOWCASE ============ -->
<section class="section showcase" id="showcase">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="section-eyebrow">The Screen</span>
            <h2 class="section-title">Video <span class="grad-text">Showcase</span></h2>
            <p class="section-sub">Cinematic visuals, premium sound. Tap any frame to launch the immersive player.</p>
            <a href="videoone.php" class="section-more magnetic">
                View all
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>

        <div class="row g-4">

            <div class="col-12 col-sm-6 col-lg-3" data-reveal>
                <article class="video-card hoverable" data-video="../images/AFSANAY.mp4" data-title="Afsanay" data-artist="Kaifi Khalil">
                    <video src="../images/AFSANAY.mp4" muted playsinline preload="metadata"></video>
                    <div class="video-shade"></div>
                    <span class="rank-badge video-top">HD</span>
                    <button class="video-play" aria-label="Play video">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <div class="video-meta">
                        <div>
                            <div class="video-name">Afsanay</div>
                            <div class="video-artist">Kaifi Khalil</div>
                        </div>
                        <span class="video-dur">0:00</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-lg-3" data-reveal>
                <article class="video-card hoverable" data-video="../images/Ali zafar.mp4" data-title="Ve Mahiya" data-artist="Ali Zafar">
                    <video src="../images/Ali zafar.mp4" muted playsinline preload="metadata"></video>
                    <div class="video-shade"></div>
                    <span class="rank-badge video-top">HD</span>
                    <button class="video-play" aria-label="Play video">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <div class="video-meta">
                        <div>
                            <div class="video-name">Ve Mahiya</div>
                            <div class="video-artist">Ali Zafar</div>
                        </div>
                        <span class="video-dur">0:00</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-lg-3" data-reveal>
                <article class="video-card hoverable" data-video="../images/Asim Azhar1.mp4" data-title="Dard" data-artist="Asim Azhar">
                    <video src="../images/Asim Azhar1.mp4" muted playsinline preload="metadata"></video>
                    <div class="video-shade"></div>
                    <span class="rank-badge video-top">HD</span>
                    <button class="video-play" aria-label="Play video">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <div class="video-meta">
                        <div>
                            <div class="video-name">Dard</div>
                            <div class="video-artist">Asim Azhar</div>
                        </div>
                        <span class="video-dur">0:00</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-lg-3" data-reveal>
                <article class="video-card hoverable" data-video="../images/Asim Azhar2.mp4" data-title="Bulleya" data-artist="Asim Azhar">
                    <video src="../images/Asim Azhar2.mp4" muted playsinline preload="metadata"></video>
                    <div class="video-shade"></div>
                    <span class="rank-badge video-top">HD</span>
                    <button class="video-play" aria-label="Play video">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <div class="video-meta">
                        <div>
                            <div class="video-name">Bulleya</div>
                            <div class="video-artist">Asim Azhar</div>
                        </div>
                        <span class="video-dur">0:00</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-lg-3" data-reveal>
                <article class="video-card hoverable" data-video="../images/Kaifi khalil 1.mp4" data-title="Kahani Suno 2.0" data-artist="Kaifi Khalil">
                    <video src="../images/Kaifi khalil 1.mp4" muted playsinline preload="metadata"></video>
                    <div class="video-shade"></div>
                    <span class="rank-badge video-top">HD</span>
                    <button class="video-play" aria-label="Play video">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <div class="video-meta">
                        <div>
                            <div class="video-name">Kahani Suno 2.0</div>
                            <div class="video-artist">Kaifi Khalil</div>
                        </div>
                        <span class="video-dur">0:00</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-lg-3" data-reveal>
                <article class="video-card hoverable" data-video="../images/Kaifi khalil 2.mp4" data-title="Mansoob" data-artist="Kaifi Khalil">
                    <video src="../images/Kaifi khalil 2.mp4" muted playsinline preload="metadata"></video>
                    <div class="video-shade"></div>
                    <span class="rank-badge video-top">HD</span>
                    <button class="video-play" aria-label="Play video">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <div class="video-meta">
                        <div>
                            <div class="video-name">Mansoob</div>
                            <div class="video-artist">Kaifi Khalil</div>
                        </div>
                        <span class="video-dur">0:00</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-lg-3" data-reveal>
                <article class="video-card hoverable" data-video="../images/Ali zafar 2.mp4" data-title="Larsha Pekhawar" data-artist="Ali Zafar">
                    <video src="../images/Ali zafar 2.mp4" muted playsinline preload="metadata"></video>
                    <div class="video-shade"></div>
                    <span class="rank-badge video-top">HD</span>
                    <button class="video-play" aria-label="Play video">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <div class="video-meta">
                        <div>
                            <div class="video-name">Larsha Pekhawar</div>
                            <div class="video-artist">Ali Zafar</div>
                        </div>
                        <span class="video-dur">0:00</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-lg-3" data-reveal>
                <article class="video-card hoverable" data-video="../images/BRAHMASTRA.mp4" data-title="Kesariya" data-artist="Arijit Singh">
                    <video src="../images/BRAHMASTRA.mp4" muted playsinline preload="metadata"></video>
                    <div class="video-shade"></div>
                    <span class="rank-badge video-top">HD</span>
                    <button class="video-play" aria-label="Play video">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <div class="video-meta">
                        <div>
                            <div class="video-name">Kesariya</div>
                            <div class="video-artist">Arijit Singh</div>
                        </div>
                        <span class="video-dur">0:00</span>
                    </div>
                </article>
            </div>

        </div>
    </div>
</section>

<!-- ============ ABOUT ============ -->
<section class="section about" id="about">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="section-eyebrow">Our Story</span>
            <h2 class="section-title">About <span class="grad-text">The Mark</span></h2>
            <p class="section-sub">Every artist deserves a stage. We built one — cinematic, premium and built for voices that refuse to be quiet.</p>
        </div>

        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-reveal>
                <div class="about-panel">
                    <img src="images/about-img.jpg" alt="Inside the studio">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-story" data-reveal>
                    <p>Hi there — we're glad you found us. <strong>YOUR VOICE ON THE MARK</strong> is a premium streaming platform built for artists who believe music is not a one-way street.</p>
                    <p>Music is a conversation — the listener's role is as important as the artist's. We handpick every track and every visual so the sound you press play on feels intentional, cinematic and true.</p>
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

<!-- ============ CONTACT ============ -->
<section class="section contact" id="contact">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="section-eyebrow">Get In Touch</span>
            <h2 class="section-title">Let's <span class="grad-text">Connect</span></h2>
            <p class="section-sub">Collaborations, feedback, bookings — or just to say the music moved you. We read every message.</p>
        </div>

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
                            <div class="info-value">The Mark Studio, Gulberg, Lahore</div>
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
