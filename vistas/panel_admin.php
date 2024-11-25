<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica si el usuario está autenticado
if (!isset($_SESSION['autentificado']) || $_SESSION['autentificado'] !== TRUE) {
    header('Location: login.php');
    exit();
}

// Conexión a la base de datos
include('../modelo/conexion.php');

// Variables de paginación
$limite = 10; // Número de reclamos por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $limite;

// Variables para el filtrado
$fechaDesde = isset($_GET['fecha_desde']) ? $_GET['fecha_desde'] : null;
$fechaHasta = isset($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : null;

// Construir la consulta base
$sql = "SELECT SQL_CALC_FOUND_ROWS id_reclamacion, id_usuario, fecha_reclamo, hora_reclamo, estado, respuesta, fecha_respuesta 
        FROM reclamaciones";

// Condiciones del filtro por fechas
$conditions = [];
if ($fechaDesde) {
    $conditions[] = "fecha_reclamo >= '$fechaDesde'";
}
if ($fechaHasta) {
    $conditions[] = "fecha_reclamo <= '$fechaHasta'";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Agregar paginación
$sql .= " ORDER BY  id_reclamacion DESC LIMIT $inicio, $limite";

// Ejecutar la consulta
$result = mysqli_query($con, $sql);

// Obtener el total de registros
$totalQuery = mysqli_query($con, "SELECT FOUND_ROWS() AS total");
$totalRow = mysqli_fetch_assoc($totalQuery);
$totalRegistros = $totalRow['total'];

// Calcular el número total de páginas
$totalPaginas = ceil($totalRegistros / $limite);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Reclamos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <?php 
    require("../MenuV.php"); // Sidebar fijo 
    ?>

    <div class="container mt-4">
        <!-- Filtros -->
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <form method="GET" action="../controlador/reclamo_listar.php" id="filterForm">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label>Fecha Desde:</label>
                            <input type="date" name="fecha_desde" id="fecha_desde" value="<?= htmlspecialchars($fechaDesde) ?>" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Fecha Hasta:</label>
                            <input type="date" name="fecha_hasta" id="fecha_hasta" value="<?= htmlspecialchars($fechaHasta) ?>" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-secondary btn-block" onclick="limpiarFiltros()">Limpiar</button>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
        function limpiarFiltros() {
            // Limpiar los campos de fecha
            document.getElementById('fecha_desde').value = '';
            document.getElementById('fecha_hasta').value = '';
            
            // Enviar el formulario para recargar sin filtros
            document.getElementById('filterForm').submit();
        }
        </script>

        <!-- Tabla de reclamos -->
        <div class="card shadow-lg text-center mb-4">
            <div class="card-header">
                <h4>LISTADO DE RECLAMOS</h4>
            </div>
            <div class="card-body">
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-bordered table-striped'>";
                    echo "<thead class='thead-dark'>
                            <tr>
                                <th>ID Reclamo</th>
                                <th>ID Usuario</th>
                                <th>Fecha Reclamo</th>
                                <th>Hora Reclamo</th>
                                <th>Estado</th>
                                <th>Respuesta</th>
                                <th>Fecha Respuesta</th>
                                <th>Ver PDF</th>
                                <th>Responder</th>
                            </tr>
                          </thead>
                          <tbody>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        // Normalizar el estado
                        $estado = strtolower(trim($row['estado']));
                        switch ($estado) {
                            case 'pendiente':
                                $badgeClass = 'badge-warning';
                                break;
                            case 'respondido':
                                $badgeClass = 'badge-success';
                                break;
                            default:
                                $badgeClass = 'badge-secondary';
                                break;
                        }

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id_reclamacion']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['id_usuario']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['fecha_reclamo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['hora_reclamo']) . "</td>";
                        echo "<td><span class='badge $badgeClass'>" . ucfirst($estado) . "</span></td>";
                        echo "<td>" . ($row['respuesta'] ? htmlspecialchars($row['respuesta']) : 'Sin respuesta') . "</td>";
                        echo "<td>" . ($row['fecha_respuesta'] ? htmlspecialchars($row['fecha_respuesta']) : 'Pendiente') . "</td>";
                        echo "<td><a href='../reclamo_pdf.php?id_usuario=" . htmlspecialchars($row['id_usuario']) . "' class='btn btn-info btn-sm' target='_blank'>Ver PDF</a></td>";
                        echo "<td><a href='../vistas/responder.php?id_reclamo=" . htmlspecialchars($row['id_reclamacion']) . "' class='btn btn-primary btn-sm'>Responder</a></td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-warning' role='alert'>No se encontraron reclamos.</div>";
                }
                ?>
            </div>
        </div>

        
        <!-- Paginación -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($pagina > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=1&fecha_desde=<?= $fechaDesde ?>&fecha_hasta=<?= $fechaHasta ?>" aria-label="Primera página">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?= $pagina - 1 ?>&fecha_desde=<?= $fechaDesde ?>&fecha_hasta=<?= $fechaHasta ?>" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;&laquo;</span>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                <?php endif; ?>

                <?php
                // Mostrar un número limitado de páginas alrededor de la página actual
                $rango = 2;
                $inicio_rango = max(1, $pagina - $rango);
                $fin_rango = min($totalPaginas, $pagina + $rango);

                for ($i = $inicio_rango; $i <= $fin_rango; $i++): 
                ?>
                    <li class="page-item <?= ($i === $pagina) ? 'active' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $i ?>&fecha_desde=<?= $fechaDesde ?>&fecha_hasta=<?= $fechaHasta ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($pagina < $totalPaginas): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?= $pagina + 1 ?>&fecha_desde=<?= $fechaDesde ?>&fecha_hasta=<?= $fechaHasta ?>" aria-label="Siguiente">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?= $totalPaginas ?>&fecha_desde=<?= $fechaDesde ?>&fecha_hasta=<?= $fechaHasta ?>" aria-label="Última página">
                            <span aria-hidden="true">&raquo;&raquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;&raquo;</span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</body>
</html>