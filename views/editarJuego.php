<?php 
// Si tienes código PHP al inicio, mantenlo
// IMPORTANTE: Cambiar cómo incluimos el header
include dirname(__DIR__) . '/views/layouts/header.php'; 
?>
<main>
    <section class="bg-white rounded shadow-sm p-4 mb-4">
        <h2 class="text-center mb-5">Editar juego</h2>
        <?php if (!empty($resultado['error'])): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    mostrarToast("<?php echo addslashes($resultado['error']); ?>", "error");
                });
            </script>
        <?php endif; ?>
        <div class="fondoFormularioOscuro p-4 rounded">
            <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="titulo" class="form-label campoObligatorio">Título del juego:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required
                        value="<?php echo htmlspecialchars($juego['titulo']); ?>">
                </div>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="fecha_inicio" class="form-label campoObligatorio">Fecha de inicio:</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required
                            value="<?php echo htmlspecialchars($juego['fecha_inicio']); ?>" max="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="fecha_fin" class="form-label campoObligatorio">Fecha de finalización:</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required
                            value="<?php echo htmlspecialchars($juego['fecha_fin']); ?>" max="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="horas_jugadas" class="form-label campoObligatorio">Horas jugadas:</label>
                        <input type="number" class="form-control" id="horas_jugadas" name="horas_jugadas" min="1" required
                            value="<?php echo htmlspecialchars($juego['horas_jugadas']); ?>">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="plataforma" class="form-label campoObligatorio">Plataforma:</label>
                        <select class="form-select" id="plataforma" name="plataforma" required>
                            <option value="">Selecciona una plataforma</option>
                            <?php
                            $plataformas = [
                                "PC", "PlayStation 5", "PlayStation 4", "Xbox Series X/S", "Xbox One",
                                "Nintendo Switch", "Nintendo 3DS", "Móvil", "Emulador", "Consola antigua", "Otra"
                            ];
                            foreach ($plataformas as $plataforma) {
                                $selected = ($juego['plataforma'] === $plataforma) ? 'selected' : '';
                                echo "<option value=\"$plataforma\" $selected>$plataforma</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="puntuacion" class="form-label campoObligatorio">Puntuación (1-10):</label>
                    <div class="d-flex align-items-center">
                        <input type="number" class="form-control text-center pe-none anchoPuntuacionInput" id="puntuacion" name="puntuacion" min="1" max="10" required readonly value="<?php echo htmlspecialchars($juego['puntuacion']); ?>">
                        <div class="estrellasPuntuacion ms-3" id="rating-stars">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <span class="estrella<?php echo ($i <= $juego['puntuacion']) ? ' activa' : ''; ?>" data-value="<?php echo $i; ?>">★</span>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="resenya" class="form-label campoObligatorio">Tu opinión sobre el juego:</label>
                    <textarea class="form-control" id="resenya" name="resenya" rows="4" placeholder="Escribe aquí tu reseña del juego..."><?php echo htmlspecialchars($juego['resenya']); ?></textarea>
                </div>
                
                <div class="row g-3 mb-4 mt-4 text-center align-items-center justify-content-center">
                    <div class="col-12 col-lg-6 mb-3 mb-md-0" id="caratula-container">
                        <div class="contenedorImagenTarjeta position-relative">
                            <?php
                            $caratula_url = obtenerUrlCaratula($juego);
                            ?>
                            <img src="<?php echo $caratula_url ? $caratula_url : ''; ?>" alt="Carátula" class="rounded shadow-sm mw-100 h-auto <?php echo !$caratula_url ? 'd-none' : ''; ?>" id="caratula-preview">
                            <div class="sinCaratula <?php echo $caratula_url ? 'd-none' : ''; ?>">
                                Sin imagen
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="caratula" class="form-label">Seleccionar nueva carátula:</label>
                        <input type="file" class="form-control" id="caratula" name="caratula" accept="image/*">
                        <div class="form-text">Formatos permitidos: JPG, PNG, WEBP, GIF. Tamaño máximo: 2MB</div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 col-6 mx-auto mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Guardar cambios
                    </button>
                    <a href="<?php echo BASE_URL; ?>views/verJuego.php?id=<?php echo $juego['id']; ?>" class="btn btn-secondary mt-2">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </section>
</main>
<?php include dirname(__DIR__) . '/views/layouts/footer.php'; ?>