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
    $result = mysqli_query($connection, "SELECT COUNT(*) FROM `usuario` WHERE usuario.baja = 0;") or die("Error al obtener la cantidad de usuarios desde la base de datos.");
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
    $result = mysqli_query($connection, "SELECT * FROM `usuario` WHERE usuario.baja = 0;") or die("Error al obtener la lista usuarios desde la base de datos.");
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
    $query = "SELECT * FROM `usuario` WHERE `apellido` LIKE '%$surname%' AND usuario.baja = 0;";
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
    $query = "SELECT `rol` FROM `usuario` WHERE `nombre_usuario` = '$escaped_username' AND usuario.baja = 0;";
    $result = mysqli_query($connection, $query) or die("Error al obtener el rol del usuario desde la base de datos.");
    $row = mysqli_fetch_assoc($result);
    $role = (int)$row["rol"];
    return $role;
}

/* DATOS DEL USUARIO */
function get_user_info($connection, $username){
    $query = "SELECT nombre, apellido, dni, rol, id_usuario FROM usuario WHERE nombre_usuario = '$username';";
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
    $hashed_password = md5($password);
    $query = "SELECT * FROM `usuario` WHERE `nombre_usuario` = '$escaped_username' AND `contrasena` = '$hashed_password' AND usuario.baja = 0;";
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
    $query = "INSERT INTO `usuario` VALUES (NULL,'$escaped_name','$escaped_surname','$escaped_dni','$escaped_role','$escaped_username','$hashed_password', 0);";
    $result = mysqli_query($connection, $query) or die("Error al agregar usuario a la base de datos.");
    return $result;
}

/* MODIFICA DATOS DEL USUARIO */
function modify_user($connection, $name, $surname, $dni, $role, $username, $user_id, $password) {
    $escaped_name = mysqli_real_escape_string($connection, $name);
    $escaped_surname = mysqli_real_escape_string($connection, $surname);
    $escaped_dni = mysqli_real_escape_string($connection, $dni);
    $escaped_role = mysqli_real_escape_string($connection, $role);
    $escaped_username = mysqli_real_escape_string($connection, $username);
    $hashed_password = md5($password);
    $query = "UPDATE usuario SET nombre = '$escaped_name', apellido = '$escaped_surname', dni = '$escaped_dni', rol = '$escaped_role', nombre_usuario = '$escaped_username', contrasena = '$hashed_password' WHERE id_usuario = $user_id;";

    $result = mysqli_query($connection, $query) or die("Error al modificar usuario de la base de datos.");
    return $result;
}

function delete_user($connection, $username){
    $result = mysqli_query($connection, "UPDATE usuario SET baja = 1 WHERE nombre_usuario = '$username';") or die("remove user failed");
    return mysqli_affected_rows($connection);
}

function get_user_list($connection) {
    $result = mysqli_query($connection, "SELECT nombre_usuario, rol FROM usuario WHERE usuario.baja = 0 ORDER BY rol ASC;") or die("dije basta de error catching");
    $user_list = array();

    while ($row = mysqli_fetch_assoc($result))
        array_push($user_list, $row["nombre_usuario"], $row["rol"]);
    mysqli_free_result($result);
    return $user_list;
}

function get_product_list($connection) {
    $result = mysqli_query($connection, "SELECT nombre_producto, precio, tipo FROM producto WHERE producto.baja = 0;") or die("Error al obtener la lista de productos desde la base de datos");
    $product_list = array();

    while ($row = mysqli_fetch_assoc($result))
        array_push($product_list, $row["nombre_producto"], $row["precio"], $row["tipo"]);
    mysqli_free_result($result);
    return $product_list;
}

/* INGREDIENTES Y SUS UNIDADES, POR PRODUCTO */
function get_available_ingredients($connection){
    $result = mysqli_query($connection, "SELECT p.id_producto FROM producto p WHERE p.baja = 0;") or die("Error al obtener los ingredientes por producto desde la base de datos");

    $product_id = array();

    while ($row = mysqli_fetch_assoc($result))
        array_push($product_id, $row["id_producto"]);
    
    $product_array = array();
    $ingredients = array();

    foreach($product_id as $i){
        $query = "SELECT i.nombre_ingrediente, i.unidad_medida FROM ingrediente_x_producto ixp INNER JOIN ingrediente i ON i.id_ingrediente = ixp.id_ingrediente WHERE ixp.id_producto = $i AND i.baja = 0;";

        $result = mysqli_query($connection, $query) or die("Error get_available_ingredients");

        while ($row = mysqli_fetch_assoc($result))
            array_push($ingredients, $row["nombre_ingrediente"], $row["unidad_medida"]);
        array_push($product_array, $ingredients);

    }
    mysqli_free_result($result);
    return $ingredients;
}
    
