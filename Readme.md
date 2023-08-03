# Apliación proveedores - Viajes para ti
## Descripción
Aplicación de PHP que permite gestionar proveedores que pueden ser de tipo: Hotel, Pista o Complemento.
### Funcionalidades
Todas las funcionalidades básicas: 

&#10004; Operaciones CRUD sobre proveedores (Crear, Leer, Actualizar y Borrar) <br>
&#10004; Ver la fecha y hora de creación <br>
&#10004; Ver la fecha y hora de la última actualización <br>
&#10004; Responsive <br>
&#10004; Se puede desplegar usando docker <br>

Funcionalidades añadidas:

&#10004; Sistema de paginación (debe haber más de 10 entradas para que se active) <br>
&#10004; Sistema de búsqueda <br>
&#10004; Poder ordenar por cualquier campo <br>
&#10004; Feedback visual de las acciones realizadas (popups) <br>

## Tecnologias usadas
- PHP v8.2
- Symfony v4
- Doctrine como ORM (ORM de symfony)
- Twig para las vistas
- MySQL v8 para el motor de la base de datos
- TailwindCSS, DaysiUI y FontAwesome para los estilos
## Cómo ejecutar?
### En docker
Para ejecutar la aplicación en docker, se debe tener instalado docker y docker-compose.
Los pasos a seguir son:
1. Clonar el repositorio
```bash
git clone https://github.com/A1bert04/proveedores-viajes-para-ti
```
2. Entrar en la carpeta:
```bash
cd proveedores-viajes-para-ti
```
3. Ejecutar el siguiente comando. Este creará los contenedores necesarios para ejecutar la aplicación y después creará las tablas de la base de datos.
```bash
docker-compose up --build -d && sleep 10 && (docker exec symfony-providers php bin/console doctrine:schema:create > /dev/null 2>&1 || true) && echo "Server running successfully"
```
Es importante esperar a que termine de ejecutarse ya que tiene un tiempo de espera de 10s para que se cree la base de datos.
Una vez finalizado, la aplicación estará disponible el navegador en la url: http://localhost:8000 o la ip que corresponda en caso de ejecutarse en un servidor.

### En local
La aplicación está desarrollada usando symfony, 
por lo que si se quiere ejecutar en local, se debe tener instalado php, composer, el cli de symfony y se debe 
tener el servidor mysql.
Se puede ejecutar el servidor web siguiendo los pasos:
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

# Conclusiones 
En general, debo decir que me ha gustado mucho 
aprender Symfony desde cero. 
La experiencia ha sido enriquecedora y gratificante. 
Una de las cosas que más me ha impresionado de Symfony
es la facilidad y eficiencia con la que se pueden realizar 
tareas comunes de desarrollo gracias a las herramientas que proporciona. 
Su CLI es muy útil, y permite generar rápidamente diferentes elementos de la aplicación
como formularios, controladores, paginación, etc.

## A mejorar
La estructura de la aplicación es sin duda una de
las cosas a mejorar, al no haber visto anteriormente
proyectos en producción en Symfony.
Al no tener experiencia con Twig, aprendí
algo más tarde sobre temas como los layouts y
components que definitivamente habrían facilitado la
experiencia de desarrollo.

También he notado que mi falta de experiencia inicial 
me llevó a encontrar soluciones alternativas en 
lugar de aprovechar plenamente la potencia de Twig y sus características. 