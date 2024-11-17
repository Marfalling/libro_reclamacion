<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica si el usuario está autenticado
if (!isset($_SESSION['autentificado']) || $_SESSION['autentificado'] !== TRUE) {
    // Si no está autenticado, redirige al login
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sidebar Mejorado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        #sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #343a40 0%, #495057 100%);
            color: #fff;
            position: fixed;
            transition: width 0.3s;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        #sidebar .nav-link {
            color: #adb5bd;
            transition: color 0.3s ease, background 0.3s ease;
        }
        #sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        #sidebar .sb-sidenav-menu-heading {
            font-size: 0.9rem;
            color: #ced4da;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .nav-item {
            position: relative;
        }
        .nav-item .badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav id="sidebar" class="flex-shrink-0 p-4">
            <h4 class="text-light">ADMINISTRADOR</h4>
            <hr class="bg-secondary">
            <div class="nav flex-column">
                <div class="sb-sidenav-menu-heading">Gestión de Reclamos</div>

                <!-- Ventas -->
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#listaReclamos" aria-expanded="false">
                    <i class="fas mr-2"></i> Reclamos
                    <i class="fas fa-angle-down float-right"></i>
                </a>
                <div class="collapse" id="listaReclamos">
                    <nav class="nav flex-column ml-3">
                        <a class="nav-link" href="vistas/panel_admin.php">Listado</a>

                    </nav>
                </div>
            </div>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>