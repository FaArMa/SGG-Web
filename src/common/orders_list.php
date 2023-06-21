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
    header("Location: log_in.php#log-in");
    die;
}

// Requerir los archivos necesarios para la conexión a la base de datos y las funciones
require_once("../php/db/connection.php");
require_once("../php/db/functions.php");

// Obtener la lista de pedidos según corresponda
date_default_timezone_set("America/Argentina/Buenos_Aires");
$date_start_searched = isset($_GET["date-start"]) ? sanitize_input($_GET["date-start"]) : "";
$date_end_searched = isset($_GET["date-end"]) ? sanitize_input($_GET["date-end"]) : date("Y-m-d");
$orders = empty($date_start_searched) ? get_orders_list($connection) : get_orders_list_by_date_range($connection, $date_start_searched, $date_end_searched);

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
        <!-- Buscador -->
        <form action="<?php echo sanitize_input($_SERVER["PHP_SELF"]); ?>#content" method="get">
            <label for="date-start">Fecha inicial</label>
            <input type="date" id="date-start" name="date-start" max="<?php echo $date_end_searched; ?>" value="<?php echo $date_start_searched; ?>" required>
            <label for="date-end">Fecha final</label>
            <input type="date" id="date-end" name="date-end" max="<?php echo date("Y-m-d"); ?>" value="<?php echo $date_end_searched; ?>" required>
            <button type="submit" id="btn-send">Buscar</button>
            <button type="button" id="btn-reset">Reiniciar</button>
        </form>
        <!-- Lista de pedidos -->
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
            <tbody id="content">
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