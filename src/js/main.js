/*
 * Configura el comportamiento del menú y el resaltado de elementos activos al
 * pasar el mouse sobre ellos.
 */
const menu = document.getElementById("navbar");
Array.from(document.getElementsByClassName("menu-item")).forEach((item, index) => {
    item.onmouseover = () => {
        menu.dataset.activeIndex = index;
    };
});


/*
 * Agrega un controlador de eventos para las imágenes del footer.
 * Si una imagen falla al cargarse, se asigna una imagen de respaldo.
 */
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("footer img").forEach(function (img) {
        img.addEventListener("error", function () {
            img.src = "/SGG-Web/src/img/img_error_placeholder.png";
        });
    });
});
