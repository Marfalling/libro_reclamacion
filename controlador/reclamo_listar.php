<?php
session_start();
if (!isset($_SESSION['autentificado']) || $_SESSION['autentificado'] !== TRUE) {
    header('Location: login.php');
    exit();
}

require('../modelo/m_reclamaciones.php'); // Incluye el modelo para obtener datos

// Inicialización de variables
$limite = 10; // Número de reclamos por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Asegúrate de que $pagina esté definido
$fechaDesde = isset($_GET['fecha_desde']) ? $_GET['fecha_desde'] : null;
$fechaHasta = isset($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : null;

// Obtener reclamos
$reclamosData = ObtenerReclamos($fechaDesde, $fechaHasta, $pagina, $limite);
$result = isset($reclamosData['result']) ? $reclamosData['result'] : null; // Asegúrate de que está definido
$totalRegistros = isset($reclamosData['totalRegistros']) ? $reclamosData['totalRegistros'] : 0; // Asegúrate de que está definido

// Calcular el número total de páginas
$totalPaginas = ceil($totalRegistros / $limite);

// Asegúrate de que todas las variables necesarias estén definidas
if (!isset($result)) {
    $result = []; // Inicializa result para evitar errores en la vista
}

// Incluye la vista que mostrará los reclamos
include('../vistas/panel_admin.php');
?>