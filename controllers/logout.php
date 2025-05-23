<?php
session_start();
require_once dirname(__DIR__) . '/config/configuracion.php';
require_once dirname(__DIR__) . '/controllers/controladorUsuario.php';

$controlador = new ControladorUsuario();
$resultado = $controlador->logout();

redirigir(BASE_URL . 'index.php', '¡Has cerrado sesión correctamente!', 'info');
?>
