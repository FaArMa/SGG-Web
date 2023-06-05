<?php
// Iniciar o re-usar sesión
session_start();

/*
 * Verificar si el usuario ha iniciado sesión y tiene el rol adecuado.
 * Si no se ha iniciado sesión, la variable $_SESSION["logged_in"] es falsa
 * o el valor de $_SESSION["role"] no es igual a 0 (Dueño),
 * se redirecciona a la página de inicio de sesión y se finaliza la ejecución del script.
 */
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] === false || $_SESSION["role"] !== 0) {
    header("Location: /SGG-Web/src/common/log_in.php");
    die;
}

// Requerir los archivos necesarios para la conexión a la base de datos y las funciones
require_once("../php/db/connection.php");
require_once("../php/db/functions.php");

// Obtener la lista de usuarios según corresponda
$surname_searched = isset($_GET["surname"]) ? sanitize_input($_GET["surname"]) : "";
$users = empty($surname_searched) ? get_users_list($connection) : get_users_list_surname($connection, $surname_searched);

// Cerrar la conexión a la base de datos
mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de pedidos - SGG</title>
    <meta name="description" content="Página de lista de pedidos del SGG. Sitio web creado para la parte práctica del segundo parcial de Laboratorio de Computación IV">
    <meta name="author" content="FaArMa, iglop, ereichardt">
    <meta name="robots" content="noindex, nofollow">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <!-- Header -->
    <?php require_once("../php/header.php"); ?>
    <!-- Contenido -->
    <section id="orders-list">
        <h1 class="neon" data-text="U"><span class="flicker-slow">L</span>ist<span class="flicker-fast">a</span> de <span class="flicker-slow">pe</span>di<span class="flicker-fast">do</span>s</h1>
        <form action="<?php echo sanitize_input($_SERVER["PHP_SELF"]); ?>" method="get">
            <!--Los pedidos tendría sentidos buscarlos por fecha supongo-->
            <input type="text" id="date" name="date" placeholder="Ingresa la fecha..." value="<?php echo $surname_searched; ?>">
            <button type="submit" id="btn-send">Buscar</button>
        </form>
        <!--Solo pide un CRUD pero se podría reciclar el de usuarios... por lo pronto saco el boton de agregar-->
        <!--<a href="#" id="agregate"><i id="add" class="fa-solid fa-circle-plus"></i> Nuevo pedido</a>-->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha de Creación</th>
                    <th>Estado</th>
                    <th>Usuario que lo creó</th>
                    <th colspan="2">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Recorrer cada usuario y mostrar los datos en filas de la tabla
                foreach ($users as $row) {
                    echo "<tr>";
                    echo "<td>" . $row["id_pedido"] . "</td>";
                    echo "<td>" . $row["fecha"] . "</td>";
                    echo "<td>" . $row["estado"] . "</td>";
                    echo "<td>" . $row["id_usuario"] . "</td>";     //¿Es necesario...? ¿Hacer un join del id del usuario con la tabla usuario y devolver su apellido?
                    echo "<td><a href=\"#\"><i class=\"fa-solid fa-pen-to-square\"></i></a></td>";
                    echo "<td><a href=\"#\"><i class=\"fa-solid fa-trash-can\"></i></a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
    <!-- Footer -->
    <?php require_once("../php/footer.php"); ?>
</body>
</html>