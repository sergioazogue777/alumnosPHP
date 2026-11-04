# Gestión de alumnos con PHP y MySQL

Ejercicio del primer curso del ciclo de Desarrollo de Aplicaciones Web (DAW). Lo desarrollé mientras aprendía PHP, formularios, sesiones, consultas a bases de datos y operaciones CRUD.

La aplicación permite registrar usuarios, iniciar sesión, consultar un listado de alumnos y crear, modificar o eliminar sus fichas. Es un proyecto académico sencillo, no una aplicación de producción.

## Requisitos

PHP 8.0 o superior con PDO MySQL y una base de datos MySQL o MariaDB. El esquema de ejemplo está en `schema.sql`.

## Puesta en marcha

1. Crea la base de datos con el contenido de `schema.sql`.
2. Configura las variables de entorno `DB_HOST`, `DB_NAME`, `DB_USER` y `DB_PASSWORD`. Si no se especifican, se utilizan los valores locales de desarrollo.
3. Desde la carpeta del repositorio, ejecuta `php -S localhost:8000`.
4. Abre `http://localhost:8000/registrarse.php` para crear un usuario.

No subas credenciales reales al repositorio.

## Qué practiqué

Uso de PHP en el servidor, MySQL, formularios, sesiones, autenticación básica, consultas con filtros y paginación.

El ejercicio se ha revisado posteriormente para separar la conexión a la base de datos, usar consultas preparadas, codificar la salida HTML y añadir protección CSRF. La versión actual no conserva la subida de fotos del ejercicio original: esa funcionalidad necesitaba una validación de archivos que no estaba implementada correctamente.
