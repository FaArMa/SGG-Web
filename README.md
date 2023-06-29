# SGG-Web
- Un sitio web para la parte práctica del segundo parcial de **Laboratorio de Computación IV** (materia de la carrera *Tecnicatura Universitaria en Programación* de la *UTN*), el cual será para interactuar con la base de datos (MySQL) del **Sistema de Gestión Gastronómico** ([SGG-GDEng](https://github.com/FaArMa/SGG-GDEng)) utilizando PHP.
  - Desarrollado junto a [iglop](https://github.com/iglop) y [ereichardt](https://github.com/ereichardt).

## Consignas
1. La temática del mismo será libre y podrá articularse con los requisitos de los proyectos solicitados en la materia Práctica Profesional Supervisada.
2. El proyecto debe tener una base de datos y al menos 2 tablas, una de usuarios y la otra que permita cargar el contenido principal del proyecto.
3. En la tabla usuarios agregar uno o más usuarios con la categoría de administrador. Las contraseñas de todos los usuarios deberán guardarse encriptadas (MD5 o cualquier otro método).
4. Desarrollar en formato HTML la página principal del proyecto, la misma deberá contener el menú de navegación, la descripción del proyecto, una opción de registro de usuarios "Suscriptores" y un acceso a un contenido protegido por usuario y contraseña (estos 2 pueden resolverse en la misma página o lo que sería más prolijo, resolverse en una página aparte).
5. Página adicional con formulario de contacto y su correspondiente PHP con la función mail para que envíe el mismo a una dirección simulada del sitio.
6. Una vez logueado (debe chequearse esto utilizando el concepto de sesión y sus variables) si el resultado es correcto mostrará el contenido principal del sitio (dependiendo del tipo de usuario que se haya logueado), caso contrario redireccionará a la página principal del sitio mostrando un mensaje de error.
7. Si el usuario logueado tiene la categoría de "Suscriptor" se le mostrará una Página interna con el contenido principal del sitio que deberá ser traído desde una base de datos (desde su tabla correspondiente) y sobre el cual se hará el ABM abajo solicitado y su correspondiente buscador.
8. Si el usuario logueado tiene la categoría de "Administrador" se le mostrará una Página adicional con los contenidos anteriormente mencionados con su correspondiente ABM (Altas, bajas y modificaciones) y su correspondiente buscador. El mismo se adaptará a la temática del proyecto.

## Aviso
1. Fecha de entrega para el 21/06/2023, así que si ves cambios posteriores es porque quisimos terminar de corregir y/o mejorar ciertas cosas.
2. El último commit del SGG-Web es el [1274f7f](https://github.com/FaArMa/SGG-Web/tree/1274f7fbe21ccf2c2bd5450660823f8406c15cf6) (ya que se presentó este y aprobamos), los posteriores *muy probablemente* sean solo para SGG-GDEng.
    - Especialmente si los cambios son en `src/php/sgg_api.php`, `src/php/db/functions.php` y `src/php/db/sgg_web.sql`.
3. El diseño no es adaptable ya que no era obligatorio que lo sea, pero parece ir bien desde 850x480 en adelante.
