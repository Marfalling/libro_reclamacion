<?php
include('../modelo/conexion.php'); // Conexión a la base de datos

// Verificar si se ha enviado una respuesta
if (isset($_POST['enviar_respuesta'])) {
    // Obtener datos del formulario
    $id_reclamo = $_POST['id_reclamo'];
    $respuesta = mysqli_real_escape_string($conexion, $_POST['respuesta']);
    $estado = 'respondido'; // El estado pasa a respondido

    // Actualizar la respuesta en la base de datos
    $sql = "UPDATE reclamaciones SET respuesta = '$respuesta', estado = '$estado' WHERE id_reclamo = $id_reclamo";

    if (mysqli_query($conexion, $sql)) {
        // Enviar correo con la respuesta al usuario
        $reclamo = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT nombre_usuario, email FROM reclamaciones WHERE id_reclamo = $id_reclamo"));
        $to = $reclamo['email'];
        $subject = "Respuesta a tu Reclamo";
        $message = "Estimado " . $reclamo['nombre_usuario'] . ",\n\nTu reclamo ha sido respondido. Aquí está la respuesta:\n\n" . $respuesta;
        mail($to, $subject, $message);

        // Redirigir al administrador al panel de administración
        header('Location: /vista/panel_admin.php');
        exit;
    } else {
        echo "Error al enviar la respuesta: " . mysqli_error($conexion);
    }
}
?>
