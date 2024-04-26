<?php

// Using PHP mailer.
use PHPMailer\PHPMailer\PHPMailer;

// Requiring the autoload file.
require __DIR__ . "/vendor/autoload.php";

// Creating a new PHPMailer object.
$mail = new PHPMailer(true);

// Configuring the mail settings.
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = "aftabansari1024@gmail.com";
$mail->Password = 'kbgnmieqmmcycxcf';
// For sending HTML content in mail.
$mail->isHTML(true);

// Returning the configured PHP mailer object.
return $mail;
