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

if (isset($_POST["id"])) {
    if (isset($_POST["delete_user"])) {
        // Eliminar al usuario en la base de datos (baja lógica)
        delete_user($connection, $_POST["username"]);
        // Decrementa el contador de usuarios en la sesión si se eliminó correctamente
        --$_SESSION["users_count"];
    } else if (isset($_POST["restore_user"])) {
        // Restaurar al usuario eliminado en la base de datos
        restore_user($connection, $_POST["username"]);
        // Incrementa el contador de usuarios en la sesión si se restauró correctamente
        ++$_SESSION["users_count"];
    } else
        // Actualizar los datos del usuario en la base de datos
        modify_user($connection, $_POST["name"], $_POST["surname"], $_POST["dni"], $_POST["role"], $_POST["username"], $_POST["password"], $_POST["id"]);
} else {
    // Registrar/agregar un nuevo usuario a la base de datos
    add_user($connection, $_POST["name"], $_POST["surname"], $_POST["dni"], $_POST["role"], $_POST["username"], $_POST["password"]);
    // Incrementa el contador de usuarios en la sesión si se registró/agregó correctamente
    ++$_SESSION["users_count"];
}

// Cerrar la conexión a la base de datos
mysqli_close($connection);

// Redirige al usuario a la página de inicio
header("Location: ../../");
?>