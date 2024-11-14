<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Reclamos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="card shadow-lg text-center mb-4">
            <div class="card-header">
                <h4>LISTADO DE RECLAMOS</h4>
            </div>
            <div class="card-body">
                <?php
                    // Incluye la conexión a la base de datos
                    include('../modelo/conexion.php');

                    // Consulta para obtener los reclamos
                    $sql = "SELECT id_reclamacion, id_usuario, tipo_bien, monto_reclamado, descripcion, tipo_reclamo, detalle_reclamo, pedido, menor_edad, fecha_reclamo, estado, respuesta, fecha_respuesta FROM reclamaciones";
                    $result = mysqli_query($con, $sql);

                    // Verificar si la consulta fue exitosa
                    if ($result) {
                        // Verificar si hay datos
                        if (mysqli_num_rows($result) > 0) {
                            echo "<table class='table table-bordered table-striped'>";
                            echo "<thead class='thead-dark'>";
                            echo "<tr><th>ID Reclamo</th><th>Nombre Usuario</th><th>Fecha Reclamo</th><th>Estado</th><th>Respuesta</th><th>Fecha Respuesta</th><th>Ver PDF</th><th>Responder</th></tr>";
                            echo "</thead><tbody>";
                            
                            // Mostrar los datos
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id_reclamacion'] . "</td>";
                                echo "<td>" . $row['id_usuario'] . "</td>";
                                echo "<td>" . $row['fecha_reclamo'] . "</td>";
                                echo "<td>" . $row['estado'] . "</td>";
                                echo "<td>" . ($row['respuesta'] ? $row['respuesta'] : 'Sin respuesta') . "</td>"; // Muestra respuesta si existe
                                echo "<td>" . ($row['fecha_respuesta'] ? $row['fecha_respuesta'] : 'Pendiente') . "</td>"; // Muestra la fecha de respuesta o 'Pendiente'
                                echo "<td><a href='ver_pdf.php?id_reclamo=" . $row['id_reclamacion'] . "' class='btn btn-info btn-sm'>Ver PDF</a></td>";
                                echo "<td><a href='responder.php?id_reclamo=" . $row['id_reclamacion'] . "' class='btn btn-primary btn-sm'>Responder</a></td>";
                                echo "</tr>";
                            }
                            
                            echo "</tbody></table>";
                        } else {
                            echo "<div class='alert alert-warning' role='alert'>No se encontraron reclamos.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Error al ejecutar la consulta: " . mysqli_error($con) . "</div>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
