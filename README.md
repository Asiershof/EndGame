# EndGame - Gestor de Videojuegos Completados

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://www.php.net/)
[![Cloudinary](https://img.shields.io/badge/Cloudinary-2.14.0-orange.svg)](https://cloudinary.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg)](https://getbootstrap.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

<p align="center">
  <img src="assets/img/logo.png" alt="EndGame Logo" width="150">
</p>

## 📝 Descripción

EndGame es una aplicación web que te permite gestionar y organizar los videojuegos que has completado. Podrás registrar información detallada, subir carátulas personalizadas y valorar tus experiencias de juego.

## ✨ Características principales

- 🎮 **Registro completo de juegos**: Guarda todos los detalles de los videojuegos que has completado, incluyendo tiempo de juego, plataforma, género y más.
- 🖼️ **Carátulas personalizadas**: Sube imágenes de las carátulas de tus juegos para tener una biblioteca visual atractiva.
- ⭐ **Sistema de valoración**: Puntúa tus juegos y añade comentarios personales sobre tu experiencia.
- 👤 **Gestión de usuarios**: Registro e inicio de sesión para mantener tu colección personal.
- 📊 **Estadísticas**: Visualiza estadísticas sobre tus hábitos de juego.
- 📱 **Diseño responsive**: Accede desde cualquier dispositivo con una experiencia optimizada.

## 🚀 Tecnologías utilizadas

- PHP 7.4+
- MySQL
- [Cloudinary](https://cloudinary.com/) para almacenamiento y gestión de imágenes
- HTML5, CSS3, JavaScript
- Bootstrap 5 para diseño responsive
- GuzzleHTTP para peticiones API

## 📋 Requisitos previos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Extensiones PHP: json, mysqli, gd
- Cuenta en Cloudinary (gratuita disponible)
- Servidor web (Apache, Nginx, etc.)
- Composer

## 🔧 Instalación

1. Clona este repositorio:
```bash
git clone https://github.com/tu-usuario/EndGame.git
```

2. Navega al directorio del proyecto:
```bash
cd EndGame
```

3. Instala las dependencias con Composer:
```bash
composer install
```

4. Crea una base de datos MySQL y configura las credenciales:
   - Importa el archivo `config/database.sql` para crear las tablas necesarias
   - Actualiza `config/conexion.php` con tus credenciales de base de datos

5. Configura Cloudinary:
   - Regístrate en [Cloudinary](https://cloudinary.com/)
   - Actualiza `config/cloudinary.php` con tus credenciales

6. Abre la aplicación en tu navegador:
```
http://localhost/EndGame
```

## 📱 Demo

<p align="center">
  <img src="https://via.placeholder.com/800x500?text=Demo+EndGame" alt="Demo EndGame">
</p>

Puedes probar una demo en vivo aquí: [https://endgame-demo.ejemplo.com](https://endgame-demo.ejemplo.com)

## 📸 Capturas de pantalla

<p align="center">
  <img src="https://via.placeholder.com/400x250?text=Pantalla+Inicio" alt="Pantalla de inicio" width="45%">
  <img src="https://via.placeholder.com/400x250?text=Lista+Juegos" alt="Lista de juegos" width="45%">
</p>
<p align="center">
  <img src="https://via.placeholder.com/400x250?text=Detalles+Juego" alt="Detalles de juego" width="45%">
  <img src="https://via.placeholder.com/400x250?text=Perfil+Usuario" alt="Perfil de usuario" width="45%">
</p>

## 📁 Estructura del proyecto

```
EndGame/
├── assets/              # Archivos estáticos (CSS, JS, imágenes)
├── config/              # Archivos de configuración
├── controllers/         # Controladores de la aplicación
├── includes/            # Funciones y utilidades
├── models/              # Modelos de datos
├── uploads/             # Directorio para subidas temporales
├── vendor/              # Dependencias de Composer
├── views/               # Vistas de la aplicación
│   └── layouts/         # Plantillas reutilizables
├── composer.json        # Configuración de Composer
├── composer.lock        # Versiones bloqueadas de dependencias
├── index.php            # Punto de entrada principal
└── README.md            # Este archivo
```

## 🛠️ Guía de uso

### Registro e inicio de sesión

1. Accede a la página principal y haz clic en "Registrarse"
2. Completa el formulario con tus datos
3. Verifica tu cuenta a través del correo electrónico
4. Inicia sesión con tus credenciales

### Añadir un juego completado

1. Navega a "Mi colección" y haz clic en "Añadir juego"
2. Completa el formulario con los detalles del juego
3. Sube una imagen de la carátula
4. Añade tu valoración y comentarios
5. Guarda los cambios

### Gestionar tu colección

- Filtra juegos por plataforma, género o puntuación
- Ordena por fecha de finalización, título o tiempo de juego
- Edita o elimina entradas existentes
- Visualiza estadísticas de tu historial de juego

## 🤝 Contribuir

Las contribuciones son bienvenidas y muy apreciadas!

1. Haz un fork del proyecto
2. Crea una rama para tu función: `git checkout -b feature/nueva-funcion`
3. Haz commit de tus cambios: `git commit -m 'Añadida nueva función'`
4. Sube los cambios a tu fork: `git push origin feature/nueva-funcion`
5. Abre un Pull Request

## 🐛 Reportar problemas

Si encuentras algún problema o tienes alguna sugerencia, por favor abre un issue en GitHub detallando:

- Descripción del problema o sugerencia
- Pasos para reproducir el problema (si aplica)
- Capturas de pantalla (si es posible)
- Tu entorno (navegador, sistema operativo, etc.)

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

## 👨‍💻 Autor

- **Tu Nombre** - [tu-usuario](https://github.com/tu-usuario)

## 📧 Contacto

Si tienes alguna pregunta o sugerencia, no dudes en contactarme:

- Email: [tu-email@ejemplo.com](mailto:tu-email@ejemplo.com)
- Twitter: [@tuusuario](https://twitter.com/tuusuario)
- LinkedIn: [Tu Nombre](https://www.linkedin.com/in/tu-perfil/)

## 🙏 Agradecimientos

- A todos los usuarios que han probado y dado feedback sobre EndGame
- [Cloudinary](https://cloudinary.com/) por su excelente servicio de gestión de imágenes
- [Bootstrap](https://getbootstrap.com/) por facilitar el diseño responsive
- [Font Awesome](https://fontawesome.com/) por los iconos utilizados

---

<p align="center">
  Desarrollado con ❤️ para todos los gamers que disfrutan completando sus juegos
</p>