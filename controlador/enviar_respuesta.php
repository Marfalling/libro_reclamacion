<?php
// Incluye la conexión a la base de datos
include('../modelo/conexion.php');

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtiene los datos del formulario
    $id_reclamo = isset($_POST['id_reclamo']) ? $_POST['id_reclamo'] : null;
    $respuesta = isset($_POST['respuesta']) ? $_POST['respuesta'] : null;

    // Verifica que ambos campos tengan valores
    if ($id_reclamo && $respuesta) {
        // Prepara la consulta para actualizar la respuesta en la base de datos, incluyendo la fecha de respuesta
        $sql = "UPDATE reclamaciones 
        SET respuesta = ?, estado = 'Respondido', fecha_respuesta = NOW() 
        WHERE id_reclamacion = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $respuesta, $id_reclamo);
        $result = $stmt->execute();

        if ($result) {
            // Redirige a panel_admin.php después de guardar la respuesta
            echo "<script type='text/javascript'>window.location.href = '../vistas/panel_admin.php';</script>";
            exit();
        } else {
            // Error en la consulta
            echo "Error al actualizar la respuesta: " . mysqli_error($con);
        }
    } else {
        // Si faltan campos
        echo "Por favor ingresa una respuesta válida.";
    }
}
?>
