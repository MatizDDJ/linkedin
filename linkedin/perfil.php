<?php
// perfil.php
require_once 'api/modelo/PostulacionModel.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$postulacionModel = new PostulacionModel();
$postulaciones = $postulacionModel->obtenerPostulacionesPorUsuario($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - JobConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Hola, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></h1>
        <p class="text-gray-600 mb-6">Este es tu historial de postulaciones.</p>

        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Llamados a los que te has postulado</h2>

        <?php if (empty($postulaciones)): ?>
            <p class="text-gray-500">Aún no te has postulado a ningún llamado.</p>
        <?php else: ?>
            <ul class="space-y-4">
                <?php foreach ($postulaciones as $postulacion): ?>
                    <li class="p-4 border border-gray-200 rounded-md">
                        <h3 class="text-lg font-medium text-blue-600"><?php echo htmlspecialchars($postulacion['titulo']); ?></h3>
                        <p class="text-sm text-gray-700"><?php echo htmlspecialchars($postulacion['descripcion']); ?></p>
                        <p class="text-xs text-gray-500 mt-2">Postulado el: <?php echo date("d/m/Y", strtotime($postulacion['fecha_postulacion'])); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="mt-8 flex justify-between items-center">
            <a href="index.php" class="text-blue-600 hover:underline">Volver a los llamados</a>
            <a href="api/routes/usuario.php?action=logout" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>