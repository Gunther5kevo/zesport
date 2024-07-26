<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize inputs
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
    $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Validate inputs
    if (empty($fname) || empty($lname) || empty($email) || empty($phoneNumber) || empty($subject) || empty($message)) {
        die("Please fill in all required fields.");
    }

    // Process the form data (e.g., send an email)
    $mail = new PHPMailer(true); // Create a new PHPMailer instance

    try {
        //Server settings
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'champguru6@gmail.com'; // SMTP username
        $mail->Password = 'Kevo5682'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to

        //Recipients
        $mail->setFrom($email, "$fname $lname");
        $mail->addAddress('kevoguru4@gmail.com'); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = "New Contact Form Submission: $subject";
        $mail->Body    = "First Name: $fname<br>Last Name: $lname<br>Email: $email<br>Phone Number: $phoneNumber<br><br>Message:<br>$message";
        $mail->AltBody = "First Name: $fname\nLast Name: $lname\nEmail: $email\nPhone Number: $phoneNumber\n\nMessage:\n$message";

        $mail->send();
        echo "Thank you for contacting us!";
    } catch (Exception $e) {
        echo "Sorry, something went wrong. Please try again later. Mailer Error: {$mail->ErrorInfo}";
    }
}