/* INGREDIENTES, POR PRODUCTO */
function get_product_ingredients($connection) {
    $result = mysqli_query($connection, "SELECT p.id_producto FROM producto p WHERE p.baja = 0;") or die("Error al obtener los ingredientes por producto desde la base de datos");
 
    $product_id = array();

    while ($row = mysqli_fetch_assoc($result))
        array_push($product_id, $row["id_producto"]);

    $product_array = array();
    $ingredients = array();

    foreach($product_id as $i) {
        $query = "SELECT i.nombre_ingrediente FROM ingrediente_x_producto ixp INNER JOIN ingrediente i ON i.id_ingrediente = ixp.id_ingrediente WHERE ixp.id_producto = $i AND i.baja = 0;";

        $result = mysqli_query($connection, $query) or die ("Error get_product_ingredient");

        while ($row = mysqli_fetch_assoc($result))
            array_push($ingredients, $row["nombre_ingrediente"]);
        array_push($product_array, $ingredients);
        $ingredients = [];
    }
    mysqli_free_result($result);
    return $product_array;
}

/* CANTIDAD DE INGREDIENTES, POR PRODUCTO */
function get_product_ingredient_amounts($connection) {
    $result = mysqli_query($connection, "SELECT p.id_producto FROM producto p WHERE p.baja = 0;") or die("Error al obtener las cantidades de ingrediente por producto desde la base de datos");
    
    $product_id = array();

    while ($row = mysqli_fetch_assoc($result))
        array_push($product_id, $row["id_producto"]);

    $product_array = array();
    $amounts = array();

    foreach($product_id as $i) {
        $query = "SELECT ixp.cantidad FROM ingrediente_x_producto ixp INNER JOIN producto p ON ixp.id_producto = p.id_producto WHERE p.id_producto = $i AND p.baja = 0;";

        $result = mysqli_query($connection, $query) or die ("Error get_product_ingredient_amounts");

        while ($row = mysqli_fetch_assoc($result))
            array_push($amounts, $row["cantidad"]);

        array_push($product_array, $amounts);
        $amounts = [];
    }
    mysqli_free_result($result);
    return $product_array;
}

/* AGREGAR PRODUCTO */
function add_product($connection, $nombre, $tipo, $precio){
    $query_add_product = "INSERT INTO producto(id_producto, nombre_producto, tipo, precio, stock, baja) VALUES (NULL,'$nombre','$tipo',$precio,NULL,0);";
    $result_add = mysqli_query($connection, $query_add_product);
    
    $query_get_product_id = "SELECT id_producto FROM producto WHERE nombre_producto = '$nombre';";
    $result_get_id = mysqli_query($connection, $query_get_product_id);

    $row = mysqli_fetch_assoc($result_get_id);

    return $row["id_producto"];
}

