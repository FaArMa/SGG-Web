<?php
// Iniciar o re-usar sesión
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - SGG</title>
    <meta name="description" content="Página de inicio del SGG. Sitio web creado para la parte práctica del segundo parcial de Laboratorio de Computación IV">
    <meta name="author" content="FaArMa, iglop, ereichardt">
    <meta name="robots" content="noindex, nofollow">
    <!-- CSS -->
    <link rel="stylesheet" href="src/css/main.css">
</head>
<body>
    <!-- Header -->
    <?php require_once("src/php/header.php"); ?>
    <?php
    /**
     * Muestra un mensaje de error si se produjo un error en el inicio de sesión.
     * Si existe un mensaje de error, se muestra y luego se destruye la variable para evitar que aparezca después de actualizar la página.
     */
    if (isset($_SESSION["log_in_error"])) {
        echo "<p>" . $_SESSION["log_in_error"] . "</p>";
        unset($_SESSION["log_in_error"]);
    }
    ?>
    <!-- Contenido -->
    <section>
        <h1>SGG-Web</h1>
        <p>Una herramienta útil para la gestión de empleados y ventas de tu aplicación de Sistema de Gestión Gastronómico, proporcionando acceso seguro y controlado para el dueño y el contador.</p>
        <p>Si no eres el dueño ni contador del local y estás viendo este sitio web, significa que alguien configuró mal todo.</p>
    </section>
    <!-- Footer -->
    <?php require_once("src/php/footer.php"); ?>
</body>
</html>