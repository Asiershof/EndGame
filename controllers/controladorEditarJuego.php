<?php
session_start();
require_once dirname(__DIR__) . '/config/configuracion.php';
require_once dirname(__DIR__) . '/controllers/controladorJuego.php';

if (!estaLogueado()) {
    redirigir(BASE_URL . 'views/login.php', 'Debes iniciar sesión para editar juegos', 'warning');
}
if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirigir(BASE_URL . 'views/perfil.php', 'No se especificó qué juego editar', 'error');
}

$id = (int)$_GET['id'];
$controlador = new ControladorJuego();
$juego = $controlador->obtenerJuego($id);

if (!$juego || $juego['id_usuario'] != $_SESSION['usuario_id']) {
    redirigir(BASE_URL . 'views/perfil.php', 'No tienes permiso para editar este juego', 'error');
}

$resultado = $controlador->editar($id);

if (isset($resultado['exito']) && isset($resultado['toast_message'])) {
    redirigir(BASE_URL . 'views/verJuego.php?id=' . $id, $resultado['toast_message'], $resultado['toast_type']);
}

include dirname(__DIR__) . '/views/editarJuego.php';
?>
