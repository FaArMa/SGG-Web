<?php
// Iniciar o re-usar sesión
session_start();

/*
 * Verificar el rol del usuario y el número de usuarios registrados.
 * Si el usuario no tiene un rol definido o su rol no es 0 (Dueño) y hay usuarios registrados,
 * se redirecciona a la página de inicio y se finaliza la ejecución del script.
 */
if ((!isset($_SESSION["role"]) || $_SESSION["role"] !== 0) && $_SESSION["users_count"] > 0) {
    header('Location: ../../');
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


/*
 * Modo de edición:
 * Si el parámetro GET "edit_user" está establecido y no vació,
 * se activa el modo de edición y se actualizan los valores correspondientes.
 * El título de la página se establece como "Editar Usuario",
 * el título principal se actualiza con efectos de estilo y el botón se establece como "Actualizar".
 */
$edit_mode = false;
if (!empty($_GET["edit_user"])) {
    $edit_mode = true;
    $page_title = "Editar Usuario";
    $title = "<h1 class=\"neon\" data-text=\"U\">Ed<span class=\"flicker-slow\">i</span>t<span class=\"flicker-fast\">ar</span> us<span class=\"flicker-slow\">u</span>ari<span class=\"flicker-fast\">o</span></h1>";
    $button = "Actualizar";
}
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
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png">
    <link rel="shortcut icon" href="../img/favicon/favicon.ico">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <!-- Header -->
    <?php require_once("../php/header.php"); ?>
    <!-- Contenido -->
    <section id="add-user">
        <h1 class="neon" data-text="U"><?php echo $title; ?></h1>
        <?php echo ($_SESSION["users_count"] === 0) ? "<p>Aviso: Sos el primer usuario y por lo tanto obtendrás el rol de Dueño</p>" : ""; ?>
        <form action="../php/sign_in.php" method="post">
            <?php if ($edit_mode): ?>
                <?php
                require_once("../php/db/connection.php");
                require_once("../php/db/functions.php");
                $user = get_user_info_all($connection, $_GET["edit_user"]);
                mysqli_close($connection);
                ?>
                <input type="hidden" name="id" value="<?php echo $user["id_usuario"]; ?>">
            <?php else: ?>
                <?php
                // Variables predeterminadas cuando no estás en modo de edición
                $user = [
                    "nombre" => "",
                    "apellido" => "",
                    "dni" => "",
                    "rol" => 0
                ];
                ?>
            <?php endif; ?>
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" placeholder="Escribe tu nombre..." minlength="1" maxlength="30" value="<?php echo $user["nombre"]; ?>" required>
            <label for="surname">Apellido</label>
            <input type="text" id="surname" name="surname" placeholder="Escribe tu apellido..." minlength="1" maxlength="30" value="<?php echo $user["apellido"]; ?>" required>
            <label for="dni">DNI</label>
            <input type="number" id="dni" name="dni" placeholder="Escribe tu DNI..." min="1000" max="99999999" value="<?php echo $user["dni"]; ?>" required>
            <label for="role">Rol</label>
            <select id="role" name="role" <?php echo ($_SESSION["users_count"] == 0) ? " disabled" : ""; ?>>
                <option value="0" <?php echo ($user["rol"] == 0) ? "selected" : ""; ?>>Dueño</option>
                <option value="1" <?php echo ($user["rol"] == 1) ? "selected" : ""; ?>>Encargado</option>
                <option value="2" <?php echo ($user["rol"] == 2) ? "selected" : ""; ?>>Empleado</option>
                <option value="3" <?php echo ($user["rol"] == 3) ? "selected" : ""; ?>>Contador</option>
            </select>
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username" placeholder="Usuario: Primer letra del Nombre + Apellido" title="Usuario: Primer letra del Nombre + Apellido" minlength="2" maxlength="31" readonly>
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Contraseña: Últimos 4 dígitos del DNI" title="Contraseña: Últimos 4 dígitos del DNI" minlength="4" maxlength="4" readonly>
            <button type="submit" id="btn-send"><?php echo $button; ?></button>
            <?php if ($edit_mode): ?>
                <?php if ($user["baja"]): ?>
                    <button type="button" id="btn-restore">Restaurar</button>
                <?php else: ?>
                    <button type="button" id="btn-delete">Eliminar</button>
                <?php endif; ?>
            <?php endif; ?>
        </form>
    </section>
    <!-- Footer -->
    <?php require_once("../php/footer.php"); ?>
</body>
</html>