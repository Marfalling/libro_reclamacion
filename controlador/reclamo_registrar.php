<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Registro de Reclamos</title>
    </head>
    <body class="sb-nav-fixed">

  
        <div id="layoutSidenav">
            

            <div id="layoutSidenav_content">
                <main>
                <?php

                    
                require("../modelo/m_reclamaciones.php");
                
                if (isset($_REQUEST['registrar'])) 
                {

                    $tipo_bien = $_REQUEST['tipo_bien'];
                    $monto_reclamado = $_REQUEST['monto_reclamado'];
                    $descripcion = $_REQUEST['descripcion'];
                    $tipo_reclamo = $_REQUEST['tipo_reclamo'];
                    $detalle_reclamo = $_REQUEST['detalle_reclamo'];
                    $pedido = $_REQUEST['pedido'];
                    $menor_edad = isset($_REQUEST['menor_edad']) ? 1 : 0; // 1 si está marcado, 0 si no lo está
                
                
                    // Ahora puedo llamar a la función RegistrarReclamo
                    $rpta = RegistrarReclamo($tipo_bien, $monto_reclamado, $descripcion, $tipo_reclamo, $detalle_reclamo, $pedido, $menor_edad);
                
                    echo $rpta; // Muestra el mensaje de éxito o error
                }
                
                


                require("../index.php");
                ?>          
                </main>
                <footer class="py-4 bg-light mt-auto">
                <?php
                require("vista/footer.php");
                ?>
                </footer>
            </div>
        </div>
        <?php
        require("vista/scripts.php");
        ?>
    </body>
</html>
