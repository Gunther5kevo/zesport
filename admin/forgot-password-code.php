<?php
include('functions.php');

if (isset($_POST['forgot_password'])) {
    $email = $_POST['email'];

    // Check if email exists in the database
    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Store token in the database
        $query = "UPDATE users SET reset_token='$token' WHERE email='$email'";
        mysqli_query($conn, $query);

        // Send reset link via email
        $resetLink = "http://yourwebsite.com/reset-password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click on the following link to reset your password: $resetLink";
        $headers = "From: no-reply@yourwebsite.com";

        mail($email, $subject, $message, $headers);

        redirect('forgot-password.php', 'Password reset link has been sent to your email.');
    } else {
        redirect('forgot-password.php', 'Email not found.');
    }
}

