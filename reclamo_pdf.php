<?php
require('fpdf/fpdf.php');

// Conexión a la base de datos
$con = mysqli_connect("localhost", "root", "", "libro_reclamaciones", "3307");



// Verificar conexión
if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}
        // Obtener el id_usuario desde la URL, por ejemplo
        $id_usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : die("ID de usuario no especificado");
        
        $query = "SELECT 
            usuario.nombre, 
            usuario.tipo_documento, 
            usuario.numero_documento, 
            usuario.ape_paterno, 
            usuario.ape_materno, 
            usuario.dir_domicilio, 
            usuario.cel_usuario, 
            usuario.email_usuario, 
            reclamaciones.id_reclamacion, 
            reclamaciones.tipo_bien, 
            reclamaciones.monto_reclamado,
            reclamaciones.descripcion,
            reclamaciones.tipo_reclamo,
            reclamaciones.detalle_reclamo,
            reclamaciones.fecha_reclamo,
            reclamaciones.pedido,
            reclamaciones.menor_edad,
            reclamaciones.fecha_respuesta,
            reclamaciones.respuesta,
            apoderado.nombre AS nombre_apoderado
        FROM 
            usuario
        JOIN 
            reclamaciones ON usuario.id_usuario = reclamaciones.id_usuario
        LEFT JOIN 
            apoderado ON reclamaciones.id_reclamacion = apoderado.id_reclamacion
        WHERE 
            usuario.id_usuario = $id_usuario"; // Usamos id_usuario aquí


$result = mysqli_query($con, $query);


// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta SQL: " . mysqli_error($con));
}

// Obtener datos
if ($row = mysqli_fetch_assoc($result)) {
    $nom = $row['nombre'];
    $tipo_documento = $row['tipo_documento'];
    $n_documento = $row['numero_documento'];
    $ape_paterno = $row['ape_paterno'];
    $ape_materno = $row['ape_materno'];
    $dir = $row['dir_domicilio'];
    $cel = $row['cel_usuario'];
    $email = $row['email_usuario'];

    //reclamo

    $id_reclamo = $row['id_reclamacion'];
    $tipo_bien = $row['tipo_bien'];
    $monto = $row['monto_reclamado'];
    $descripcion = $row['descripcion'];
    $tipo_reclamo = $row['tipo_reclamo'];
    $detalle_reclamo = $row['detalle_reclamo'];
    $pedido = $row['pedido'];
    $menor_edad = $row['menor_edad'];
    $fecha = $row['fecha_reclamo'];
    $fecha_respuesta = $row['fecha_respuesta'];
    $respuesta = $row['respuesta'];
    //apoderado

    $nombre_apoderado = $row['nombre_apoderado'];

} else {
    die("No se encontraron datos del ID especificado.");
}


