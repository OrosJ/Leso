<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        # FIX: Replace this email with recipient email
        $mail_to = "jose.oros@uab.edu.bo";
        
        # Sender Data
        // $subject = trim($_POST["subject"]);
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);
        
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($subject) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Complete el formulario e intente otra vez.";
            exit;
        }
        
        # Mail Content
        $content = "Nombre: $name\n";
        $content .= "Email: $email\n\n";
        $content .= "Mensaje:\n$message\n";

        # email headers.
        $headers = "De: $name <$email>";

        # Send the email.
        $success = mail($mail_to,$content, $headers);
        if ($success) {
            # Set a 200 (okay) response code.
            http_response_code(200);
            echo "Gracias! se ha enviado el mensaje.";
        } else {
            # Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! algo salió mal.";
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Problema con la peticion.";
    }

?>
