# Miniproyecto proveedores - Viajes para ti
## Descripción
-- A escribir --
## Tecnologias usadas
- PHP v8.2
- Symfony v4
- MySQL v8 para el motor de la base de datos
- TailwindCSS (CDN) para los estilos
- DaysiUI (CDN) para componentes ya hechos
- Twig para las vistas
## Cómo ejecutar?
### En local
La aplicación está desarrolladao usando symfony, por lo 
que con las herramientas php y composer instaladas, además
del servidor de mysql, se puede ejecutar el servidor web siguiendo los pasos:
1. Clonar el repositorio
```bash
git clone https://github.com/A1bert04/proveedores-viajes-para-ti
```
2. Instalar las dependencias

```bash
cd proveedores-viajes-para-ti
composer install
```

3. Ejecutar el servidor web

```bash
php bin/console server:run
```

o en caso de tener instalado symfony

```bash
symfony server:start
```

4. Crear la base de datos
```bash
php bin/console doctrine:schema:create
```

5. Configurar en el fichero .env la url de conexión a la base de datos.


### En docker
Para ejecutar la aplicación en docker, se debe tener instalado docker y docker-compose.
Los pasos a seguir son:
1. Clonar el repositorio
```bash
git clone https://github.com/A1bert04/proveedores-viajes-para-ti
```

2. Ejecutar el siguiente comando. Este creará los contenedores necesarios para ejecutar la aplicación.
```bash
cd proveedores-viajes-para-ti
docker-compose up --build -d && sleep 10 && docker exec symfony-providers php bin/console doctrine:schema:create
```
