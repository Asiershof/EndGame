<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EndGame: Tu Biblioteca de Juegos</title>
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/img/favicon.ico" type="image/x-icon">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/estilos.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/toast.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE_URL; ?>index.php">
                    <img src="<?php echo BASE_URL; ?>assets/img/logo.png" alt="Logo" class="me-2 logo logo-animado">
                    <span class="marca-texto">End<span class="text-primary">Game</span></span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse text-center my-4" id="navbarMain">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>index.php">Inicio</a>
                        </li>
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <?php
                            require_once dirname(__DIR__, 2) . '/models/Usuario.php';
                            $modeloUsuario = new Usuario($conn);
                            $datosUsuario = $modeloUsuario->obtenerPorId($_SESSION['usuario_id']);
                            $avatar_url = BASE_URL . 'assets/img/usuario.png';
                            if (!empty($datosUsuario['avatar'])) {
                                if (strpos($datosUsuario['avatar'], 'http') === 0) {
                                    // Si es una URL de Cloudinary
                                    $avatar_url = $datosUsuario['avatar'];
                                } else {
                                    // Si es una ruta local del antiguo sistema
                                    $avatar_path = ROOT_PATH . '/' . $datosUsuario['avatar'];
                                    if (file_exists($avatar_path)) {
                                        $avatar_url = BASE_URL . $datosUsuario['avatar'];
                                    }
                                }
                            }
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>views/anyadirJuego.php">Añadir Juego</a>
                            </li>
                            
                            <li class="nav-item d-block d-lg-none">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>views/perfil.php">
                                    <img src="<?php echo $avatar_url; ?>" alt="Avatar" class="rounded-circle me-2 avatarCabecera">
                                    Mi Perfil
                                </a>
                            </li>
                            <li class="nav-item d-block d-lg-none">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>controllers/logout.php">Cerrar sesión</a>
                            </li>
                            
                            <li class="nav-item dropdown d-none d-lg-block">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php echo $avatar_url; ?>" alt="Avatar" class="rounded-circle me-2 avatarCabecera">
                                    <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>views/perfil.php">Mi Perfil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>controllers/logout.php">Cerrar sesión</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>views/login.php">Iniciar sesión</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>views/registro.php">Registrarse</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container py-4">
