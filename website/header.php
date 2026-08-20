<?php
if (session_status() === PHP_SESSION_NONE) session_start();
@include_once "config.php";
$page = isset($page) ? $page : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YOUR VOICE ON THE MARK — Premium Music & Video Streaming</title>
    <meta name="description" content="A premium, cinematic music & video streaming platform. Stream, discover and share premium sound and visuals — crafted for artists, loved by listeners.">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="images/logo-new.svg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 grid -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- GSAP + ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- Lenis smooth scroll -->
    <script src="https://unpkg.com/lenis@1.1.13/dist/lenis.min.js"></script>

    <!-- Theme -->
    <link rel="stylesheet" href="css/index.css">
</head>
<body data-page="<?php echo htmlspecialchars($page); ?>">

    <!-- CUSTOM CURSOR -->
    <div class="cursor-dot" aria-hidden="true"></div>
    <div class="cursor-ring" aria-hidden="true"></div>
    <div class="cursor-label" aria-hidden="true"></div>

    <!-- THREE.JS CINEMATIC WORLD -->
    <div class="world-canvas" id="worldCanvas" aria-hidden="true"></div>

    <!-- PAGE TRANSITION OVERLAY -->
    <div class="page-transition" id="pageTransition" aria-hidden="true">
        <div class="pt-curtain"></div>
        <div class="pt-streak"></div>
        <div class="pt-stage" aria-hidden="true">
            <i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i>
        </div>
    </div>

    <!-- AMBIENT BACKGROUND -->
    <div class="bg-aurora" aria-hidden="true">
        <div class="orb orb-a"></div>
        <div class="orb orb-b"></div>
        <div class="orb orb-c"></div>
        <div class="bg-grid"></div>
    </div>

    <!-- PRELOADER -->
    <div id="preloader" aria-hidden="true">
        <div class="loader-mark">
            <div class="loader-logo">
                <img src="images/logo-new.svg" alt="YOUR VOICE ON THE MARK">
            </div>
            <div class="loader-name">YOUR VOICE <span>ON THE MARK</span></div>
            <div class="loader-bar"><span></span></div>
            <div class="loader-count" id="loaderCount">0</div>
        </div>
        <noscript><style>#preloader{display:none!important}</style></noscript>
    </div>

    <!-- SCROLL PROGRESS -->
    <div class="scroll-progress" aria-hidden="true"><span id="scrollProgress"></span></div>

    <!-- SOCIAL RAIL -->
    <div class="social-rail" aria-label="Social links">
        <a href="https://www.youtube.com/channel/UCCCiwtoLf3wMnRMdxOYTErg#" target="_blank" rel="noopener" aria-label="YouTube">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.5 3.55 12 3.55 12 3.55s-7.5 0-9.38.5A3.02 3.02 0 0 0 .5 6.19C0 8.07 0 12 0 12s0 3.93.5 5.81a3.02 3.02 0 0 0 2.12 2.14c1.88.5 9.38.5 9.38.5s7.5 0 9.38-.5a3.02 3.02 0 0 0 2.12-2.14C24 15.93 24 12 24 12s0-3.93-.5-5.81zM9.55 15.57V8.43L15.82 12l-6.27 3.57z"/></svg>
            <span>YouTube</span>
        </a>
        <a href="https://www.facebook.com/" target="_blank" rel="noopener" aria-label="Facebook">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07c0 6.03 4.39 11.03 10.13 11.93v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.69.24 2.69.24v2.97h-1.52c-1.49 0-1.96.93-1.96 1.89v2.25h3.33l-.53 3.49h-2.8V24C19.61 23.1 24 18.1 24 12.07z"/></svg>
            <span>Facebook</span>
        </a>
        <a href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41-.56-.22-.96-.48-1.38-.9-.42-.42-.68-.82-.9-1.38-.16-.42-.36-1.06-.41-2.23-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63c-.79.31-1.46.72-2.13 1.38C1.35 2.68.94 3.35.63 4.14.33 4.9.13 5.78.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91.31.79.72 1.46 1.38 2.13.67.66 1.34 1.07 2.13 1.38.76.3 1.64.5 2.91.56 1.28.06 1.69.07 4.95.07s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56.79-.31 1.46-.72 2.13-1.38.66-.67 1.07-1.34 1.38-2.13.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91-.31-.79-.72-1.46-1.38-2.13C20.32 1.35 19.65.94 18.86.63 18.1.33 17.22.13 15.95.07 14.67.01 14.26 0 12 0zm0 5.84A6.16 6.16 0 1 0 18.16 12 6.16 6.16 0 0 0 12 5.84zm0 10.16A4 4 0 1 1 16 12a4 4 0 0 1-4 4zm7.85-10.4a1.44 1.44 0 1 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/></svg>
            <span>Instagram</span>
        </a>
        <div class="rail-line" aria-hidden="true"></div>
    </div>

    <!-- TOP NAVBAR -->
    <header class="site-nav" id="siteNav">
        <a href="index.php" class="nav-logo" aria-label="YOUR VOICE ON THE MARK — Home">
            <img src="images/logo-new.svg" alt="YOUR VOICE ON THE MARK">
            <span class="logo-word">YOUR VOICE<em>ON THE MARK</em></span>
        </a>

        <nav class="nav-links" aria-label="Primary">
            <a href="index.php" class="nav-link<?php echo $page === 'home' ? ' active' : ''; ?>">Home</a>
            <a href="songsone.php" class="nav-link<?php echo $page === 'songs' ? ' active' : ''; ?>">Songs</a>
            <a href="videoone.php" class="nav-link<?php echo $page === 'videos' ? ' active' : ''; ?>">Videos</a>
            <a href="about.php" class="nav-link<?php echo $page === 'about' ? ' active' : ''; ?>">About</a>
        </nav>

        <div class="nav-actions">
            <?php if (isset($_SESSION['user_name'])) { ?>
                <span class="user-chip">
                    <span class="user-avatar"><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                    <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </span>
                <a href="logout.php" class="btn-logout">Logout</a>
            <?php } else { ?>
                <a href="login.php" class="btn-login">Login</a>
            <?php } ?>

            <button class="nav-burger hoverable" id="navBurger" aria-label="Open menu" aria-expanded="false">
                <span></span><span></span>
            </button>
        </div>
    </header>

    <!-- FULLSCREEN NAV OVERLAY -->
    <div class="nav-overlay" id="navOverlay" aria-hidden="true">
        <div class="overlay-preview">
            <span class="pv-label">YOUR VOICE ON THE MARK</span>
        </div>

        <nav class="overlay-menu" aria-label="Fullscreen">
            <a href="index.php" class="ov-link" data-text="Home" data-img="images/album-thumbnail-five.jpg">Home <span class="ov-num">01</span></a>
            <a href="songsone.php" class="ov-link" data-text="Songs" data-img="images/album-thumbnail-nine.jpg">Songs <span class="ov-num">02</span></a>
            <a href="videoone.php" class="ov-link" data-text="Videos" data-img="images/img.jpg">Videos <span class="ov-num">03</span></a>
            <a href="about.php" class="ov-link" data-text="About" data-img="images/about-img.jpg">About <span class="ov-num">04</span></a>
            <a href="contact.php" class="ov-link" data-text="Contact" data-img="images/album-thumbnail-four.jpg">Contact <span class="ov-num">05</span></a>
        </nav>

        <div class="overlay-foot">
            <span class="of-line">hello@yourvoiceonthemark.com</span>
            <div class="of-socials">
                <a href="https://www.youtube.com/channel/UCCCiwtoLf3wMnRMdxOYTErg#" target="_blank" rel="noopener" aria-label="YouTube">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.5 3.55 12 3.55 12 3.55s-7.5 0-9.38.5A3.02 3.02 0 0 0 .5 6.19C0 8.07 0 12 0 12s0 3.93.5 5.81a3.02 3.02 0 0 0 2.12 2.14c1.88.5 9.38.5 9.38.5s7.5 0 9.38-.5a3.02 3.02 0 0 0 2.12-2.14C24 15.93 24 12 24 12s0-3.93-.5-5.81zM9.55 15.57V8.43L15.82 12l-6.27 3.57z"/></svg>
                </a>
                <a href="https://www.facebook.com/" target="_blank" rel="noopener" aria-label="Facebook">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07c0 6.03 4.39 11.03 10.13 11.93v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.69.24 2.69.24v2.97h-1.52c-1.49 0-1.96.93-1.96 1.89v2.25h3.33l-.53 3.49h-2.8V24C19.61 23.1 24 18.1 24 12.07z"/></svg>
                </a>
                <a href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41-.56-.22-.96-.48-1.38-.9-.42-.42-.68-.82-.9-1.38-.16-.42-.36-1.06-.41-2.23-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63c-.79.31-1.46.72-2.13 1.38C1.35 2.68.94 3.35.63 4.14.33 4.9.13 5.78.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91.31.79.72 1.46 1.38 2.13.67.66 1.34 1.07 2.13 1.38.76.3 1.64.5 2.91.56 1.28.06 1.69.07 4.95.07s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56.79-.31 1.46-.72 2.13-1.38.66-.67 1.07-1.34 1.38-2.13.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91-.31-.79-.72-1.46-1.38-2.13C20.32 1.35 19.65.94 18.86.63 18.1.33 17.22.13 15.95.07 14.67.01 14.26 0 12 0zm0 5.84A6.16 6.16 0 1 0 18.16 12 6.16 6.16 0 0 0 12 5.84zm0 10.16A4 4 0 1 1 16 12a4 4 0 0 1-4 4zm7.85-10.4a1.44 1.44 0 1 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/></svg>
                </a>
            </div>
        </div>

        <button class="overlay-close hoverable" id="navClose" aria-label="Close menu">+</button>
    </div>

    <!-- VIDEO LIGHTBOX -->
    <div class="lightbox" id="lightbox" aria-hidden="true">
        <button class="lightbox-close hoverable" aria-label="Close player">+</button>
        <div class="lightbox-stage">
            <video id="lightboxVideo" controls playsinline></video>
            <div class="lightbox-meta">
                <div>
                    <div class="lb-title" id="lbTitle">YOUR VOICE ON THE MARK</div>
                    <div class="lb-sub" id="lbSub">Premium Video Player</div>
                </div>
            </div>
        </div>
    </div>

    <main class="site-main">
