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
 * Obtiene la cantidad de usuarios registrados en la base de datos (excluyendo a los eliminados).
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @return int|false La cantidad de usuarios registrados o false en caso de error.
 */
function get_users_count($connection) {
    $result = mysqli_query($connection, "SELECT COUNT(*) FROM `usuario` WHERE `baja` = 0;") or die("Error al obtener la cantidad de usuarios desde la base de datos.");
    $records = mysqli_fetch_row($result);
    $users_count = (int) $records[0];
    mysqli_free_result($result);
    return $users_count;
}


/**
 * Obtiene una lista de usuarios desde la base de datos (excluyendo a los eliminados).
 *
 * @param mysqli $connection La conexión a la base de datos.
 * @return array Un array asociativo con los datos de los usuarios.
 */
function get_users_list($connection) {
    $result = mysqli_query($connection, "SELECT * FROM `usuario` WHERE `baja` = 0;") or die("Error al obtener la lista usuarios desde la base de datos.");
    $users = array();
    while ($row = mysqli_fetch_assoc($result))
        $users[] = $row;
    mysqli_free_result($result);
    return $users;
}


/**
 * Obtiene una lista de usuarios desde la base de datos (incluyendo a los eliminados).
 *
 * @param mysqli $connection La conexión a la base de datos.
 * @return array Un array asociativo con los datos de los usuarios.
 */
function get_users_list_all($connection) {
    $result = mysqli_query($connection, "SELECT * FROM `usuario`;") or die("Error al obtener la lista usuarios desde la base de datos.");
    $users = array();
    while ($row = mysqli_fetch_assoc($result))
        $users[] = $row;
    mysqli_free_result($result);
    return $users;
}


/**
 * Obtiene una lista de usuarios desde la base de datos filtrada por apellido (excluyendo a los eliminados).
 *
 * @param mysqli $connection La conexión a la base de datos.
 * @param string $surname El apellido a buscar.
 * @return array Un array asociativo con los datos de los usuarios que coinciden con el apellido buscado.
 */
function get_users_list_surname($connection, $surname) {
    $surname = mysqli_real_escape_string($connection, $surname);
    $query = "SELECT * FROM `usuario` WHERE `apellido` LIKE '%$surname%' AND `baja` = 0;";
    $result = mysqli_query($connection, $query) or die("Error al obtener la lista de usuarios con un apellido en especifico desde la base de datos.");
    $users = array();
    while ($row = mysqli_fetch_assoc($result))
        $users[] = $row;
    mysqli_free_result($result);
    return $users;
}


/**
 * Obtiene una lista de usuarios desde la base de datos filtrada por apellido (incluyendo a los eliminados).
 *
 * @param mysqli $connection La conexión a la base de datos.
 * @param string $surname El apellido a buscar.
 * @return array Un array asociativo con los datos de los usuarios que coinciden con el apellido buscado.
 */
function get_users_list_surname_all($connection, $surname) {
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
 * Obtiene el rol de un usuario específico desde la base de datos (excluyendo a los eliminados).
 *
 * @param mysqli $connection La conexión a la base de datos MySQL.
 * @param string $username El nombre de usuario del usuario del que se desea obtener el rol.
 * @return int|null El rol del usuario o null si no se encuentra.
 */
function get_user_role($connection, $username) {
    $escaped_username = mysqli_real_escape_string($connection, $username);
    $query = "SELECT `rol` FROM `usuario` WHERE `nombre_usuario` = '$escaped_username' AND `baja` = 0;";
    $result = mysqli_query($connection, $query) or die("Error al obtener el rol del usuario desde la base de datos.");
    $row = mysqli_fetch_assoc($result);
    $role = (int) $row["rol"];
    return $role;
}


/**
 * Obtiene los datos del usuario especificado.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $username El nombre de usuario del usuario.
 * @return array|null Los datos del usuario en forma de array asociativo o null si no se encontró ningún usuario.
 */
function get_user_info($connection, $username) {
    $query = "SELECT `nombre`, `apellido`, `dni`, `rol`, `id_usuario` FROM `usuario` WHERE `nombre_usuario` = '$username';";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $row;
}


/**
 * Obtiene todos los datos del usuario especificado.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $username El nombre de usuario del usuario.
 * @return array|null Los datos del usuario en forma de array asociativo o null si no se encontró ningún usuario.
 */
function get_user_info_all($connection, $username) {
    $query = "SELECT * FROM `usuario` WHERE `nombre_usuario` = '$username';";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $row;
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
    $query = "SELECT `contrasena` FROM `usuario` WHERE `nombre_usuario` = '$escaped_username' AND `baja` = 0;";
    $result = mysqli_query($connection, $query) or die("Error al validar las credenciales de usuario con la base de datos.");
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $hashed_password = $row['contrasena'];
        if (password_verify($password, $hashed_password)) {
            mysqli_free_result($result);
            return true;
        }
    }
    mysqli_free_result($result);
    return false;
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
    $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
    $query = "INSERT INTO `usuario` VALUES (NULL,'$escaped_name','$escaped_surname','$escaped_dni','$escaped_role','$escaped_username','$hashed_password',DEFAULT)";
    $result = mysqli_query($connection, $query) or die("Error al agregar usuario a la base de datos.");
    return $result;
}


