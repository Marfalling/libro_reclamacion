<?php

function RegistrarReclamo($id_usuario, $tipo_bien, $monto_reclamado, $descripcion, $tipo_reclamo, $detalle_reclamo, $pedido, $menor_edad, $fecha_reclamo,$hora_reclamo, $fecha_respuesta) {

    require("conexion.php");



    $fecha_reclamo = date('Y-m-d');

    $sql = "INSERT INTO reclamaciones (id_usuario, tipo_bien, monto_reclamado, descripcion, tipo_reclamo, detalle_reclamo, pedido, menor_edad, fecha_reclamo, hora_reclamo, fecha_respuesta) 

            VALUES ('$id_usuario', '$tipo_bien', '$monto_reclamado', '$descripcion', '$tipo_reclamo', '$detalle_reclamo', '$pedido', '$menor_edad', '$fecha_reclamo', '$hora_reclamo', '$fecha_respuesta')";

    

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

function ObtenerReclamosFiltrados($fechaDesde, $fechaHasta, $pagina = 1, $limite = 10) {
    include('../modelo/conexion.php');
    
    // Variables de paginación
    $inicio = ($pagina - 1) * $limite;

    // Consulta base
    $sql = "SELECT SQL_CALC_FOUND_ROWS id_reclamacion, id_usuario, fecha_reclamo, estado, respuesta, fecha_respuesta 
            FROM reclamaciones";

    // Condiciones de filtro
    $conditions = [];
    if ($fechaDesde) {
        $conditions[] = "fecha_reclamo >= '$fechaDesde'";
    }
    if ($fechaHasta) {
        $conditions[] = "fecha_reclamo <= '$fechaHasta'";
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    // Paginación
    $sql .= " ORDER BY fecha_reclamo DESC LIMIT $inicio, $limite";

    // Ejecutar la consulta
    $result = mysqli_query($con, $sql);

    // Obtener el total de registros
    $totalQuery = mysqli_query($con, "SELECT FOUND_ROWS() AS total");
    $totalRow = mysqli_fetch_assoc($totalQuery);
    $totalRegistros = $totalRow['total'];

    // Calcular el número total de páginas
    $totalPaginas = ceil($totalRegistros / $limite);

    return [
        'result' => $result,
        'totalPaginas' => $totalPaginas,
        'pagina' => $pagina,
        'fechaDesde' => $fechaDesde,
        'fechaHasta' => $fechaHasta
    ];
}


?>
