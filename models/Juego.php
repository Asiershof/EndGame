<?php
class Juego {
    private $conexion;
    
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    
    public function anyadir($titulo, $fechaInicio, $fechaFin, $horasJugadas, $plataforma, $caratula, $puntuacion, $resenya, $idUsuario) {
        $stmt = $this->conexion->prepare("INSERT INTO videojuegos (titulo, fecha_inicio, fecha_fin, horas_jugadas, plataforma, caratula, puntuacion, resenya, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (empty($caratula)) {
            $valorNulo = null;
            $stmt->bind_param("sssdssisi", $titulo, $fechaInicio, $fechaFin, $horasJugadas, $plataforma, $valorNulo, $puntuacion, $resenya, $idUsuario);
        } else {
            $stmt->bind_param("sssdssisi", $titulo, $fechaInicio, $fechaFin, $horasJugadas, $plataforma, $caratula, $puntuacion, $resenya, $idUsuario);
        }
        
        if ($stmt->execute()) {
            return $this->conexion->insert_id;
        }
        
        return false;
    }
    
    public function editar($id, $titulo, $fechaInicio, $fechaFin, $horasJugadas, $plataforma, $caratula, $puntuacion, $resenya) {
        $stmt = $this->conexion->prepare("UPDATE videojuegos SET titulo = ?, fecha_inicio = ?, fecha_fin = ?, horas_jugadas = ?, plataforma = ?, caratula = ?, puntuacion = ?, resenya = ? WHERE id = ?");
        
        if (empty($caratula)) {
            $valorNulo = null;
            $stmt->bind_param("sssdssisi", $titulo, $fechaInicio, $fechaFin, $horasJugadas, $plataforma, $valorNulo, $puntuacion, $resenya, $id);
        } else {
            $stmt->bind_param("sssdssisi", $titulo, $fechaInicio, $fechaFin, $horasJugadas, $plataforma, $caratula, $puntuacion, $resenya, $id);
        }
        
        return $stmt->execute() && $stmt->affected_rows > 0;
    }
    
    public function obtenerPorUsuario($idUsuario) {
        $stmt = $this->conexion->prepare("SELECT * FROM videojuegos WHERE id_usuario = ? ORDER BY titulo ASC");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $juegos = [];
        while ($juego = $result->fetch_assoc()) {
            $juegos[] = $juego;
        }
        
        return $juegos;
    }
    
    public function obtenerPorId($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM videojuegos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }
        
        return false;
    }
    
    public function eliminar($id, $idUsuario) {
        $stmt = $this->conexion->prepare("DELETE FROM videojuegos WHERE id = ? AND id_usuario = ?");
        $stmt->bind_param("ii", $id, $idUsuario);
        
        return $stmt->execute() && $stmt->affected_rows > 0;
    }
}
?>
