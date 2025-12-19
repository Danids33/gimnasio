# PowerFit Gym - Sistema de Gestión de Membresías

Este proyecto es un sistema web desarrollado en Laravel para el gimnasio PowerFit Gym. El cliente es Marco, que es el administrador del gimnasio, y necesitaba una solución para gestionar las membresías de los miembros. El caso que me asignaron fue el CASO 4 - Gimnasio.

## Descripción del Problema

Marco tenía un problema porque estaba anotando todo en un cuaderno: nombre, cédula, qué plan compró cada persona, desde cuándo hasta cuándo. Pero no sabía quién ya había vencido su membresía. Necesitaba un sistema donde pudiera registrar miembros con su nombre completo, cédula, teléfono, tipo de membresía, y saber si está activo o ya venció. También quería que la fecha de inscripción se pusiera sola pero que pudiera corregirla si se equivocaba. Y sobre eliminar registros, su socio le dijo que mejor guardar todo por temas legales, así que implementé soft deletes. Además, como a veces está en la entrada con solo el teléfono verificando si alguien es miembro, el sistema tiene que funcionar bien desde el celular.

## Solución Implementada

Desarrollé un sistema completo con CRUD para gestionar los miembros. El sistema permite registrar nuevos miembros con todos sus datos, ver el listado completo, editar información cuando sea necesario, y ver los detalles de cada miembro. Cuando se elimina un miembro, en realidad no se borra de la base de datos, solo se marca como eliminado para mantener el historial legal como pidió el socio de Marco.

Para el modelo de datos usé Eloquent ORM de Laravel con soft deletes. Configuré el $fillable con todos los campos necesarios: nombre_completo, cedula, telefono, tipo_membresia, fecha_inscripcion, fecha_inicio, fecha_fin, y esta_activo. También agregué casts apropiados para que las fechas se manejen como objetos Carbon y el estado activo como boolean. En el método boot() del modelo puse lógica para que automáticamente actualice el estado activo basándose en si la fecha de fin ya pasó o no.

La migración de la base de datos tiene todos los campos necesarios. La cédula tiene constraint unique para evitar duplicados. Incluí soft deletes con la columna deleted_at. Los tipos de datos son apropiados: strings para nombres y textos, date para las fechas, y boolean para el estado activo. También están los timestamps automáticos de Laravel.

El controlador MiembroController tiene todos los métodos necesarios para el CRUD. El método index muestra el listado con paginación. Create muestra el formulario para registrar un nuevo miembro. Store valida los datos y guarda el nuevo miembro, y si no se proporciona fecha de inscripción la asigna automáticamente con la fecha actual. Show muestra los detalles de un miembro específico. Edit muestra el formulario de edición. Update valida y actualiza la información. Y destroy hace el soft delete del miembro.

Las validaciones están completas. Todos los campos requeridos tienen validación, la cédula debe ser única (excepto cuando se está editando el mismo registro), y validé que la fecha de fin sea posterior a la fecha de inicio. Los mensajes de error están en español para que sean más claros.

Para las vistas usé Bootstrap 5 porque es fácil de usar y tiene buen soporte responsive. Creé un layout principal que se usa en todas las páginas, con un navbar que se colapsa en móviles, sistema de alertas para mostrar mensajes de éxito o error, y un footer. La vista index tiene una tabla responsive con paginación, badges de colores para mostrar el estado (verde para activo, rojo para vencido), y botones para ver, editar o eliminar cada miembro. Los teléfonos son clickeables para llamar directamente.

Las vistas create y edit tienen formularios con validación visual. Cuando hay errores se muestran en rojo. Incluí un select para elegir el tipo de membresía (Mensual, Trimestral, Semestral, Anual) y con JavaScript hice que automáticamente calcule la fecha de fin cuando se selecciona el tipo y se ingresa la fecha de inicio. La fecha de inscripción se puede dejar vacía y se asigna automáticamente, pero también se puede editar si es necesario.

La vista show muestra todos los detalles del miembro en una tarjeta. Muestra el estado con un badge grande, calcula los días restantes de la membresía, y tiene botones para editar o eliminar.

Para las rutas usé Route::resource que es la forma estándar de Laravel para hacer CRUD. Esto genera automáticamente todas las rutas necesarias: GET para listar y ver, POST para crear, PUT para actualizar, y DELETE para eliminar.

El diseño es completamente responsive. Usé el sistema de grid de Bootstrap que se adapta automáticamente. En móviles el navbar se colapsa en un menú hamburguesa, las tablas tienen scroll horizontal, y los formularios se apilan en una sola columna. Los botones tienen buen tamaño para ser tocados fácilmente en pantallas táctiles.

