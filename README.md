# BotanicApp

**BotanicApp** es un aplicativo web desarrollado para la gestión y caracterización de la flora endémica de la provincia de Morona Santiago. El sistema que utiliza una arquitectura de base de datos NoSQL con **MongoDB** que integra el framework **Laravel** con el panel administrativo **MoonShine**.

Este proyecto forma parte del trabajo de titulación: 
> *Diseño de una base de datos documental para el registro de la caracterización de la flora endémica de Morona Santiago.*

---

## Anexos del Proyecto

Todos los recursos técnicos y documentos de respaldo se encuentran organizados en la carpeta `/ANEXOS`.

### Diseño de la Base de Datos (MongoDB)
Se detalla el diseño estructural de las colecciones mediante esquemas JSON y la definición de índices:

* **Colección Plantas:**
    * `Json Schema Planta.pdf`:  Diseño documental de plantas.
    * `Indices de la coleccion Plantas.pdf`: Optimización de consultas.
* **Colección Georreferenciación:**
    * `Json Schema Georreferenciacion.pdf`: Diseño documental de ubicación.
    * `Indices de la coleccion Georreferenciacion.pdf`: Optimización de búsquedas geográficas.

---

## Documentación y Manuales

Para facilitar el despliegue y uso de la plataforma, se han incluido los siguientes manuales:

### 1. Manual de Usuario 
Explica detalladamente cómo interactuar con la aplicación, la gestión de registros botánicos y la navegación en el panel administrativo.

### 2. Manual de Instalación 
Guía paso a paso para montar el entorno de desarrollo, incluyendo:
* Configuración de **PHP** y **Laravel**.
* Conexión con la base de datos **MongoDB**.
* Instalación de dependencias (`composer install`, extensiones de php mongodb).
* Configuración de los recursos de **MoonShine**.

---

## Tecnologías Utilizadas

* **Framework:** [Laravel](https://laravel.com/)
* **Admin Panel:** [MoonShine](https://moonshine-laravel.com/)
* **Base de Datos:** [MongoDB](https://www.mongodb.com/)