/**
 * Modifica los datos del usuario especificado.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $name El nuevo nombre del usuario.
 * @param string $surname El nuevo apellido del usuario.
 * @param int $dni El nuevo DNI del usuario.
 * @param int $role El nuevo rol del usuario.
 * @param string $username El nuevo nombre de usuario del usuario.
 * @param string $password La nueva contraseña del usuario.
 * @param int $user_id El ID del usuario a modificar.
 * @return bool|mysqli_result El resultado de la operación de modificación o false en caso de error.
 */
function modify_user($connection, $name, $surname, $dni, $role, $username, $password, $user_id) {
    $escaped_name = mysqli_real_escape_string($connection, $name);
    $escaped_surname = mysqli_real_escape_string($connection, $surname);
    $escaped_dni = mysqli_real_escape_string($connection, $dni);
    $escaped_role = mysqli_real_escape_string($connection, $role);
    $escaped_username = mysqli_real_escape_string($connection, $username);
    $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
    $query = "UPDATE usuario SET nombre = '$escaped_name', apellido = '$escaped_surname', dni = '$escaped_dni', rol = '$escaped_role', nombre_usuario = '$escaped_username', contrasena = '$hashed_password' WHERE id_usuario = $user_id;";
    $result = mysqli_query($connection, $query) or die("Error al modificar usuario de la base de datos.");
    return $result;
}


/**
 * Elimina un usuario de la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $username El nombre de usuario del usuario a eliminar.
 * @return int|false El número de filas afectadas por la operación o false en caso de error.
 */
function delete_user($connection, $username) {
    mysqli_query($connection, "UPDATE `usuario` SET `baja` = 1 WHERE `nombre_usuario` = '$username';") or die("Remove user failed");
    return mysqli_affected_rows($connection);
}


/**
 * Restaura un usuario eliminado de la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $username El nombre de usuario del usuario a restaurar.
 * @return int|false El número de filas afectadas por la operación o false en caso de error.
 */
function restore_user($connection, $username) {
    mysqli_query($connection, "UPDATE `usuario` SET `baja` = 0 WHERE `nombre_usuario` = '$username';") or die("Restore user failed");
    return mysqli_affected_rows($connection);
}


/**
 * Obtiene la lista de usuarios y sus roles de la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @return array La lista de usuarios y sus roles.
 */
function get_user_list($connection) {
    $result = mysqli_query($connection, "SELECT nombre_usuario, rol FROM usuario WHERE usuario.baja = 0 ORDER BY rol ASC;") or die("dije basta de error catching");
    $user_list = array();
    while ($row = mysqli_fetch_assoc($result))
        array_push($user_list, $row["nombre_usuario"], $row["rol"]);
    mysqli_free_result($result);
    return $user_list;
}


/**
 * Obtiene la lista de productos con sus precios y tipos desde la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @return array La lista de productos con sus precios y tipos.
 */
function get_product_list($connection) {
    $result = mysqli_query($connection, "SELECT nombre_producto, precio, tipo FROM producto WHERE producto.baja = 0;") or die("Error al obtener la lista de productos desde la base de datos");
    $product_list = array();
    while ($row = mysqli_fetch_assoc($result))
        array_push($product_list, $row["nombre_producto"], $row["precio"], $row["tipo"]);
    mysqli_free_result($result);
    return $product_list;
}


