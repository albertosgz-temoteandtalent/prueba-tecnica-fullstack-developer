# Prueba Técnica para Fullstack Engineer

## Introducción

La prueba se ha desarrollado sobre una instancia de Laravel Breeze con Vue por defecto. 

El primer commit del proyecto fue añadir el código original de Laravel.

Se ha aprovechado de dicho código original algunos componentes visuales, para mejorar la experiencia de usuario y centrarme más en lo que pedía la prueba.
Se ha considerado que el desarrollo de un estilo no era estrictamente necesario.


## Como arrancar

1. Descargar el proyecto localmente `git@github.com:albertosgz-temoteandtalent/prueba-tecnica-fullstack-developer.git`
2. Entrar en el proyecto `cd prueba-tecnica-fullstack-developer`
2. Ejecutar `composer install`
3. Arrancar contenedores Docker `docker-compose up`
4. Arrancar workers `vendor/bin/sail php artisan queue:work`
5. Configurar bucket en Minio para alojar nuestras imágenes:
   1. Navegar a http://localhost:8900/login
   2. Hacer login con usuario y password por defecto configurados por Laravel: sail / password
   3. Clicar en _Create Bucket_
   4. Crear uno con nombre _dynamic-page_

Opcionalmente se puede:
- Generar nuevos js `vendor/bin/sail npm run build` (o `npm run dev` para continuar el desarrollo)
- Ejecutar tests `vendor/bin/sail test --filter DynamicPageTest` (el filtro es para ejecutar los tests relevantes para esta prueba) 


## Posibles mejoras

El desarrollo de la aplicación se ha centrado en una versión funcional y básica de la prueba. 
Se ha intentado desarrollar el manejo de errores por la parte servidor. 
Sin obviar que hay mucho margen de mejora todavía en la aplicación en términos de manejor de errores y buenas prácticas, como crear más servicios para aplicar el Single Responsability Principle,
propongo algunas de ellas para el frontend en particular: 

- Manejo de errores al cargar la imagen, así como poder elegir una nueva.
