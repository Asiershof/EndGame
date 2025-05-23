<?php
class Usuario {
    private $conexion;
    
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    
    public function registrar($nombreUsuario, $correo, $password) {
        $stmt_check = $this->conexion->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ? OR correo_electronico = ?");
        $stmt_check->bind_param("ss", $nombreUsuario, $correo);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt_detail = $this->conexion->prepare("SELECT nombre_usuario, correo_electronico FROM usuarios WHERE id = ?");
            $stmt_detail->bind_param("i", $row['id']);
            $stmt_detail->execute();
            $detail = $stmt_detail->get_result()->fetch_assoc();
            
            if ($detail['nombre_usuario'] === $nombreUsuario) {
                return ['error' => 'duplicado_nombre'];
            } else {
                return ['error' => 'duplicado_correo'];
            }
        }
        
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->conexion->prepare("INSERT INTO usuarios (nombre_usuario, correo_electronico, contrasenya) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombreUsuario, $correo, $passwordHash);
        
        if ($stmt->execute()) {
            return $this->conexion->insert_id;
        }
        
        return ['error' => 'error_bd'];
    }
    
    public function login($nombreUsuario, $password) {
        $stmt = $this->conexion->prepare("SELECT id, nombre_usuario, contrasenya FROM usuarios WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $nombreUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            
            if (password_verify($password, $usuario['contrasenya'])) {
                return $usuario;
            }
        }
        
        return false;
    }
    
    public function actualizarAvatar($idUsuario, $rutaAvatar) {
        $stmt = $this->conexion->prepare("UPDATE usuarios SET avatar = ? WHERE id = ?");
        $stmt->bind_param("si", $rutaAvatar, $idUsuario);
        
        return $stmt->execute() && $stmt->affected_rows > 0;
    }
    
    public function obtenerPorId($id) {
        $stmt = $this->conexion->prepare("SELECT id, nombre_usuario, correo_electronico, fecha_registro, avatar FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }
        
        return false;
    }

    public function actualizarEmail($id, $nuevoCorreo) {
        $stmt_check = $this->conexion->prepare("SELECT id FROM usuarios WHERE correo_electronico = ? AND id != ?");
        $stmt_check->bind_param("si", $nuevoCorreo, $id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            return false;
        }

        $stmt = $this->conexion->prepare("UPDATE usuarios SET correo_electronico = ? WHERE id = ?");
        $stmt->bind_param("si", $nuevoCorreo, $id);
        return $stmt->execute();
    }

    public function actualizarPassword($id, $passwordActual, $nuevoPassword) {
        $stmt_get = $this->conexion->prepare("SELECT contrasenya FROM usuarios WHERE id = ?");
        $stmt_get->bind_param("i", $id);
        $stmt_get->execute();
        $result_get = $stmt_get->get_result();
        
        if ($result_get->num_rows === 1) {
            $usuario = $result_get->fetch_assoc();
            if (password_verify($passwordActual, $usuario['contrasenya'])) {
                $nuevoPasswordHash = password_hash($nuevoPassword, PASSWORD_DEFAULT);
                $stmt_update = $this->conexion->prepare("UPDATE usuarios SET contrasenya = ? WHERE id = ?");
                $stmt_update->bind_param("si", $nuevoPasswordHash, $id);
                return $stmt_update->execute();
            }
        }
        return false;
    }

    public function actualizarNombreUsuario($id, $nuevoNombre) {
        $stmt_check = $this->conexion->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ? AND id != ?");
        $stmt_check->bind_param("si", $nuevoNombre, $id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            return false;
        }

        $stmt = $this->conexion->prepare("UPDATE usuarios SET nombre_usuario = ? WHERE id = ?");
        $stmt->bind_param("si", $nuevoNombre, $id);
        $result = $stmt->execute();
        
        if ($result) {
            $_SESSION['nombre_usuario'] = $nuevoNombre;
        }
        
        return $result;
    }

    public function actualizarPerfil($idUsuario, $nombreUsuario, $correo, $rutaAvatar = null) {
        if ($rutaAvatar !== null) {
            $sql = "UPDATE usuarios SET nombre_usuario = ?, correo_electronico = ?, avatar = ? WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sssi", $nombreUsuario, $correo, $rutaAvatar, $idUsuario);
        } else {
            $sql = "UPDATE usuarios SET nombre_usuario = ?, correo_electronico = ? WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ssi", $nombreUsuario, $correo, $idUsuario);
        }
        
        return $stmt->execute();
    }
}
?>
