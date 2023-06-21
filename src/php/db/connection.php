<?php
/**
 * Ruta relativa al archivo .env en relación con el archivo actual.
 *
 * @var string $env_file - Ruta al archivo .env.
 */
$env_file = __DIR__ . "/../../../.env";


/**
 * Mensaje de error si el archivo .env no existe.
 */
if (!file_exists($env_file)) {
    echo "El archivo .env no existe";
    die;
}


/**
 * Datos del archivo .env analizados como un archivo INI.
 *
 * @var array|false $env_data - Datos del archivo .env como array asociativo.
 */
$env_data = parse_ini_file($env_file);


/**
 * Mensaje de error si no se pudo leer el archivo .env.
 */
if (!$env_data) {
    echo "No se ha podido leer el archivo .env";
    die;
}


/**
 * Este código desactiva los informes de errores de mysqli para evitar que se muestren en pantalla.
 */
mysqli_report(MYSQLI_REPORT_OFF);


/**
 * Establece la conexión con la base de datos.
 *
 * @var mysqli $connection - La conexión establecida con la base de datos.
 */
$connection = @mysqli_connect(
    $env_data["DB_HOST"],
    $env_data["DB_USERNAME"],
    $env_data["DB_PASSWORD"],
    $env_data["DB_DATABASE"],
    $env_data["DB_PORT"]
);


/**
 * Si se produce un error al conectar, se establece el código de respuesta HTTP en 502 (Bad Gateway),
 * se imprime un mensaje de error en el cuerpo de la respuesta y se termina la ejecución del script.
 * En caso de que la conexión sea exitosa, se puede proceder a ejecutar consultas o realizar otras operaciones en la base de datos.
 */
if (mysqli_connect_error()) {
    http_response_code(502);
    echo "No se pudo conectar con la base de datos";
    die;
}
?>