<header>
    <nav id="navbar">
        <a href="#" class="nav-icon" title="Barra de navegación"><i class="fa-solid fa-bars"></i></a>
        <ul>
            <li><a href="/SGG-Web/">Inicio</a></li>
            <?php
            // Visible solamente al tener una sesión iniciada
            if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true)
                echo "<li><a href=\"/SGG-Web/src/common/control_panel.php\">Panel de control</a></li>";
            ?>
            <li><a href="/SGG-Web/src/common/contact.php">Contacto</a></li>
            <?php
            // Visible a menos que hayas iniciado sesión
            if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] === false) {
                echo "<li><a href=\"/SGG-Web/src/common/log_in.php\">Iniciar sesión</a></li>";
                // Si no existe users_count debo obtenerlo
                if (!isset($_SESSION["users_count"])) {
                    require_once("src/php/db/connection.php");
                    require_once("src/php/db/functions.php");
                    $_SESSION["users_count"] = get_users_count($connection);
                    mysqli_close($connection);
                }
                // Si existe users_count y vale 0 entonces muestro Registrarse (caso contrario lo oculto)
                if ($_SESSION["users_count"] === 0)
                    echo "<li><a href=\"/SGG-Web/src/common/sign_in.php\">Registrarse</a></li>";
            } else
                // Visible solamente al tener una sesión iniciada
                echo "<li><a href=\"/SGG-Web/src/common/log_out.php\">Cerrar sesión</a></li>";
            ?>
        </ul>
    </nav>
</header>