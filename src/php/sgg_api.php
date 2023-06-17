<?php
/*
 * Verifica si el método de solicitud es diferente a POST.
 * Si no es POST, establece el código de respuesta HTTP en 405 (Método no permitido)
 * y termina la ejecución del script.
 */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die;
}


/*
 * Verifica si la variable POST "action" no está definida o está vacía.
 * Si no está definida o está vacía, establece el código de respuesta HTTP en 400 (Solicitud incorrecta),
 * imprime un mensaje de error en el cuerpo de la respuesta y termina la ejecución del script.
 */
if (!isset($_POST["action"]) || empty($_POST["action"])) {
    http_response_code(400);
    echo "Action: No está definido o está vacío.";
    die;
}


// Se requiere una conexión a la base de datos y las funciones que interactúan con la misma
require_once("db/connection.php");
require_once("db/functions.php");


/*
 * Verifica si la acción es "get_users_count" y devuelve la cantidad de usuarios registrados.
 * Imprime el resultado de la cantidad en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "get_users_count") {
    echo get_users_count($connection);
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "get_user_role" y devuelve el rol del usuario proporcionado.
 * Imprime el rol obtenido en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "get_user_role") {
    $_POST["username"] = sanitize_input($_POST["username"]);
    echo get_user_role($connection, $_POST["username"]);
    mysqli_close($connection);
    die;
}

/* Devuelve datos del usuario */
if ($_POST["action"] === "get_user_info"){
    $query_result = get_user_info($connection, $_POST["username"]);
    echo implode(',',$query_result);
    mysqli_close($connection);
    die;
}

/*
 * Verifica si la acción es "validate_user_credentials" y valida las credenciales del usuario.
 * Imprime el resultado de la validación en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "validate_user_credentials") {
    $_POST["username"] = sanitize_input($_POST["username"]);
    echo validate_user_credentials($connection, $_POST["username"], $_POST["password"]);
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "add_user" y registra/agrega los datos proporcionados.
 * Imprime el resultado de la operación en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "add_user") {
    $_POST["name"] = sanitize_input($_POST["name"]);
    $_POST["surname"] = sanitize_input($_POST["surname"]);
    $_POST["dni"] = sanitize_input($_POST["dni"]);
    $_POST["role"] = sanitize_input($_POST["role"]);
    $_POST["username"] = sanitize_input($_POST["username"]);
    echo add_user($connection, $_POST["name"], $_POST["surname"], (int) $_POST["dni"], (int) $_POST["role"], $_POST["username"], $_POST["password"]);
    mysqli_close($connection);
    die;
}

/* Modifica datos del usuario */
if ($_POST["action"] === "modify_user") {
    $_POST["name"] = sanitize_input($_POST["name"]);
    $_POST["surname"] = sanitize_input($_POST["surname"]);
    $_POST["dni"] = sanitize_input($_POST["dni"]);
    $_POST["role"] = sanitize_input($_POST["role"]);
    $_POST["username"] = sanitize_input($_POST["username"]);
    echo modify_user($connection, $_POST["name"], $_POST["surname"], (int) $_POST["dni"], (int) $_POST["role"], $_POST["username"], $_POST["user_id"], $_POST["password"]);
    mysqli_close($connection);
    die;
}

/* Elimina usuario */
if ($_POST["action"] === "delete_user"){
    $query_result = delete_user($connection, $_POST["username"]);
    mysqli_close($connection);
    die;
}

/* Devuelve los productos con sus precios y tipos */
if ($_POST["action"] === "get_product_list") {
    $query_result = get_product_list($connection);
    echo implode(',',$query_result);
    mysqli_close($connection);
    die;
}

/* Devuelve todos los ingredientes */
if ($_POST["action"] === "get_available_ingredients") {
    $query_result = get_available_ingredients($connection);
    echo implode(',',$query_result);
    mysqli_close($connection);
    die;
}

/* Devuelve los ingredientes de todos los productos */
if ($_POST["action"] === "get_product_ingredients") {
    $query_result = get_product_ingredients($connection);
    header('Content-Type: application/json');
    echo json_encode($query_result);
    mysqli_close($connection);
    die;
}

/* Devuelve las cantidades de cada ingrediente de todos los productos */
if ($_POST["action"] === "get_product_ingredient_amounts") {
    $query_result = get_product_ingredient_amounts($connection);
    header('Content-Type: application/json');
    echo json_encode($query_result);
    mysqli_close($connection);
    die;
}

/* Devuelve los usuarios y sus roles */
if ($_POST["action"] === "get_user_list") {
    $query_result = get_user_list($connection);
    echo implode(',',$query_result);
    mysqli_close($connection);
    die;
}

/* Modifica nombre, precio, o ambos datos de producto */
if($_POST["action"] === "modify_product_data"){
    $query_result = modify_product_data($connection, (float) $_POST["nuevo_precio"], $_POST["nuevo_nombre_producto"], $_POST["viejo_nombre_producto"]);
    echo $query_result;
    mysqli_close($connection);
    die;
}

/* Agrega producto y sus ingredientes*/
if($_POST["action"] === "add_product"){
    $query_add_product = add_product($connection, $_POST["nombre"], $_POST["tipo"], $_POST["precio"]);

    foreach(json_decode($_POST["ingredientes"],true) as $nombre_ingrediente => $cantidad_unidad) {
        $query_add_ingredients = add_product_ingredients($connection, $nombre_ingrediente, $cantidad_unidad[0], $cantidad_unidad[1], $query_add_product);
    }
    
    mysqli_close($connection);
    die;
}

/* Elimina producto */
if ($_POST["action"] === "delete_product") {
    $query_result = delete_product($connection,$_POST["nombre_producto"]);
    echo $query_result;
    mysqli_close($connection);
    die;
}

/* Crea factura, le asigna productos y el importe total */
if ($_POST["action"] === "generate_bill") {
    $query_result_bill_id = generate_bill($connection, $_POST["mesa"], $_POST["nombre_usuario"]);

    foreach(json_decode($_POST["productos"],true) as $nombre_producto => $cantidad) {
        $query_add_bill_item = set_bill_item($connection, $nombre_producto, $cantidad, $query_result_bill_id);
    }

    $query_bill_total_sum = set_bill_total_amount($connection, $query_result_bill_id);

    mysqli_close($connection);
    die;
}

/* Busca facturas emitidas entre cierta fecha */
if ($_POST["action"] === "billing_search"){
    $query_result = billing_search($connection, $_POST["desde"], $_POST["hasta"]);

    echo implode(',',$query_result);

    mysqli_close($connection);
    die;
}
?>