<?php
/* forgot_password.php — Password reset handler.
   The reset UI lives on login.php. This file keeps the reset logic clearly
   separated so it can be connected to a real email service later.

   NOTE: No fake success. Until an email service (SMTP/PHPMailer) is configured,
   a reset link is NOT actually sent and the user is told so honestly.
*/
session_start();

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$user_email = trim($_POST['user_email'] ?? '');

if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['reset_notice'] = 'Please enter a valid email address.';
    header('Location: login.php');
    exit;
}

if ($conn) {
    /* Prepared-statement lookup so the future reset-token flow is ready to use. */
    $stmt = $conn->prepare('SELECT user_id, user_name FROM users WHERE user_email = ? LIMIT 1');
    if ($stmt) {
        $stmt->bind_param('s', $user_email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $user_name);
            $stmt->fetch();

            /*
             * TODO — connect a real email service here (e.g. PHPMailer + SMTP).
             * 1. Generate a secure reset token + expiry and store it (e.g. in a
             *    `password_resets` table or memory).
             * 2. Email the user a one-time link like:
             *    reset_password.php?token=<token>
             * The account WAS found, so the reset email can now be delivered.
             */
        }
        $stmt->close();
    }
}

/* Honest, neutral message — a reset link was not sent because email delivery
   is not configured yet. Do not fake a successful reset. */
$_SESSION['reset_notice'] = 'Password reset is not enabled yet. Please contact support at hello@yourvoiceonthemark.com and we will help you get back in.';
header('Location: login.php');
exit;