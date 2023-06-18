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
$users = empty($surname_searched) ? get_users_list_all($connection) : get_users_list_surname_all($connection, $surname_searched);

// Cerrar la conexión a la base de datos
mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de usuarios - SGG</title>
    <meta name="description" content="Página de lista de usuarios del SGG. Sitio web creado para la parte práctica del segundo parcial de Laboratorio de Computación IV">
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
    <section id="users-list">
        <h1 class="neon" data-text="U"><span class="flicker-slow">L</span>ist<span class="flicker-fast">a</span> de <span class="flicker-slow">us</span>uar<span class="flicker-fast">io</span>s</h1>
        <!-- Buscador -->
        <form action="<?php echo sanitize_input($_SERVER["PHP_SELF"]); ?>#content" method="get">
            <input type="text" id="surname" name="surname" placeholder="Escribe un apellido..." value="<?php echo $surname_searched; ?>">
            <button type="submit" id="btn-send">Buscar</button>
        </form>
        <!-- Agregar usuario -->
        <a href="sign_in.php#add-user" id="agregate"><i id="add" class="fa-solid fa-circle-plus"></i> Agregar usuario</a>
        <!-- Lista de usuarios -->
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th>Rol</th>
                    <th>Usuario</th>
                    <th>Eliminado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="content">
                <?php
                // Recorrer cada usuario y mostrar los datos en filas de la tabla
                foreach ($users as $row) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>" . $row["apellido"] . "</td>";
                    echo "<td>" . $row["dni"] . "</td>";
                    echo "<td>";
                    if ($row["rol"] == 0)
                        echo "Dueño";
                    elseif ($row["rol"] == 1)
                        echo "Encargado";
                    elseif ($row["rol"] == 2)
                        echo "Empleado";
                    elseif ($row["rol"] == 3)
                        echo "Contador";
                    else
                        echo "Desconocido";
                    echo "</td>";
                    echo "<td>" . $row["nombre_usuario"] . "</td>";
                    echo "<td>" . ($row["baja"] == 1 ? "Si" : "No") . "</td>";
                    echo "<td><a href=\"sign_in.php?edit_user=" . $row["nombre_usuario"] . "\"><i class=\"fa-solid fa-pen-to-square\"></i></a></td>";
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