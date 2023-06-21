/**
 * Se ejecuta cuando la ventana se ha cargado por completo.
 */
window.onload = function () {
    // Para el nav de todas las páginas
    navMenu();
    // Para el footer de todas las páginas
    footerImg();
    // Solo para la página de Registrarse / Agregar / Editar Usuario
    if (window.location.pathname.match(/\/common\/sign_in\.php/))
        signInHandler();
    // Solo para la página de Lista de pedidos
    if (window.location.pathname.match(/\/common\/orders_list\.php/))
        orderListHandler();
};


/**
 * Configura el comportamiento del menú y el resaltado de elementos activos al pasar el mouse sobre ellos.
 */
function navMenu() {
    const menu = document.getElementById("navbar");
    Array.from(document.getElementsByClassName("menu-item")).forEach((item, index) => {
        item.onmouseover = () => {
            menu.dataset.activeIndex = index;
        };
    });
}


/**
 * Agrega un controlador de eventos para las imágenes del footer.
 * Si una imagen falla al cargarse, se asigna una imagen de respaldo.
 */
function footerImg() {
    document.querySelectorAll("footer img").forEach(function (img) {
        img.addEventListener("error", function () {
            img.src = "/SGG-Web/src/img/img_error_placeholder.png";
        });
    });
}


/**
 * Controlador de eventos para el formulario de registrarse / agregar usuario.
 * Genera campos de usuario y contraseña en base a los valores de entrada.
 */
function signInHandler() {
    const nameInput = document.getElementById("name");
    const surnameInput = document.getElementById("surname");
    const dniInput = document.getElementById("dni");
    const usernameInput = document.getElementById("username");
    const passwordInput = document.getElementById("password");

    /**
     * Genera los campos de usuario y contraseña basados en los valores ingresados.
     */
    function generateFields() {
        const name = nameInput.value.trim();
        const surname = surnameInput.value.trim();
        const dni = dniInput.value.trim();

        if (name.length > 0 && surname.length > 0)
            usernameInput.value = generateUsername(name, surname);
        else
            usernameInput.value = "";

        if (dni.length >= 4)
            passwordInput.value = generatePassword(dni);
        else
            passwordInput.value = "";
    }

    // Verificar si el campo "id" existe
    if (document.querySelector("input[name='id']"))
        generateFields();

    nameInput.addEventListener("input", generateFields);
    surnameInput.addEventListener("input", generateFields);
    dniInput.addEventListener("input", generateFields);

    // Botón de eliminar usuario
    const deleteButton = document.getElementById("btn-delete");
    if (deleteButton) {
        deleteButton.addEventListener("click", function () {
            const confirmation = window.confirm("¿Estás seguro de que deseas eliminar este usuario?");
            if (confirmation) {
                // Agregar el campo oculto al formulario
                let deleteInput = document.createElement("input");
                deleteInput.setAttribute("type", "hidden");
                deleteInput.setAttribute("name", "delete_user");
                document.querySelector("form").appendChild(deleteInput);
                // Enviar el formulario
                document.querySelector("form").submit();
            }
        });
    }

    // Botón de restaurar usuario
    const restoreButton = document.getElementById("btn-restore");
    if (restoreButton) {
        restoreButton.addEventListener("click", function () {
            const confirmation = window.confirm("¿Estás seguro de que deseas restaurar este usuario?");
            if (confirmation) {
                // Agregar el campo oculto al formulario
                let restoreInput = document.createElement("input");
                restoreInput.setAttribute("type", "hidden");
                restoreInput.setAttribute("name", "restore_user");
                document.querySelector("form").appendChild(restoreInput);
                // Enviar el formulario
                document.querySelector("form").submit();
            }
        });
    }
}


/**
 * Controlador de eventos para el formulario de lista de pedidos.
 * Reinicia los campos de fecha inicial y fecha final.
 */
function orderListHandler() {
    document.getElementById("btn-reset").addEventListener("click", function () {
        document.getElementById("date-start").value = "";
        document.getElementById("date-end").value = get_today_date();
        document.querySelector("form").submit();
    });
}


/**
 * Genera un nombre de usuario basado en el nombre y apellido proporcionados.
 *
 * @param {string} name - El nombre del usuario.
 * @param {string} surname - El apellido del usuario.
 * @returns {string} El nombre de usuario generado.
 */
function generateUsername(name, surname) {
    return (name.trim().charAt(0) + surname.trim()).replace(/\s/g, "").toLowerCase();
}


/**
 * Genera una contraseña basada en los últimos 4 dígitos del DNI proporcionado.
 *
 * @param {string} dni - El DNI del usuario.
 * @returns {string} La contraseña generada.
 */
function generatePassword(dni) {
    return dni.slice(-4);
}


/**
 * Obtiene la fecha actual en formato ISO 8601 (YYYY-MM-DD) ajustada al desplazamiento de la zona horaria.
 *
 * @returns {string} La fecha actual en formato "YYYY-MM-DD".
 */
function get_today_date() {
    let date = new Date();
    const offset = date.getTimezoneOffset();
    date = new Date(date.getTime() - (offset * 60 * 1000));
    return date.toISOString().split("T")[0];
}