/**
 * Obtiene la lista de ingredientes y sus unidades por producto desde la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @return array La lista de ingredientes y sus unidades por producto.
 */
function get_available_ingredients($connection) {
    $result = mysqli_query($connection, "SELECT p.id_producto FROM producto p WHERE p.baja = 0;") or die("Error al obtener los ingredientes por producto desde la base de datos");
    $product_id = array();
    while ($row = mysqli_fetch_assoc($result))
        array_push($product_id, $row["id_producto"]);
    $product_array = array();
    $ingredients = array();
    foreach ($product_id as $i) {
        $query = "SELECT i.nombre_ingrediente, i.unidad_medida, i.stock FROM ingrediente_x_producto ixp INNER JOIN ingrediente i ON i.id_ingrediente = ixp.id_ingrediente WHERE ixp.id_producto = $i AND i.baja = 0;";
        $result = mysqli_query($connection, $query) or die("Error get_available_ingredients");
        while ($row = mysqli_fetch_assoc($result))
            array_push($ingredients, $row["nombre_ingrediente"], $row["unidad_medida"], $row["stock"]);
        array_push($product_array, $ingredients);
    }
    mysqli_free_result($result);
    return $ingredients;
}


/**
 * Obtiene los ingredientes por producto desde la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @return array Los ingredientes por producto.
 */
function get_product_ingredients($connection) {
    $result = mysqli_query($connection, "SELECT p.id_producto FROM producto p WHERE p.baja = 0;") or die("Error al obtener los ingredientes por producto desde la base de datos");
    $product_id = array();
    while ($row = mysqli_fetch_assoc($result))
        array_push($product_id, $row["id_producto"]);
    $product_array = array();
    $ingredients = array();
    foreach ($product_id as $i) {
        $query = "SELECT i.nombre_ingrediente FROM ingrediente_x_producto ixp INNER JOIN ingrediente i ON i.id_ingrediente = ixp.id_ingrediente WHERE ixp.id_producto = $i AND i.baja = 0;";
        $result = mysqli_query($connection, $query) or die("Error get_product_ingredient");
        while ($row = mysqli_fetch_assoc($result))
            array_push($ingredients, $row["nombre_ingrediente"]);
        array_push($product_array, $ingredients);
        $ingredients = [];
    }
    mysqli_free_result($result);
    return $product_array;
}


/**
 * Obtiene las cantidades de ingredientes por producto desde la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @return array Las cantidades de ingredientes por producto.
 */
function get_product_ingredient_amounts($connection) {
    $result = mysqli_query($connection, "SELECT p.id_producto FROM producto p WHERE p.baja = 0;") or die("Error al obtener las cantidades de ingrediente por producto desde la base de datos");
    $product_id = array();
    while ($row = mysqli_fetch_assoc($result))
        array_push($product_id, $row["id_producto"]);
    $product_array = array();
    $amounts = array();
    foreach ($product_id as $i) {
        $query = "SELECT ixp.cantidad FROM ingrediente_x_producto ixp INNER JOIN producto p ON ixp.id_producto = p.id_producto WHERE p.id_producto = $i AND p.baja = 0;";
        $result = mysqli_query($connection, $query) or die("Error get_product_ingredient_amounts");
        while ($row = mysqli_fetch_assoc($result))
            array_push($amounts, $row["cantidad"]);
        array_push($product_array, $amounts);
        $amounts = [];
    }
    mysqli_free_result($result);
    return $product_array;
}


/**
 * Agrega un nuevo producto a la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $nombre El nombre del producto.
 * @param string $tipo El tipo del producto.
 * @param float $precio El precio del producto.
 * @return int El ID del producto agregado.
 */
function add_product($connection, $nombre, $tipo, $precio) {
    $query_add_product = "INSERT INTO producto(id_producto, nombre_producto, tipo, precio, stock, baja) VALUES (NULL,'$nombre','$tipo',$precio,NULL,0);";
    $result_add = mysqli_query($connection, $query_add_product);
    $query_get_product_id = "SELECT id_producto FROM producto WHERE nombre_producto = '$nombre';";
    $result_get_id = mysqli_query($connection, $query_get_product_id);
    $row = mysqli_fetch_assoc($result_get_id);
    return $row["id_producto"];
}


