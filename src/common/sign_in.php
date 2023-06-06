<?php
// Iniciar o re-usar sesión
session_start();

/*
 * Verificar el rol del usuario y el número de usuarios registrados.
 * Si el usuario no tiene un rol definido o su rol no es 0 (Dueño) y hay usuarios registrados,
 * se redirecciona a la página de inicio y se finaliza la ejecución del script.
 */
if ((!isset($_SESSION["role"]) || $_SESSION["role"] !== 0) && $_SESSION["users_count"] > 0) {
    header('Location: /SGG-Web/');
    die;
}

/*
 * Establecer el título de la página.
 * Si no hay usuarios registrados, el título se establece como "Registrarse",
 * de lo contrario, se establece como "Agregar usuario".
 */
$page_title = ($_SESSION["users_count"] == 0) ? "Registrarse" : "Agregar Usuario";
$title = ($_SESSION["users_count"] == 0) ? "Re<span class=\"flicker-slow\">g</span>ist<span class=\"flicker-fast\">rar</span>se" : "Agr<span class=\"flicker-fast\">eg</span>ar <span class=\"flicker-slow\">Us</span>uar<span class=\"flicker-fast\">io</span>";
$button = ($_SESSION["users_count"] == 0) ? "Registrarse" : "Agregar";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - SGG</title>
    <meta name="description" content="Página de registro del SGG. Sitio web creado para la parte práctica del segundo parcial de Laboratorio de Computación IV">
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
        <h1 class="neon" data-text="U"><?php echo $title; ?></h1>
        <?php echo ($_SESSION["users_count"] === 0) ? "<p>Aviso: Sos el primer usuario y por lo tanto obtendrás el rol de Dueño</p>" : ""; ?>
        <form action="../php/sign_in.php" method="post">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" placeholder="Escribe tu nombre..." required>
            <label for="surname">Apellido</label>
            <input type="text" id="surname" name="surname" placeholder="Escribe tu apellido..." required>
            <label for="dni">DNI</label>
            <input type="number" id="dni" name="dni" placeholder="Escribe tu DNI..." required>
            <label for="role">Rol</label>
            <select id="role" name="role" <?php echo ($_SESSION["users_count"] == 0) ? " disabled" : ""; ?>>
                <option value="0">Dueño</option>
                <option value="1">Gerente</option>
            </select>
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username" placeholder="Escribe tu usuario..." required>
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Escribe tu contraseña..." required>
            <button type="submit" id="btn-send"><?php echo $button; ?></button>
        </form>
    </section>
    <!-- Footer -->
    <?php require_once("../php/footer.php"); ?>
</body>
</html>