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
                require("../modelo/m_apoderado.php");

                if (isset($_REQUEST['registrar'])) {
                    // Obtener el id_usuario desde la URL 
                    $id_usuario = $_REQUEST['id_usuario'];
                    
                    // Datos del reclamo
                    $tipo_bien = $_REQUEST['tipo_bien'];
                    $monto_reclamado = $_REQUEST['monto_reclamado'];
                    $descripcion = $_REQUEST['descripcion'];
                    $tipo_reclamo = $_REQUEST['tipo_reclamo'];
                    $detalle_reclamo = $_REQUEST['detalle_reclamo'];
                    $pedido = $_REQUEST['pedido'];
                    $menor_edad = isset($_REQUEST['menor_edad']) ? 'Sí' : 'No';

                    // Registrar el reclamo
                    $id_reclamacion = RegistrarReclamo($id_usuario, $tipo_bien, $monto_reclamado, $descripcion, $tipo_reclamo, $detalle_reclamo, $pedido, $menor_edad);

                    if ($id_reclamacion) {
                        echo "Reclamo registrado exitosamente.";

                        // Comprobar si es menor de edad y registrar los datos del apoderado
                        if ($menor_edad) {
                            // Obtener los datos del apoderado
                            $tipo_documento = $_REQUEST['tipo_documento'];
                            $num_documento = $_REQUEST['num_documento'];
                            $nombre_apoderado = $_REQUEST['nom'];
                            $apellido_paterno = $_REQUEST['ape_paterno'];
                            $apellido_materno = $_REQUEST['ape_materno'];
                            $telefono = $_REQUEST['cel'];
                            $email = $_REQUEST['email'];

                            // Registrar los datos del apoderado
                            RegistrarApoderado($id_reclamacion, $tipo_documento, $num_documento, $nombre_apoderado, $apellido_paterno, $apellido_materno, $telefono, $email);
                        }
                    } else {
                        echo "Error al registrar el reclamo.";
                    }
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
