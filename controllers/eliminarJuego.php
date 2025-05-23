<?php
session_start();
require_once dirname(__DIR__) . '/config/configuracion.php';
require_once dirname(__DIR__) . '/controllers/controladorJuego.php';

if (!estaLogueado()) {
    redirigir(BASE_URL . 'views/login.php', 'Debes iniciar sesión para eliminar juegos', 'warning');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirigir(BASE_URL . 'views/perfil.php', 'No se especificó qué juego eliminar', 'error');
}

$id = (int)$_GET['id'];
$controlador = new ControladorJuego();
$resultado = $controlador->eliminar($id);

if (isset($resultado['redirigir'])) {
    $toast_message = isset($resultado['toast_message']) ? $resultado['toast_message'] : null;
    $toast_type = isset($resultado['toast_type']) ? $resultado['toast_type'] : 'info';
    redirigir($resultado['redirigir'], $toast_message, $toast_type);
} else {
    redirigir(BASE_URL . 'views/perfil.php');
}
?>
