<?php
session_start();
require_once dirname(__DIR__) . '/config/configuracion.php';
require_once dirname(__DIR__) . '/controllers/controladorUsuario.php';

// Redirigir si ya está logueado
if (estaLogueado()) {
    redirigir('index.php');
}

$controlador = new ControladorUsuario();
$resultado = $controlador->registrar();

if (isset($resultado['redirigir'])) {
    $toast_message = isset($resultado['toast_message']) ? $resultado['toast_message'] : null;
    $toast_type = isset($resultado['toast_type']) ? $resultado['toast_type'] : 'info';
    redirigir($resultado['redirigir'], $toast_message, $toast_type);
}

// IMPORTANTE: Cambiar cómo incluimos el header
include dirname(__DIR__) . '/views/layouts/header.php';
?>

<main class="py-5 my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <section class="bg-white rounded shadow-sm p-4 mb-4">
                    <h2 class="mb-4 text-center">Registro de Usuario</h2>
                    
                    <?php if (isset($resultado['error'])): ?>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                mostrarToast("<?php echo addslashes($resultado['error']); ?>", "error");
                            });
                        </script>
                    <?php endif; ?>
                                        
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="nombre_usuario" class="form-label campoObligatorio">Nombre de usuario:</label>
                            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="correo" class="form-label campoObligatorio">Correo electrónico:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label campoObligatorio">Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirmar_password" class="form-label campoObligatorio">Confirmar contraseña:</label>
                            <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required>
                        </div>
                        
                        <div class="d-grid gap-2 col-8 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">Registrarse</button>
                        </div>
                    </form>
                    
                    <p class="text-center mt-3">
                        ¿Ya tienes una cuenta? <a href="<?php echo BASE_URL; ?>views/login.php">Inicia sesión</a>
                    </p>
                </section>
            </div>
        </div>
    </div>
</main>

<?php include dirname(__DIR__) . '/views/layouts/footer.php'; ?>
