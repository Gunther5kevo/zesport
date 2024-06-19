<?php
session_start();

function redirect($url, $message = null) {
    if ($message) {
        $_SESSION['message'] = $message;
    }
    header("Location: $url");
    exit();
}

if (isset($_SESSION['auth'])) {
    $userRole = $_SESSION['loggedInUserRole'];
    session_unset();
    session_destroy();

    if ($userRole == 'admin') {
        redirect('login.php', 'Logged out successfully.');
    } else {
        redirect('login.php', 'Logged out successfully.');
    }
} else {
    redirect('login.php', 'You are not logged in.');
}

