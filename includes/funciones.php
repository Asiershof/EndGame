<?php
function sanitizar($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

function estaLogueado() {
    return isset($_SESSION['usuario_id']);
}

function redirigir($url, $mensajeToast = null, $tipoToast = 'info') {
    if (!filter_var($url, FILTER_VALIDATE_URL) && strpos($url, BASE_URL) !== 0) {
        $url = BASE_URL . ltrim($url, '/');
    }
    
    if ($mensajeToast !== null) {
        $separator = (strpos($url, '?') !== false) ? '&' : '?';
        $url .= $separator . 'toast_message=' . urlencode($mensajeToast) . '&toast_type=' . urlencode($tipoToast);
    }
    
    header('Location: ' . $url);
    exit;
}

function mostrarMensaje($mensaje, $tipo = 'error') {
    if ($tipo === 'error') {
        echo '<div class="mensaje error">' . $mensaje . '</div>';
    } else {
        echo '<div class="mensaje exito">' . $mensaje . '</div>';
    }
}

function verificarDirectorio($ruta) {
    if (!file_exists($ruta)) {
        return mkdir($ruta, 0777, true);
    }
    return true;
}

function subirImagen($archivo, $carpeta = 'general') {
    if (!isset($archivo['name']) || $archivo['error'] !== 0) {
        return false;
    }

    try {
        // Cargar cloudinary config
        $cloudinary = require_once ROOT_PATH . '/config/cloudinary.php';
        
        // Subir a Cloudinary
        $resultado = $cloudinary->uploadApi()->upload(
            $archivo['tmp_name'],
            ['folder' => 'endgame/' . $carpeta]
        );
        
        // Devolver la URL segura de la imagen
        return $resultado['secure_url'];
        
    } catch (Exception $e) {
        error_log("Error al subir imagen a Cloudinary: " . $e->getMessage());
        return false;
    }
}

function obtenerUrlCaratula($juego) {
    if (empty($juego['caratula'])) {
        return null;
    }
    
    // Si es una URL absoluta (comienza con http o https), es de Cloudinary
    if (strpos($juego['caratula'], 'http') === 0) {
        return $juego['caratula'];
    }
    
    // Proceso antiguo para imágenes locales
    $rutaCompleta = ROOT_PATH . $juego['caratula'];
    if (file_exists($rutaCompleta)) {
        return BASE_URL . $juego['caratula'];
    }
    
    $rutaAlternativa = ROOT_PATH . DIR_CARATULAS . basename($juego['caratula']);
    if (file_exists($rutaAlternativa)) {
        return BASE_URL . DIR_CARATULAS . basename($juego['caratula']);
    }
    
    $rutaAnterior = ROOT_PATH . 'uploads/caratulas/' . basename($juego['caratula']);
    if (file_exists($rutaAnterior)) {
        return BASE_URL . 'uploads/caratulas/' . basename($juego['caratula']);
    }
    
    return null;
}
?>