/**
 * Agrega ingredientes a un producto en la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $nombre El nombre del ingrediente.
 * @param float $cantidad La cantidad del ingrediente.
 * @param string $unidad La unidad de medida del ingrediente.
 * @param int $id_producto El ID del producto al que se agregarán los ingredientes.
 * @return int El número de filas afectadas por la operación.
 */
function add_product_ingredients($connection, $nombre, $cantidad, $unidad, $id_producto, $stock) {
    // CHEQUEA SI EXISTE
    $query_get_ingredient_id = "SELECT id_ingrediente FROM ingrediente WHERE nombre_ingrediente = '$nombre';";
    $result_get_id = mysqli_query($connection, $query_get_ingredient_id);
    if ($affected_row = mysqli_fetch_assoc($result_get_id)) {
        // SI EXISTE...
        $id_ingrediente = $affected_row["id_ingrediente"];
        // LO RELACIONA CON EL PRODUCTO
        $query_add_product_ingredient = "INSERT INTO ingrediente_x_producto(cantidad, id_ingrediente, id_producto) VALUES ($cantidad, $id_ingrediente, $id_producto);";
        $result_add_product_ingredient = mysqli_query($connection, $query_add_product_ingredient);
    } else {
        // SI NO EXISTE...
        // LO AGREGA
        $query_add_ingredient = "INSERT INTO ingrediente(id_ingrediente, nombre_ingrediente, stock, unidad_medida, baja) VALUES (NULL, '$nombre', $stock, '$unidad', 0);";
        $result_add = mysqli_query($connection, $query_add_ingredient);
        // OBTIENE SU ID
        $query_get_ingredient_id = "SELECT id_ingrediente FROM ingrediente WHERE nombre_ingrediente = '$nombre';";
        $result_get_id = mysqli_query($connection, $query_get_ingredient_id);
        $affected_row = mysqli_fetch_assoc($result_get_id);
        $id_ingrediente = $affected_row["id_ingrediente"];
        // LO RELACIONA CON EL PRODUCTO
        $query_add_product_ingredient = "INSERT INTO ingrediente_x_producto(cantidad, id_ingrediente, id_producto) VALUES ($cantidad, $id_ingrediente, $id_producto);";
        $result_add_product_ingredient = mysqli_query($connection, $query_add_product_ingredient);
    }
    return mysqli_affected_rows($connection);
}


/**
 * Modifica el stock de un ingrediente en la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $nombre_ingrediente El nombre del ingrediente a modificar.
 * @param int $stock La cantidad de stock a modificar. Puede ser positivo para aumentar el stock o negativo para disminuirlo.
 * @return int El número de filas afectadas por la consulta de actualización.
 */
function modify_ingredient_stock($connection, $nombre_ingrediente, $stock) {
    $query = "UPDATE ingrediente SET stock = stock + $stock WHERE nombre_ingrediente = '$nombre_ingrediente';";
    mysqli_query($connection, $query);
    return mysqli_affected_rows($connection);
}


/**
 * Disminuye el stock de los ingredientes de un producto en la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $nombre_producto El nombre del producto cuyos ingredientes se van a actualizar.
 * @param int $cantidad La cantidad de productos a disminuir. Esta cantidad se multiplicará por la cantidad de ingredientes utilizados en el producto.
 * @return int Devuelve 1 si la operación se realizó correctamente, o 0 si ocurrió algún error.
 */
function update_ingredient_stock_decrease($connection, $nombre_producto, $cantidad) {
    $query = "UPDATE ingrediente i JOIN ingrediente_x_producto ixp ON i.id_ingrediente = ixp.id_ingrediente JOIN producto p ON p.id_producto = ixp.id_producto SET i.stock = i.stock - (ixp.cantidad * $cantidad) WHERE p.nombre_producto = '$nombre_producto';";
    return (mysqli_query($connection, $query)) ? 1 : 0;
}


