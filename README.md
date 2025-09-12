Prueba Técnica: Mini OMS - Órdenes de Servicio

Este proyecto es una aplicación web de gestión de órdenes de servicio, que consta de un backend API construido con Laravel y un frontend desarrollado con Vue 3. La aplicación permite la gestión de órdenes de servicio, incluyendo la creación, asignación, cambio de estado y cálculo de costos.
Criterios de la Prueba

El proyecto cumple con los siguientes criterios de la prueba técnica:

    Backend (Laravel):

        Implementación de un API RESTful para la gestión de órdenes.

        Autenticación mediante Sanctum.

        Control de acceso y autorización con Policies/Gates para restringir acciones por rol (admin y agent).

        Pruebas operativas (php artisan test) que incluyen:

            Una prueba unitaria (Tests\Unit\ExampleTest).

            Pruebas de característica (Tests\Feature\OrdersApiTest) que validan los endpoints de la API.

        Un Job (NotifyOrderClosed) que se despacha al marcar una orden como "done" y registra la acción en los logs.

        Validación de datos con Form Requests y manejo de errores con respuestas JSON apropiadas.

    Frontend (Vue 3):

        Vista de lista con filtros reactivos por estado.

        Vista de detalle de la orden.

        Interfaz para asignar un técnico y cambiar el estado de una orden.

        Manejo de errores mediante notificaciones de UI.

    DevOps y CI:

        Configuración del entorno de desarrollo con Docker Compose para la aplicación y la base de datos MySQL.

        Un script de CI (ci.sh) que automatiza la instalación de dependencias, la configuración de la base de datos y la ejecución de las pruebas.

Requisitos

    Docker y Docker Compose instalados.

Configuración del Entorno de Desarrollo

    Clonar el repositorio:

    git clone <URL_DEL_REPOSITORIO>
    cd <NOMBRE_DEL_DIRECTORIO>

    Configurar el entorno:

        Copia el archivo .env.example a .env y ajusta las variables de entorno si es necesario.

        Asegúrate de que las credenciales de la base de datos en el .env coincidan con las de docker-compose.yml.

    Construir y levantar los contenedores de Docker:

    docker-compose up --build -d

    Instalar dependencias de Composer y Node.js:

    docker-compose exec -T app composer install
    docker-compose exec -T app npm install

    Ejecutar migraciones y seeders:

    docker-compose exec -T app php artisan migrate --seed

    Generar la clave de la aplicación:

    docker-compose exec -T app php artisan key:generate

    Iniciar el servidor de desarrollo de Laravel:

    docker-compose exec -T app php artisan serve

    Iniciar el servidor de desarrollo de Vue:

    docker-compose exec -T app npm run dev

La API estará disponible en http://localhost:8000 y el frontend en http://localhost:5173.
Cómo Correr el CI

Para ejecutar el pipeline de CI, simplemente corre el siguiente script desde la raíz del proyecto. Este script automatizará la configuración del entorno, la base de datos y la ejecución de las pruebas.

sh ci.sh

Pruebas de la Aplicación

Para correr las pruebas directamente desde el contenedor de Laravel, utiliza el siguiente comando:

docker-compose exec -T app php artisan test

