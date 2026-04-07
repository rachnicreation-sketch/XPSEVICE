<?php
/**
 * RX SERVICES - Contact Form Handler
 * Sends form data to rachnicreation@gmail.com
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Basic validation
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Oups ! Il y a eu un problème avec votre soumission. Veuillez compléter le formulaire et réessayer.";
        exit;
    }

    // Recipient email address
    $recipient = "rachnicreation@gmail.com";

    // Email headers
    $email_headers = "From: $name <$email>";

    // Build the email content
    $email_content = "Nom: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Sujet: $subject\n\n";
    $email_content .= "Message:\n$message\n";

    // Send the email
    if (mail($recipient, "Nouveau message de contact: $subject", $email_content, $email_headers)) {
        // Set a 200 (success) response code.
        http_response_code(200);
        echo "Merci ! Votre message a été envoyé avec succès.";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Oups ! Quelque chose s'est mal passé et nous n'avons pas pu envoyer votre message.";
    }

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "Il y a eu un problème avec votre soumission, veuillez réessayer.";
}
?>
