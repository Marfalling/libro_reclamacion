<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Título principal
        $this->SetFont('Arial', 'B', 12);
        
        // Celda para el título principal
        $this->Cell(0, 10, utf8_decode('Anexo I: Formato de Hoja de Reclamaciones del Libro de Reclamaciones'), 0, 1, 'C');
        $this->Ln(5);    
    }

    // Contenido de la tabla
    function TablaLibroDeReclamaciones()
    {
        // Configuración del estilo
        $this->SetFont('Arial', 'B', 10);

        // Primera fila: Títulos
        $this->Cell(120, 8, 'LIBRO DE RECLAMACIONES', 1, 0, 'C'); // Título
        $this->Cell(70, 8, 'HOJA DE RECLAMACION', 1, 1, 'C'); // Cuadro a la derecha

        // Segunda fila: Fecha
        $this->Cell(25, 10, 'FECHA:', 1, 0, 'C');                  // Etiqueta de Fecha
        $this->Cell(35, 10, utf8_decode ('DÍA'), 1, 0, 'C');                     // Celda para el día
        $this->Cell(25, 10, 'MES', 1, 0, 'C');                     // Celda para el mes
        $this->Cell(35, 10,  utf8_decode ('AÑO'), 1, 0, 'C');                     // Celda para el año
        
        // Alinear la celda de N° a la misma altura que HOJA DE RECLAMACION
        $this->Cell(70, 10, utf8_decode ('N° 000000000000000000'), 1, 1, 'C');   // Cuadro para el número de reclamación
        

        // Datos del proveedor
        $this->SetFont('Arial', 'B', 8); // Cambia el tamaño de la fuente a 8
        $this->MultiCell(0, 8, "[NOMBRE DE LA PERSONA NATURAL O RAZON SOCIAL DE LA PERSONA JURIDICA / RUC DEL PROVEEDOR]\n[DOMICILIO DEL ESTABLECIMIENTO DONDE SE COLOCA EL LIBRO DE RECLAMACIONES/ CODIGO DE IDENTIFICACION]", 1, 'C');
        
        $this->SetFont('Arial', 'B', 8); // Restablece el tamaño de la fuente a 12, si es necesario para el siguiente contenido
        
        $this->Cell(0, 8, '1. IDENTIFICACION DEL CONSUMIDOR RECLAMANTE', 1, 1, 'L');
        $this->Cell(0, 8, 'NOMBRE:', 1, 0); // Asigna un ancho específico
        $this->Cell(0, 8, '', 0, 0); // Celda vacía para el nombre
        $this->Ln(); // Salta a la siguiente línea
        $this->Cell(0, 8, 'DOMICILIO:', 1, 0); // Asigna un ancho específico
        $this->Cell(0, 8, '', 0, 0); // Celda vacía para el domicilio
        $this->Ln(); // Salta a la siguiente línea
        $this->Cell(75, 10, 'DNI: / CE', 1, 0, 'L');                  // Etiqueta DNI / C.E.
        $this->Cell(0, 10, utf8_decode ('TÉLEFONO / EMAIL:'), 1, 0, 'L');                  // Etiqueta de TELEFONO Y EMAIL
        $this->Ln(); // Salta a la siguiente línea
        $this->Cell(0, 8, 'PADRE O MADRE: [PARA EL CASO DE MENORES DE EDAD]', 1, 1);
        

        $this->SetFont('Arial', 'B', 8); // Restablece el tamaño de la fuente a 12, si es necesario para el siguiente contenido
        //IDENTIFICACION DEL BIEN CONTRATADO
        $this->Cell(0, 8, '2. IDENTIFICACION DEL BIEN CONTRATADO', 1, 1, 'L');
        $this->Cell(30, 8, 'PRODUCTO', 1, 0);
        $this->Cell(15, 8, '', 1, 0); // Espacio vacío para producto
        $this->Cell(0, 8, 'MONTO RECLAMADO:', 1, 0);
        $this->Ln(); // Salta a la siguiente línea

        // Usar MultiCell para "DESCRIPCIÓN"
        $this->Cell(30, 8, 'SERVICIO', 1, 0);
        $this->Cell(15, 8, '', 1, 0); // Espacio vacío para servicio
        $this->Cell(0, 8, utf8_decode ('DESCRIPCIÓN:'), 1, 0); // Crea una celda más alta para "DESCRIPCIÓN"
        $this->Ln(); // Salta a la siguiente línea

        
        $this->SetFont('Arial', 'B', 8); // Restablece el tamaño de la fuente
        // DETALLE DE LA RECLAMACION
        $this->Cell(100, 8, '3. DETALLE DE LA RECLAMACION Y EL PEDIDO DEL CONSUMIDOR', 1, 0, 'L'); // Título
        $this->Cell(30, 8, utf8_decode('RECLAMO:'), 1, 0, 'C'); // Crea una celda para "RECLAMO" al lado del título
        $this->Cell(15, 8, '', 1, 0); // Espacio vacío para "RECLAMO"
        $this->Cell(30, 8, utf8_decode('QUEJA:'), 1, 0, 'C'); // Crea una celda para "QUEJA:" al lado de "RECLAMO"
        $this->Cell(15, 8, '', 1, 1); // Espacio vacío para "QUEJA"
        
        // Celda ancha para "DETALLE:"
        $this->Cell(0, 30, 'DETALLE:', 1, 1, 'L'); // Celda ancha para "DETALLE:"
        
        // Celda ancha para "PEDIDO:"
        $this->Cell(125, 30, 'PEDIDO:', 1, 0, 'L'); // Celda ancha para "PEDIDO:"

        // Coloca un margen a la derecha para "FIRMA DEL CONSUMIDOR"
        $this->Cell(0,30,'FIRMA DEL CONSUMIDOR',1,1,'C');
 
        $this->SetFont('Arial', 'B', 8); // Restablece el tamaño de la fuente
        // TÍTULO: 4. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR
        $this->Cell(0, 8, '4. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR', 1, 0, 'L'); // Título
        $this->Ln();

        // Segunda fila: Fecha
        $this->Cell(80, 10, 'FECHA DE COMUNICACION DE LA RESPUESTA:', 1, 0, 'C'); // Etiqueta de Fecha
        $this->Cell(15, 10, utf8_decode('DÍA'), 1, 0, 'C'); // Celda para el día
        $this->Cell(15, 10, 'MES', 1, 0, 'C'); // Celda para el mes
        $this->Cell(15, 10, utf8_decode('AÑO'), 1, 0, 'C');
        $this->Cell(0, 10, utf8_decode('FIRMA DEL PROVEEDOR'), 1, 0, 'C');

        $this->Ln(); // Salto de línea después de la fila de fecha

        // Fila para la firma del proveedor y cuadro vacío
        $this->Cell(125, 30, '', 1, 0, 'C'); // Cuadro vacío a la izquierda
        $this->Cell(0, 30, '', 1, 1, 'C'); // Celda de FIRMA

// Puedes ajustar los valores según sea necesario para obtener la alineación y el diseño que desees.

    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

// Crear un nuevo PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->TablaLibroDeReclamaciones();
$pdf->Output();
?>
