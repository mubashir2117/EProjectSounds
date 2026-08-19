<?php
/* loginCheck.php — handles the login form POST from login.php */
session_start();

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$user_email    = trim($_POST['user_email'] ?? '');
$user_password = $_POST['user_password'] ?? '';

/* Client-side already validates, but never trust the client. */
if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['login_error'] = 'Please enter a valid email address.';
    $_SESSION['login_email'] = $user_email;
    header('Location: login.php');
    exit;
}
if ($user_password === '') {
    $_SESSION['login_error'] = 'Please enter your password.';
    $_SESSION['login_email'] = $user_email;
    header('Location: login.php');
    exit;
}

$user = null;
if ($conn) {
    $stmt = $conn->prepare('SELECT user_id, user_name, user_email, user_password, role_id FROM users WHERE user_email = ? LIMIT 1');
    if ($stmt) {
        $stmt->bind_param('s', $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
    }
}

if ($user) {
    $stored = $user['user_password'];
    $valid  = false;

    /* New accounts store a bcrypt hash (password_hash). */
    if (password_verify($user_password, $stored)) {
        $valid = true;
    } elseif (!preg_match('/^\$2[aby]\$/', $stored) && hash_equals($stored, $user_password)) {
        /* Legacy plain-text password from the original system.
           Accept it once and upgrade it to a bcrypt hash so existing users keep working
           without being locked out. New logins then use password_verify. */
        $valid = true;
        $new_hash = password_hash($user_password, PASSWORD_DEFAULT);
        if ($conn) {
            $up = $conn->prepare('UPDATE users SET user_password = ? WHERE user_id = ?');
            if ($up) {
                $up->bind_param('si', $new_hash, $user['user_id']);
                $up->execute();
                $up->close();
            }
        }
    }

    if ($valid) {
        session_regenerate_id(true);
        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['role']      = $user['role_id'];

        /* Existing behaviour preserved — role_id 2 (User) lands on index.php. */
        if ((int)$_SESSION['role'] == 2) {
            header('Location: index.php');
            exit;
        }
        header('Location: index.php');
        exit;
    }
}

/* Never reveal whether the email or the password was wrong. */
$_SESSION['login_error'] = 'Invalid email or password.';
$_SESSION['login_email'] = $user_email;
header('Location: login.php');
exit;
