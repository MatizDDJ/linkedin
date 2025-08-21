<?php
// modelo/UsuarioModel.php
require_once 'Conexion.php';
class UsuarioModel {
    private $conn;
    public function __construct() {
        $this->conn = connection();
    }
    public function registrarUsuario($nombre, $email, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $email, $hashed_password);
        return $stmt->execute();
    }
    public function obtenerUsuarioPorEmail($email) {
        $sql = "SELECT id, nombre, email, password FROM usuarios WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>