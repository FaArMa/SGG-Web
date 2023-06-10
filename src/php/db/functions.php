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
    $query = "SELECT `rol` FROM `usuario` WHERE `nombre_usuario` = '$escaped_username';";
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
    $query = "SELECT * FROM `usuario` WHERE `nombre_usuario` = '$escaped_username' AND `contrasena` = '$hashed_password'";
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
 * @param int $dni El DNI del usuario.
 * @param int $role El rol del usuario.
 * @param string $username El nombre de usuario.
 * @param string $password La contraseña del usuario (sin encriptar).
 * @return bool True si el usuario se ha agregado correctamente, false en caso contrario.
 */
function add_user($connection, $name, $surname, $dni, $role, $username, $password) {
    $escaped_name = mysqli_real_escape_string($connection, $name);
    $escaped_surname = mysqli_real_escape_string($connection, $surname);
    $escaped_dni = mysqli_real_escape_string($connection, $dni);
    $escaped_role = mysqli_real_escape_string($connection, $role);
    $escaped_username = mysqli_real_escape_string($connection, $username);
    $hashed_password = md5($password);
    $query = "INSERT INTO `usuario` VALUES (NULL,'$escaped_name','$escaped_surname','$escaped_dni','$escaped_role','$escaped_username','$hashed_password');";
    $result = mysqli_query($connection, $query) or die("Error al agregar usuario a la base de datos.");
    return $result;
}

function get_user_list($connection) {
    $result = mysqli_query($connection, "SELECT nombre_usuario, rol FROM usuario ORDER BY rol ASC;") or die("dije basta de error catching");
    $user_list = array();

    while ($row = mysqli_fetch_assoc($result))
        array_push($user_list, $row["nombre_usuario"], $row["rol"]);
    mysqli_free_result($result);
    return $user_list;
}

function get_product_list($connection) {
    $result = mysqli_query($connection, "SELECT nombre_producto, precio, tipo FROM producto;") or die("Error al obtener la lista de productos desde la base de datos");
    $product_list = array();

    while ($row = mysqli_fetch_assoc($result))
        array_push($product_list, $row["nombre_producto"], $row["precio"], $row["tipo"]);
    mysqli_free_result($result);
    return $product_list;
}

function get_available_ingredients($connection) {
    $result = mysqli_query($connection, "SELECT nombre_ingrediente, unidad_medida FROM ingrediente;") or die("BASTA DE ERROR CATCHING");
    $available_ingredients = array();

    while ($row = mysqli_fetch_assoc($result))
        array_push($available_ingredients, $row["nombre_ingrediente"], $row["unidad_medida"]);
    mysqli_free_result($result);
    return $available_ingredients;
}

function get_product_ingredients($connection) {
    $result = mysqli_query($connection, "SELECT COUNT(id_producto) AS cantidad_productos FROM producto;") or die("Error al obtener los ingredientes por producto desde la base de datos");
    $row = mysqli_fetch_assoc($result);
    $product_qty = (int)$row["cantidad_productos"];

    $product_array = array();
    $ingredients = array();

    for($i = 1; $i <= $product_qty; $i++) {
        $query = sprintf("SELECT i.nombre_ingrediente FROM ingrediente_x_producto ixp INNER JOIN ingrediente i ON (i.id_ingrediente = ixp.id_ingrediente) WHERE ixp.id_producto = %d;", $i);

        $result = mysqli_query($connection, $query) or die ("Error get_product_ingredient");

        while ($row = mysqli_fetch_assoc($result))
            array_push($ingredients, $row["nombre_ingrediente"]);
        array_push($product_array, $ingredients);
        $ingredients = [];
    }
    mysqli_free_result($result);
    return $product_array;
}

function get_product_ingredient_amounts($connection) {
    $result = mysqli_query($connection, "SELECT COUNT(id_producto) AS cantidad_productos FROM producto;") or die("Error al obtener las cantidades de ingrediente por producto desde la base de datos");
    $row = mysqli_fetch_assoc($result);
    $product_qty = (int)$row["cantidad_productos"];

    $product_array = array();
    $amounts = array();

    for($i = 1; $i <= $product_qty; $i++) {
        $query = sprintf("SELECT ixp.cantidad FROM ingrediente_x_producto ixp WHERE ixp.id_producto = %d;", $i);

        $result = mysqli_query($connection, $query) or die ("Error get_product_ingredient_amounts");

        while ($row = mysqli_fetch_assoc($result))
            array_push($amounts, $row["cantidad"]);
        array_push($product_array, $amounts);
        $amounts = [];
    }
    mysqli_free_result($result);
    return $product_array;
}
?>