/**
 * Aumenta el stock de los ingredientes de un producto en la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $nombre_producto El nombre del producto cuyos ingredientes se van a actualizar.
 * @param int $cantidad La cantidad de productos a aumentar. Esta cantidad se multiplicará por la cantidad de ingredientes utilizados en el producto.
 * @return int Devuelve 1 si la operación se realizó correctamente, o 0 si ocurrió algún error.
 */
function update_ingredient_stock_increase($connection, $nombre_producto, $cantidad) {
    $query = "UPDATE ingrediente i JOIN ingrediente_x_producto ixp ON i.id_ingrediente = ixp.id_ingrediente JOIN producto p ON p.id_producto = ixp.id_producto SET i.stock = i.stock + (ixp.cantidad * $cantidad) WHERE p.nombre_producto = '$nombre_producto';";
    return (mysqli_query($connection, $query)) ? 1 : 0;
}


/**
 * Verifica si hay suficiente stock de ingredientes para un producto en la base de datos.
 * Si hay suficiente stock, disminuye el stock de los ingredientes y luego lo aumenta nuevamente.
 * Devuelve 1 si la verificación y las operaciones de modificación se realizan correctamente, o 0 si ocurre algún error.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $nombre_producto El nombre del producto cuyos ingredientes se verificarán y modificarán.
 * @param int $cantidad La cantidad de productos a verificar y modificar. Esta cantidad se utilizará para la disminución y el aumento del stock.
 * @return int Devuelve 1 si la verificación y las operaciones de modificación se realizan correctamente, o 0 si ocurre algún error.
 */
function check_ingredient_stock($connection, $nombre_producto, $cantidad) {
    if (update_ingredient_stock_decrease($connection, $nombre_producto, $cantidad) === 1) {
        // Si esto falla, quebramos.
        update_ingredient_stock_increase($connection, $nombre_producto, $cantidad);
        return 1;
    }
    return 0;
}


/**
 * Modifica el nombre, el precio o ambos datos de un producto en la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param float|null $nuevo_precio El nuevo precio del producto. Puede ser null si no se desea modificar.
 * @param string $nuevo_nombre_producto El nuevo nombre del producto. Puede ser una cadena vacía si no se desea modificar.
 * @param string $viejo_nombre_producto El nombre actual del producto que se desea modificar.
 * @return int El número de filas afectadas por la operación.
 */
function modify_product_data($connection, $nuevo_precio, $nuevo_nombre_producto, $viejo_nombre_producto) {
    if ($nuevo_precio) {
        $query = "UPDATE producto SET precio = $nuevo_precio WHERE nombre_producto = '$viejo_nombre_producto';";
        $result = mysqli_query($connection, $query);
    }
    if ($nuevo_nombre_producto !== '') {
        $query = "UPDATE producto SET nombre_producto = '$nuevo_nombre_producto' WHERE nombre_producto = '$viejo_nombre_producto';";
        $result = mysqli_query($connection, $query);
    }
    return mysqli_affected_rows($connection);
}


/**
 * Elimina un producto de la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $nombre_producto El nombre del producto que se desea eliminar.
 * @return int El número de filas afectadas por la operación.
 */
function delete_product($connection, $nombre_producto) {
    $query = "UPDATE producto SET baja = 1 WHERE nombre_producto = '$nombre_producto';";
    $result = mysqli_query($connection, $query);
    return mysqli_affected_rows($connection);
}


/**
 * Crea una nueva factura en la base de datos y devuelve su ID.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $mesa El número de mesa asociado a la factura.
 * @param string $nombre_usuario El nombre de usuario asociado a la factura.
 * @return int El ID de la factura recién creada.
 */
function generate_bill($connection, $mesa, $nombre_usuario, $importe) {   // Faltaria mandar la fecha (¿y hora?) del ticket
    $query_user_id = "SELECT id_usuario FROM usuario WHERE nombre_usuario = '$nombre_usuario';";
    $result = mysqli_query($connection, $query_user_id);
    $row = mysqli_fetch_assoc($result);
    $usuario_id = $row["id_usuario"];
    $query_new_bill = "INSERT INTO factura (id_factura, fecha_emision, importe, mesa, id_usuario) VALUES (NULL, sysdate(), $importe, '$mesa', $usuario_id);";
    $result = mysqli_query($connection, $query_new_bill);
    $query_bill_id = "SELECT MAX(id_factura) AS id_factura FROM factura;";
    $result = mysqli_query($connection, $query_bill_id);
    $row = mysqli_fetch_assoc($result);
    $factura_id = $row["id_factura"];
    return $factura_id;
}


