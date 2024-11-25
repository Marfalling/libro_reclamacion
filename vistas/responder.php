<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['autentificado']) || $_SESSION['autentificado'] !== TRUE) {
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
            respuesta, 
            fecha_respuesta
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Responder Reclamo #<?= $reclamo['id_reclamacion'] ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
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
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <button onclick="window.history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </button>
                            <h3 class="mb-0">Responder Reclamo #<?= $reclamo['id_reclamacion'] ?></h3>
                            
                            <div style="width: 85px"></div>
                        </div>
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
                                <?php 
                                    // Normaliza el estado para evitar problemas de formato
                                    $estado = strtolower(trim($reclamo['estado']));
                                    
                                    // Asigna clases según el estado
                                    switch ($estado) {
                                        case 'pendiente':
                                            $badgeClass = 'badge badge-warning';  // Amarillo
                                            break;
                                        case 'respondido':
                                            $badgeClass = 'badge badge-success';  // Verde
                                            break;
                                    }
                                ?>
                                <span class="badge badge-pill <?= $badgeClass ?>">
                                    <?= ucfirst($estado) ?>
                                </span>
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
                                <label for="respuesta">Nueva Respuesta:</label>
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
                                    Enviar Respuesta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
