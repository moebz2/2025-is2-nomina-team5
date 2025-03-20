## Bienvenidos al Proyecto Nomina IS2 del grupo 5
El proyecto utiliza la arquitectura MVC y esta diseñada sobre el framework de Laravel. Laravel es un framework PHP que permite crear aplicaciones web de forma agil y sencilla sin perder de vista la seguridad y las buenas practicas fundamentales en proyectos profesionales. 

Este proyecto usa la **VERSION 12** de Laravel por lo que es importante seguir los siguientes pasos para compilar correctamente el proyecto

### Requisitos previos

**Git:** Necesitará Git instalado para clonar el repositorio. Puede descargarlo desde [git-scm.com](http://git-scm.com "GIT")

**Composer:** Laravel utiliza Composer para gestionar sus dependencias. Puede descargarlo desde [getcomposer.org](https://getcomposer.org).

**PHP:** Laravel requiere PHP. Asegúrate de que tenga una versión compatible instalada. Puede descargar PHP desde [php.net](https://php.net).

**Node.js y npm (opcional):** Si el proyecto utiliza assets frontend (como JavaScript o CSS compilados con Laravel Mix o Vite), necesitará Node.js y npm. Puede descargarlos desde [nodejs.org](https://node.org).

**Base de datos:** Laravel generalmente utiliza una base de datos (MySQL, PostgreSQL, etc.). Asegúrate de que tenga una instalada y configurada.

### Clonar el repositorio

1. Abre la terminal o línea de comandos.

2. Navega al directorio donde quiere guardar el proyecto.

3. Ejecute el siguiente comando, reemplazando url_del_repositorio con la url del repositorio de git:


```
git clone https://github.com/moebz2/2025-is2-nomina-team5.git
```

Esto creará una copia del proyecto en su computadora.

### Instalar dependencias de Composer:

Navega al directorio del proyecto en la terminal:

``` bash
cd 2025-is2-nomina-team5
```

Ejecute el siguiente comando para instalar las dependencias de PHP:

```bash
composer install
```

Esto descargará e instalará todas las bibliotecas y paquetes necesarios.

### Copiar el archivo .env:

Laravel utiliza un archivo **.env** para la configuración. Copie el archivo **.env.example** a  **.env**:


```bash
cp .env.example .env
```

Abra el archivo **.env** en un editor de texto y configure las variables de entorno, como la configuración de la base de datos.

### Generar la clave de la aplicación:

Ejecute el siguiente comando para generar una clave única para la aplicación:


```bash
php artisan key:generate
```

### Instalar dependencias de npm (si es necesario):

Si el proyecto utiliza assets frontend, ejecute los siguientes comandos:

```bash
npm install
npm run dev `Para desarrollo`
npm run buid `Para produccion`
```

El comando "npm run dev", es para correr en modo desarrollo, esto quiere decir que cada cambio que realices en el codigo fuente de los archivos javascript, y css, se verán reflejados de manera automática en el navegador. En caso de correr la aplicación en modo producción, se utiliza el comando "npm run build".

### Configurar la base de datos:

Cree una base de datos con el nombre especificado en el archivo **.env**.
Ejecute las migraciones de la base de datos:

```bash
php artisan migrate
```

Si es necesario llenar la base de datos con datos de prueba, entonces debe de ejecutar los seeders:

``` bash
php artisan db:seed
```

####Iniciar el servidor de desarrollo:

Ejecute el siguiente comando para iniciar el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

Abra el navegador web y vaya a http://localhost:8000 para ver la aplicación.
