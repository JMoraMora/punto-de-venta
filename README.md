# Reto tecnico punto de venta

### Requerimientos
* php8.3
* mariadb10.6
* laravel 12

### Instalacion

Descargar el repositorio y posicionar el cursor en este mismo

```
# instalar dependencias npm
npm install

# instalar dependencias composer
composer install
```

Copiar el archivo .env.example y cambiar las credenciales de base de datos con tus credenciales
```
cp .env.example .env
```

Ejecutar las migraciones para crear la base de datos y generar los registros de prueba
```
php artisan migrate --seed
```

Generar key
```
php artisan key:generate
```

### Correr proyecto
```
composer run dev
```

Accedemos a la aplicacion con nuestro puerto asignado.