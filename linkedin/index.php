<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
$user_name = $is_logged_in ? htmlspecialchars($_SESSION['user_nombre']) : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobConnect - Portal de Empleos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="llamados.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        .job-card { transition: all 0.2s ease-in-out; }
        .job-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); }
        .navbar-shadow { box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-white navbar-shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="md:hidden flex items-center order-1">
                    <button id="menu-toggle" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 justify-center md:justify-start items-center order-2">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-blue-800">JobConnect</h1>
                    </div>
                </div>
                <div id="nav-links" class="hidden md:block order-3">
                    <div class="ml-10 flex flex-col md:flex-row items-baseline space-y-2 md:space-y-0 md:space-x-8 bg-white md:bg-transparent absolute md:static top-16 left-0 w-full md:w-auto shadow md:shadow-none p-4 md:p-0 z-40">
                        <a href="index.php" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium border-b-2 border-blue-600">Empleos</a>
                        <?php if ($is_logged_in): ?>
                            <a href="perfil.php" class="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium">Perfil</a>
                        <?php else: ?>
                            <a href="login.html" class="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium">Login</a>
                            <a href="registro.html" class="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium">Registro</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if ($is_logged_in): ?>
                        <a href="perfil.php" class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium"><?php echo htmlspecialchars(substr($user_name, 0, 1)); ?></span>
                        </a>
                    <?php else: ?>
                        <div class="w-8 h-8 bg-gray-400 rounded-full"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Empleos recomendados para ti</h2>
            <p class="text-gray-600">Basado en tu perfil y actividad reciente</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Ofertas disponibles</h3>
                    <p class="text-gray-600">Actualizado hace unos minutos</p>
                </div>
                <div class="text-right">
                    <div id="empleos-activos" class="text-3xl font-bold text-blue-600"></div>
                    <p class="text-sm text-gray-500">empleos activos</p>
                </div>
            </div>
        </div>
        <div id="container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
    </main>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menu-toggle');
        const navLinks = document.getElementById('nav-links');
        menuToggle.addEventListener('click', function() {
            navLinks.classList.toggle('hidden');
        });
    });
    </script>
</body>
</html>