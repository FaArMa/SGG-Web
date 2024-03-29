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


/*
 * Verifica si la acción es "get_user_info" y devuelve los datos del usuario.
 * Imprime los datos obtenidos en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "get_user_info") {
    $query_result = get_user_info($connection, $_POST["username"]);
    echo implode(',', $query_result);
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


/*
 * Verifica si la acción es "modify_user" y modifica los datos del usuario.
 * Imprime el resultado de la modificación en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "modify_user") {
    $_POST["name"] = sanitize_input($_POST["name"]);
    $_POST["surname"] = sanitize_input($_POST["surname"]);
    $_POST["dni"] = sanitize_input($_POST["dni"]);
    $_POST["role"] = sanitize_input($_POST["role"]);
    $_POST["username"] = sanitize_input($_POST["username"]);
    echo modify_user($connection, $_POST["name"], $_POST["surname"], (int) $_POST["dni"], (int) $_POST["role"], $_POST["username"], $_POST["password"], $_POST["user_id"]);
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "delete_user" y elimina el usuario.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "delete_user") {
    $query_result = delete_user($connection, $_POST["username"]);
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "get_product_list" y devuelve la lista de productos con sus precios y tipos.
 * Imprime la lista obtenida en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "get_product_list") {
    $query_result = get_product_list($connection);
    echo implode(',', $query_result);
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "get_available_ingredients" y devuelve la lista de todos los ingredientes disponibles.
 * Imprime la lista obtenida en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "get_available_ingredients") {
    $query_result = get_available_ingredients($connection);
    echo implode(',', $query_result);
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "get_product_ingredients" y devuelve los ingredientes de todos los productos.
 * Imprime los ingredientes obtenidos en el cuerpo de la respuesta en formato JSON.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "get_product_ingredients") {
    $query_result = get_product_ingredients($connection);
    header('Content-Type: application/json');
    echo json_encode($query_result);
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "get_product_ingredient_amounts" y devuelve las cantidades de cada ingrediente de todos los productos.
 * Imprime las cantidades obtenidas en el cuerpo de la respuesta en formato JSON.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "get_product_ingredient_amounts") {
    $query_result = get_product_ingredient_amounts($connection);
    header('Content-Type: application/json');
    echo json_encode($query_result);
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "get_user_list" y devuelve la lista de usuarios con sus roles.
 * Imprime la lista obtenida en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "get_user_list") {
    $query_result = get_user_list($connection);
    echo implode(',', $query_result);
    mysqli_close($connection);
    die;
}


/*
* Modificar stock de ingrediente
*/
if ($_POST["action"] === "modify_ingredient_stock") {
    $query_result = modify_ingredient_stock($connection, $_POST["nombre_ingrediente"], $_POST["stock"]);
    echo $query_result;
    mysqli_close($connection);
    die;
}


/**
 * Verifica si la acción es "update_ingredient_stock_decrease" y disminuye el stock de los ingredientes de un producto.
 * Imprime el resultado de la consulta en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "update_ingredient_stock_decrease") {
    $query_result = update_ingredient_stock_decrease($connection, $_POST["nombre_producto"], $_POST["cantidad"]);
    echo $query_result;
    mysqli_close($connection);
    die;
}


/**
 * Verifica si la acción es "update_ingredient_stock_increase" y aumenta el stock de los ingredientes de un producto.
 * Imprime el resultado de la consulta en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "update_ingredient_stock_increase") {
    $query_result = update_ingredient_stock_increase($connection, $_POST["nombre_producto"], $_POST["cantidad"]);
    echo $query_result;
    mysqli_close($connection);
    die;
}


/**
 * Verifica si la acción es "check_ingredient_stock" y comprueba si hay suficiente stock de ingredientes para un producto.
 * Imprime el resultado de la consulta en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "check_ingredient_stock") {
    $query_result = check_ingredient_stock($connection, $_POST["nombre_producto"], $_POST["cantidad"]);
    echo $query_result;
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "modify_product_data" y modifica el nombre, precio o ambos datos de un producto.
 * Imprime el resultado de la modificación en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "modify_product_data") {
    $query_result = modify_product_data($connection, (float) $_POST["nuevo_precio"], $_POST["nuevo_nombre_producto"], $_POST["viejo_nombre_producto"]);
    echo $query_result;
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "add_product" y agrega un producto junto con sus ingredientes.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "add_product") {
    $query_add_product = add_product($connection, $_POST["nombre"], $_POST["tipo"], $_POST["precio"]);
    foreach (json_decode($_POST["ingredientes"], true) as $nombre_ingrediente => $cantidad_unidad_stock)
        $query_add_ingredients = add_product_ingredients($connection, $nombre_ingrediente, $cantidad_unidad_stock[0], $cantidad_unidad_stock[1], $query_add_product, $cantidad_unidad_stock[2]);
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "delete_product" y elimina un producto.
 * Imprime el resultado de la eliminación en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "delete_product") {
    $query_result = delete_product($connection, $_POST["nombre_producto"]);
    echo $query_result;
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "generate_bill" y crea una factura, asigna productos y calcula el importe total.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "generate_bill") {
    $query_result_bill_id = generate_bill($connection, $_POST["mesa"], $_POST["nombre_usuario"], $_POST["importe"]);
    echo $query_result_bill_id;
    foreach (json_decode($_POST["productos"], true) as $nombre_producto => $cantidad)
        $query_add_bill_item = set_bill_item($connection, $nombre_producto, $cantidad, $query_result_bill_id);
    mysqli_close($connection);
    die;
}


/*
 * Verifica si la acción es "billing_search" y busca facturas emitidas entre ciertas fechas.
 * Imprime el resultado de la búsqueda en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "billing_search") {
    $query_result = billing_search($connection, $_POST["desde"], $_POST["hasta"]);
    echo implode(',', $query_result);
    mysqli_close($connection);
    die;
}
?>