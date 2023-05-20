<?php
// Iniciar o re-usar sesión
session_start();

/*
 * Verificar si el usuario ha iniciado sesión.
 * Si no se ha iniciado sesión o la variable $_SESSION["logged_in"] es falsa,
 * se redirecciona a la página de inicio de sesión y se finaliza la ejecución del script.
 */
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] === false) {
    header("Location: /SGG-Web/src/common/log_in.php");
    die;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de control - SGG</title>
    <meta name="description" content="Página del panel de control del SGG. Sitio web creado para la parte práctica del segundo parcial de Laboratorio de Computación IV">
    <meta name="author" content="FaArMa, iglop, ereichardt">
    <meta name="robots" content="noindex, nofollow">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <!-- Header -->
    <?php require_once("../php/header.php"); ?>
    <!-- Contenido -->
    <section>
        <h1>Panel de control</h1>
        <?php
        // Solo lo ve el Dueño
        if ($_SESSION["role"] === 0)
            echo "<p><a href=\"/SGG-Web/src/common/users_list.php\">Lista de usuarios</a></p>";
        echo "<p><a href=\"/SGG-Web/src/common/invoices_list.php\">Lista de facturas</a></p>";
        ?>
    </section>
    <!-- Footer -->
    <?php require_once("../php/footer.php"); ?>
</body>
</html>