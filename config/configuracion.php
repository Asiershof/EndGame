<?php
// Define la ruta base del proyecto
define('ROOT_PATH', dirname(__DIR__));

// Función para obtener la URL base
function obtenerBaseUrl() {
    // Forzar HTTPS para Railway y usar detección para otros entornos
    if (strpos(strtolower($_SERVER['HTTP_HOST']), '.railway.app') !== false) {
        $protocolo = 'https://';
    } else {
        $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
                  (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
                  (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on') ||
                  (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https');
        $protocolo = $isHttps ? 'https://' : 'http://';
    }
    
    $host = $_SERVER['HTTP_HOST'];
    return $protocolo . $host . '/';
}

define('BASE_URL', obtenerBaseUrl());

// Definir rutas relativas para los directorios (sin slash al principio)
define('DIR_DESCARGAS', 'assets/uploads/');
define('RUTA_DESCARGAS', ROOT_PATH . DIRECTORY_SEPARATOR . DIR_DESCARGAS);
define('DIR_CARATULAS', 'assets/uploads/caratulas/');
define('RUTA_CARATULAS', ROOT_PATH . DIRECTORY_SEPARATOR . DIR_CARATULAS);
define('DIR_AVATARES', 'assets/uploads/avatares/');
define('RUTA_AVATARES', ROOT_PATH . DIRECTORY_SEPARATOR . DIR_AVATARES);

// Includes usando rutas relativas
require_once ROOT_PATH . DIRECTORY_SEPARATOR . 'config/conexion.php';
require_once ROOT_PATH . DIRECTORY_SEPARATOR . 'includes/funciones.php';

// Crear directorios necesarios si no existen
if (!file_exists(RUTA_DESCARGAS)) {
    mkdir(RUTA_DESCARGAS, 0777, true);
}
if (!file_exists(RUTA_CARATULAS)) {
    mkdir(RUTA_CARATULAS, 0777, true);
}
if (!file_exists(RUTA_AVATARES)) {
    mkdir(RUTA_AVATARES, 0777, true);
}
?>