/* AGREGAR INGREDIENTES A PRODUCTO */
function add_product_ingredients($connection, $nombre, $cantidad, $unidad, $id_producto){
    // CHEQUEA SI EXISTE
    $query_get_ingredient_id = "SELECT id_ingrediente FROM ingrediente WHERE nombre_ingrediente = '$nombre';";
    $result_get_id = mysqli_query($connection, $query_get_ingredient_id);
    
    if ($affected_row = mysqli_fetch_assoc($result_get_id)){
        // SI EXISTE...
        $id_ingrediente = $affected_row["id_ingrediente"];

        // LO RELACIONA CON EL PRODUCTO
        $query_add_product_ingredient = "INSERT INTO ingrediente_x_producto(cantidad, id_ingrediente, id_producto) VALUES ($cantidad, $id_ingrediente, $id_producto);";
        $result_add_product_ingredient = mysqli_query($connection, $query_add_product_ingredient);
    } else {
        // SI NO EXISTE...
        // LO AGREGA
        $query_add_ingredient = "INSERT INTO ingrediente(id_ingrediente, nombre_ingrediente, stock, unidad_medida, baja) VALUES (NULL, '$nombre', 200, '$unidad', 0);";
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

/* MODIFICAR NOMBRE, PRECIO, O AMBOS DATOS DEL PRODUCTO */
function modify_product_data($connection, $nuevo_precio, $nuevo_nombre_producto, $viejo_nombre_producto){
    if ($nuevo_precio){
        $query = "UPDATE producto SET precio = $nuevo_precio WHERE nombre_producto = '$viejo_nombre_producto';";
        $result = mysqli_query($connection, $query);
    }
    if ($nuevo_nombre_producto !== ''){
        $query = "UPDATE producto SET nombre_producto = '$nuevo_nombre_producto' WHERE nombre_producto = '$viejo_nombre_producto';";
        $result = mysqli_query($connection, $query);
    }
    return mysqli_affected_rows($connection);
}

/* ELIMINAR PRODUCTO */
function delete_product($connection, $nombre_producto){
    $query = "UPDATE producto SET baja = 1 WHERE nombre_producto = '$nombre_producto';";
    $result = mysqli_query($connection, $query);
    return mysqli_affected_rows($connection);
}

/* CREA FACTURA */
function generate_bill($connection, $mesa, $nombre_usuario){
    $query_user_id = "SELECT id_usuario FROM usuario WHERE nombre_usuario = '$nombre_usuario';";
    $result = mysqli_query($connection, $query_user_id);

    $row = mysqli_fetch_assoc($result);
    $usuario_id = $row["id_usuario"];

    $query_new_bill = "INSERT INTO factura (id_factura, fecha_emision, importe, mesa, id_usuario) VALUES (NULL, sysdate(), 0, '$mesa', $usuario_id);";
    $result = mysqli_query($connection, $query_new_bill);

    $query_bill_id = "SELECT MAX(id_factura) AS id_factura FROM factura;";
    $result = mysqli_query($connection, $query_bill_id);

    $row = mysqli_fetch_assoc($result);
    $factura_id = $row["id_factura"];

    return $factura_id;
}

/* RELACIONA PRODUCTO CONSUMIDO POR LA MESA Y LO AGREGA A LA FACTURA */
function set_bill_item($connection, $nombre_producto, $cantidad, $factura_id){
    $query_add_product = "INSERT INTO item_factura ( cantidad, precio, id_producto, id_factura)	VALUES ($cantidad, (SELECT precio * $cantidad FROM producto WHERE nombre_producto = '$nombre_producto'), (SELECT id_producto FROM producto WHERE nombre_producto = '$nombre_producto'), $factura_id);";
    $result = mysqli_query($connection, $query_add_product);
}

/******      EN ALGUNA DE ESTAS FUNCIONES SE DEBE LLAMAR A OTRA PARA DESCONTAR STOCK?        ******/

/* ASIGNA A LA FACTURA EL VALOR TOTAL DE LOS PRODUCTOS CONSUMIDOS */
function set_bill_total_amount($connection, $factura_id){
    $query_sum_total = "UPDATE factura f JOIN item_factura it ON it.id_factura = $factura_id SET f.importe = (SELECT SUM(it.precio) FROM item_factura it JOIN factura f ON f.id_factura = it.id_factura WHERE f.id_factura = $factura_id) WHERE f.id_factura = $factura_id;";
    $result = mysqli_query($connection, $query_sum_total);
}

/* BUSCA FACTURAS EMITIDAS */
function billing_search($connection, $desde, $hasta){
    $query_bill_id = "SELECT id_factura FROM factura WHERE fecha_emision BETWEEN CAST('$desde' AS DATE) AND CAST('$hasta' AS DATE);";
    
    $result_bill_id = mysqli_query($connection, $query_bill_id);

    $bill_id_array = array();

    while ($row = mysqli_fetch_assoc($result_bill_id)){
        array_push($bill_id_array, $row["id_factura"]);
    }

    $bill_info_array = array();

    foreach($bill_id_array as $i){
        $query_bill_info = "SELECT fecha_emision, mesa, importe, id_usuario FROM factura WHERE id_factura = $i";
        $result_bill_info = mysqli_query($connection, $query_bill_info);

        $row_bill = mysqli_fetch_assoc($result_bill_info);

        $id_usuario = $row_bill["id_usuario"];
        $query_username = "SELECT nombre_usuario FROM usuario WHERE id_usuario = $id_usuario;";
        $result_user_id = mysqli_query($connection, $query_username);

        $row_username = mysqli_fetch_assoc($result_user_id);

        $nombre_usuario = $row_username["nombre_usuario"];

        array_push($bill_info_array, $row_bill["fecha_emision"], $row_bill["mesa"], $row_bill["importe"], $nombre_usuario);
    }

    return $bill_info_array;
}
?>