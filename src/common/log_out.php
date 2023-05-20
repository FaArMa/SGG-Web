<?php
// Iniciar o re-usar sesión
session_start();
// Eliminar todas las variables de sesión
session_unset();
// Eliminar la sesión
session_destroy();
// Redireccionar a la página de inicio
header('Location: /SGG-Web/');
?>