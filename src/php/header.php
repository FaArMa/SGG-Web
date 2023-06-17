<?php
/*
 * Huevos de Pascua
 * Misma probabilidad de aparición que un Item Especial Raro con StatTrak en CS: GO (bueno, sin contar otros detalles)
 */
if ((rand() / getrandmax()) <= 0.02558) {
    switch (rand(0, 2)) {
        case 0:
            echo "<img src=\"/SGG-Web/src/img/eg/fbi_seized.jpg\">";
            die;
        case 1:
            echo "<img src=\"/SGG-Web/src/img/eg/elephpant-running.gif\" width=\"117\" height=\"72\">";
            die("<br>ElePHPant E GOOOOOOOOOD, ElePHPant E GOOOOOOOOOD, NAAAAAAAAAAASHE, GOOOOOOOOOD GOOOOOOOOOD<br>Perdón, Metodología de Sistemas nos hizo mucho daño.");
        case 2:
            echo "<iframe width=\"640\" height=\"360\" src=\"https://www.youtube-nocookie.com/embed/khYALqZ3FhA?start=41&autoplay=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>";
            die;
        default:
            break;
    }
}
?>
<header>
    <nav id="navbar">
        <ul id="menu-items">
            <li><a href="/SGG-Web/" class="menu-item">Inicio</a></li>
            <?php
            // Visible solamente al tener una sesión iniciada
            if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true)
                echo "<li><a href=\"/SGG-Web/src/common/control_panel.php#control-content\" class=\"menu-item\">Panel de control</a></li>";
            ?>
            <li><a href="/SGG-Web/src/common/contact.php#contact" class="menu-item">Contacto</a></li>
            <?php
            // Visible a menos que hayas iniciado sesión
            if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] === false) {
                echo "<li><a href=\"/SGG-Web/src/common/log_in.php#log-in\" class=\"menu-item\">Iniciar sesión</a></li>";
                // Si no existe users_count debo obtenerlo
                if (!isset($_SESSION["users_count"])) {
                    require_once("src/php/db/connection.php");
                    require_once("src/php/db/functions.php");
                    $_SESSION["users_count"] = get_users_count($connection);
                    mysqli_close($connection);
                }
                // Si existe users_count y vale 0 entonces muestro Registrarse (caso contrario lo oculto)
                if ($_SESSION["users_count"] === 0)
                    echo "<li><a href=\"/SGG-Web/src/common/sign_in.php#add-user\" class=\"menu-item\">Registrarse</a></li>";
            } else
                // Visible solamente al tener una sesión iniciada
                echo "<li><a href=\"/SGG-Web/src/common/log_out.php\" class=\"menu-item\">Cerrar sesión</a></li>";
            ?>
        </ul>
        <div id="menu-background-pattern"></div>
        <div id="menu-background-image"></div>
    </nav>
</header>