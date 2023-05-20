<?php
// Declarar e inicializar variables
$name = $email = $msg = $name_error = $email_error = $msg_error = "";

// Requerido solamente para usar sanitize_input()
require_once("db/functions.php");

// Trabajamos solamente cuando la petición sea POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitizar antes de usar
    $name = sanitize_input($_POST["name"]);
    $email = sanitize_input($_POST["email"]);
    $msg = sanitize_input($_POST["msg"]);
    
    // Controlar el nombre ingresado
    if (empty($name))
        $name_error = "Se debe ingresar un nombre";
    else
        if (!preg_match("/^[a-zA-Z ]+$/", $name))
            $name_error = "Solo se permiten letras y espacios";

    // Controlar el correo electrónico ingresado
    if (empty($email))
        $email_error = "Se debe ingresar un correo electrónico";
    else
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $email_error = "Formato de correo electrónico inválido";

    // Controlar el mensaje ingresado
    if (empty($msg))
        $msg_error = "Se debe ingresar un mensaje";

    // Si no hay errores, simular el envió de los datos a un correo electrónico
    if ($name_error === $email_error && $email_error === $msg_error) {
        $from = $name . " <" . $email . ">";
        $to = "sgg@example.com";
        $subject = "Contacto desde SGG-Web";
        $message = $from . PHP_EOL . $msg;
        // Cada línea de $message debe ser de 70 caracteres o menos
        $message = wordwrap($message, 70, PHP_EOL);
        // Intentar enviar el correo electrónico
        if (@mail($to, $subject, $message, "From: " . $from))
            echo "Formulario enviado con éxito.";
        else
            echo "Hubo un error al enviar su formulario.";
    }
}
?>