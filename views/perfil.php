<?php
session_start();
require_once dirname(__DIR__) . '/config/configuracion.php';
require_once dirname(__DIR__) . '/controllers/controladorJuego.php';

// Redirigir si no está logueado
if (!estaLogueado()) {
    redirigir(BASE_URL . 'views/login.php', 'Debes iniciar sesión para ver tu perfil', 'warning');
}

// Obtener datos del usuario
$usuario_id = $_SESSION['usuario_id'];
require_once dirname(__DIR__) . '/models/Usuario.php';
$modeloUsuario = new Usuario($conn);
$usuario = $modeloUsuario->obtenerPorId($usuario_id);

// Obtener juegos del usuario
$controlador = new ControladorJuego();
$juegos = $controlador->obtenerJuegosUsuario($usuario_id);

// Determinar URL del avatar
$avatar_url = BASE_URL . 'assets/img/usuario.png';
if (!empty($usuario['avatar'])) {
    $avatar_path = ROOT_PATH . $usuario['avatar'];
    if (file_exists($avatar_path)) {
        $avatar_url = BASE_URL . $usuario['avatar'];
    }
}

include dirname(__DIR__) . '/views/layouts/header.php';
?>

<main class="my-4">
    <div class="container">
        <section class="bg-white rounded shadow p-4 mb-4">
            <div class="row align-items-center p-3">
                <div class="col-md-6 text-center mb-4 mb-md-0">
                    <div class="contenedorAvatar">
                        <img src="<?php echo $avatar_url; ?>" alt="Avatar de <?php echo htmlspecialchars($usuario['nombre_usuario']); ?>" class="rounded-circle img-thumbnail tamanoAvatarPerfil">
                    </div>
                </div>
                
                <!-- Columna Derecha: Datos y Botón Editar -->
                <div class="col-md-6">
                    <div class="mb-4 text-center"> 
                        <p><strong>Usuario:</strong> <?php echo htmlspecialchars($usuario['nombre_usuario']); ?></p>
                        <p><strong>Correo:</strong> <?php echo htmlspecialchars($usuario['correo_electronico']); ?></p>
                        <p><strong>Fecha de registro:</strong> <?php echo date('d/m/Y', strtotime($usuario['fecha_registro'])); ?></p>
                        <p><strong>Total de juegos completados:</strong> <?php echo count($juegos); ?></p>
                    </div>
                    
                    <div class="mt-3 text-center">
                        <a href="<?php echo BASE_URL; ?>controllers/controladorEditarPerfil.php" class="btn btn-outline-primary">
                            <i class="bi bi-pencil-square"></i> Editar Perfil
                        </a>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="bg-white rounded shadow p-4 my-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Mis juegos completados</h3>
                <a href="<?php echo BASE_URL; ?>views/anyadirJuego.php" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Añadir Juego
                </a>
            </div>
            
            <?php if (empty($juegos)): ?>
                <div class="alert alert-info">
                    Aún no has añadido ningún juego. ¡Comienza a registrar tus juegos completados!
                </div>
            <?php else: ?>
                <div id="juegos-container" class="listaJuegos row g-3">
                    <?php foreach ($juegos as $juego): ?>
                        <div class="col-12 col-sm-6 col-md-12 col-lg">
                            <a href="<?php echo BASE_URL; ?>views/verJuego.php?id=<?php echo $juego['id']; ?>" class="text-decoration-none text-dark">
                                <div class="card tarjetaJuego h-100 shadow-sm">
                                    <div class="contenedorImagenTarjeta">
                                        <?php 
                                        $caratula_url = obtenerUrlCaratula($juego);
                                        if ($caratula_url):
                                        ?>
                                            <img src="<?php echo $caratula_url; ?>" alt="Carátula" >
                                        <?php else: ?>
                                            <div class="sinCaratula">Sin imagen</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body cuerpoTarjeta text-center">
                                        <h5 class="tituloTarjeta text-truncate"><?php echo htmlspecialchars($juego['titulo']); ?></h5>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <span class="fw-bold"><?php echo htmlspecialchars($juego['puntuacion']); ?>/10</span>
                                            <span class="estrellasMini">
                                                <?php 
                                                for ($i = 1; $i <= 5; $i++) {
                                                    $mitad = $juego['puntuacion'] / 2;
                                                    echo ($i <= $mitad) ? '★' : '☆';
                                                } 
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php include dirname(__DIR__) . '/views/layouts/footer.php'; ?>
