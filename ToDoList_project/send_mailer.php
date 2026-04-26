<?php
// Install PHPMailer using Composer with this commande : composer require phpmailer/phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendEmail($to, $subject, $body){

    $mail = new PHPMailer(true);

    try{
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Update to your SMTP server in genral if you use Gmail it's smtp.gmail.com
        $mail->SMTPAuth   = true;
        $mail->Username   = 'name@gmail.com'; // Your email address
        $mail->Password   = 'Your app password'; // Create app in Gmail and use the generated password here https://myaccount.google.com/apppasswords
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('name@gmail.com', 'To-Do List App');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        echo 'Mail is sent';
        return true;
    }
    catch (Exception $e) {
        echo $mail->ErrorInfo;
        return false;
    }
}