<?php
/**
 * Establece la conexión con la base de datos.
 *
 * ADVERTENCIA: Exponer las credenciales de conexión a la base de datos de esta manera es un riesgo de seguridad.
 * Pero reafirmo mi autoridad como estudiante universitario arriesgándome de todos modos. (?
 *
 * @var mysqli $connection - La conexión establecida con la base de datos.
 */
$connection = mysqli_connect("localhost", "root", "", "sgg_web") or die("No se pudo conectar con la base de datos.");
?>