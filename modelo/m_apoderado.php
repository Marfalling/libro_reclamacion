<?php
function RegistrarApoderado($id_reclamacion, $tipo_documento, $num_documento, $nom, $ape_paterno, $ape_materno, $telefono, $email)
{
    require("conexion.php");

    // Actualiza la consulta SQL para incluir el id_reclamacion
    $sql = "INSERT INTO apoderado (id_reclamacion, tipo_documento, numero_documento, nombre, ape_paterno, ape_materno, telefono, email) 
            VALUES ('$id_reclamacion', '$tipo_documento', '$num_documento', '$nom', '$ape_paterno', '$ape_materno', '$telefono', '$email')";

    // Ejecutar la consulta
    $res = mysqli_query($con, $sql);

    // Guardar el resultado de error antes de cerrar la conexión
    if ($res) {
        // Si la inserción fue exitosa, puedes devolver un mensaje o realizar otra acción
        $resultado = "Registro de apoderado exitoso";
    } else {
        // En caso de error, puedes devolver el mensaje de error
        $resultado = "Error: " . mysqli_error($con);
    }

    // Cierra la conexión después de realizar la consulta
    mysqli_close($con);

    return $resultado; // Devuelve el resultado
}
?>
