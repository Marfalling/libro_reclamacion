<?php
function RegistrarReclamo($id_usuario, $tipo_bien, $monto_reclamado, $descripcion, $tipo_reclamo, $detalle_reclamo, $pedido, $menor_edad, $fecha_reclamo) {
    require("conexion.php");

    $fecha_reclamo = date('Y-m-d');
    $sql = "INSERT INTO reclamaciones (id_usuario, tipo_bien, monto_reclamado, descripcion, tipo_reclamo, detalle_reclamo, pedido, menor_edad, fecha_reclamo) 
            VALUES ('$id_usuario', '$tipo_bien', '$monto_reclamado', '$descripcion', '$tipo_reclamo', '$detalle_reclamo', '$pedido', '$menor_edad', '$fecha_reclamo')";
    
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
