<?php
function RegistrarReclamo($tipo_bien, $monto_reclamado, $descripcion, $tipo_reclamo, $detalle_reclamo, $pedido, $menor_edad)
{
    require("conexion.php");
    
    $sql = "INSERT INTO reclamaciones (tipo_bien, monto_reclamado, descripcion, tipo_reclamo, detalle_reclamo, pedido, menor_edad) 
            VALUES ('$tipo_bien', '$monto_reclamado', '$descripcion', '$tipo_reclamo', '$detalle_reclamo', '$pedido', '$menor_edad')";
    
    $res = mysqli_query($con, $sql);
    if (!$res) {
        return "Error: " . mysqli_error($con);
    }
    
    mysqli_close($con);
    return "Registro exitoso"; 
}

?>