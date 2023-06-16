<header>
    <nav id="navbar">
        <!--<a href="#" class="nav-icon" title="Barra de navegación"><i class="fa-solid fa-bars"></i></a>-->
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