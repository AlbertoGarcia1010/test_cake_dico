# Prueba CakePHP

Este proyecto es parte de una prueba técnica con el framework de PHP
llamado Cake. También hacemos uso de Bootstrap para la parte visual y Datatable Js.

La siguiente documentación es obtenida desde el sitio oficial de [CakePHP](https://book.cakephp.org/4/en/index.html) para la **version 4.**

Requerimientos:

- HTTP Server.  Por ejemplo: **Apache**.
- Version **PHP 7.4** hasta  **8.2**.

CakePHP DB soportadas:

- MySQL (5.6 or higher)
- MariaDB (5.6 or higher)
- PostgreSQL (9.4 or higher)
- Microsoft SQL Server (2012 or higher)
- SQLite 3

## Instalación

Partiendo de que tenemos todo instalado (Composer, PHP, Mysql, etc) y siendo que vamos a descargar este 
repositorio, vamos a ejecutar el siguiente comando para hacer la instalación de los paquetes por medio de Composer.

  ```
      Composer install
  ```

## DB MySQL

El archivo de la Base de datos se encuentra dentro del proyecto en la carpeta DB
y solo será necesario ejecutar el script dentro de su Gestor de DB. Cabe mencionar 
que para este proyecto se esta usando MySQL.

Nota: Si requieres de alguna configuración extra, puedes hacerla desde config/app_local.php dentro de 
Datasource y dentro de app.php viene la configuración de la DB a usar (config de driver, timezone, etc) de igual manera en Datasource.

## Servidor Local

Luego, levantaremos nuestro servidor local ejecutando lo siguiente

  ```
      bin/cake server
  ```
Tu aplicación estará disponible en http://host:port


## Improvments

Por motivos de desconocimiento del equipo y sus configuraciones, tuve un retraso del tiempo, 
lo que derivo que no concluyera en su totalidad la prueba, por lo que la mayoría de los 
modulos estan inconclusos.

Nota: se estará subiendo la totalidad del proyecto y de la prueba en los proximos días.

# Tasks Prueba
**Modulos**
- **Home Page**
  
✅ Mostrar Tipo de Cambio Actual consumiendo API de Banxico

- **Clientes**

✅ Create

✅ Read

✅ Update

✅ Delete

- **Empleados**
  
✅ Create

✅ Read

✅ Update

✅ Delete

- **Productos**

✅ Create

✅ Read

✅ Update

✅ Delete

- **Ventas**

⏳ Crear Venta

⏳ Agregar Productos a la Venta

⏳ Cobrar Venta

⏳ Cancelar Venta

⏳ Consultar Venta





