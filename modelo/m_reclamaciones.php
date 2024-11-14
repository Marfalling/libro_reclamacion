<?php
function RegistrarReclamo($id_usuario, $tipo_bien, $monto_reclamado, $descripcion, $tipo_reclamo, $detalle_reclamo, $pedido, $menor_edad, $fecha_reclamo, $fecha_respuesta) {
    require("conexion.php");

    $fecha_reclamo = date('Y-m-d');
    $sql = "INSERT INTO reclamaciones (id_usuario, tipo_bien, monto_reclamado, descripcion, tipo_reclamo, detalle_reclamo, pedido, menor_edad, fecha_reclamo, fecha_respuesta) 
            VALUES ('$id_usuario', '$tipo_bien', '$monto_reclamado', '$descripcion', '$tipo_reclamo', '$detalle_reclamo', '$pedido', '$menor_edad', '$fecha_reclamo', '$fecha_respuesta')";
    
    $res = mysqli_query($con, $sql);

    // Obtiene id de la reclamacion recién creada
    $id_reclamacion = mysqli_insert_id($con);

    mysqli_close($con);

    if ($res) {
        return $id_reclamacion; // Retorna el ID de la reclamación
    } else {
        return "Error: " . mysqli_error($con);
    }
}

?>
