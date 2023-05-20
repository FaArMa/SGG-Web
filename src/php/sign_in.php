<?php
// Iniciar o re-usar sesión
session_start();

/*
 * Recibe los valores del formulario de registro/agregar usuario mediante POST
 * El valor predeterminado del rol es 0 (Dueño) si no se proporciona
 */
$role = (isset($_POST["role"])) ? $_POST["role"] : 0;

// Se requiere una conexión a la base de datos y las funciones que interactúan con la misma
require_once("db/connection.php");
require_once("db/functions.php");

// Registrar/agregar un nuevo usuario a la base de datos
add_user($connection, $_POST["name"], $_POST["surname"], $role, $_POST["username"], $_POST["password"]);

// Cerrar la conexión a la base de datos
mysqli_close($connection);

// Incrementa el contador de usuarios en la sesión si se registró/agregó correctamente
++$_SESSION["users_count"];

// Redirige al usuario a la página de inicio
header("Location: /SGG-Web/");
?>