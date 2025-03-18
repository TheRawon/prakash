<?php
// Start session to handle messages (optional, can use GET instead)
session_start();

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: index.php?status=error&message=All fields are required.");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.php?status=error&message=Invalid email format.");
        exit();
    }

    // Email configuration
    $to = "yadavprakashppp@gmail.com";
    $subject = "New Contact Form Message from $name";
    $body = "Name: $name\nEmail: $email\nMessage: $message";
    $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=utf-8";

    // Attempt to send email
    $mailSent = mail($to, $subject, $body, $headers);

    if ($mailSent) {
        header("Location: index.php?status=success");
    } else {
        error_log("Mail failed for $name: " . error_get_last()['message']);
        header("Location: index.php?status=error&message=Failed to send message. Please try again later.");
    }
    exit();
} else {
    // Redirect if accessed directly without POST
    header("Location: index.php");
    exit();
}
?>
