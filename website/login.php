<?php
/* login.php */
session_start();

$login_error = isset($_SESSION['login_error'])
    ? $_SESSION['login_error']
    : null;

unset($_SESSION['login_error']);


$reset_notice = isset($_SESSION['reset_notice'])
    ? $_SESSION['reset_notice']
    : null;

unset($_SESSION['reset_notice']);


/* Email coming from login error */
$old_email = isset($_SESSION['login_email'])
    ? $_SESSION['login_email']
    : '';

unset($_SESSION['login_email']);


/* Email coming from successful signup */
if (isset($_SESSION['signup_email'])) {

    $old_email =
        $_SESSION['signup_email'];

    unset($_SESSION['signup_email']);

}


/* Signup success */
$signup_success =
    isset($_SESSION['signup_success'])
        ? $_SESSION['signup_success']
        : false;

unset($_SESSION['signup_success']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — YOUR VOICE ON THE MARK</title>
    <link rel="icon" type="image/svg+xml" href="images/logo-new.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body class="auth-body">

    <!-- ============ AUDIO BACKGROUND ============ -->
    <div class="scene" aria-hidden="true">
        <div class="aurora"></div>
        <div class="glow glow-a"></div>
        <div class="glow glow-b"></div>
        <div class="glow glow-c"></div>
        <div class="waveform"></div>
        <svg class="sine-wave" viewBox="0 0 1440 240" preserveAspectRatio="none" aria-hidden="true">
            <defs>
                <linearGradient id="sineGrad" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0" stop-color="#6C2BD9" stop-opacity="0"/>
                    <stop offset="0.5" stop-color="#00D4FF" stop-opacity="0.9"/>
                    <stop offset="1" stop-color="#6C2BD9" stop-opacity="0"/>
                </linearGradient>
            </defs>
            <path class="sw-path" d="M0 120 Q 90 40 180 120 T 360 120 T 540 120 T 720 120 T 900 120 T 1080 120 T 1260 120 T 1440 120" fill="none" stroke="url(#sineGrad)" stroke-width="1.6"/>
            <path class="sw-path sw-path--soft" d="M0 130 Q 90 210 180 130 T 360 130 T 540 130 T 720 130 T 900 130 T 1080 130 T 1260 130 T 1440 130" fill="none" stroke="url(#sineGrad)" stroke-width="1"/>
        </svg>
        <div class="sound-line"><span class="s-inner"></span></div>
        <div class="sound-line s-2"><span class="s-inner"></span></div>
        <div class="particles"></div>
        <div class="bg-grid"></div>
        <div class="film-grain"></div>
        <div class="bg-vignette"></div>
    </div>

    <!-- ============ TOASTS ============ -->
    <div class="toast-stack" id="toastStack" aria-live="polite"></div>

    <!-- ============ CARD ============ -->
    <main class="auth-page">
        <div class="auth-card">

            <div class="auth-brand">
                <img src="images/logo-new.svg" alt="YOUR VOICE ON THE MARK">
                <span class="brand-word">YOUR VOICE<em>ON THE MARK</em></span>
            </div>

            <!-- ===== LOGIN VIEW ===== -->
            <div class="auth-view auth-view--active" id="loginView">
                <h1 class="auth-title">Welcome <span class="grad-text">back</span></h1>
                <p class="auth-sub">Sign in to continue your listening journey</p>

                <form id="loginForm" action="loginCheck.php" method="POST" novalidate>
                    <div class="field">
                        <label for="loginEmail">Email</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
                            </span>
                            <input type="email" id="loginEmail" name="user_email" placeholder="you@email.com" autocomplete="email" value="<?php echo htmlspecialchars($old_email); ?>" required>
                        </div>
                        <span class="field-msg" data-for="loginEmail"></span>
                    </div>

                    <div class="field">
                        <label for="loginPassword">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                            </span>
                            <input type="password" id="loginPassword" name="user_password" placeholder="Enter your password" autocomplete="current-password" required>
                            <button type="button" class="toggle-pass" data-target="loginPassword" aria-label="Show password" aria-pressed="false">
                                <svg class="eye-on" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-off" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/><path d="m1 1 22 22"/></svg>
                            </button>
                        </div>
                        <span class="field-msg" data-for="loginPassword"></span>
                    </div>

                    <div class="form-extra">
                        <button type="button" class="forgot-link" id="forgotLink">Forgot Password?</button>
                    </div>

                    <button type="submit" class="btn-gradient" id="loginBtn">
                        <span class="spinner" hidden></span>
                        <span class="btn-text">Login</span>
                    </button>

                    <div class="auth-alt">
                        Don't have an account? <a href="signup.php">Sign Up</a>
                    </div>
                </form>
            </div>

            <!-- ===== FORGOT PASSWORD VIEW ===== -->
            <div class="auth-view hidden" id="forgotView">
                <h1 class="auth-title small">Reset <span class="grad-text">password</span></h1>
                <p class="auth-sub">Enter your email and we'll send you a reset link</p>

                <form id="forgotForm" action="forgot_password.php" method="POST" novalidate>
                    <div class="field">
                        <label for="forgotEmail">Email</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
                            </span>
                            <input type="email" id="forgotEmail" name="user_email" placeholder="you@email.com" autocomplete="email" required>
                        </div>
                        <span class="field-msg" data-for="forgotEmail"></span>
                    </div>

                    <button type="submit" class="btn-gradient" id="forgotBtn">
                        <span class="spinner" hidden></span>
                        <span class="btn-text">Send Reset Link</span>
                    </button>

                    <button type="button" class="btn-ghost" id="forgotBack">Back to Login</button>
                </form>
            </div>

        </div>
    </main>

    <script>
        window.flashed = {
            error:  <?php echo $login_error  ? json_encode($login_error)  : 'null'; ?>,
            notice: <?php echo $reset_notice ? json_encode($reset_notice) : 'null'; ?>
        };
       window.signupSuccess =
    <?php echo $signup_success ? 'true' : 'false'; ?>;
    </script>
    <script src="js/auth.js"></script>
</body>
</html>
