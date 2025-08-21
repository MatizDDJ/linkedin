<?php
// modelo/PostulacionModel.php
require_once 'Conexion.php';
class PostulacionModel {
    private $conn;
    public function __construct() {
        $this->conn = connection();
    }
    public function crearPostulacion($usuario_id, $llamado_id) {
        $sql = "INSERT INTO postulaciones (usuario_id, llamado_id, fecha_postulacion) VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $usuario_id, $llamado_id);
        return $stmt->execute();
    }
    // Consulta con INNER JOIN
    public function obtenerPostulacionesPorUsuario($usuario_id) {
        $sql = "SELECT l.titulo, l.descripcion, p.fecha_postulacion 
                FROM postulaciones p
                INNER JOIN llamados l ON p.llamado_id = l.id
                WHERE p.usuario_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $postulaciones = [];
        while ($row = $result->fetch_assoc()) {
            $postulaciones[] = $row;
        }
        return $postulaciones;
    }
}
?>