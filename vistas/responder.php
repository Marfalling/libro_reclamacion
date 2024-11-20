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

require_once('../modelo/conexion.php');

// Obtener ID del reclamo
$id_reclamo = filter_input(INPUT_GET, 'id_reclamo', FILTER_VALIDATE_INT);

if (!$id_reclamo) {
    die("<div class='alert alert-danger'>ID de reclamo no válido.</div>");
}

try {
    // Preparar consulta con prepared statement
    $stmt = $con->prepare("
        SELECT 
            id_reclamacion, 
            id_usuario, 
            tipo_bien, 
            monto_reclamado, 
            descripcion, 
            tipo_reclamo, 
            fecha_reclamo, 
            estado, 
            respuesta 
        FROM reclamaciones 
        WHERE id_reclamacion = ?
    ");
    $stmt->bind_param("i", $id_reclamo);
    $stmt->execute();
    $result = $stmt->get_result();
    $reclamo = $result->fetch_assoc();

    if (!$reclamo) {
        throw new Exception("Reclamo no encontrado");
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    die("<div class='alert alert-danger'>Error al recuperar el reclamo.</div>");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responder Reclamo #<?= $reclamo['id_reclamacion'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid #007bff;
        }
        .detail-label {
            font-weight: bold;
            color: #495057;
        }
    </style>
</head>
<body>
    <?php require("../MenuV.php"); ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <h3 class="mb-0">Responder Reclamo #<?= $reclamo['id_reclamacion'] ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="detail-label">Fecha del Reclamo:</p>
                                <p><?= htmlspecialchars($reclamo['fecha_reclamo']) ?></p>
                                
                                <p class="detail-label">Tipo de Bien:</p>
                                <p><?= htmlspecialchars($reclamo['tipo_bien']) ?></p>
                                
                                <p class="detail-label">Monto Reclamado:</p>
                                <p>S/.<?= number_format($reclamo['monto_reclamado'], 2) ?></p>
                            </div>
                            
                            <div class="col-md-6">
                                <p class="detail-label">Tipo de Reclamo:</p>
                                <p><?= htmlspecialchars($reclamo['tipo_reclamo']) ?></p>
                                
                                <p class="detail-label">Estado Actual:</p>
                                <p class="badge bg-<?= $reclamo['estado'] == 'Pendiente' ? 'warning' : 'success' ?>">
                                    <?= htmlspecialchars($reclamo['estado']) ?>
                                </p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="detail-label">Descripción del Reclamo:</p>
                            <div class="card bg-light p-3">
                                <?= htmlspecialchars($reclamo['descripcion']) ?>
                            </div>
                        </div>

                        <?php if ($reclamo['respuesta']): ?>
                            <div class="alert alert-info mb-4">
                                <strong>Respuesta Anterior:</strong>
                                <?= htmlspecialchars($reclamo['respuesta']) ?>
                            </div>
                        <?php endif; ?>

                        <form action="../controlador/enviar_respuesta.php" method="post">
                            <div class="form-group mb-3">
                                <label for="respuesta" class="form-label">Nueva Respuesta:</label>
                                <textarea 
                                    class="form-control" 
                                    name="respuesta" 
                                    id="respuesta" 
                                    rows="3" 
                                    placeholder="Escriba su respuesta detallada aquí"
                                    required
                                ></textarea>
                            </div>
                            
                            <input type="hidden" name="id_reclamo" value="<?= $reclamo['id_reclamacion'] ?>">
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-send"></i> Enviar Respuesta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>