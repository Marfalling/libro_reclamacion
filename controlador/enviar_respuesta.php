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
        // Prepara la consulta para actualizar la respuesta en la base de datos
        $sql = "UPDATE reclamaciones SET respuesta = '$respuesta', estado = 'Respondido' WHERE id_reclamacion = $id_reclamo";

        // Ejecuta la consulta
        $result = mysqli_query($con, $sql);

        // Verifica si la actualización fue exitosa
        if ($result) {
            // Redirige a panel_admin.php después de guardar la respuesta
            echo "<script type='text/javascript'>window.location.href = '../vistas/panel_admin.php';</script>";
            exit(); // Asegúrate de detener el script después de la redirección
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
