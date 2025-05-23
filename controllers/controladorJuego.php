<?php
require_once dirname(__DIR__) . '/config/configuracion.php';
require_once dirname(__DIR__) . '/models/Juego.php';

class ControladorJuego {
    private $modelo;
    
    public function __construct() {
        global $conn;
        $this->modelo = new Juego($conn);
        
        $this->verificarCarpetaCaratulas();
    }
    
    private function verificarCarpetaCaratulas() {
        if (!file_exists(RUTA_CARATULAS)) {
            mkdir(RUTA_CARATULAS, 0777, true);
            
            $index_content = '<!DOCTYPE html><html><head><title>Acceso Denegado</title></head><body><h1>Acceso Denegado</h1><p>No tienes permiso para ver el contenido de este directorio.</p></body></html>';
            file_put_contents(RUTA_CARATULAS . 'index.html', $index_content);
        }
    }
    
    public function anyadir() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!estaLogueado()) {
                return ['error' => 'Debes iniciar sesión para añadir juegos', 'redirigir' => BASE_URL . 'views/login.php'];
            }
            
            $tituloJuego = sanitizar($_POST['titulo']);
            $fechaInicio = sanitizar($_POST['fecha_inicio']);
            $fechaFin = sanitizar($_POST['fecha_fin']);
            $horasJugadas = (int)sanitizar($_POST['horas_jugadas']);
            $plataforma = sanitizar($_POST['plataforma']);
            $puntuacion = sanitizar($_POST['puntuacion']);
            $resenia = sanitizar($_POST['resenya']);
            $idUsuario = $_SESSION['usuario_id'];
            
            if (empty($tituloJuego) || empty($fechaInicio) || empty($fechaFin) || empty($horasJugadas) || empty($plataforma) || empty($puntuacion) || empty($resenia)) {
                return ['error' => 'Todos los campos son obligatorios'];
            }
            
            if ($puntuacion < 1 || $puntuacion > 10) {
                return ['error' => 'La puntuación debe estar entre 1 y 10.'];
            }
            
            $fechaHoy = date('Y-m-d');
            if ($fechaInicio > $fechaHoy) {
                return ['error' => 'La fecha de inicio no puede ser posterior a hoy.'];
            }

            if ($fechaFin > $fechaHoy) {
                return ['error' => 'La fecha de finalización no puede ser posterior a hoy.'];
            }

            $caratula = null;
            
            if (isset($_FILES['caratula']) && $_FILES['caratula']['error'] === 0) {
                $caratulaUrl = subirImagen($_FILES['caratula'], 'caratulas');
                if (!$caratulaUrl) {
                    return ['error' => 'Error al subir la carátula a Cloudinary'];
                }
                
                $caratula = $caratulaUrl;
            }
            
            $resultado = $this->modelo->anyadir($tituloJuego, $fechaInicio, $fechaFin, $horasJugadas, $plataforma, $caratula, $puntuacion, $resenia, $idUsuario);
            
            if ($resultado) {
                return [
                    'exito' => 'Juego añadido correctamente', 
                    'redirigir' => BASE_URL . 'views/perfil.php',
                    'toast_message' => "¡El juego \"$tituloJuego\" ha sido añadido a tu biblioteca!",
                    'toast_type' => 'success'
                ];
            } else {
                return ['error' => 'Error al añadir el juego'];
            }
        }
        
        return [];
    }
    
    public function editar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!estaLogueado()) {
                return ['error' => 'Debes iniciar sesión para editar juegos', 'redirigir' => BASE_URL . 'views/login.php'];
            }
            
            $juegoActual = $this->modelo->obtenerPorId($id);
            
            if (!$juegoActual || $juegoActual['id_usuario'] != $_SESSION['usuario_id']) {
                return ['error' => 'No tienes permiso para editar este juego', 'redirigir' => BASE_URL . 'views/perfil.php'];
            }
            
            $titulo = sanitizar($_POST['titulo']);
            $fechaInicio = sanitizar($_POST['fecha_inicio']);
            $fechaFin = sanitizar($_POST['fecha_fin']);
            $horasJugadas = (int)sanitizar($_POST['horas_jugadas']);
            $plataforma = sanitizar($_POST['plataforma']);
            $puntuacion = sanitizar($_POST['puntuacion']);
            $resenia = sanitizar($_POST['resenya']);

            $sinCambios = (
                $titulo === $juegoActual['titulo'] &&
                $fechaInicio === $juegoActual['fecha_inicio'] &&
                $fechaFin === $juegoActual['fecha_fin'] &&
                $horasJugadas == $juegoActual['horas_jugadas'] &&
                $plataforma === $juegoActual['plataforma'] &&
                $puntuacion == $juegoActual['puntuacion'] &&
                $resenia === $juegoActual['resenya'] &&
                (!isset($_FILES['caratula']) || $_FILES['caratula']['error'] !== 0)
            );

            if ($sinCambios) {
                return [
                    'error' => 'No has realizado ningún cambio en el juego'
                ];
            }
            
            if (empty($titulo) || empty($fechaInicio) || empty($fechaFin) || empty($horasJugadas) || empty($plataforma) || empty($puntuacion) || empty($resenia)) {
                return ['error' => 'Todos los campos son obligatorios'];
            }
            
            if ($puntuacion < 1 || $puntuacion > 10) {
                return ['error' => 'La puntuación debe estar entre 1 y 10'];
            }

            $fechaHoy = date('Y-m-d');
            if ($fechaInicio > $fechaHoy) {
                return ['error' => 'La fecha de inicio no puede ser posterior a hoy.'];
            }

            if ($fechaFin > $fechaHoy) {
                return ['error' => 'La fecha de finalización no puede ser posterior a hoy.'];
            }

            $caratula = $juegoActual['caratula'];
            
            if (isset($_FILES['caratula']) && $_FILES['caratula']['error'] === 0) {
                $caratulaUrl = subirImagen($_FILES['caratula'], 'caratulas');
                if (!$caratulaUrl) {
                    return ['error' => 'Error al subir la carátula a Cloudinary'];
                }
                
                $caratula = $caratulaUrl;
            }
            
            $resultado = $this->modelo->editar($id, $titulo, $fechaInicio, $fechaFin, $horasJugadas, $plataforma, $caratula, $puntuacion, $resenia);
            
            if ($resultado) {
                return [
                    'exito' => 'Juego actualizado correctamente',
                    'toast_message' => "¡El juego \"$titulo\" ha sido actualizado correctamente!",
                    'toast_type' => 'success'
                ];
            } else {
                return ['error' => 'Error al actualizar el juego'];
            }
        }
        
        return [];
    }
    
    public function obtenerJuego($id) {
        return $this->modelo->obtenerPorId($id);
    }
    
    public function obtenerJuegosUsuario() {
        if (estaLogueado()) {
            return $this->modelo->obtenerPorUsuario($_SESSION['usuario_id']);
        }
        
        return [];
    }
    
    public function eliminar($id) {
        if (!estaLogueado()) {
            return ['error' => 'Debes iniciar sesión para eliminar juegos'];
        }
        
        $juego = $this->modelo->obtenerPorId($id);
        
        if (!$juego) {
            return [
                'error' => 'El juego no existe',
                'redirigir' => BASE_URL . 'views/perfil.php',
                'toast_message' => 'El juego que intentas eliminar no existe',
                'toast_type' => 'error'
            ];
        }
        
        $tituloJuego = $juego['titulo'];
        
        // Borrar solo para archivos locales, las imágenes de Cloudinary se quedan en la nube
        if ($juego && !empty($juego['caratula']) && strpos($juego['caratula'], 'http') !== 0) {
            $rutaFisica = ROOT_PATH . $juego['caratula'];
            if (file_exists($rutaFisica)) {
                unlink($rutaFisica);
            }
        }
        
        $resultado = $this->modelo->eliminar($id, $_SESSION['usuario_id']);
        
        if ($resultado) {
            return [
                'exito' => 'Juego eliminado correctamente',
                'redirigir' => BASE_URL . 'views/perfil.php',
                'toast_message' => "El juego \"$tituloJuego\" ha sido eliminado de tu biblioteca",
                'toast_type' => 'info'
            ];
        } else {
            return [
                'error' => 'Error al eliminar el juego o no tienes permiso',
                'redirigir' => BASE_URL . 'views/perfil.php',
                'toast_message' => 'No se pudo eliminar el juego',
                'toast_type' => 'error'
            ];
        }
    }
}
?>
