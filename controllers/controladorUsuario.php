<?php
require_once dirname(__DIR__) . '/models/Usuario.php';

class ControladorUsuario {
    private $modelo;
    
    public function __construct() {
        global $conn;
        $this->modelo = new Usuario($conn);
    }
    
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreUsuario = sanitizar($_POST['nombre_usuario']);
            $correo = sanitizar($_POST['correo']);
            $password = sanitizar($_POST['password']);
            $confirmarPassword = sanitizar($_POST['confirmar_password']);
            
            if (empty($nombreUsuario) || empty($correo) || empty($password)) {
                return ['error' => 'Todos los campos son obligatorios'];
            }
            
            if ($password !== $confirmarPassword) {
                return ['error' => 'Las contraseñas no coinciden'];
            }
            
            if (strlen($password) < 6) {
                return ['error' => 'La contraseña debe tener al menos 6 caracteres'];
            }
            
            $resultado = $this->modelo->registrar($nombreUsuario, $correo, $password);
            
            if (is_array($resultado) && isset($resultado['error'])) {
                switch($resultado['error']) {
                    case 'duplicado_nombre':
                        return ['error' => 'El nombre de usuario ya está en uso'];
                    case 'duplicado_correo':
                        return ['error' => 'El correo electrónico ya está registrado'];
                    default:
                        return ['error' => 'Error al crear la cuenta. Inténtalo de nuevo más tarde'];
                }
            } else if (is_numeric($resultado)) {
                $_SESSION['usuario_id'] = $resultado;
                $_SESSION['nombre_usuario'] = $nombreUsuario;
                
                return [
                    'exito' => 'Registro exitoso', 
                    'redirigir' => BASE_URL . 'index.php',
                    'toast_message' => '¡Bienvenido a Mi Biblioteca de Juegos! Tu cuenta ha sido creada correctamente.',
                    'toast_type' => 'success'
                ];
            } else {
                return ['error' => 'Error desconocido al crear la cuenta'];
            }
        }
        
        return [];
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreUsuario = sanitizar($_POST['nombre_usuario']);
            $password = $_POST['password'];
            
            if (empty($nombreUsuario) || empty($password)) {
                return ['error' => 'Todos los campos son obligatorios'];
            }
            
            $usuario = $this->modelo->login($nombreUsuario, $password);
            
            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                
                return [
                    'exito' => 'Inicio de sesión exitoso', 
                    'redirigir' => BASE_URL . 'index.php',
                    'toast_message' => '¡Bienvenido de nuevo, ' . $usuario['nombre_usuario'] . '!',
                    'toast_type' => 'success'
                ];
            } else {
                return ['error' => 'Nombre de usuario o contraseña incorrectos'];
            }
        }
        
        return [];
    }
    
    public function logout() {
        session_unset();
        session_destroy();
        
        return [
            'exito' => 'Sesión cerrada correctamente', 
            'redirigir' => BASE_URL . 'index.php',
            'toast_message' => '¡Has cerrado sesión correctamente!',
            'toast_type' => 'info'
        ];
    }
    
    public function obtenerUsuarioActual() {
        if (isset($_SESSION['usuario_id'])) {
            return $this->modelo->obtenerPorId($_SESSION['usuario_id']);
        }
        
        return false;
    }
    
    public function actualizarAvatar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
            if (!estaLogueado()) {
                return ['error' => 'Debes iniciar sesión para cambiar tu avatar'];
            }
            
            $idUsuario = $_SESSION['usuario_id'];
            $usuario = $this->modelo->obtenerPorId($idUsuario);
            
            if ($_FILES['avatar']['error'] !== 0) {
                return ['error' => 'Error al subir la imagen'];
            }
            
            $tipos_permitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($_FILES['avatar']['type'], $tipos_permitidos)) {
                return ['error' => 'Formato de archivo no permitido. Se permiten: JPG, PNG, GIF, WEBP'];
            }
            
            if ($_FILES['avatar']['size'] > 1048576) {
                return ['error' => 'La imagen no debe superar 1MB'];
            }
            
            $rutaAvatares = RUTA_AVATARES;
            if (!file_exists($rutaAvatares)) {
                mkdir($rutaAvatares, 0777, true);
            }
            
            $nombreArchivo = uniqid() . '_' . basename($_FILES['avatar']['name']);
            $rutaDestino = $rutaAvatares . $nombreArchivo;
            $rutaRelativa = DIR_AVATARES . $nombreArchivo;
            
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $rutaDestino)) {
                if (!empty($usuario['avatar']) && $usuario['avatar'] !== 'assets/img/usuario.png') {
                    $rutaAnterior = ROOT_PATH . $usuario['avatar'];
                    if (file_exists($rutaAnterior)) {
                        unlink($rutaAnterior);
                    }
                }
                $resultado = $this->modelo->actualizarAvatar($idUsuario, $rutaRelativa);
                
                if ($resultado) {
                    redirigir(BASE_URL . 'views/perfil.php', 
                        '¡Tu avatar ha sido actualizado correctamente!', 
                        'success');
                    exit;
                } else {
                    return ['error' => 'Error al actualizar el avatar en la base de datos'];
                }
            } else {
                return ['error' => 'Error al guardar la imagen'];
            }
        }
        
        return [];
    }

    public function editarPerfil() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return [];
        }
        
        $usuarioActual = $this->obtenerUsuarioActual();
        $idUsuario = $usuarioActual['id'];

        $nombreUsuario = sanitizar($_POST['nombre_usuario']);
        if (empty($nombreUsuario)) {
            return ['error' => 'El nombre de usuario no puede estar vacío.'];
        }
        
        if ($nombreUsuario !== $usuarioActual['nombre_usuario']) {
            if (!$this->modelo->actualizarNombreUsuario($idUsuario, $nombreUsuario)) {
                return ['error' => 'Error al actualizar el nombre de usuario o ya está en uso.'];
            }
        }
        
        $correo = sanitizar($_POST['correo']);
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'El formato del correo electrónico no es válido.'];
        }
        
        if ($correo !== $usuarioActual['correo_electronico']) {
            if (!$this->modelo->actualizarEmail($idUsuario, $correo)) {
                return ['error' => 'Error al actualizar el correo o ya está en uso.'];
            }
        }

        $passwordActual = sanitizar($_POST['current_password']);
        $nuevoPassword = sanitizar($_POST['new_password']);
        $confirmarNuevoPassword = sanitizar($_POST['confirm_new_password']);

        if (!empty($passwordActual) || !empty($nuevoPassword) || !empty($confirmarNuevoPassword)) {
            if (empty($passwordActual) || empty($nuevoPassword) || empty($confirmarNuevoPassword)) {
                return ['error' => 'Para cambiar la contraseña, debes rellenar los campos: actual, nueva y confirmación.'];
            }
            
            if (strlen($nuevoPassword) < 6) {
                return ['error' => 'La nueva contraseña debe tener al menos 6 caracteres.'];
            }
            
            if ($nuevoPassword !== $confirmarNuevoPassword) {
                return ['error' => 'La nueva contraseña y su confirmación no coinciden.'];
            }
            
            if (!$this->modelo->actualizarPassword($idUsuario, $passwordActual, $nuevoPassword)) {
                return ['error' => 'Error al actualizar la contraseña. Verifica que la contraseña actual sea correcta.'];
            }
        }
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
            $archivoAvatar = $_FILES['avatar'];
            
            $tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $tamanoMaximo = 1048576;

            if (!in_array($archivoAvatar['type'], $tiposPermitidos)) {
                return ['error' => 'Formato de avatar no permitido. Se permiten: JPG, PNG, GIF, WEBP.'];
            }
            
            if ($archivoAvatar['size'] > $tamanoMaximo) {
                return ['error' => 'La imagen del avatar no debe superar 1MB.'];
            }

            // Subir avatar a Cloudinary
            $avatarUrl = subirImagen($archivoAvatar, 'avatares');
            
            if ($avatarUrl) {
                // Actualizar en BD
                if (!$this->modelo->actualizarAvatar($idUsuario, $avatarUrl)) {
                    return ['error' => 'Error al guardar la URL del avatar en la base de datos.'];
                }
            } else {
                return ['error' => 'Error al subir el avatar a Cloudinary.'];
            }
        }

        return [
            'exito' => 'Perfil actualizado correctamente',
            'redirigir' => BASE_URL . 'views/perfil.php',
            'toast_message' => 'Perfil actualizado correctamente',
            'toast_type' => 'success'
        ];
    }
}
?>
