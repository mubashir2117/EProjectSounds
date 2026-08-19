<?php
$current = basename($_SERVER['PHP_SELF']);
$isGenre   = in_array($current, ['genre.php', 'genrelist.php']);
$isArtist  = in_array($current, ['artist.php', 'artistlist.php']);
$isSong    = in_array($current, ['song.php', 'songlist.php']);
$isVideo   = in_array($current, ['video.php', 'videolist.php']);
$isReviews = ($current === 'index.php');

function nav_active($pages) {
    return in_array(basename($_SERVER['PHP_SELF']), $pages) ? ' sub-active' : '';
}

$pageTitles = [
    'index.php' => 'Reviews',
    'genre.php' => 'Add Genre',
    'genrelist.php' => 'Genre List',
    'artist.php' => 'Add Artist',
    'artistlist.php' => 'Artist List',
    'song.php' => 'Add Song',
    'songlist.php' => 'Song List',
    'video.php' => 'Add Video',
    'videolist.php' => 'Video List',
    'editgenre.php' => 'Edit Genre',
    'editartist.php' => 'Edit Artist',
    'editsong.php' => 'Edit Song',
    'editvideo.php' => 'Edit Video',
    'profile.php' => 'Profile',
];
$pageTitle = isset($pageTitles[$current]) ? $pageTitles[$current] : 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Sound Music</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./custom-admin.css">
</head>
<body>
<div id="main-wrapper">

    <div class="nav-header">
        <a href="index.php" class="brand-logo">
            <span class="brand-badge">ADMIN</span>
            <span class="brand-sub">Sound Music</span>
        </a>
        <div class="nav-control">
            <button class="hamburger" id="sidebarToggle" aria-label="Toggle sidebar">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </button>
        </div>
    </div>

    <div class="layout-body">

        <!-- Sidebar -->
        <aside class="quixnav">
            <nav class="quixnav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Genre Management</li>
                    <li class="<?php echo $isGenre ? 'mm-active' : ''; ?>">
                        <a class="has-arrow" href="javascript:void(0)" data-label="Genre">
                            <i class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                            </i>
                            <span class="nav-text">Genre</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a class="<?php echo nav_active(['genre.php']); ?>" href="genre.php">Add Genre</a></li>
                            <li><a class="<?php echo nav_active(['genrelist.php']); ?>" href="genrelist.php">Genre List</a></li>
                        </ul>
                    </li>

                    <li class="nav-label">Artist Management</li>
                    <li class="<?php echo $isArtist ? 'mm-active' : ''; ?>">
                        <a class="has-arrow" href="javascript:void(0)" data-label="Artist">
                            <i class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </i>
                            <span class="nav-text">Artist</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a class="<?php echo nav_active(['artist.php']); ?>" href="artist.php">Add Artist</a></li>
                            <li><a class="<?php echo nav_active(['artistlist.php']); ?>" href="artistlist.php">Artist List</a></li>
                        </ul>
                    </li>

                    <li class="nav-label">Song Management</li>
                    <li class="<?php echo $isSong ? 'mm-active' : ''; ?>">
                        <a class="has-arrow" href="javascript:void(0)" data-label="Song">
                            <i class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                            </i>
                            <span class="nav-text">Song</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a class="<?php echo nav_active(['song.php']); ?>" href="song.php">Add Song</a></li>
                            <li><a class="<?php echo nav_active(['songlist.php']); ?>" href="songlist.php">Song List</a></li>
                        </ul>
                    </li>

                    <li class="nav-label">Video Management</li>
                    <li class="<?php echo $isVideo ? 'mm-active' : ''; ?>">
                        <a class="has-arrow" href="javascript:void(0)" data-label="Video">
                            <i class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M10 9l5 3-5 3z"/></svg>
                            </i>
                            <span class="nav-text">Video</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a class="<?php echo nav_active(['video.php']); ?>" href="video.php">Add Video</a></li>
                            <li><a class="<?php echo nav_active(['videolist.php']); ?>" href="videolist.php">Video List</a></li>
                        </ul>
                    </li>

                    <li class="nav-label">Reviews</li>
                    <li class="<?php echo $isReviews ? 'mm-active' : ''; ?>">
                        <a href="index.php" data-label="Reviews">
                            <i class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z"/></svg>
                            </i>
                            <span class="nav-text">Reviews</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main area -->
        <div class="layout-main">

            <div class="header">
                <div class="header-left">
                    <span class="header-title"><?php echo htmlspecialchars($pageTitle); ?></span>
                </div>
                <div class="header-right">
                    <span class="header-badge"><i class="fa-solid fa-shield-halved"></i> Admin</span>
                    <div class="dropdown">
                        <button class="dropdown-btn" type="button">
                            <svg class="account-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>Account</span>
                        </button>
                        <div class="dropdown-content">
                            <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>
