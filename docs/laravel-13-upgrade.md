# Actualización a Laravel 13

El proyecto pasa de Laravel 10.50.2 a Laravel 13.36.0. Se mantiene la estructura
existente de kernels, proveedores y rutas, compatible con el framework.

## Entorno

- Laravel 13 requiere PHP 8.3 como mínimo.
- El `composer.lock` generado en este proyecto utiliza componentes Symfony 8,
  que requieren PHP 8.4. Usar PHP 8.4 o superior tanto en CLI como en el servidor web.
- Ejecutar `composer check-platform-reqs` en el servidor de destino.

## Cambios de compatibilidad

- Sanctum 4, Tinker 3, Collision 8 y PHPUnit 12.
- El middleware CSRF existente hereda de `PreventRequestForgery`.
- Las sesiones conservan la serialización `php` y su nombre de cookie existente.
- El mutador de contraseña de `UserPortal` conserva los hashes recibidos del
  proveedor de autenticación para evitar aplicar el hash dos veces durante el login.
- `freshwork/chilean-bundle` pasa a dependencias de producción: los controladores
  lo utilizan para procesar RUT.
- Ya existe la migración de `personal_access_tokens` requerida por Sanctum.
  Esta actualización no añade migraciones ni requiere cambios en el esquema.

## Instalación en otro entorno

```sh
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan config:clear
php artisan route:clear
php artisan view:clear
npm ci
npm run build
```

Reiniciar los procesos PHP y los workers persistentes que utilice el despliegue.
Verificar el inicio y cierre de sesión, cambio de contraseña, sistemas del usuario,
registro de accesos y mantenedor de enlaces con las conexiones de datos disponibles.

## Validación

```sh
php artisan --version
php artisan test
php artisan route:list --except-vendor
composer validate --strict
composer check-platform-reqs
composer audit
```

La auditoría posterior a la actualización detectó nueve avisos en la dependencia
existente `phpoffice/phpspreadsheet` 4.5.0. La actualización de esa biblioteca a
una versión corregida queda fuera del cambio de framework y requiere validar
la importación de Excel antes de desplegarla.

Guías oficiales consultadas:

- https://laravel.com/docs/11.x/upgrade
- https://laravel.com/docs/12.x/upgrade
- https://laravel.com/docs/13.x/upgrade
