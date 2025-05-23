<?php
session_start();
require_once dirname(__DIR__) . '/config/configuracion.php';
require_once dirname(__DIR__) . '/controllers/controladorJuego.php';

if (!estaLogueado()) {
    redirigir(BASE_URL . 'views/login.php', 'Debes iniciar sesión para ver detalles de juegos', 'warning');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirigir(BASE_URL . 'views/perfil.php', 'No se especificó qué juego ver', 'error');
}

$id = (int)$_GET['id'];
$controlador = new ControladorJuego();

$juego = $controlador->obtenerJuego($id);

if (!$juego || $juego['id_usuario'] != $_SESSION['usuario_id']) {
    redirigir(BASE_URL . 'views/perfil.php', 'No tienes permiso para ver este juego', 'error');
}

include dirname(__DIR__) . '/views/layouts/header.php';
?>

<main>
    <section class="bg-white rounded shadow-sm p-4 mb-4">
        <h2 class="mb-4 text-center"><?php echo htmlspecialchars($juego['titulo']); ?></h2>
        
        <div class="row g-4 mt-4">
            <div class="col-lg-6">
                <div class="imagenJuego">
                    <?php 
                    $caratula_url = obtenerUrlCaratula($juego);
                    if ($caratula_url):
                    ?>
                        <img src="<?php echo $caratula_url; ?>" alt="Carátula de <?php echo htmlspecialchars($juego['titulo']); ?>" class="img-fluid rounded">
                    <?php else: ?>
                        <div class="sinCaratula rounded">Sin imagen</div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="mb-4 pb-3 border-bottom">
                    <h4 class="mb-3">Detalles</h4>
                    <p><strong>Plataforma:</strong> <?php echo $juego['plataforma']; ?></p>
                    <p><strong>Fecha inicio:</strong> <?php echo date('d/m/Y', strtotime($juego['fecha_inicio'])); ?></p>
                    <p><strong>Fecha fin:</strong> <?php echo date('d/m/Y', strtotime($juego['fecha_fin'])); ?></p>
                    <p><strong>Horas jugadas:</strong> <?php echo $juego['horas_jugadas']; ?></p>
                </div>
                
                <div class="mb-4 pb-3 border-bottom">
                    <h4 class="mb-3">Puntuación</h4>
                    <div class="puntuacionJuego">
                        <span class="fs-4"><?php echo htmlspecialchars($juego['puntuacion']); ?>/10</span>
                        <div class="estrellasPuntuacion ms-3 contenedorEstrellas">
                            <?php
                            for ($i = 1; $i <= 10; $i++) {
                                $class = ($i <= $juego['puntuacion']) ? 'activa' : '';
                                echo "<span class=\"estrella $class\">★</span>";
                            } 
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h4 class="mb-3">Mi opinión</h4>
                    <div class="p-3 bg-light rounded">
                        <?php if (!empty($juego['resenya'])): ?>
                            <div class="contenidoReseña">
                                <?php echo nl2br(htmlspecialchars($juego['resenya'])); ?>
                            </div>
                        <?php else: ?>
                            <p class="sinReseña">No hay reseña disponible para este juego.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
            <div class="mt-5 d-flex gap-4 justify-content-center">
                <a href="<?php echo BASE_URL; ?>controllers/controladorEditarJuego.php?id=<?php echo $juego['id']; ?>" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="<?php echo BASE_URL; ?>controllers/eliminarJuego.php?id=<?php echo $juego['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este juego?')">
                    <i class="bi bi-trash"></i> Eliminar
                </a>
                <a href="<?php echo BASE_URL; ?>views/perfil.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </section>
</main>

<?php include dirname(__DIR__) . '/views/layouts/footer.php'; ?>