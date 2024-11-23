<?php
require('../modelo/m_reclamaciones.php');

// Obtener los parámetros desde el formulario
$fechaDesde = isset($_GET['fecha_desde']) ? $_GET['fecha_desde'] : null;
$fechaHasta = isset($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : null;

// Consultar los reclamos en el modelo
$reclamos = ObtenerReclamosFiltrados($fechaDesde, $fechaHasta);

// Redirigir a la vista para mostrar los resultados
require('../vistas/panel_admin.php');
?>
