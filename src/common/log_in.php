<?php require_once("../php/log_in.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - SGG</title>
    <meta name="description" content="Página de inicio de sesión del SGG. Sitio web creado para la parte práctica del segundo parcial de Laboratorio de Computación IV">
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
        <h1>Iniciar sesión</h1>
        <form action="../php/log_in.php" method="post">
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username" placeholder="Escribe tu usuario..." required>
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Escribe tu contraseña..." required>
            <button type="submit" id="btn-send">Enviar</button>
        </form>
    </section>
    <!-- Footer -->
    <?php require_once("../php/footer.php"); ?>
</body>
</html>