/**
 * Relaciona un producto consumido por la mesa y lo agrega a la factura especificada.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $nombre_producto El nombre del producto consumido.
 * @param int $cantidad La cantidad del producto consumido.
 * @param int $factura_id El ID de la factura a la que se agrega el producto.
 * @return void
 */
function set_bill_item($connection, $nombre_producto, $cantidad, $factura_id) {
    $query_add_product = "INSERT INTO item_factura ( cantidad, precio, id_producto, id_factura)	VALUES ($cantidad, (SELECT precio * $cantidad FROM producto WHERE nombre_producto = '$nombre_producto'), (SELECT id_producto FROM producto WHERE nombre_producto = '$nombre_producto'), $factura_id);";
    $result = mysqli_query($connection, $query_add_product);
}


/**
 * Busca facturas emitidas dentro de un rango de fechas.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $desde La fecha de inicio del rango en formato 'YYYY-MM-DD'.
 * @param string $hasta La fecha de fin del rango en formato 'YYYY-MM-DD'.
 * @return array Un array con la información de las facturas encontradas. Cada factura está representada por un conjunto de valores [fecha_emision, mesa, importe, nombre_usuario].
 */
function billing_search($connection, $desde, $hasta) {
    $query_bill = "SELECT factura.id_factura, factura.fecha_emision, factura.mesa, factura.importe, usuario.nombre_usuario FROM factura JOIN usuario ON factura.id_usuario = usuario.id_usuario WHERE fecha_emision BETWEEN CAST('$desde' AS DATE) AND CAST('$hasta' AS DATE) ORDER BY factura.fecha_emision, factura.mesa, factura.importe;";
    $result_bill = mysqli_query($connection, $query_bill);
    $bill_array = array();
    while ($row = mysqli_fetch_assoc($result_bill)) {
        array_push($bill_array, $row["id_factura"], $row["fecha_emision"], $row["mesa"], $row["importe"], $row["nombre_usuario"]);
    }
    return $bill_array;
}


/**
 * Obtiene una lista de pedidos de proveedores desde la base de datos.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @return array La lista de pedidos de proveedores.
 */
function get_orders_list($connection) {
    $query = "SELECT pedido_proveedor.id_pedido, pedido_proveedor.fecha_pedido, usuario.nombre_usuario, proveedor.nombre, pedido_proveedor.baja FROM pedido_proveedor INNER JOIN usuario ON pedido_proveedor.id_usuario = usuario.id_usuario INNER JOIN proveedor ON pedido_proveedor.id_proveedor = proveedor.id_proveedor;";
    $result = mysqli_query($connection, $query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result))
        $records[] = $row;
    mysqli_free_result($result);
    return $records;
}


/**
 * Obtiene una lista de pedidos de proveedores desde la base de datos dentro de un rango de fechas.
 *
 * @param mysqli $connection La conexión activa a la base de datos.
 * @param string $startDate La fecha inicial del rango (en formato "YYYY-MM-DD").
 * @param string $endDate La fecha final del rango (en formato "YYYY-MM-DD").
 * @return array La lista de pedidos de proveedores dentro del rango de fechas.
 */
function get_orders_list_by_date_range($connection, $startDate, $endDate) {
    $startDate = mysqli_real_escape_string($connection, $startDate);
    $endDate = mysqli_real_escape_string($connection, $endDate);
    $query = "SELECT pedido_proveedor.id_pedido, pedido_proveedor.fecha_pedido, usuario.nombre_usuario, proveedor.nombre, pedido_proveedor.baja FROM pedido_proveedor INNER JOIN usuario ON pedido_proveedor.id_usuario = usuario.id_usuario INNER JOIN proveedor ON pedido_proveedor.id_proveedor = proveedor.id_proveedor WHERE pedido_proveedor.fecha_pedido BETWEEN '$startDate' AND '$endDate';";
    $result = mysqli_query($connection, $query);
    $records = array();
    while ($row = mysqli_fetch_assoc($result))
        $records[] = $row;
    mysqli_free_result($result);
    return $records;
}
?>