class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Título principal
        $this->SetFont('Arial', 'B', 12);
        
        // Celda para el título principal
        $this->Cell(0, 10, mb_convert_encoding('Anexo I: Formato de Hoja de Reclamaciones del Libro de Reclamaciones', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Ln(5);    
    }

    // Contenido de la tabla
    function TablaLibroDeReclamaciones($nom, $tipo_documento, $n_documento, $ape_paterno, $ape_materno, $dir, $cel, $email, $id_reclamo, $tipo_bien, $monto,$descripcion,$tipo_reclamo, $detalle_reclamo, $pedido, $nombre_apoderado, $menor_edad, $fecha, $fecha_respuesta, $respuesta)
    {
        if (strtotime($fecha)) { // Verifica si la fecha es válida
            list($ano, $mes, $dia) = explode('-', $fecha);
        } else {
            // En caso de que la fecha no sea válida, asigna valores por defecto o muestra un mensaje de error
            $ano = $mes = $dia = 'N/A';
        }

        // Configuración del estilo
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(220, 220, 220);
        // Primera fila: Títulos
        $this->Cell(120, 8, 'LIBRO DE RECLAMACIONES', 1, 0, 'C', true); // Título
        $this->Cell(70, 8, 'HOJA DE RECLAMACION', 1, 1, 'C'); // Cuadro a la derecha

        // Segunda fila: Fecha
        $this->Cell(25, 10, 'FECHA:', 1, 0, 'C');                  // Etiqueta de Fecha
        $this->Cell(35, 10, '' . mb_convert_encoding($dia, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(25, 10, ''.mb_convert_encoding($mes, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');                     // Celda para el mes
        $this->Cell(35, 10, ''.mb_convert_encoding ($ano, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');                     // Celda para el año

        
        // Alinear la celda de N° a la misma altura que HOJA DE RECLAMACION
        $this->Cell(70, 10, mb_convert_encoding ('N° ', 'ISO-8859-1', 'UTF-8').mb_convert_encoding($id_reclamo, 'ISO-8859-1', 'UTF-8'), 1, 1, 'C');   // Cuadro para el número de reclamación
        

        // Datos del proveedor
        $this->SetFont('Arial', 'B', 8); // Cambia el tamaño de la fuente a 8
        $this->MultiCell(0, 8, "[NOMBRE DE LA PERSONA NATURAL O RAZON SOCIAL DE LA PERSONA JURIDICA / RUC DEL PROVEEDOR]\n[DOMICILIO DEL ESTABLECIMIENTO DONDE SE COLOCA EL LIBRO DE RECLAMACIONES/ CODIGO DE IDENTIFICACION]", 1, 'C');
        
        $this->SetFont('Arial', 'B', 8); // Restablece el tamaño de la fuente a 12, si es necesario para el siguiente contenido
        $this->SetFillColor(220, 220, 220);

        $this->Cell(0, 8, '1. IDENTIFICACION DEL CONSUMIDOR RECLAMANTE', 1, 1, 'L',true);
        $this->Cell(0, 8, 'NOMBRE: '. mb_convert_encoding($nom, 'ISO-8859-1', 'UTF-8') . ' ' .mb_convert_encoding($ape_paterno, 'ISO-8859-1', 'UTF-8') . ' ' .mb_convert_encoding($ape_materno, 'ISO-8859-1', 'UTF-8'),1, 0); // Asigna un ancho específico
        $this->Cell(0, 8, '', 0, 0); // Celda vacía para el nombre
        $this->Ln(); // Salta a la siguiente línea
        $this->Cell(0, 8, 'DOMICILIO: '. mb_convert_encoding($dir, 'ISO-8859-1', 'UTF-8'), 1, 0); // Asigna un ancho específico
        $this->Cell(0, 8, '', 0, 0); // Celda vacía para el domicilio
        $this->Ln(); // Salta a la siguiente línea
        $this->Cell(75, 10, 'DNI: / CE: ' .  mb_convert_encoding($tipo_documento, 'ISO-8859-1', 'UTF-8') . ' : ' . mb_convert_encoding($n_documento, 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $this->Cell(0, 10, mb_convert_encoding ('TÉLEFONO / EMAIL: ', 'ISO-8859-1', 'UTF-8'). mb_convert_encoding($cel, 'ISO-8859-1', 'UTF-8') . ' / ' . mb_convert_encoding($email, 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');                  // Etiqueta de TELEFONO Y EMAIL
        $this->Ln(); // Salta a la siguiente línea
        $this->Cell(0, 8, 'PADRE O MADRE: '. mb_convert_encoding($menor_edad, 'ISO-8859-1', 'UTF-8') . ' es menor de edad. ' . ' ' . mb_convert_encoding($nombre_apoderado, 'ISO-8859-1', 'UTF-8'), 1, 1);
        

        $this->SetFont('Arial', 'B', 8); // Restablece el tamaño de la fuente a 12, si es necesario para el siguiente contenido
        //IDENTIFICACION DEL BIEN CONTRATADO
        $this->SetFillColor(220, 220, 220);
        $this->Cell(0, 8, '2. IDENTIFICACION DEL BIEN CONTRATADO', 1, 1, 'L',true);
        $this->Cell(30, 8, 'PRODUCTO', 1, 0);
        $this->Cell(15, 8, ($tipo_bien == 'Producto' ? 'X' : ''), 1, 0, 'C'); // Marca "X" si es Producto
        $this->Cell(0, 8, 'MONTO RECLAMADO: '. mb_convert_encoding($monto, 'ISO-8859-1', 'UTF-8'), 1, 0);
        $this->Ln(); // Salta a la siguiente línea

        // Usar MultiCell para "DESCRIPCIÓN"
        $this->Cell(30, 8, 'SERVICIO', 1, 0);
        $this->Cell(15, 8, ($tipo_bien == 'Servicio' ? 'X' : ''), 1, 0, 'C'); // Marca "X" si es Servicio
        $this->Cell(0, 8, mb_convert_encoding ('DESCRIPCIÓN: ', 'ISO-8859-1', 'UTF-8'). mb_convert_encoding($descripcion, 'ISO-8859-1', 'UTF-8'), 1, 0); // Crea una celda más alta para "DESCRIPCIÓN"
        $this->Ln(); // Salta a la siguiente línea

        
        $this->SetFont('Arial', 'B', 8); // Restablece el tamaño de la fuente
        $this->SetFillColor(220, 220, 220);
        // DETALLE DE LA RECLAMACION
        $this->Cell(100, 8, '3. DETALLE DE LA RECLAMACION Y EL PEDIDO DEL CONSUMIDOR', 1, 0, 'L', true); // Título
        $this->Cell(30, 8, mb_convert_encoding('RECLAMO:', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C'); // Crea una celda para "RECLAMO" al lado del título
        $this->Cell(15, 8, ($tipo_reclamo == 'Reclamo' ? 'X' : ''), 1, 0, 'C'); // Espacio vacío para "RECLAMO"
        $this->Cell(30, 8, mb_convert_encoding('QUEJA:', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C'); // Crea una celda para "QUEJA:" al lado de "RECLAMO"
        $this->Cell(15, 8, ($tipo_reclamo == 'Queja' ? 'X' : ''), 1, 1, 'C'); // Espacio vacío para "QUEJA"
        
        // Celda ancha para "DETALLE:"
        $this->Cell(0, 30, 'DETALLE: '. mb_convert_encoding($detalle_reclamo, 'ISO-8859-1', 'UTF-8'), 1, 1, 'L'); // Celda ancha para "DETALLE:"
        
       // Fila para la firma del proveedor y cuadro vacío
       $this->Cell(125, 30, 'PEDIDO: '. mb_convert_encoding($pedido, 'ISO-8859-1', 'UTF-8'), 1, 0, 'L'); // Cuadro vacío a la izquierda
       // Coloca el texto "FIRMA DEL CONSUMIDOR" centrado
       $this->Cell(0, 10, 'FIRMA DEL CONSUMIDOR', 1, 0, 'C'); 

       // Celda vacía para la firma, alineada a la misma altura
       $this->Cell(0, 30, '', 1, 1, 'C'); // Celda vacía para la firma


        // Restablece el tamaño de la fuente
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(220, 220, 220);

        // TÍTULO: 4. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR
        $this->Cell(0, 8, '4. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR', 1, 0, 'L', true); // Título
        $this->Ln();

        
        // Segunda fila: Fecha
        $this->Cell(80, 10, 'FECHA DE COMUNICACION DE LA RESPUESTA:', 1, 0, 'C'); // Etiqueta de Fecha

        if (strtotime($fecha_respuesta)) { // Verifica si la fecha de respuesta es válida
            $fecha_resp = new DateTime($fecha_respuesta);
            $day_resp = $fecha_resp->format('d'); // Día de la fecha de respuesta
            $month_resp = $fecha_resp->format('m'); // Mes de la fecha de respuesta
            $year_resp = $fecha_resp->format('Y'); // Año de la fecha de respuesta

            $this->Cell(15, 10, mb_convert_encoding($day_resp, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C'); // Celda para el día
            $this->Cell(15, 10, mb_convert_encoding($month_resp, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C'); // Celda para el mes
            $this->Cell(15, 10, mb_convert_encoding($year_resp, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C'); // Celda para el año
        } else {
            // Manejo de error o valor por defecto
            $this->Cell(15, 10, 'N/A', 1, 0, 'C'); // Valor por defecto si la fecha no es válida
            $this->Cell(15, 10, 'N/A', 1, 0, 'C');
            $this->Cell(15, 10, 'N/A', 1, 0, 'C');
        }

        $this->Cell(0, 10, mb_convert_encoding('FIRMA DEL PROVEEDOR', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');

        $this->Ln(); // Salto de línea después de la fila de fecha

        // Fila para la firma del proveedor y cuadro vacío
        $this->Cell(125, 20,  mb_convert_encoding($respuesta, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C'); // Cuadro vacío a la izquierda
        $this->Cell(0, 20, '', 1, 1, 'C'); // Celda de FIRMA 

        $this->Cell(100,12, 'Reclamo: Disconformidad relacionada a los productos o servicios.', 1, 0, 'L');        
        $this->MultiCell(0,4, mb_convert_encoding("Queja: Disconformidad no relacionada a los productos o servicios; o, \nmalestar o descontento respecto a la atención al publico.", 'ISO-8859-1', 'UTF-8'), 1, 'L');
        $this->Ln();
        

    }

    function Footer()
    {

        $this->SetFont('Arial', 'I', 8);
        $this->MultiCell(0, 5,mb_convert_encoding( '* La formulación del reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI.' . "\n" .
                        '* El proveedor debe dar respuesta al reclamo o queja en un plazo no mayor a quince (15) días hábiles, el cual es improrrogable.', 'ISO-8859-1', 'UTF-8'), 0, 'L');
        // Establecer la posición en Y a la altura total de la página menos el margen inferior
        $this->SetY(-($this->bMargin + 10)); // 15 es la distancia desde el borde inferior que deseas para la imagen
        
        $this->Image('icon/Rysoft.png', 90, $this->GetY(), 30); // Cambié el valor de X a 100 mm y tamaño de la imagen a 50 mm
        
        
    }
    
    
    
    
}

// Crear un nuevo PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->TablaLibroDeReclamaciones($nom, $tipo_documento, $n_documento, $ape_paterno, $ape_materno, $dir, $cel, $email, $id_reclamo, $tipo_bien, $monto,$descripcion,$tipo_reclamo, $detalle_reclamo, $pedido, $nombre_apoderado, $menor_edad, $fecha, $fecha_respuesta, $respuesta);
$pdf->Output();
// Cerrar la conexión
mysqli_close($con);
?>