## Tecnologías Usadas

Para el backend usé Laravel 11 con PHP 8.4 y MySQL como base de datos. Para el frontend usé Bootstrap 5.3.2 para los estilos y componentes responsive. También usé JavaScript vanilla para el auto-cálculo de la fecha de fin cuando se selecciona el tipo de membresía. Las migraciones de Laravel para la estructura de la base de datos, Eloquent ORM para trabajar con los datos, y soft deletes para mantener el historial.

## Instalación

Para instalar el proyecto necesitas tener PHP 8.4 o superior, Composer, MySQL, y Laragon como servidor web. Primero clonas o descargas el proyecto y entras a la carpeta. Luego ejecutas composer install para instalar las dependencias. Después copias el archivo .env.example a .env y generas la clave de la aplicación con php artisan key:generate.

En el archivo .env configuras la conexión a la base de datos. La configuración típica para Laragon es DB_CONNECTION=mysql, DB_HOST=127.0.0.1, DB_PORT=3306, DB_DATABASE=gimnasio, DB_USERNAME=root, y DB_PASSWORD vacío.

Una vez configurada la base de datos, ejecutas php artisan migrate para crear las tablas. Si ya tienes Laragon corriendo puedes acceder directamente a http://gimnasio.test, o si prefieres usar el servidor de desarrollo de Laravel ejecutas php artisan serve y accedes a http://localhost:8000.

## Uso del Sistema

Para registrar un nuevo miembro, vas a la página principal y haces click en el botón "Nuevo Miembro". Completas el formulario con todos los datos. Si no pones fecha de inscripción se asigna automáticamente la fecha actual, pero puedes cambiarla si quieres. Cuando seleccionas el tipo de membresía y pones la fecha de inicio, automáticamente se calcula la fecha de fin. El estado activo se actualiza solo según si la fecha de fin ya pasó o no.

Para consultar miembros, en la página principal ves el listado completo con paginación si hay muchos registros. Los estados se ven con badges de colores: verde para activo, rojo para vencido. Puedes hacer click en ver para ver todos los detalles, en editar para modificar información, o en eliminar para dar de baja al miembro (aunque el registro se mantiene en la base de datos).

Para verificar una membresía desde el móvil, simplemente abres el sistema desde el teléfono. La interfaz se adapta automáticamente y puedes buscar por nombre o cédula en el listado. El estado se ve claramente con los badges de color.

Para editar información de un miembro, haces click en el botón editar, modificas los campos que necesites, y guardas. La fecha de inscripción es editable como pidió Marco.

Para eliminar un miembro, usas el botón eliminar. El sistema pregunta confirmación y luego hace un soft delete. El registro no se borra físicamente, solo se marca como eliminado, cumpliendo con el requisito legal de mantener el historial.

## Estructura de la Base de Datos

La tabla miembros tiene los siguientes campos: id como primary key, nombre_completo como string, cedula como string de máximo 20 caracteres con constraint unique, telefono como string de máximo 20 caracteres, tipo_membresia como string de máximo 50 caracteres, fecha_inscripcion como date, fecha_inicio como date, fecha_fin como date, esta_activo como boolean con valor por defecto true, created_at y updated_at como timestamps automáticos, y deleted_at como timestamp nullable para el soft delete.

## Cumplimiento de Requisitos

El sistema cumple con todos los requisitos del caso. Permite registrar miembros con todos los campos solicitados: nombre completo, cédula, teléfono, tipo de membresía, y estado activo o vencido. La fecha de inscripción se asigna automáticamente pero es editable. El estado activo se calcula automáticamente según la fecha de fin. Se implementó soft deletes para mantener el historial legal. La interfaz es responsive y funciona bien desde móviles. Y permite verificación rápida desde el teléfono.

Para la rúbrica del examen, el modelo tiene $fillable completo con todos los campos, casts apropiados para fechas y boolean, y soft deletes implementado. El controlador tiene 7 métodos (index, create, store, show, edit, update, destroy) con validaciones completas y código limpio. Las vistas tienen layout compartido, CRUD completo, Bootstrap para estilos, diseño responsive, y feedback visual con alertas. Las rutas están configuradas con Route::resource correctamente. Y la migración es funcional con todos los campos necesarios.

## Notas Finales

El sistema calcula automáticamente el estado activo basándose en la fecha de fin cada vez que se guarda o actualiza un miembro. Los registros eliminados se mantienen en la base de datos gracias al soft delete, cumpliendo con los requisitos legales. La interfaz está optimizada para uso desde dispositivos móviles con diseño responsive. Y si en el futuro se necesitan agregar más tipos de membresía, solo hay que agregarlos en el select del formulario.
