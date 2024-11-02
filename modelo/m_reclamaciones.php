<?php
function RegistrarReclamo($id_usuario, $tipo_bien, $monto_reclamado, $descripcion, $tipo_reclamo, $detalle_reclamo, $pedido, $menor_edad)
{
    require("conexion.php");
    
    // Incluimos `id_usuario` en la consulta SQL
    $sql = "INSERT INTO reclamaciones (id_usuario, tipo_bien, monto_reclamado, descripcion, tipo_reclamo, detalle_reclamo, pedido, menor_edad) 
            VALUES ('$id_usuario', '$tipo_bien', '$monto_reclamado', '$descripcion', '$tipo_reclamo', '$detalle_reclamo', '$pedido', '$menor_edad')";
    
    $res = mysqli_query($con, $sql);
    if (!$res) {
        return "Error: " . mysqli_error($con);
    }
    
    mysqli_close($con);
    return "Registro exitoso"; 
}
?>
