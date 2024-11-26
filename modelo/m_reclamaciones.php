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

function ObtenerReclamos($fechaDesde, $fechaHasta, $pagina = 1, $limite = 10) {
    include('conexion.php'); 

    $inicio = ($pagina - 1) * $limite;
    $sql = "SELECT SQL_CALC_FOUND_ROWS id_reclamacion, id_usuario, fecha_reclamo, hora_reclamo, estado, respuesta, fecha_respuesta FROM reclamaciones";
    $conditions = [];
    $params = [];

    if ($fechaDesde) {
        $conditions[] = "fecha_reclamo >= ?";
        $params[] = $fechaDesde;
    }

    if ($fechaHasta) {
        $conditions[] = "fecha_reclamo <= ?";
        $params[] = $fechaHasta;
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " ORDER BY id_reclamacion DESC LIMIT ?, ?";
    $params[] = $inicio;
    $params[] = $limite;

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, str_repeat('s', count($params) - 2) . 'ii', ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Obtener el total de registros
    $totalQuery = mysqli_query($con, "SELECT FOUND_ROWS() AS total");
    $totalRow = mysqli_fetch_assoc($totalQuery);
    $totalRegistros = $totalRow['total'];

    return [
        'result' => $result,
        'totalRegistros' => $totalRegistros
    ];
}


?>
