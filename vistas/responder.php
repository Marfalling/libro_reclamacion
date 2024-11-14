<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responder al Reclamo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <?php
    // Incluye la conexión a la base de datos
    include('../modelo/conexion.php');

    // Obtén el ID del reclamo
    $id_reclamo = isset($_GET['id_reclamo']) ? $_GET['id_reclamo'] : null;

    if ($id_reclamo) {
        // Consulta para obtener los detalles del reclamo
        $sql = "SELECT id_reclamacion, id_usuario, fecha_reclamo, estado, respuesta FROM reclamaciones WHERE id_reclamacion = $id_reclamo";
        $result = mysqli_query($con, $sql);
        
        if ($row = mysqli_fetch_assoc($result)) {
            // Muestra los detalles del reclamo y el formulario para responder
            echo "<div class='container mt-4'>";
            echo "<div class='card shadow-lg'>";
            echo "<div class='card-header'>";
            echo "<h3>Responder al Reclamo ID: " . $row['id_reclamacion'] . "</h3>";
            echo "</div>";
            echo "<div class='card-body'>";
            
            // Detalles del reclamo
            echo "<p><strong>Fecha de Reclamo:</strong> " . $row['fecha_reclamo'] . "</p>";
            echo "<p><strong>Estado:</strong> " . $row['estado'] . "</p>";
            echo "<p><strong>Respuesta Anterior:</strong> " . ($row['respuesta'] ? $row['respuesta'] : 'No hay respuesta aún') . "</p>";
            
            // Formulario para responder
            echo "<form action='../controlador/enviar_respuesta.php' method='post'>";
            echo "<div class='form-group'>";
            echo "<label for='respuesta'>Escribe tu respuesta:</label>";
            echo "<textarea class='form-control' name='respuesta' id='respuesta' rows='4' placeholder='Escribe tu respuesta aquí'></textarea>";
            echo "</div>";
            echo "<input type='hidden' name='id_reclamo' value='" . $row['id_reclamacion'] . "'>";
            echo "<button type='submit' class='btn btn-primary'>Enviar Respuesta</button>";
            echo "</form>";
            
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<div class='alert alert-warning mt-4' role='alert'>No se encontró el reclamo.</div>";
        }
    } else {
        echo "<div class='alert alert-danger mt-4' role='alert'>ID de reclamo no válido.</div>";
    }
    ?>
</body>
</html>
