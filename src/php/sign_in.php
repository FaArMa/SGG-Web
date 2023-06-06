<?php
// Iniciar o re-usar sesión
session_start();

// Se requiere una conexión a la base de datos y las funciones que interactúan con la misma
require_once("db/connection.php");
require_once("db/functions.php");

// Sanitizar los valores de $_POST[] que posiblemente se muestren en la página en algún futuro
$_POST["name"] = sanitize_input($_POST["name"]);
$_POST["surname"] = sanitize_input($_POST["surname"]);
$_POST["dni"] = sanitize_input($_POST["dni"]);
$_POST["role"] = sanitize_input($_POST["role"]);
$_POST["username"] = sanitize_input($_POST["username"]);

// Registrar/agregar un nuevo usuario a la base de datos
add_user($connection, $_POST["name"], $_POST["surname"], $_POST["dni"], $_POST["role"], $_POST["username"], $_POST["password"]);

// Cerrar la conexión a la base de datos
mysqli_close($connection);

// Incrementa el contador de usuarios en la sesión si se registró/agregó correctamente
++$_SESSION["users_count"];

// Redirige al usuario a la página de inicio
header("Location: /SGG-Web/");
?>