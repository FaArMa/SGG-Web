<?php
// Iniciar o re-usar sesión
session_start();

/*
 * Verificar si el usuario ha iniciado sesión y tiene el rol adecuado.
 * Si no se ha iniciado sesión, la variable $_SESSION["logged_in"] es falsa
 * o el valor de $_SESSION["role"] no es igual a 0 (Dueño) o 1 (Encargado),
 * se redirecciona a la página de inicio de sesión y se finaliza la ejecución del script.
 */
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] === false || $_SESSION["role"] > 1) {
    header("Location: /SGG-Web/src/common/log_in.php");
    die;
}

// Requerir los archivos necesarios para la conexión a la base de datos y las funciones
require_once("../php/db/connection.php");
require_once("../php/db/functions.php");

// Obtener la lista de pedidos
$orders = get_orders_list($connection);

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
    <section id="orders-list">
        <h1 class="neon" data-text="U"><span class="flicker-slow">L</span>ist<span class="flicker-fast">a</span> de <span class="flicker-slow">pe</span>di<span class="flicker-fast">do</span>s</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha de Creación</th>
                    <th>Usuario</th>
                    <th>Proveedor</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Recorrer cada pedido y mostrar los datos en filas de la tabla
                foreach ($orders as $row) {
                    echo "<tr>";
                    echo "<td>" . $row["id_pedido"] . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($row["fecha_pedido"])) . "</td>";
                    echo "<td>" . $row["nombre_usuario"] . "</td>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>" . ($row["baja"] == 1 ? "Entregado" : "Activo") . "</td>";
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