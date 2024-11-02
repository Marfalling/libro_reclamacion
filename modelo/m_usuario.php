<?php
function RegistrarUsuario($tipo_documento,$num_documento, $nom, $ape_paterno, $ape_materno,$tipo_resp,$dir, $cel,$email)
{
    require("conexion.php");
    //los parentesis son para que se recepcione todo lo que lleva cada campo
    $sql="INSERT INTO usuario() VALUES(NULL,'$tipo_documento','$num_documento', '$nom', '$ape_paterno', '$ape_materno','$tipo_resp','$dir', '$cel','$email')";
    //se le coloca null, porque el id es incremental, luego se coloca cada valor segun el orden de la base de datos para que inserte en los datos correctos
    //se hace la inserción de los datos
    $res = mysqli_query($con, $sql);

    //esto devuelve el ultimo insert
    $id = mysqli_insert_id ($con);
    //podemos colocar un retorno 
    return $id;

    //con esto se cierra la conexion
    mysqli_close($con);

}
?>