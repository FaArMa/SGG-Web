<?php
// Iniciar o re-usar sesión
session_start();

// Si el usuario ya ha iniciado sesión, redirige al panel de control.
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    header("Location: /SGG-Web/src/common/control_panel.php");
    die;
}

// Verificar si se envió el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Se requiere una conexión a la base de datos y las funciones que interactúan con la misma
    require_once("db/connection.php");
    require_once("db/functions.php");
    // Sanitizar los valores de $_POST[] que posiblemente se muestren en la página en algún futuro
    $_POST["username"] = sanitize_input($_POST["username"]);
    // Validación de las credenciales del usuario
    if (validate_user_credentials($connection, $_POST["username"], $_POST["password"])) {
        // Establecer variables de sesión
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $_POST["username"];
        // Obtener el rol del usuario
        $_SESSION["role"] = get_user_role($connection, $_SESSION["username"]);
        // Redirigir al usuario a la página del panel de control
        header("Location: /SGG-Web/src/common/control_panel.php");
    } else {
        // Establecer el mensaje de error y redirigir al usuario a la página de inicio
        $_SESSION["log_in_error"] = "Usuario y/o contraseña incorrectos";
        header("Location: /SGG-Web/#error");
    }
    // Cerrar la conexión a la base de datos
    mysqli_close($connection);
}
?>