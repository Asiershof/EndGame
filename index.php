<?php
session_start();
require_once __DIR__ . '/config/configuracion.php';
include __DIR__ . '/views/layouts/header.php';
?>

<main class="py-5 my-5">
    <div class="container">
        <section class="mb-5">
            <div class="bg-white rounded shadow-sm p-4 text-center">
                <h2 class="mb-3">¿Qué es EndGame?</h2>
                <p class="lead">
                    EndGame es una página te permite guardar y gestionar los datos de los videojuegos que has completado. 
                    Podrás registrar varios datos de tu juego a la hora de añadirlo junto con una imagen de la carátula del juego y hasta poder darle una puntuación.
                </p>
            </div>
        </section>
        
        <section>
            <h3 class="mb-4 text-center">Características principales</h3>
            <div class="row row-cols-1 row-cols-md-3 g-4 text-center">
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title">Registro de juegos</h4>
                            <p class="card-text">Guarda todos los detalles de los juegos que has completado, incluyendo el tiempo que te ha llevado terminarlos.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title">Carátulas personalizadas</h4>
                            <p class="card-text">Sube imágenes de las carátulas de tus juegos para tener una biblioteca visual atractiva.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title">Puntúa qué te ha parecido</h4>
                            <p class="card-text">Añade una valoración a tu juego e incluso una breve descripción de qué te ha parecido.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php include __DIR__ . '/views/layouts/footer.php'; ?>

