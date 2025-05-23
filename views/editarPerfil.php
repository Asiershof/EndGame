<?php 
// Si tienes código PHP al inicio, mantenlo
// IMPORTANTE: Cambiar cómo incluimos el header
include dirname(__DIR__) . '/views/layouts/header.php'; 
?>

<main>
    <section class="bg-white rounded shadow-sm p-4 mb-4">
        <h2 class="text-center mb-5">Editar perfil</h2>

        <?php if (!empty($resultado['error'])): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    mostrarToast("<?php echo addslashes($resultado['error']); ?>", "error");
                });
            </script>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-8">
                <div class="fondoFormularioOscuro p-4 rounded">
                    <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        
                        <h5 class="mb-3">Datos de la cuenta</h5>
                        <div class="mb-3">
                            <label for="nombre_usuario" class="form-label campoObligatorio">Nombre de usuario:</label>
                            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required value="<?php echo htmlspecialchars($usuario['nombre_usuario']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label campo-obligatorio">Correo electrónico:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required value="<?php echo htmlspecialchars($usuario['correo_electronico']); ?>">
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Cambiar contraseña (opcional)</h5>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña actual:</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Introduce tu contraseña actual para cambiarla">
                            <div class="form-text">Deja este campo y los siguientes en blanco si no quieres cambiar la contraseña.</div>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nueva contraseña:</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" minlength="6">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_new_password" class="form-label">Confirmar nueva contraseña:</label>
                            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password">
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Cambiar avatar</h5>
                        <div id="avatar-preview-container" class="mb-3 text-center <?php echo empty($usuario['avatar']) || $usuario['avatar'] === 'assets/img/usuario.png' ? 'd-none' : ''; ?>">
                            <h6 class="text-muted mb-2">Vista previa</h6>
                            <img id="avatar-preview-modal" src="<?php echo $avatar_url;?>" alt="Vista previa del nuevo avatar" class="rounded-circle img-thumbnail mb-3 object-fit-cover tamanoVistaAvatar">
                        </div>
                        
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Selecciona una nueva imagen:</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                            <div class="form-text">Formatos permitidos: JPG, PNG, GIF, WEBP. Tamaño máximo: 1MB.</div>
                        </div>

                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar cambios
                            </button>
                            <a href="<?php echo BASE_URL; ?>views/perfil.php" class="btn btn-secondary mt-2">
                                <i class="bi bi-arrow-left"></i> Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include dirname(__DIR__) . '/views/layouts/footer.php'; ?>