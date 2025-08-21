<?php
// routes/usuario.php
require_once '../controller/UsuarioController.php';
$controller = new UsuarioController();
$controller->handleRequest();
?>