<?php
/**
 * Archivo de funciones de base de datos.
 *
 * Este archivo contiene funciones para interactuar con la base de datos,
 * como consultas, inserciones, actualizaciones y eliminaciones.
 *
 * @package functions
 */


/**
 * Sanitiza una cadena de entrada eliminando espacios en blanco adicionales,
 * caracteres de escape y convirtiendo caracteres especiales en entidades HTML.
 *
 * @param string $data La cadena a sanitizar.
 * @return string La cadena sanitizada.
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


/**
 * Obtiene la cantidad de usuarios registrados en la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @return int|false La cantidad de usuarios registrados o false en caso de error.
 */
function get_users_count($connection) {
    $result = mysqli_query($connection, "SELECT COUNT(*) FROM `usuario`;") or die("Error al obtener la cantidad de usuarios desde la base de datos.");
    $records = mysqli_fetch_row($result);
    $users_count = (int) $records[0];
    mysqli_free_result($result);
    return $users_count;
}


/**
 * Obtiene una lista de usuarios desde la base de datos.
 *
 * @param mysqli $connection La conexión a la base de datos.
 * @return array Un array asociativo con los datos de los usuarios.
 */
function get_users_list($connection) {
    $result = mysqli_query($connection, "SELECT * FROM `usuario`;") or die("Error al obtener la lista usuarios desde la base de datos.");
    $users = array();
    while ($row = mysqli_fetch_assoc($result))
        $users[] = $row;
    mysqli_free_result($result);
    return $users;
}


/**
 * Obtiene una lista de usuarios desde la base de datos filtrada por apellido.
 *
 * @param mysqli $connection La conexión a la base de datos.
 * @param string $surname El apellido a buscar.
 * @return array Un array asociativo con los datos de los usuarios que coinciden con el apellido buscado.
 */
function get_users_list_surname($connection, $surname) {
    $surname = mysqli_real_escape_string($connection, $surname);
    $query = "SELECT * FROM `usuario` WHERE `apellido` LIKE '%$surname%';";
    $result = mysqli_query($connection, $query) or die("Error al obtener la lista de usuarios con un apellido en especifico desde la base de datos.");
    $users = array();
    while ($row = mysqli_fetch_assoc($result))
        $users[] = $row;
    mysqli_free_result($result);
    return $users;
}


/**
 * Obtiene el rol de un usuario específico desde la base de datos.
 *
 * @param mysqli $connection La conexión a la base de datos MySQL.
 * @param string $username El nombre de usuario del usuario del que se desea obtener el rol.
 * @return int|null El rol del usuario o null si no se encuentra.
 */
function get_user_role($connection, $username) {
    $escaped_username = mysqli_real_escape_string($connection, $username);
    $query = "SELECT `rol` FROM `usuario` WHERE `usuario` = '$escaped_username';";
    $result = mysqli_query($connection, $query) or die("Error al obtener el rol del usuario desde la base de datos.");
    $row = mysqli_fetch_assoc($result);
    $role = (int)$row["rol"];
    return $role;
}


/**
 * Verifica si las credenciales de usuario son válidas.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $username El nombre de usuario a verificar.
 * @param string $password La contraseña a verificar (sin encriptar).
 * @return bool True si las credenciales son válidas, false en caso contrario.
 */
function validate_user_credentials($connection, $username, $password) {
    $escaped_username = mysqli_real_escape_string($connection, $username);
    $hashed_password = md5($password);
    $query = "SELECT * FROM `usuario` WHERE `usuario` = '$escaped_username' AND `contrasena` = '$hashed_password'";
    $result = mysqli_query($connection, $query) or die("Error al validar las credenciales de usuario con la base de datos.");
    $valid = (mysqli_num_rows($result) > 0);
    mysqli_free_result($result);
    return $valid;
}


/**
 * Registra/agrega un nuevo usuario a la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $name El nombre del usuario.
 * @param string $surname El apellido del usuario.
 * @param int $role El rol del usuario.
 * @param string $username El nombre de usuario.
 * @param string $password La contraseña del usuario (sin encriptar).
 * @return bool True si el usuario se ha agregado correctamente, false en caso contrario.
 */
function add_user($connection, $name, $surname, $role, $username, $password) {
    $escaped_name = mysqli_real_escape_string($connection, $name);
    $escaped_surname = mysqli_real_escape_string($connection, $surname);
    $escaped_role = mysqli_real_escape_string($connection, $role);
    $escaped_username = mysqli_real_escape_string($connection, $username);
    $hashed_password = md5($password);
    $query = "INSERT INTO `usuario` VALUES (NULL,'$escaped_name','$escaped_surname','$escaped_role','$escaped_username','$hashed_password')";
    $result = mysqli_query($connection, $query) or die("Error al agregar usuario a la base de datos.");
    return $result;
}
?>