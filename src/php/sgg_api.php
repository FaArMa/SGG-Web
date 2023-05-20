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
 * Verifica si la acción es "validate_user_credentials" y valida las credenciales del usuario.
 * Imprime el resultado de la validación en el cuerpo de la respuesta.
 * Cierra la conexión a la base de datos y finaliza la ejecución del script.
 */
if ($_POST["action"] === "validate_user_credentials") {
    echo validate_user_credentials($connection, $_POST["username"], $_POST["password"]);
    mysqli_close($connection);
    die;
}
?>