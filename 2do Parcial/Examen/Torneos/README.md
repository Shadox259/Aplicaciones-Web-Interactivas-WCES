# App de Torneos

Aplicación web desarrollada con Laravel donde un administrador crea torneos (fútbol, básquetbol, videojuegos, etc.) y los jugadores se inscriben en ellos para participar.

Los visitantes sin cuenta pueden consultar el listado público y el detalle de cada torneo, pero no inscribirse.

---------------------------------------------------------------------------------------------------------------------------------

## Roles

Administrador: Crear, editar y eliminar torneos. Dar de baja inscripciones. Ver el panel de administración.
Jugador: Inscribirse en torneos disponibles, ver "Mis torneos" y cancelar su inscripción hasta la fecha del evento. 
Visitante: Consultar el listado público y el detalle de cada torneo con participantes. No puede inscribirse ni acceder al panel de admin.

> Cualquier cuenta creada desde `/register` obtiene automáticamente el rol `jugador`.
> El administrador se crea vía seeder.

---------------------------------------------------------------------------------------------------------------------------------

## Cuentas demo

Creadas automáticamente por el seeder (`DatabaseSeeder`):

Administrador: `admin@demo.com` | `password`
Jugador: `jugador@demo.com` | `password`

El seeder también cuenta con 2 torneos de ejemplo para pruebas.