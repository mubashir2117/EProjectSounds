<?php

session_start();

include 'config.php';


/* =========================================================
   PASSWORD SCORE
   ========================================================= */

function password_score($password)
{
    $score = 0;

    if (strlen($password) >= 8) {
        $score++;
    }

    if (preg_match('/[A-Z]/', $password)) {
        $score++;
    }

    if (preg_match('/[a-z]/', $password)) {
        $score++;
    }

    if (preg_match('/[0-9]/', $password)) {
        $score++;
    }

    if (preg_match('/[^A-Za-z0-9]/', $password)) {
        $score++;
    }

    return $score;
}


/* =========================================================
   VARIABLES
   ========================================================= */

$err_name     = null;
$err_email    = null;
$err_password = null;
$err_confirm  = null;
$err_general  = null;

$success = false;

$old_name  = '';
$old_email = '';


/* =========================================================
   FORM SUBMISSION
   ========================================================= */

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    &&
    isset($_POST['submit'])
) {

    $user_name =
        trim($_POST['user_name'] ?? '');

    $user_email =
        trim($_POST['user_email'] ?? '');

    $user_password =
        $_POST['user_password'] ?? '';

    $confirm_password =
        $_POST['confirm_password'] ?? '';


    /* New signup users are always User */
    $role_id = 2;


    /* Keep old values if validation fails */
    $old_name  = $user_name;
    $old_email = $user_email;


    /* =====================================================
       USERNAME VALIDATION
       ===================================================== */

    if ($user_name === '') {

        $err_name =
            'Username is required.';

    } elseif (strlen($user_name) < 3) {

        $err_name =
            'Username must be at least 3 characters.';

    } elseif (
        !preg_match(
            "/^[a-zA-Z0-9_ .'-]{3,50}$/",
            $user_name
        )
    ) {

        $err_name =
            'Username can only contain letters, numbers and . _ -';

    }


    /* =====================================================
       EMAIL VALIDATION
       ===================================================== */

    if ($user_email === '') {

        $err_email =
            'Email is required.';

    } elseif (
        !filter_var(
            $user_email,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        $err_email =
            'Please enter a valid email address.';

    }


    /* =====================================================
       PASSWORD VALIDATION
       ===================================================== */

    if ($user_password === '') {

        $err_password =
            'Password is required.';

    } elseif (strlen($user_password) < 8) {

        $err_password =
            'Password must be at least 8 characters.';

    } elseif (
        password_score($user_password) < 3
    ) {

        $err_password =
            'Password does not meet the required strength.';

    }


    /* =====================================================
       CONFIRM PASSWORD
       ===================================================== */

    if ($confirm_password === '') {

        $err_confirm =
            'Please confirm your password.';

    } elseif (
        $confirm_password !== $user_password
    ) {

        $err_confirm =
            'Passwords do not match.';

    }


    /* =====================================================
       CHECK EMAIL ALREADY EXISTS
       ===================================================== */

    if (
        $err_name === null &&
        $err_email === null &&
        $err_password === null &&
        $err_confirm === null
    ) {

        $stmt = $conn->prepare(
            "SELECT user_id
             FROM users
             WHERE user_email = ?
             LIMIT 1"
        );


        if (!$stmt) {

            $err_general =
                "Database query failed: " .
                $conn->error;

        } else {

            $stmt->bind_param(
                "s",
                $user_email
            );

            $stmt->execute();

            $stmt->store_result();


            if ($stmt->num_rows > 0) {

                $err_email =
                    "An account with this email already exists.";

            }


            $stmt->close();

        }

    }


    /* =====================================================
       INSERT NEW USER
       ===================================================== */

    if (
        $err_name === null &&
        $err_email === null &&
        $err_password === null &&
        $err_confirm === null
    ) {


        /* =================================================
           HASH PASSWORD
           ================================================= */


        if ($hashed_password === true) {

            $err_general =
                "Password hashing failed.";

        } else {


            /* =============================================
               INSERT QUERY
               ============================================= */

            $stmt = $conn->prepare(
                "INSERT INTO users
                (
                    user_name,
                    user_email,
                    user_password,
                    role_id
                )
                VALUES (?, ?, ?, ?)"
            );


            if (!$stmt) {

                $err_general =
                    "Database query failed: " .
                    $conn->error;

            } else {


                /* =========================================
                   IMPORTANT:
                   USE $hashed_password HERE
                   NOT $user_password
                   ========================================= */

                $stmt->bind_param(
                    "sssi",
                    $user_name,
                    $user_email,
                    $user_password,
                    $role_id
                );


                /* =========================================
                   EXECUTE INSERT
                   ========================================= */

                if ($stmt->execute()) {

                    $stmt->close();


                    /* =====================================
                       SAVE EMAIL IN SESSION
                       ===================================== */

                    $_SESSION['signup_email'] =
                        $user_email;


                    /* =====================================
                       SIGNUP SUCCESS
                       ===================================== */

                    $_SESSION['signup_success'] =
                        true;


                    /* =====================================
                       REDIRECT TO LOGIN
                       ===================================== */

                    header(
                        "Location: login.php"
                    );

                    exit;

                } else {

                    $err_general =
                        "Database error while creating account: " .
                        $stmt->error;

                    $stmt->close();

                }

            }

        }

    }

}


/* =========================================================
   FIRST ERROR
   ========================================================= */

$first_error =
    $err_name ??
    $err_email ??
    $err_password ??
    $err_confirm ??
    $err_general;

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Sign Up — YOUR VOICE ON THE MARK
    </title>


    <link
        rel="icon"
        type="image/svg+xml"
        href="images/logo-new.svg"
    >


    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >


    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >


    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <link
        rel="stylesheet"
        href="css/auth.css"
    >

</head>


<body class="auth-body">


<!-- =====================================================
     AUDIO BACKGROUND
     ===================================================== -->

<div
    class="scene"
    aria-hidden="true"
>

    <div class="aurora"></div>

    <div class="glow glow-a"></div>

    <div class="glow glow-b"></div>

    <div class="glow glow-c"></div>

    <div class="waveform"></div>


    <svg
        class="sine-wave"
        viewBox="0 0 1440 240"
        preserveAspectRatio="none"
        aria-hidden="true"
    >

        <defs>

            <linearGradient
                id="sineGrad"
                x1="0"
                y1="0"
                x2="1"
                y2="0"
            >

                <stop
                    offset="0"
                    stop-color="#6C2BD9"
                    stop-opacity="0"
                />

                <stop
                    offset="0.5"
                    stop-color="#00D4FF"
                    stop-opacity="0.9"
                />

                <stop
                    offset="1"
                    stop-color="#6C2BD9"
                    stop-opacity="0"
                />

            </linearGradient>

        </defs>


        <path
            class="sw-path"
            d="M0 120 Q 90 40 180 120 T 360 120 T 540 120 T 720 120 T 900 120 T 1080 120 T 1260 120 T 1440 120"
            fill="none"
            stroke="url(#sineGrad)"
            stroke-width="1.6"
        />


        <path
            class="sw-path sw-path--soft"
            d="M0 130 Q 90 210 180 130 T 360 130 T 540 130 T 720 130 T 900 130 T 1080 130 T 1260 130 T 1440 130"
            fill="none"
            stroke="url(#sineGrad)"
            stroke-width="1"
        />

    </svg>


    <div class="sound-line">
        <span class="s-inner"></span>
    </div>


    <div class="sound-line s-2">
        <span class="s-inner"></span>
    </div>


    <div class="particles"></div>

    <div class="bg-grid"></div>

    <div class="film-grain"></div>

    <div class="bg-vignette"></div>

</div>


<!-- =====================================================
     TOASTS
     ===================================================== -->

<div
    class="toast-stack"
    id="toastStack"
    aria-live="polite"
></div>


<!-- =====================================================
     CARD
     ===================================================== -->

<main class="auth-page">

    <div class="auth-card">


        <!-- BRAND -->

        <div class="auth-brand">

            <img
                src="images/logo-new.svg"
                alt="YOUR VOICE ON THE MARK"
            >

            <span class="brand-word">
                YOUR VOICE
                <em>ON THE MARK</em>
            </span>

        </div>


        <!-- =================================================
             SIGNUP VIEW
             ================================================= -->

        <div
            class="auth-view auth-view--active"
            id="signupView"
        >

            <h1 class="auth-title">

                Join

                <span class="grad-text">
                    the wave
                </span>

            </h1>


            <p class="auth-sub">
                Create your account and start listening
            </p>


            <!-- SIGNUP FORM -->

            <form
                id="signupForm"
                action="signup.php"
                method="POST"
                novalidate
            >


                <!-- USERNAME -->

                <div class="field">

                    <label for="suName">
                        Username
                    </label>


                    <div class="input-wrap">

                        <span class="input-icon">

                            <svg
                                width="17"
                                height="17"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>

                                <circle
                                    cx="12"
                                    cy="7"
                                    r="4"
                                />

                            </svg>

                        </span>


                        <input
                            type="text"
                            id="suName"
                            name="user_name"
                            placeholder="Enter username"
                            autocomplete="username"
                            value="<?php echo htmlspecialchars($old_name); ?>"
                            required
                        >

                    </div>


                    <span
                        class="field-msg <?php echo $err_name ? 'show err' : ''; ?>"
                        data-for="suName"
                    >
                        <?php
                        echo htmlspecialchars(
                            (string)$err_name
                        );
                        ?>
                    </span>

                </div>


                <!-- EMAIL -->

                <div class="field">

                    <label for="suEmail">
                        Email
                    </label>


                    <div class="input-wrap">

                        <span class="input-icon">

                            <svg
                                width="17"
                                height="17"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <rect
                                    x="2"
                                    y="4"
                                    width="20"
                                    height="16"
                                    rx="2"
                                />

                                <path d="m22 7-10 6L2 7"/>

                            </svg>

                        </span>


                        <input
                            type="email"
                            id="suEmail"
                            name="user_email"
                            placeholder="you@email.com"
                            autocomplete="email"
                            value="<?php echo htmlspecialchars($old_email); ?>"
                            required
                        >

                    </div>


                    <span
                        class="field-msg <?php echo $err_email ? 'show err' : ''; ?>"
                        data-for="suEmail"
                    >
                        <?php
                        echo htmlspecialchars(
                            (string)$err_email
                        );
                        ?>
                    </span>

                </div>


                <!-- PASSWORD -->

                <div class="field">

                    <label for="suPassword">
                        Password
                    </label>


                    <div class="input-wrap">

                        <span class="input-icon">

                            <svg
                                width="17"
                                height="17"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <rect
                                    x="4"
                                    y="11"
                                    width="16"
                                    height="10"
                                    rx="2"
                                />

                                <path
                                    d="M8 11V7a4 4 0 0 1 8 0v4"
                                />

                            </svg>

                        </span>


                        <input
                            type="password"
                            id="suPassword"
                            name="user_password"
                            placeholder="Create a strong password"
                            autocomplete="new-password"
                            required
                        >


                        <button
                            type="button"
                            class="toggle-pass"
                            data-target="suPassword"
                            aria-label="Show password"
                            aria-pressed="false"
                        >

                            <svg
                                class="eye-on"
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3"
                                />

                            </svg>


                            <svg
                                class="eye-off"
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>

                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>

                                <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/>

                                <path d="m1 1 22 22"/>

                            </svg>

                        </button>

                    </div>


                    <span
                        class="field-msg <?php echo $err_password ? 'show err' : ''; ?>"
                        data-for="suPassword"
                    >
                        <?php
                        echo htmlspecialchars(
                            (string)$err_password
                        );
                        ?>
                    </span>


                    <!-- PASSWORD STRENGTH -->

                    <div
                        class="strength-meter level-0"
                        id="strengthMeter"
                    >

                        <div class="strength-head">

                            <span>
                                Password Strength
                            </span>

                            <span
                                class="strength-label"
                                id="strengthLabel"
                            ></span>

                        </div>


                        <div
                            class="strength-bar"
                            id="strengthBar"
                        >

                            <span class="seg"></span>

                            <span class="seg"></span>

                            <span class="seg"></span>

                            <span class="seg"></span>

                            <span class="seg"></span>

                        </div>

                    </div>

                </div>


                <!-- CONFIRM PASSWORD -->

                <div class="field">

                    <label for="suConfirm">
                        Confirm Password
                    </label>


                    <div class="input-wrap">

                        <span class="input-icon">

                            <svg
                                width="17"
                                height="17"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <rect
                                    x="4"
                                    y="11"
                                    width="16"
                                    height="10"
                                    rx="2"
                                />

                                <path
                                    d="M8 11V7a4 4 0 0 1 8 0v4"
                                />

                            </svg>

                        </span>


                        <input
                            type="password"
                            id="suConfirm"
                            name="confirm_password"
                            placeholder="Re-enter your password"
                            autocomplete="new-password"
                            required
                        >


                        <button
                            type="button"
                            class="toggle-pass"
                            data-target="suConfirm"
                            aria-label="Show password"
                            aria-pressed="false"
                        >

                            <svg
                                class="eye-on"
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3"
                                />

                            </svg>


                            <svg
                                class="eye-off"
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>

                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>

                                <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/>

                                <path d="m1 1 22 22"/>

                            </svg>

                        </button>

                    </div>


                    <span
                        class="field-msg <?php echo $err_confirm ? 'show err' : ''; ?>"
                        data-for="suConfirm"
                    >
                        <?php
                        echo htmlspecialchars(
                            (string)$err_confirm
                        );
                        ?>
                    </span>

                </div>


                <!-- ROLE -->

                <input
                    type="hidden"
                    name="role_id"
                    value="2"
                >


                <!-- SUBMIT -->

                <button
                    type="submit"
                    class="btn-gradient"
                    id="suBtn"
                    name="submit"
                >

                    <span
                        class="spinner"
                        hidden
                    ></span>

                    <span class="btn-text">
                        Create Account
                    </span>

                </button>


                <!-- LOGIN LINK -->

                <div class="auth-alt">

                    Already have an account?

                    <a href="login.php">
                        Login
                    </a>

                </div>

            </form>

        </div>

    </div>

</main>


<!-- =====================================================
     JAVASCRIPT DATA
     ===================================================== -->

<script>

window.flashed = {

    error:
        <?php
        echo $first_error
            ? json_encode($first_error)
            : 'null';
        ?>,

    notice: null

};


window.signupSuccess = false;

</script>


<script src="js/auth.js"></script>


</body>

</html>