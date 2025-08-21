<?php
// routes/postulacion.php
require_once '../modelo/PostulacionModel.php';
session_start();
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Usuario no autenticado.']);
        exit();
    }
    $data = json_decode(file_get_contents('php://input'), true);
    $llamadoId = $data['llamado_id'];
    $usuarioId = $_SESSION['user_id'];
    $model = new PostulacionModel();
    if ($model->crearPostulacion($usuarioId, $llamadoId)) {
        echo json_encode(['message' => 'Postulación exitosa.']);
    } else {
        echo json_encode(['error' => 'Error al postular.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido.']);
}
?>